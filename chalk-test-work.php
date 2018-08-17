<?php


class Chalk_Test_Work{
	
	private function Output_Html($teamArray){
							
			$team_data=$teamArray;
					
			$conference=array_column($team_data,'conference');
			$division=array_column($team_data,'division');
			array_multisort($conference, SORT_ASC, $division, SORT_ASC, $team_data);
		
			$conference='';
			$division='';
			
			echo '<ul style="list-style: none;">';
			
			
			foreach ($team_data as $teams) { 
				if ($conference <> $teams["conference"]){
					$conference = $teams["conference"];
					echo '<h1><strong>' . $conference . '</strong></h1></p>';
				}
				if ($division <> $teams["division"]){
					$division = $teams["division"];
					echo '<div style="padding-left:20px;"><strong>' . $division . '</strong></div>';
				}
			
				echo '<li style=padding-left:70px;">'.$teams["name"] .  '</li>';
			}
			
				echo '</ul>';
			
				/*	echo '<ul>';
				foreach($data->results->data->team as $teams ) {
					echo '<li>';
						echo $teams->name . ' / ' . $teams->conference  . ' / ' . $teams->division . '</br>';
					echo '</li>';
				}
				echo '</ul>';
			
			*/	
		
	}

	
	public function Get_Json($url){
		$request = wp_remote_get( $url);
		if( is_wp_error( $request ) ) {
			return false; // Bail early
		}
		$body = wp_remote_retrieve_body( $request );
		$data = json_decode( $body,true );
		
		if( ! empty( $data ) ) {
			//print_r($data);
			$this->Output_Html($data["results"]["data"]["team"]);

		}
	}

}
	

