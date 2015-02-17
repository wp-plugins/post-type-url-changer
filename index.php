<?php
/**
 * Plugin Name: Post Type URL Changer
 * Plugin URI: http://burimshala.com
 * Description: Change any post URL to a custom one
 * Version: 1.0
 * Author: Burim Shala
 * Author URI: http://burimshala.com
 * Text Domain: um_lang
 * License: GPL2
 */

require_once plugin_dir_path( __FILE__ )."/admin.php";
require_once plugin_dir_path( __FILE__ )."/metabox.php";
require_once plugin_dir_path( __FILE__ )."/url_injector.php";

/*Register Post Types Option*/
function um_plugin_activate() {
  add_option('um_post_type_url_changer_post_types', null );
}
register_activation_hook( __FILE__, 'um_plugin_activate' );

/*Enqeueu CSS and JS*/
function um_url_changer_enq_scripts() {
	wp_enqueue_style('um_change_url_style',plugins_url('assets/css/style.css',__FILE__));
}
add_action('admin_enqueue_scripts', 'um_url_changer_enq_scripts' );
?>