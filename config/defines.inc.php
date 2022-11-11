<?php

$currentDir = dirname(__FILE__);

if (!defined('_APP_DEBUG_MODE_')) {
    define('_APP_DEBUG_MODE_', false);
}

if (!defined('_APP_ROOT_DIR_')) {
    define('_APP_ROOT_DIR_', realpath($currentDir.'/..'));
}

if (!defined('_APP_TEMPLATES_DIR_')) {
    define('_APP_TEMPLATES_DIR_', _APP_ROOT_DIR_.'/templates/');
}

if (!defined('_APP_CACHE_DIR_')) {
    define('_APP_CACHE_DIR_', _APP_ROOT_DIR_.'/cache/');
}

if (!defined('_APP_ASSETS_DIR_')) {
    define('_APP_ASSETS_DIR_', 'assets/build/');
}