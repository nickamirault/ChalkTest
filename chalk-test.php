<?php
/**
 * Plugin Name: Chalk Code Test
 * Author: Nick Amirault
 * Github: https://github.com/nickamirault/chalktest.git
 * Description: A code test for chalk,  parses a json response from server
 *              and outputs a grouped response in html. Developed with OOP in mind.
 *				I would have liked to get more time on this to pretty up the output
 *				a bit more. But i'm finishing up a contract at the same time. 
 *			
 * shortcode [chalk-test]
 *				
 */
 
 
 /****************************Chalk_Test****************************************
 The main entry class, handles the shortcode which starts the plugin execution.
 *******************************************************************************/
  
class Chalk_Test{
	protected $work;
	protected $admin;

	//Load all dependent files, hooks and classes needed for this class
    public function __construct() {
         $this->load_dependencies();
		 $this->load_hooks();
		 $this->work = new Chalk_Test_Work();
		 $this->admin = new Chalk_Test_Admin();
    }
	
	//Loads all the class files, normally on a larger project I would have the 
	//classes under a class folder.
	private function load_dependencies() {
		require_once('chalk-test-admin.php');
		require_once('chalk-test-work.php');
	} 
	
	//add the shortcode to wordpress
	private function load_hooks(){
		add_shortcode( 'chalk-test', array($this,'run'));
	}
	
	//branch out to the Chalk_Test_Work class and start processing
	public function run(){
		$this->work->get_json('http://delivery.chalk247.com/team_list/NFL.JSON?api_key=',get_option('api_key'));
	}
	
	
}
	
//Load the class so WordPress knows were here.	
$test=new Chalk_Test();











	
