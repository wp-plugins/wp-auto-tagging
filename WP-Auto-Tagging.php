<?php
/*
Plugin Name: WP-Auto-Tagging
Plugin URI: https://wordpress.org/plugins/wp-auto-tagging/
Description: A Wordpress Plugin to Automatically Generate Tags for Posts and Pages.
Version: 1.0
Author: Muhammad Junaid Iqbal
Author URI: http://www.wallpapershdtop.com/
License: GPL
*/
//Get Wordpress Tables Prefix
global $wpdb;
$table_prefix = $wpdb->prefix;
//echo $table_prefix;

// Create Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
	//echo "Connection Established.";
}

//Query to Database
$sql = 'SELECT ID, post_title FROM '.$table_prefix.'posts WHERE LENGTH(post_title) > 5 AND post_status="publish"';
$result = $conn->query($sql);
//Counting SQL Records
$count = $result->num_rows;
//echo $count;

//Looping Through Returened Records
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo  . $row["post_title"]. "<br>";
		$post_ID = $row['ID'];
		$post_title = $row['post_title'];
		$smpost_title = strtolower($post_title);
		//echo ''.$post_ID.' '.$smpost_title.'';
		//echo "<br>";
		
		//First Check if Post Has Already Tags
		$posttags = get_the_tags($post_ID);
		
		if ($posttags) 
		{
			foreach($posttags as $tag) 
			{
				//If Tags Are Available, Do Nothing 
			}
			} 
				else
			{
		
		//Looping Returned Post Title for String Break and Words Length
		$string = $smpost_title;
		$arr = preg_split('/[,\ \.;]/', $string);
		$keywords = array_unique($arr);
		$i=0;
		foreach ($keywords as $keyword){
            if ((preg_match("/^[a-z0-9]/", $keyword) ) && (strlen($keyword) > 3)){
                    //echo $final_tags = ''.$keyword.'';
					$final_tags = ''.$keyword.'';
                    //echo "<br />";
					$i++;
                    if ($i==7) break;
					
					//Updating Post Tags
					//If Tags Are Not Available, Add Tags to It
					
						wp_set_post_tags($post_ID, $final_tags, true );	
				}	
            }
        }
	}
} 
//Closing Database Connection
$conn->close();
?>