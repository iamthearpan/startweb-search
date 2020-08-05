<?php

	//searching algorithm
	function searchFromDatabase($database_connection, $query_string, $table_name, $row_name){

		//breakdown query string in array
		$query_string_array = explode(' ',$query_string);

		//selecting all data from database
		$sql = "SELECT * FROM ".$table_name;
		$mysqli_data = mysqli_query($database_connection,$sql);

		while($mysqli_result = mysqli_fetch_array($mysqli_data)){

			//breaking the result and put into an array
			$mysqli_result_array = explode(",", $mysqli_result[$row_name]);
			$matching_count = 0;

			//matching query_string_array to mysqli_result_array
			foreach ($query_string_array as $single_string) {
				foreach ($mysqli_result_array as $word_mysqli) {
					$word_mysqli_array = explode(" ", $word_mysqli);
					foreach ($word_mysqli_array as $single_mysqli) {
						if (strtolower($single_string) == strtolower($single_mysqli)) {
							$matching_count += 1;
						}
					}
				}
			}

			//making an array with matching count and id
			if(isset($arr)){
			$arr[$mysqli_result['id']] = $matching_count;
			}else{
				$arr = array($mysqli_result['id'] => $matching_count);
			}
		}

		//array sorting in assending order
		arsort($arr);

		//all matching are done now returning the array
		return $arr;
	}