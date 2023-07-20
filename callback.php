<?php

require 'vendor/autoload.php';
require "_config.php";

use Shopify\Auth\OAuth;
use Shopify\Utils;

try {
	$session = Shopify\Auth\OAuth::callback($_COOKIE, $_GET);
	$url = Utils::getEmbeddedAppUrl($_GET['host']);
	header("Location: $url");
} catch ( Exception $e ) {
	dd($e);
}
