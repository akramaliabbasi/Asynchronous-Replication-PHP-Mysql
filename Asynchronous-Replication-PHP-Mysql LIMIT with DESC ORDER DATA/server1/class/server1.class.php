<?php
@include("includes/config.php");
class server1{

	public function __construct(){
		$this->dbconnection();
	}

	private function dbconnection(){
		$this->con = mysqli_connect(HOST,DBUSER,DBPASSWORD,DBNAME) or mysqli_connect_error();
	}

	public function getdbupdate(){
		$table_list = $this->table_list();

		if(count($table_list)>0){
			foreach ($table_list as $key => $table_name) {
				$response_array['data'][$table_name] = $this->synch_table_data($table_name);
			}
			$response_array['status']="success";
			$response_array['message']="Database synchronization initiated.";

			return $response_array;
			exit;
		} else {
			$response_array['status']="fail";
			$response_array['message']="No Tables Found.";
			$response_array['data']=array();
			return $response_array;
			exit;
		}
	}	

	private function table_list(){
		$table_query = mysqli_query($this->con,"SHOW TABLES");
		$table_array = array();

		if(mysqli_num_rows($table_query)>0){
			while($table_query_data = mysqli_fetch_assoc($table_query)){
				$table_array[] = $table_query_data['Tables_in_'.DBNAME];
			}
		}
		return $table_array;
	}

	private function synch_table_data($table_name){
		$table_check_query = mysqli_query($this->con,"show create table `".$table_name."`");
		if(mysqli_num_rows($table_check_query)>0){
			$table_structure_string = mysqli_fetch_assoc($table_check_query);
			$table_structure_string = $table_structure_string['Create Table'];
			$table_structure_string = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $table_structure_string);

			$post_data['table_name'] = $table_name;
			$post_data['table_structure'] = $table_structure_string;
			
			//$table_query = mysqli_query($this->con,"select * from `".$table_name."`  LIMIT 4000");
			
			
			//++++++++++++++++++++++++++NOTE++++++++++++++++++++++++++++//
			//LIMIT is added becoasue of its error out of memory
			// counter fileld is added dumy due to geting data in DESC Order becasue of id field is not exist in all tables
			$table_query = mysqli_query($this->con,"SELECT *, @counter := @counter + 1 AS 'counter' FROM `".$table_name."`, (SELECT @counter := 0) `".$table_name."` ORDER BY counter DESC LIMIT 4000");
			
			
			
			if(mysqli_num_rows($table_query)>0){
				$c = 0;
				while($table_data = mysqli_fetch_assoc($table_query)){
					
				
					//++++++++++++++++++++++++++NOTE++++++++++++++++++++++++++++//
					// some special characters were getting errors while inserting so it was replaced before inserting
					
					$table_data = array_map(function($valuess) { 
						
						$table_data = str_replace("'","\'",$valuess);
						$table_datas = str_replace("'\'","\\",$table_data);
						$table_datass = str_replace("'\\'","\\\\",$table_datas);
						RETURN $table_data.'';
						
					}, $table_data);
				
					$post_data['table_data'][] = $table_data;
					
				//++++++++++++++++++++++++++NOTE++++++++++++++++++++++++++++//	
				// Due to field_count option incresing 2 more extra fileds counter and @counter := 0 therefore server2 occurs errors
				//Accordilly both extra fields or removed
				unset($post_data['table_data'][$c]['counter']);
				unset($post_data['table_data'][$c]['@counter := 0']);
				$c++;
				}	
				
			}
			
			
			//SYNC DATA TO LIVE SERVER
			$ch = curl_init(SYNC_URL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
			// execute!
			$response = curl_exec($ch);
			// close the connection, release resources used
			curl_close($ch);

			return $response;
		} else {
			return 'Table Structure Not Found.';
		}
	}

	public function __destruct(){
		mysqli_close($this->con);
	}
}
?>
