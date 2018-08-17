<?php

/**************************Chalk_Test_Admin*************************************
 Handles the admin settings for the plugin,  which is only api_key
********************************************************************************/
  
class Chalk_Test_Admin{
		
	//load everyghing needed for this class
	public function __construct() {
		$this->load_hooks();
	}
		
	//loads the hooks needed to integrate within the settings menu
	private function load_hooks(){
		add_action('admin_menu', function() {
			add_options_page( 'Chalk Test Settings', 'Chalk Test Settings', 'manage_options', 'my-awesome-plugin', array($this,'chalk_admin_settings_render' ));
		});
	
	}
	
	//handles the postback/processing of the settings
	function chalk_admin_settings_render(){
		 //update the api key
		 if (isset($_POST['api_key'])) {
			$value = $_POST['api_key'];
			update_option('api_key', $value);
		}

		//get the api_key from wordpress and set to default if need be
		$value = get_option('api_key', '74db8efa2a6db279393b433d97c2bc843f8e32b0');

		//load the html for the form	
		include 'form-chalk-settings.php';
	}
	
}
	

