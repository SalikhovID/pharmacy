<?php
/**
 * Setup application environment
 */

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');

$dotenv->load();

function env($key){
    return ($_ENV[$key] ?? getenv($key));
}

if($_ENV['YII_DEBUG'] === 'true') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV','dev');
}else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'prod');
}