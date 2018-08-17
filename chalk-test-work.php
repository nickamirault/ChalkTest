<?php

 /**************************Chalk_Test_Work************************************
 Handles the grunt work for the plugin,  processing the json, grouping and
 html output
 *******************************************************************************/
  
class Chalk_Test_Work{
		
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
			
			//I would normally link to an external CSS file instead of adding inline CSS
			echo '<ul style="list-style: none;">';
								
			foreach ($team_data as $teams) { 
				//Catch a new Conference and set as a header
				if ($conference <> $teams["conference"]){
					$conference = $teams["conference"];
					echo '<h1><strong>' . $conference . '</strong></h1></p>';
				}
				//Catch a new division and set as a new sub-header
				if ($division <> $teams["division"]){
					$division = $teams["division"];
					echo '<div style="padding-left:20px;"><strong>' . $division . '</strong></div>';
				}
				
				//print the city of the team
				echo '<li style=padding-left:70px;">'.$teams["name"] .  '</li>';
			}
			
			echo '</ul>';
			
				
	}

	//Gets the json from the server based on the url and the api key from the admin settings
	public function get_json($url,$key){
		//get everything back from the url
		$url_request = wp_remote_get( $url.$key);
		
		//error out if theres a problem
		if( is_wp_error( $url_request ) ) {
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
	

