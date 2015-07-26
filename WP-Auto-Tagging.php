<?php
/*
Plugin Name: WP-Auto-Tagging
Plugin URI: https://wordpress.org/plugins/wp-auto-tagging/
Description: A Wordpress Plugin to Automatically Generate Tags for Posts and Pages.
Version: 2.0
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
//Limiting Returned Records
$lmSQL = 'SELECT ID, post_title FROM '.$table_prefix.'posts WHERE LENGTH(post_title) > 5 AND post_status="publish" LIMIT 3000';
$lmResult = $conn->query($lmSQL);
//Looping Through Returened Records
if ($result->num_rows >= 1) {
    // output data of each row
    while($row = $lmResult->fetch_assoc()) {
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

//Adding Admin Hooks
add_action('admin_menu', 'wp_auto_tagging_menu');
 
function wp_auto_tagging_menu(){
        add_menu_page( 'WP Auto Tagging Plugin', 'WP Auto Tagging', 'manage_options', 'wp-auto-tagging', 'init_watp_menu' );
}
 
function init_watp_menu(){
		
        echo "<h1>WP Auto Tagging</h1>";
		
		//Twitter Badge Code
		echo '<a href="https://twitter.com/zebicute" class="twitter-follow-button" data-show-count="false">Follow @zebicute</a>';
		echo "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
		
		echo '<h3><a href="http://www.chunoa.com/product/wp-auto-tagging-plugin/" target="_blank">Go Pro</a></h3>';
		
		//Plugins Features
		echo '<ul>
			<li class="li-tag">1. It will read post title and will split title into Tags and will add tags to all the posts automatically (posts which are missing tags).</li>
			
			<li class="li-tag">2. You do not need to manually insert tags for each post.</li>
			
			<li class="li-tag">3. Install WP Auto Tagging Wordpress Plugin, Activate it and tags will be added to all already published posts.</li>
			
			<li class="li-tag">4. WP Auto Tagging will add tags to new posts automatically as well (post you are going to publish now).</li>
			
			<li class="li-tag">5. WP Auto Tagging supports only One word tag. If you want to add tags with more than one word you can contact me at smjunaidiqbal@gmail.com</li>
			
			<li class="li-tag">6. Plugin will skip words in title less than 4 characters.</li>
			
			<li class="li-tag">7. Plugin will generate and add 6 tags for your published posts, you can delete unwanted tags and can update post.</li>
			
			<li class="li-tag">8. All of the generated and added tags will not be deleted once you de-activate WP Auto Tagging Wordpress plugin.</li>
			
		</ul>';
		
		echo "<h1>Free/ Pro Features</h1>";
		echo '<ul>
		<li class="li-tag">1. Plugin is free for your first 3000 posts and will add tags to them automatically.</li>
		<li class="li-tag">2. You will need to purchase pro version of plugin if you have more than 3000 posts.</li>
		<li class="li-tag">3. You will need to pay $99 for pro version of WP Auto Tagging Plugin.</li>
		<li class="li-tag">4. Life time pro version of WP Auto Tagging plugin will let you to add tags for old as well as new posts.</li>
		</ul>';
		
		echo '<h3><a href="http://www.chunoa.com/product/wp-auto-tagging-plugin/" target="_blank">Go Pro</a></h3>';
		
}

//add_shortcode("superb", "test_process_shortcode");
// 
//function test_process_shortcode(){
//echo '<form>';
//echo '<p><label>Your Name<strong>*</strong><br>';
//echo '<input type="text" size="48" name="name" value="one"></label></p>';
//echo '<p><label>Email Address<strong>*</strong><br>';
//echo '<input type="email" size="48" name="email" value="two"></label></p>';
//echo '<p><label>Subject<br>';
//echo '<input type="text" size="48" name="subject" value="three"></label></p>';
//echo '<p><label>Enquiry<strong>*</strong><br>';
//echo '<p><input type="submit" name="sendfeedback" value="Send Message"></p>';
//echo '</form>';
//}

?>