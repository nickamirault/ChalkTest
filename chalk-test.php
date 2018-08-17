<?php
/**
 * Plugin Name: Chalk Code Test
 * Author: Nick Amirault

 */
 

 
class Chalk_Test{

    public function __construct() {
         $this->load_dependencies();
     }

	private function load_dependencies() {
	 
		require_once('chalk-test-work.php');
		$this->Work = new Chalk_Test_Work();
	}

	public function run(){
		$this->Work->Get_Json('http://delivery.chalk247.com/team_list/NFL.JSON?api_key=74db8efa2a6db279393b433d97c2bc843f8e32b0');
		
	}
	
	
}


function Chalky(){
	
	$test=new Chalk_Test();
	$test->run();

}


	add_shortcode( 'chalk-test', 'Chalky' );
