<?php

 /**************************Chalk_Test_Work************************************
 Handles the grunt work for the plugin,  processing the json, grouping and
 html output
 *******************************************************************************/
  
class Chalk_Test_Work{
	
	//load everyghing needed for this class
	Public function __construct() {
		$this->load_hooks();
	}
	
	//add the hooks for this class
	private function load_hooks(){
		//hook to load CSS file 
		add_action( 'wp_enqueue_scripts', array($this,'chalk_load_css'));
	}
	
	//loads the CSS file for this class
	public function chalk_load_css(){
		$url = plugin_dir_url( __FILE__ );
		wp_enqueue_style( 'chalktest', $url . 'css/chalk_test.css' );
	}
	
	
	//parses the array and outputs the html, just in unordered list for an example
	private function output_html($team_array){
				
			$team_data=$team_array;
			
			//set the array columns for grouping/sorting
			$conference=array_column($team_data,'conference');
			$division=array_column($team_data,'division');
			
			/*multisort sorts the array by the previously set columns. I'm also
			sorting Ascending*/
			array_multisort($conference, SORT_ASC, $division, SORT_ASC, $team_data);
					
			/*This section loops through the array and prints the elements
			based on the previous set grouping , conference & division
			in an unordered list*/
			
			$conference='';
			$division='';
			
			echo '<ul class="chalklist">';
								
			foreach ($team_data as $teams) { 
				//Catch a new Conference and set as a header
				if ($conference <> $teams["conference"]){
					$conference = $teams["conference"];
					echo '<h1 class="chalklist_h1">' . $conference . '</h1></p>';
				}
				//Catch a new division and set as a new sub-header
				if ($division <> $teams["division"]){
					$division = $teams["division"];
					echo '<div class="chalklist_subheader">' . $division . '</div>';
				}
				
				//print the city of the team
				echo '<li class="chalklist_city">'.$teams["name"] .  '</li>';
			}
			
			echo '</ul>';
			
				
	}

	//Gets the json from the server based on the url and the api key from the admin settings
	public function get_json($url,$key){
		//get everything back from the url
		$url_request = wp_remote_get( $url.$key);
		
		//error out if theres a problem
		if( is_wp_error( $url_request ) ) {
			echo 'Error: loading '.$url.$key;
			return false; 
		}
		
		//get the body from the retrieved request
		$body = wp_remote_retrieve_body( $url_request );
		
		//decode the json into an array
		$data = json_decode( $body,true );
		
		//if the array is not empty output it into html
		if( ! empty( $data ) ) {
			$this->output_html($data["results"]["data"]["team"]);
		}
	}

}
	

