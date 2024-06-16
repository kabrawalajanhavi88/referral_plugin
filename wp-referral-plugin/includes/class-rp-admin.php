<?php

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

Class RP_Admin{
	public function __construct(){
		add_action('admin_menu',array($this,'add_menu'));

	}

	public function add_menu(){
		add_menu_page(
	        'Referral History',      // Page title
	        'Referral History',      // Menu title
	        'manage_options',        // Capability
	        'wrp-referral-history',   // Menu slug
	        array($this,'wrp_referral_history_page')// Callback function
	    );
	}

	public function wrp_referral_history_page(){
		 ?>
    	<div class="wrap">
	        <h2>Referral History</h2>
	        <form method="post">
	            <?php
	            $referral_list_table = new RP_List_Table();
	            $referral_list_table->prepare_items();
	            $referral_list_table->display();
	            ?>
	        </form>
	    </div>
    <?php
	}
	
}

