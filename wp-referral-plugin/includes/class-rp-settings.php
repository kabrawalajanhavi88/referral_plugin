<?php

Class RP_Settings{
	public function __construct(){
		add_action('admin_init',array($this,'register_settings'));
		add_action('admin_init',array($this,'add_setting_page'));
		

	}

	public function register_settings(){
		register_setting('wrp_setting_group','wrp_join_commission');
	}

	public function add_setting_page(){
		add_options_page('Referral Plugin Settings','Referral Settings','manage_options','wrp-settings',array($this,'setting_page'));
	}

	public function setting_page(){
		?>
		<div class="wrap">
			<h2>Referral Plugin Settings</h2>
			<form method="post" accept="options.php">
				<?php
		            settings_fields('wrp_setting_group'); ?>
		            <table>
		            	<tr>
		            		<th>Join Commission</th>
		            		<td><input type="text" name="rp_join_commission" value="<?php echo esc_attr(get_option('rp_join_commission','50'));?>"/> </td>
		            	</tr>
		            </table>
		            <?php
		            submit_button();
            	?>
			</form>
		</div>
	<?php
	}
	
}

