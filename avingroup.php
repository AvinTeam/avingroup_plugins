<?php

/**
 * Avin Group
 *
 * Plugin Name: آوین گروپ
 * Plugin URI:  https://updater.mrrashidpour.com/
 * Description: افزونه برای سایت آورن گروپ
 * Version:     1.0.0
 * Author:      Mohammadreza Rashidpour Aghamahali
 * Author URI:  https://mrrashidpour.com/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Requires at least: 6.5
 * Requires PHP: 7.4
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

use AvinGroup\App\Core\FunctionAutoloader;
use Dotenv\Dotenv;

defined('ABSPATH') || exit;
date_default_timezone_set('Asia/Tehran');

preg_match('/Version:\s*(.+)/i', file_get_contents(__FILE__), $versionMatches);

$version = $versionMatches[ 1 ] ?? "1.0.0";

define('AG_VERSION', $version);

define('AG_FILE', __FILE__);
define('AG_PATH', plugin_dir_path(__FILE__));
define('AG_INCLUDES', AG_PATH . 'includes/');
define('AG_CONFIG', AG_PATH . 'config/');
define('AG_VIEWS', AG_PATH . 'views/');

define('AG_URL', plugin_dir_url(__FILE__));
define('AG_ASSETS', AG_URL . 'assets/');
define('AG_CSS', AG_ASSETS . 'css/');
define('AG_JS', AG_ASSETS . 'js/');
define('AG_IMAGE', AG_ASSETS . 'images/');
define('AG_VENDOR', AG_ASSETS . 'vendor/');



if (file_exists(AG_PATH . '/vendor/autoload.php')) {
    require_once AG_PATH . '/vendor/autoload.php';
}

if (class_exists(Dotenv::class)) {
    $dotenv = Dotenv::createImmutable(AG_PATH);
    $dotenv->load();
}


new FunctionAutoloader;


// dd();