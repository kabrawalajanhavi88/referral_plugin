<?php
/* Plugin name: WP Referral Plugin
 Description: A simple referreal plugin with user registration form
 Version : 1.0 */

 if(!defined('ABSPATH')){
 	exit;
 }

 function wp_referral_plugin_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'referrals';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        firstname varchar(55) DEFAULT '' NOT NULL,
        lastname varchar(55) DEFAULT '' NOT NULL,
        email varchar(55) DEFAULT '' NOT NULL,
        password varchar(55) DEFAULT '' NOT NULL,
        code varchar(55) DEFAULT '' NOT NULL,
        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'wp_referral_plugin_activate');

// Enqueue frontend scripts and styles
function RP_enqueue_scripts() {
	wp_enqueue_style('rp-style',plugins_url('/css/style.css',__FILE__));
		wp_enqueue_script('rp-script',plugins_url('/js/custom.js',__FILE__),array('jquery'), null, true);
		wp_localize_script('rp-script', 'wrp_ajax', array(
	        'ajax_url' => admin_url('admin-ajax.php')
	    ));	
   
}
add_action('wp_enqueue_scripts', 'RP_enqueue_scripts');

 require_once plugin_dir_path(__FILE__).'includes/class-rp-frontend.php';
 require_once plugin_dir_path(__FILE__).'includes/class-rp-admin.php';
 require_once plugin_dir_path(__FILE__).'includes/class-rp-settings.php';
 require_once plugin_dir_path(__FILE__).'includes/class-rp-list-table.php';

 
 /**
  * Initialize the plugin
  */
 class WP_Referreal_Plugin
 {
 	
 	public function __construct()
 	{
 		add_action('plugin_loaded',array($this,'init'));
 	}

 	public function init(){
 		new RP_Frontend();
 		new RP_Admin();
 		new RP_Settings();
 	}
 }

 new WP_Referreal_Plugin();

