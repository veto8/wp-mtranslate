<?php

/**
 * @see              https://wp-mtranslate.myridia.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Wp-mtranslate
 * Plugin URI: https://wordpress.org/plugins/wp-mtranslate
 * Description: Automatically translate your Site based on your Domain, a source and target Language.
 * Version: 1.1.0
 * Author: veto, Myridia Company
 * Author URI: http://wp-mtranslate.myridia.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wp-mtranslate
 * Domain Path: /languages
 * Update URL: https://github.com/myridia/wp-mtranslate
 * Constant Prefix: MWPDT_
 * Prefix: wpmtr_
 * Option_key: myridia_domain_translate
 **/

/*
 * Default Wordpress Constant
 *
 * @since 1.0.0 (if available)
 */
defined('ABSPATH') or exit('Something went wrong');

/*
 * Set the Plugin Namespace
 *
 * @since 1.0.0 (if available)
 */
use MWPDT\Dt\Class\MDT_Admin;
use MWPDT\Dt\Class\MDT_Frontend;

/*
 * Constants Calls
 * @since 1.0.0 (if available)
 */
define('MWPDT_PLUGIN_FILE', __FILE__);
define('MWPDT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MWPDT_PLUGIN_URL', plugin_dir_url(__FILE__));

/*
 * Default Plugin activate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_activation_hook(__FILE__, ['MWPDT\Dt\Class\MDT_Admin', 'activate']);

/*
 * Default Plugin deactivate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_deactivation_hook(__FILE__, ['MWPDT\Dt\Class\MDT_Admin', 'deactivate']);

// Register to start the Plugin

add_action('init', 'wpmtr_init', 80);
add_action('admin_init', 'wpmtr_admin_init', 99);

/**
 * Init the Admin Plugin .
 *
 * Init class Admin and register the settings
 *
 * @since 1.0.0
 */
function wpmtr_admin_init()
{
    $plugin = new MDT_Admin();
    $plugin->register_settings();
}

/**
 * Init the User Front Plugin.
 *
 * Init class Admin, class Frontend
 *
 * @since 1.0.0
 */
function wpmtr_init()
{
    $plugin = new MDT_Admin();
    $plugin->add_menu_setting();
    $plugin2 = new MDT_Frontend();
}

/*
 * Register Classes
 *
 *  Register a PHP Class with Namespace
 *  Check for all Classes, then filter out only our name space one and get their full file path.
 *  Use this file path to use it for the php require_once
 *
 * @since 1.0.0
 * @param String $className
 */
spl_autoload_register(function (string $className) {

    if (false === strpos($className, 'MWPDT\\Dt')) {
        return;
    }
    
    $className = str_replace('MWPDT\\Dt\\', __DIR__.'/src/', $className);
    $classFile = str_replace('\\', '/', $className).'.php';
    require_once $classFile;
});
