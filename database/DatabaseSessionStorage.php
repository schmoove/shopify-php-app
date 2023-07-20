<?php

declare(strict_types=1);

namespace Shopify\Auth;

class DatabaseSessionStorage implements SessionStorage {
	
    /** @var string */
    private $path;

    /** @var scope */
    private $scope;

    /** @var SQLite3 */
    private $db;

	public function __construct(string $path = 'database/sessions.db', string $scope = '') {
	    $this->db = new \SQLite3($path);
	    $this->scope = $scope;
	    $this->db->exec('CREATE TABLE IF NOT EXISTS sessions (
	    	id STRING, 
	    	shop STRING, 
	    	isOnline INTEGER, 
	    	state STRING, 
	    	scope STRING,
	    	expires INTEGER, 
	    	accessToken STRING
	    )');
  	}

  	public function loadSession(string $sessionId): ?Session
    {
    	$dbSession = $this->db->querySingle("SELECT * FROM sessions WHERE id = '$sessionId'", true);
    	if ( $dbSession ) {
	    	$session = new Session($dbSession['id'], $dbSession['shop'], ( $dbSession['isOnline'] == 1 ), $dbSession['state']);

    		if ( $dbSession['expires'] ) {
                $session->setExpires($dbSession['expires']);
            }
            if ( $dbSession['accessToken'] ) {
                $session->setAccessToken($dbSession['accessToken']);
            }
            $session->setScope($this->scope);

    		return $session;
    	}
    	return null;
    }

    public function storeSession(Session $session): bool
    {
    	$dbSession = $this->db->querySingle(sprintf("SELECT * FROM sessions WHERE id='%s'", $session->getId()), true);
    	if ( $dbSession ) {
    		$sql = "UPDATE sessions SET id = :id, shop = :shop, isOnline = :isOnline, state = :state, scope = :scope";
    		if ( $session->getAccessToken() ) {
    			$sql .= ", accessToken = :accessToken";
    		}
    		if ( $session->getExpires() ) {
    			$sql .= ", expires = :expires";
    		}
    	} else {
    		$sql = "INSERT INTO sessions (id, shop, isOnline, state, scope) VALUES (:id, :shop, :isOnline, :state, :scope)";
	    }

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $session->getId(), SQLITE3_TEXT);
		$stmt->bindValue(':shop', $session->getShop(), SQLITE3_TEXT);
		$stmt->bindValue(':isOnline', $session->isOnline(), SQLITE3_INTEGER);
		$stmt->bindValue(':state', $session->getState(), SQLITE3_TEXT);
		$stmt->bindValue(':scope', $this->scope, SQLITE3_TEXT);

		if ( $session->getAccessToken() ) {
			$stmt->bindValue(':accessToken', $session->getAccessToken(), SQLITE3_TEXT);
		}
		if ( $session->getExpires() ) {
			$stmt->bindValue(':expires', $session->getExpires(), SQLITE3_TEXT);
		}

		try {
			$result = $stmt->execute();
			return true;
		} catch ( Exception $e ) {
			dd($e->getMessage());
			return false;
		}
    }

    public function deleteSession(string $sessionId): bool
    {
		$this->db->exec(sprintf("DELETE FROM sessions WHERE id = '%s'", $sessionId));

		return true;
    }

}
