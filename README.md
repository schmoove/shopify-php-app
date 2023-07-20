# shopify-php-app

###### A basic example of an embedded Shopify app written in PHP, utilising the latest versions of the [Shopify API Library for PHP](https://github.com/Shopify/shopify-api-php) (backend) and [Shopify App Bridge](https://shopify.dev/docs/apps/tools/app-bridge) via CDN  (frontend).

###### _Last updated: 20 July 2023_



## Dependencies

- [shopify/shopify-api](https://packagist.org/packages/shopify/shopify-api)**@5.1.0** [packagist]
- [@shopify/app-bridge](https://unpkg.com/browse/@shopify/app-bridge@3.7.8/)**@3.7.8** [unpkg]


## Overview

This is a stripped-down example of an embedded Shopify app, designed to be as illistrative of the functionality as possible. Too many examples across the web are outdated, bloated and impossible to get up and running quickly and easily. Hopefully this repo helps you do just that.

## Setup

#### Clone the repo and install the PHP API
```
git clone https://github.com/schmoove/shopify-php-app.git shopify-php-app
cd shopify-php-app
composer install
```

### Create the app in Shopify
1. Login to your Partners account, and under `Apps` click `Create app` in the top right.
2. Choose public (this is always a better option, as it offers greater security measures and you're not obliged to list it on the Shopify App Store.
3. Name your app.
4. Set **App URL** to `https://your-app-location.com/`
5. Set **Allowed redirection URL(s)** to `https://your-app-location.com/callback.php`
6. Click **Create app** in the top right.

### Add your app Key and Secret Key to `_config.php`
The next screen after clicking **Create app** should display these keys for you.

Inside `_config.php` set `api_key` to the **API key**, and  `api_secret` to the **API secret key**.

### Set your app scopes in `_config.php`
Modify the `$scopes` array to contain all necessary [scopes](https://shopify.dev/docs/api/usage/access-scopes) your app will require.

### Database
The Shopify API Library provides a simple example of a [filesystem session storage class](https://github.com/Shopify/shopify-api-php/blob/main/src/Auth/FileSessionStorage.php) that isn't recommended for production. I've replaced this with a database class that manages sessions in SQLite. From the code, you can see how easy it is to abstract the functionality for other frameworks/databases.

### Upload the app to your server
The final step is to upload all of the files for the app to your server. Once that is done your app should be ready to be installed on a development store. This is found under **More actions** when viewing your app inside of Shopify Partners.

## Frontend

- `index.php` contains the basic HTML markup for the app once it has been installed and loaded.
-  `app.js` contains the App Bridge-specific JavaScript to initialise the UI components and their associated functionality.
-  `polaris.css.php` contains a recent CSS-only version of [Shopify's Polaris design system](https://polaris.shopify.com/components) for component styling.


## To Do
- App Bridge navigation examples
- REST client request examples
- GraphQL client query examples
- Webhook registration and functionality
