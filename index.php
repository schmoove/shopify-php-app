<?php

require 'vendor/autoload.php';
require "_config.php";

use Shopify\Utils;

$session = Utils::loadOfflineSession($shop);

if ( !$session ) {
	header("Location: /auth.php?shop=$shop");
}

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  	<meta charset="utf-8">
  	<title>Shopify PHP App</title>
  	<meta name="description" content="Example of a simple Shopify app written in PHP">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<?php require 'polaris.css.php'; ?>
	<script src="https://unpkg.com/@shopify/app-bridge@3/umd/index.development.js"></script>
	<script src="app.js"></script>
</head>

<body>


</body>

</html>
