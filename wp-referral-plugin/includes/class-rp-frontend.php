<?php

Class RP_Frontend{
	public function __construct(){
		add_shortcode('wrp_registration_form', array($this,'registration_form'));
		//add_action('wp_enqueue_scripts', array($this,'enqueue_scripts'));
		add_action('wp_ajax_validate_refferal_code', array($this,'validate_refferal_code'));
		add_action('wp_ajax_nopriv_validate_refferal_code', array($this,'validate_refferal_code'));
		add_action('init', array($this,'rp_plugin_handle_form_submission'));
	}

	// public function enqueue_scripts(){
	// 	wp_enqueue_style('rp-style',plugins_url('./css/style.css',__FILE__));
	// 	wp_enqueue_script('rp-script',plugins_url('/js/custom.js',__FILE__),array('jquery'), null, true);
	// 	wp_localize_script('rp-script', 'wrp_ajax', array(
	//         'ajax_url' => admin_url('admin-ajax.php')
	//     ));		
	// }

	//Referral Form
	public function registration_form(){
		ob_start();?>
		<form id="wp-referral-form" method="post">
			<p>
				<label for="rp_fname">First Name</label>
				<input type="text" id="rp_fname" name="rp_fname" required="">
			</p>
			<p>
				<label for="rp_lname">Last name</label>
				<input type="text" id="rp_lname" name="rp_lname" required="">
			</p>
			<p>
				<label for="rp_email">Email</label>
				<input type="text" id="rp_email" name="rp_email" required="">
			</p>
			<p>
				<label for="rp_password">Password</label>
				<input type="text" id="rp_password" name="rp_password" required="">
			</p>
			<p>
				<label for="rp_referral_code">Referral Code</label>
				<input type="text" id="rp_referral_code" name="rp_referral_code">
				<span id="rp_referral_code_status"></span>
			</p>
			<p>
				<input type="submit" value="Register" name="submit_referral">
			</p>        
	      
	    </form>
	
	    <?php
	    return ob_get_clean();

	
	}

	//Create AJAX Handler for Referral Code Validation
	public function validate_refferal_code(){
		if (isset($_POST['rp_referral_code'])) {
	        $referral_code = sanitize_text_field($_POST['rp_referral_code']);
	        
	        // Simulate code validation. Replace this with actual validation logic.
	        $valid_codes = array('ABC123', 'XYZ789');
	        
	        if (in_array($referral_code, $valid_codes)) {
	            wp_send_json_success('Valid code');
	        } else {
	            wp_send_json_error('Invalid code');
	        }
	    }
	    wp_send_json_error('No code provided');
	}

	// Handle form submission and insert data
function rp_plugin_handle_form_submission() {
    if (isset($_POST['submit_referral'])) {
        global $wpdb;

        // Sanitize input        
        $rp_fname = sanitize_text_field($_POST['rp_fname']);
        $rp_fname = sanitize_text_field($_POST['rp_fname']);
        $rp_email = sanitize_text_field($_POST['rp_email']);
        $rp_password = sanitize_text_field($_POST['rp_password']);
        $rp_referral_code = sanitize_text_field($_POST['rp_referral_code']);

        // Table name
        $table_name = $wpdb->prefix . 'referrals';

        // Insert data
        $wpdb->insert(
            $table_name,
            array(
                'firstname' => $rp_fname,
                'lastname' => $rp_fname,
                'email' => $rp_email,
                'password' => $rp_password,
                'code' => $rp_referral_code,
                'time' => current_time('mysql')
            )
        );

        // Redirect or show a success message
        echo '<p>Referral submitted successfully!</p>';
    }
}

}

