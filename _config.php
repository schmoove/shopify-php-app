<?php 

# App setup in Shopify:
#
# App URL: https://1234-202-36-32-50.ngrok-free.app/
# Redirection URL: https://1234-202-36-32-50.ngrok-free.app/callback.php

require 'database/DatabaseSessionStorage.php';

use Shopify\Context;
use Shopify\Auth\DatabaseSessionStorage;
use Shopify\Auth\OAuthCookie;
use Shopify\Utils;

if ( !isset($_GET['shop']) ) {
	dd('Error: No `shop` parameter specified');
}

$shop = Utils::sanitizeShopDomain($_GET['shop']);

$config = [
	'api_key' => '', // From your app dashboard
	'api_secret' => '', // From your app dashboard
	'host' => '', // 1234-202-36-32-50.ngrok-free.app
	'scopes' => '' // read_products,read_inventory,read_themes
];

foreach ( $config as $key => $value ) {
    if ( empty($value) ) {
        dd("Missing config value for `$key` in _config.php");
    }
}

$dbStorage = new DatabaseSessionStorage('database/sessions.db', $config['scopes']);

Context::initialize(
    apiKey: $config['api_key'],
    apiSecretKey: $config['api_secret'],
    scopes: $config['scopes'],
    hostName: $config['host'],
    sessionStorage: $dbStorage,
    apiVersion: '2023-04',
    isEmbeddedApp: true,
    isPrivateApp: false
);
