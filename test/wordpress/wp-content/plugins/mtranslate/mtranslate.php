<?php

/**
 * @see              https://mtranslate.myridia.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: MTranslate
 * Plugin URI: https://wordpress.org/plugins/mtranslate
 * Description: Automatically translate your Site based on your Domain, a source and target Language.
 * Version: 1.1.0
 * Author: veto, Myridia Company
 * Author URI: http://mtranslate.myridia.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: mtranslate
 * Domain Path: /languages
 * Update URL: https://github.com/myridia/mtranslate
 * Constant Prefix: WPMTR_
 * Prefix: wpmtr_
 * Option_key: mtranslate
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
use WPMTR\Dt\Class\WPMTR_Admin;
use WPMTR\Dt\Class\WPMTR_Frontend;


/*
 * Constants Calls
 * @since 1.0.0 (if available)
 */
define('WPMTR_PLUGIN_FILE', __FILE__);
define('WPMTR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPMTR_PLUGIN_URL', plugin_dir_url(__FILE__));

/*
 * Default Plugin activate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_activation_hook(__FILE__, ['WPMTR\Dt\Class\WPMTR_Admin', 'activate']);

/*
 * Default Plugin deactivate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_deactivation_hook(__FILE__, ['WPMTR\Dt\Class\WPMTR_Admin', 'deactivate']);


/*
 * Default Plugin uninstall hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_uninstall_hook( __FILE__, ['WPMTR\Dt\Class\WPMTR_Admin', 'uninstall']);


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
    $plugin = new WPMTR_Admin();
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
    /*
require_once $_SERVER['DOCUMENT_ROOT']. "/wp-includes/html-api/class-wp-html-tag-processor.php";
$html = "<p>xxxxx<em>hello</em></p>";
$tags = new WP_HTML_Tag_Processor( $html );
while ( $tags->next_tag() ) {
while ( $tags->next_token() ) {
if ( '#text' === $tags->get_token_type() ) {
  $tags->set_modifiable_text("ffffff");                
  $text = $tags->get_modifiable_text();
  error_log($text);                
} 
}
}

$html2 = $tags->get_updated_html();
error_log(json_encode($html2));
    */

    if (defined('DOING_AJAX') && DOING_AJAX) {
        //error_log("xxxxx");
    }else {
        //error_log("bbbbb");        
    $plugin = new WPMTR_Admin();
    $plugin->add_menu_setting();
    $plugin2 = new WPMTR_Frontend();
    }
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

    if (false === strpos($className, 'WPMTR\\Dt')) {
        return;
    }
    
    $className = str_replace('WPMTR\\Dt\\', __DIR__.'/src/', $className);
    $classFile = str_replace('\\', '/', $className).'.php';
    require_once $classFile;
});
