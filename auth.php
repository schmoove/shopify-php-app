<?php

require 'vendor/autoload.php';
require "_config.php";

use Shopify\Auth\OAuth;

$isOnline = false;
$url = Shopify\Auth\OAuth::begin($shop, '/callback.php', $isOnline);

header("Location: $url");	
