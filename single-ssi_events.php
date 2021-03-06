<?php 
/*
Template Name: Mansion Page
*/
get_header('acf');
?>

<?php $current_user = wp_get_current_user(); ?>
<?php

if($_GET['show_location']){ 
	//update_user_meta( $current_user->ID, 'show_location', $_GET['show_location'] );
	foreach ($_GET as $param_name => $param_val) {
			
			update_user_meta( $current_user->ID, $param_name, $param_val );
			//update_post_meta( $postID, $param_name, $param_val );
		}
}
if($_GET['update']){
	if($_GET['mystery']){
		
		
		$EventName = date("M jS", strtotime(get_field('event_date',get_the_ID())));
		
		$catID = get_cat_ID( $EventName );
							//$category =  get_the_category($EventID);
							$cats = array();
							
							array_push($cats, $catID);
		
		$name = "Guest";
		
		if($_GET['alias'] == ""){ $name = "Guest"; }else{ $name = $_GET['alias']; }
		
		if($_GET['username']){ $name = $_GET['username']; }
		
		// Create post object
		$my_post = array(
		  'post_title'    => $name,
		  'post_type'  => 'event_guests',
		  'post_status'   => 'publish',
		  'post_author'   => 1,
		  'post_category' => $cats
		);
		 
		// Insert the post into the database
		$postID = wp_insert_post( $my_post );
		add_post_meta($postID , 'showed_up', 'No' );
		add_post_meta($postID , 'event_host', 'No' );
		add_post_meta($postID , 'user_ID', $_GET['userID'] );
		update_post_meta($postID , 'vortex_system_likes', 1 );
		update_post_meta($guestID  , 'event_time_in', $_GET['time'] );
		wp_publish_post( $postID ); 
		wp_update_post( $postID ); 
		
		
		foreach ($_GET as $param_name => $param_val) {
			
			update_user_meta( $current_user->ID, $param_name, $param_val );
			update_post_meta( $postID, $param_name, $param_val );
		}
		
		update_user_meta( $current_user->ID, 'stats_confirmed', true );
	}

	
	
	
	if($_GET['here']){
		
		
		//$EventName = date("M jS", strtotime(get_field('event_date',get_the_ID())));
		
		$guestID = $_GET['ID']; 
		update_post_meta($guestID  , 'showed_up', 'Yes' );
		update_post_meta($guestID  , 'event_time_in', $_GET['time'] );
		
	}
	
	if($_GET['left']){
		
		
		//$EventName = date("M jS", strtotime(get_field('event_date',get_the_ID())));
		
		$guestID = $_GET['ID']; 
		//3update_post_meta($guestID  , 'showed_up', 'No' );
		update_post_meta($guestID  , 'event_time_out', $_GET['time'] );
		
	}
}


$folks = get_posts( array (  
		
	   'posts_per_page'         =>  -1,
	  'post_type' => 'events_guests',
	//	'post_title' => $lead->post_title,
		'category_name'                  => 'vip-members' ,
		'post_status'                => 'draft',
		'order' => 'asc',
		//'offset' => 2
	   // 'meta_key'               => 'vortex_system_likes',
		//'categories'	=>	array( -147 ),
	)     );
	
	
	$EventID = 'event' . get_the_ID();
	
	
	$EventName = date("M jS", strtotime(get_field('event_date',$RegisteredID)));
			$EventID = 'event' . get_the_ID();
			
			
			if(!is_category($EventName)){
				
					$my_cat = array('cat_name' => $EventName, 'category_description' => '', 'category_nicename' => $EventID, 'category_parent' => '');

				// Create the category 
				$my_cat_id = wp_insert_category($my_cat);
			}
			
			
	
	foreach( $folks as $lead ){
		
		  $my_post = array(
			  'ID'           => $lead->ID,
			  'post_title'   => $lead->post_title,
			 // 'post_content' => 'This is the updated content.',
		  );

		  
		    add_post_meta($lead->ID , 'showed_up', 'No' );
		// Update the post into the database
		  wp_update_post( $my_post );
		
		set_post_type( $lead->ID , 'event_guests' );
		wp_publish_post( $lead->ID ); 
	
		
	}	
	$sort_folks = get_posts( array (  
		
	  'post_type' => 'event_guests',
	
	)     );

	foreach( $sort_folks as $lead ){
	
		if(get_field('event_registered' , $lead->ID ) ){  //echo "HERE";
			
			$RegisteredID = get_field('event_registered' , $lead->ID );
			$EventName = date("M jS", strtotime(get_field('event_date',$RegisteredID)));
			$EventID = 'event' . get_the_ID();
			
			
			if(!is_category($EventName)){
				
					$my_cat = array('cat_name' => $EventName, 'category_description' => '', 'category_nicename' => $EventID, 'category_parent' => '');

				// Create the category 
				$my_cat_id = wp_insert_category($my_cat);
			}
			
			

			$catID = get_cat_ID( $EventName );
			$category =  get_the_category($EventID);
			$cats = array();
			
			array_push($cats, $catID);
			
			//echo "<br>HERE-->" . $EventName . "-- " . $EventID . "-- " . $catID;
			
			//print_r($cats);
			wp_set_post_categories( $lead->ID ,$cats , 1 ); 
		}
	}



			
				$guests = get_posts( array (
						
					   'posts_per_page'         =>  -1,
					   'post_type' => 'event_guests',
						'category_name'                  => 'event' . get_the_ID() ,
					    'order'                  => 'asc',
						//'orderby'                => 'meta_value_num',
						//'meta_key'               => 'vortex_system_likes',
						//'categories'	=>	array( -147 ),
					)     );
					
		$hosts = get_posts( array (
			
		   'posts_per_page'         =>  -1,
		   'post_type' => 'event_guests',
			'category_name'                  => 'event' . get_the_ID() ,
			//'post_status'                => 'draft',
			'order' => 'asc',
			//'offset' => 2
		   // 'meta_key'               => 'vortex_system_likes',
			//'categories'	=>	array( -147 ),
		)     );
		
		$num_showed = 0;
		$num_hosts =  0;
		
		foreach( $hosts as $lead ){
						if( get_field( 'event_host' , $lead->ID ) == 'No' ){ 
							continue;	
						}
						$num_hosts++;
		}
		foreach( $hosts as $lead ){
						if( get_field( 'showed_up' , $lead->ID ) == 'No' ){ 
							continue;	
						}
						//update_post_meta(  $lead->ID  , 'showed_up' , 'No' ) ;
						$num_showed ++;
		}
		$num_guests = count($guests);
		
		$updateID = get_the_ID();
		$num_vips = $num_guests - $num_hosts;
		
		if($num_vips > 5 ) $num_vips = 5;
	
		update_post_meta($updateID , 'event_hosts', $num_hosts );
		update_post_meta($updateID , 'event_rsvps', $num_guests );
		update_post_meta($updateID , 'event_vips', $num_vips );
		update_post_meta($updateID , 'event_showed', $num_showed );
		
?>


<div class='col-xs-12 text-center'>
	<div class='col-xs-8 col-xs-offset-2 text-center'>
	
	
	
				<?php 
				$args = array( 'post_type' => 'ssi_events' , 'posts_per_page' => 1 , 'order' => 'ASC' );
				$leads = get_posts( $args );

				$t_id = 0;

				foreach( $leads as $lead ){

			

			$s_date = date('Y-m-d', strtotime(  get_field( 'lead_start_date', $lead->ID ) ) );
			
			if( get_field( 'lead_start_date', $lead->ID ) != "" ){

				$e_date = get_field( 'lead_end_date', $lead->ID );
				$e_date = date('Y-m-d', strtotime(  $e_date ) );

			}else{
				
				$e_date = date('Y-m-d', strtotime(  current_time( 'mysql' ) ) );
				
			}

			$c_date = date('Y-m-d', strtotime(  current_time( 'mysql' ) ) );

			//echo "<br> SD==>" . $s_date . "<br> ED==>" . $e_date . "<br> CD==>" . $c_date;

			
			if(  ( strtotime( $c_date ) <= strtotime( $e_date ) ) &&  ( strtotime( $c_date ) >= strtotime( $s_date ) )   ){
				//echo "<br>BEFORE<br>";

				
				$t_id = $lead->ID;

				//echo "<div class='col-md-6'>" . $lead->post_title . "</div>";
				//echo "<div class='col-md-6'>Since " . get_field( 'lead_start_date', $lead->ID ) . '</div>';
 				//break;
			}else{
				//echo "<br>AFTER<br>";
			}
		
		}
	?>
					

					<div class='clearfix'></div>
	
	
		<?php 
		
		//echo date("m-d-y");
		if( strtotime(date("m-d-y")) > strtotime(date("m-d-y", get_field('event_date'))) ){
					
					//echo 'HERE';
				}else{
					echo get_field( 'event_countdown' ); 
				}
		
		?>
									
	
	</div>
	<div class='clearfix'></div>
<div class='col-xs-10 col-xs-offset-1 text-center hidden'>		
	<img src='<?php echo get_field( 'event_flyer' ); ?>' class=' img-responsive'>	
	
</div>	
<div class='clearfix'></div>

				
			
	
	
	</div>
	
	
	<div class='clearfix'></div>

			

	<div class='col-sm-8 col-sm-offset-2'>
	
	
	
		<div class='text-center border flyer  well '>
		
	
			<h3><?php the_title(); ?></h3>
					
			
			<?php the_post_thumbnail('medium', array('alt' => get_the_title(), 'title' => '')); ?>
		
		<div class='clearfix'></div><br>
		
		
			<div class='col-xs-6 '>
				<b><u>Date</u></b><br><?php date_default_timezone_set("America/New_York"); 

					echo date("M jS", strtotime(get_field('event_date')));
					?>
					
												
			</div>
			<div class='col-xs-6 '>
				<b><u>Time</u></b><br><?php 
				
				//echo date("g:i a", strtotime(get_field('event_end'))); 
				echo get_field('event_start');
				echo ' - ';
				 echo get_field('event_end');
				//echo ' <br>';
				
				//echo date("g:i A");
				
				?>

				<?php //echo get_field( 'event_time' ); ?>
				
				
			</div>
			<div class='clear '></div><br>
				
				<b><u>Location</u></b>

				<?php 
					if( 1 /*get_user_meta( $current_user->ID , 'show_location' ,  1) == 'true' */){
						?>
						<h6><?php echo get_field( 'event_location' ); ?></h6>
						
						<?php
					}else{
						?>
						<br>
						<button id="address" class="btn btn-default">Show Location</button>
						<?php
						
					}
				?>
		
		
		<div id="address" class="col-xs-12  " style="display:none;">
		<div class="well">
				
		<form method='get'>
				<h4><center>For FULL Location</center></h4>
			<h3><center>Enter Your Phone#:</center></h3><hr>	
				
			<div class=' col-xs-12'>
				 <input type='phone' name='MX_user_phone' placeholder='1-555-555-5555' required>
				
<!--				
				 <input name='username' type='hidden' value='<?php echo $current_user->display_name; ?>'>
					<input name='userID' type='hidden' value='<?php echo $current_user->ID; ?>'>
					
					<input name='mystery' type='hidden' value='true'>
					<input name='update' type='hidden' value='true'>
-->					
					<input name='show_location' type='hidden' value='true'>
					<input type='submit' value='Show Location' class='btn btn-success btn-block btn-lg'>
			</div>
			
		</form>
		<div class='clear '></div>
		</div>
		
		
		</div>
<br>		 
			

		<br><h4><?php echo get_field( 'event_price' ); ?></h4>
	<br><br>	
		
				__<br>
				<?php echo get_field( 'event_details' , $lead->ID); ?>
		<br><br><br><br>	
		
		<div class='text-left col-md-12 mansion well'>
	
		<h2 style='margin=0;' class='text-center '>The GUEST List</h2><hr>
		
		<div class='h4'>
			<?php

					//print_r( $folks );
					// Start the loop.
					$count = 1;
					
					//$folks = (array)$query;
					
					?>
						<center>The Host's</center><hr>
							<?php 
							
					foreach( $hosts as $lead ){
						if( get_field( 'event_host' , $lead->ID ) == 'No' ){ 
							continue;	
						}
						
						?>
						<div class='col-md-6'>
							<?php 
							
							echo ($count) . ". ";
								$count++;
							?>
							<a target='_blank' href='/user-profile?ID=<?php echo get_field( "user_ID" , $lead->ID ); ?>'>
								<?php echo $lead->post_title;  ?>
							</a>
								<br>
				<?php 
				
				$user_logged_in = 0;
				$user_is_admin = 0;
			$user = wp_get_current_user();
			$allowed_roles = array('editor', 'administrator');
	
			if ( is_user_logged_in() && array_intersect($allowed_roles, $user->roles ) ) {
					$user_logged_in = 1;
					$user_is_admin = 1;
					?>
					<br>
		<form method="post" action="" class='pull-left'>
			<button name="update" type="submit" class='btn btn-danger' value="Remove Lead" />Delete</button>
			<input name="ID" type="hidden" value="<?php echo $lead->ID; ?>" />
			<input name="post_to_draft" type="hidden" value="true" />
			<input name="URI" type="hidden" value="<?php echo get_page_link(); ?>" />
		</form>

		<a target='_blank' href='/wp-admin/post.php?post=<?php echo $lead->ID ; ?>&action=edit' class='btn btn-default pull-left'>Edit Lead</a>
		
			<?php } ?>
							
							
						</div>
			<div class='col-md-6 pull-right text-right'>
						
						<?php 
			$user = wp_get_current_user();
			$allowed_roles = array('editor', 'administrator');
		
	
			if( get_field( 'event_time_in' , $lead->ID )  ){ 
					echo "<span class='num text-center here'>HERE@ </span>";
						echo get_field( 'event_time_in' , $lead->ID );
				}else{
					
					if ( is_user_logged_in() && array_intersect($allowed_roles, $user->roles ) ) {
					?>
					<a href='?update=1&here=1&ID=<?php echo $lead->ID; ?>&time=<?php echo date("g:i A"); ?>' class='btn- btn-default'>Here Now!</a>
				<?php
					}
					
				}

					?>

					
	<?php if( get_field( 'event_time_out' , $lead->ID ) ){

			?>
				/ Left@
				<?php
				echo get_field( 'event_time_out' , $lead->ID );  
					
			}else{
					if ( is_user_logged_in() && array_intersect($allowed_roles, $user->roles ) ) {
					?>
					/ <a href='?update=1&left=1&ID=<?php echo $lead->ID; ?>&time=<?php echo date("g:i A"); ?>' class='btn- btn-default'>Left Out!</a>
					<?php 
					
					}	
				
			}
					?>
		</div>
					
					<div class='clearfix'></div><hr>
				<?php
					}
						?>
						<center>Top 5 RSVP's</center><hr>
							<?php
					$count = 1;
					foreach( $guests as $lead ){
						
							if( get_field( 'event_host' , $lead->ID ) == 'Yes' ){ 
							continue;	
						}
						
						
						?>
						<div class='col-md-6'>
							<?php 
							
							echo ($count) . ". ";
								$count++;
							?>
							<a target='_blank' href='/user-profile?ID=<?php echo get_field( "user_ID" , $lead->ID ); ?>'>
								<?php echo $lead->post_title;  ?>
							</a>
							
								<br>
				<?php 
				
				$user_logged_in = 0;
				$user_is_admin = 0;
			$user = wp_get_current_user();
			$allowed_roles = array('editor', 'administrator');
		

					
			if ( is_user_logged_in() && array_intersect($allowed_roles, $user->roles ) ) {
					$user_logged_in = 1;
					$user_is_admin = 1;
					?>
					<br>
		<form method="post" action="" class='pull-left'>
			<button name="update" type="submit" class='btn btn-danger' value="Remove Lead" />Delete</button>
			<input name="ID" type="hidden" value="<?php echo $lead->ID; ?>" />
			<input name="post_to_draft" type="hidden" value="true" />
			<input name="URI" type="hidden" value="<?php echo get_page_link(); ?>" />
		</form>

		<a target='_blank' href='/wp-admin/post.php?post=<?php echo $lead->ID ; ?>&action=edit' class='btn btn-default pull-left'>Edit Lead</a>
		
			<?php } ?>
			
			
						</div>
						<div class='col-md-6 pull-right text-right'>
						
				
						<?php 
						
					
						
						
			$user = wp_get_current_user();
			$allowed_roles = array('editor', 'administrator');

							
				
			
			if( get_field( 'event_time_in' , $lead->ID )  ){ 
					echo "<span class='num text-center here'>HERE@ </span>";
						echo get_field( 'event_time_in' , $lead->ID );
				}else{
					
					if ( is_user_logged_in() && array_intersect($allowed_roles, $user->roles ) ) {
					?>
					<a href='?update=1&here=1&ID=<?php echo $lead->ID; ?>&time=<?php echo date("g:i A"); ?>' class='btn- btn-default'>Here Now!</a>
				<?php
					}
				
					
				}
						
				
				
					
					?>
					
					
					
	<?php if( get_field( 'event_time_out' , $lead->ID ) ){


			?>
				/ Left@
				<?php
				
				echo get_field( 'event_time_out' , $lead->ID );  
					
			}else{
					if ( is_user_logged_in() && array_intersect($allowed_roles, $user->roles ) ) {
					?>
					/ <a href='?update=1&left=1&ID=<?php echo $lead->ID; ?>&time=<?php echo date("g:i A"); ?>' class='btn- btn-default'>Left Out!</a>
					<?php 
					
					}	
				
			}
					
					
					
					?>
						</div>
						<div class='clearfix'></div><hr>
						
						<?php if($count == 6){ ?>
						
						<center>The RSVP's</center>
					
						<div class='clearfix'></div><hr>
					<?php } } ?>
		</div>
			<?php
					$user = wp_get_current_user();
			$allowed_roles = array('editor', 'administrator');
		
			if ( is_user_logged_in() && array_intersect($allowed_roles, $user->roles ) ) {
				?>
				
				<form method='get'>
					<input name='alias' type='text' placeholder='Name'>
					<input name='time' type='hidden' value='<?php echo date("g:i A"); ?>'>
					<input name='mystery' type='hidden' value='true'>
					<input name='update' type='hidden' value='true'>
					<input type='submit' value='Add Guest'>
				</form>
				<br>
					<a href='?update=1&mystery=1&time=<?php echo date("g:i A"); ?>' class='btn- btn-default'>(+) Mystery Man</a>
					<br>
					
				<?php
			}
				?>
		
			
	</div>
		<div class='clearfix'></div><br>
		
		<?php $user = wp_get_current_user(); ?>
			
<?php
	$max_guests = get_field('event_max_guests');
 if( $count <= $max_guests ){ ?>		
	<div id="Verify" style="display: block;">		

		<button id="Verify" class="btn btn-success btn-block btn-lg">I AM Going! >></button>	<br>
			
		<a href='/events' class='btn btn-danger btn-block btn-lg'><< Im NOT Going</a>	<br>
	</div>			
<?php }else{ ?>
		<h3>This Event had <u><?php echo $max_guests; ?></u> Seats!</h3>
		<br>
		
		<div id="Verify" style="display: block;">		

		<button id="Verify" class="btn btn-danger btn-lg">> Join the Overflow List <</button>	<br>
			
		
	</div>	
<?php } ?>		
		
			
	<div id="Verify" class="  " style="display:none;">
		<div class="well">
				
		<form method='get'>
				
			<h3><center>Confirm - Basic Info</center></h3><hr>	
				<div class=' col-xs-6'>
				Name:
			</div>
			<div class=' col-xs-6'>
				 
				 <input name='username' type='text' value='<?php echo $current_user->display_name; ?>' required>
			</div>
				<div class=' col-xs-6'>
				Phone#:
			</div>
			<div class=' col-xs-6'>
				 
				 <input name='MX_user_phone' type='text' value='<?php	echo get_user_meta($current_user->ID, 'MX_user_phone', "user_" . $current_user->ID); ?>' required>
			</div>
				<div class=' col-xs-6'>
				Email:
			</div>
			<div class=' col-xs-6'>
				 
				 <input name='MX_user_email' type='text' value='<?php	echo get_user_meta($current_user->ID, 'MX_user_email', "user_" . $current_user->ID); ?>' required>
			</div>
				<div class=' col-xs-6'>
				City:
			</div>
			<div class=' col-xs-6'>
				 
				 <input name='MX_user_city' type='text' value='<?php	echo get_user_meta($current_user->ID, 'MX_user_city', "user_" . $current_user->ID); ?>' required>
			</div>
				<div class=' col-xs-6'>
				State:
			</div>
			<div class=' col-xs-6'>
				 
				 <input name='MX_user_state' type='text' value='<?php	echo get_user_meta($current_user->ID, 'MX_user_state', "user_" . $current_user->ID); ?>' required>
			</div>
			<div class='clearfix'></div><hr>
			
			<div class="event-info h4">
					<div class='clearfix'></div><br>
						<div class="col-xs-6">
							<b>Are you Hosting?</b>
						</div>
						<div class="col-xs-6">
							<?php 
							
								$att = get_user_meta($userid, 'event_host', 1);
								$options = array( 'No', 'Yes' );

							?>
							<select name="event_host" >
							<?php 
								foreach($options as $option){
									
									?>
									<option value="<?php echo $option;?>" <?php if ($att == $option) echo "selected='selected'";?>><?php echo $option;?></option>
									<?php
								}
							?>
							</select>

						</div>
					</div>
			<div class='clearfix'></div><hr>
			<p>NOTICE - Only RSVP if you Plan to SHOW UP!</p>
			
			<div class='clearfix'></div><hr>
			
					
					<input name='userID' type='hidden' value='<?php echo $current_user->ID; ?>'>
					<input name='time' type='hidden' value='<?php echo date("g:i A"); ?>'>
					<input name='mystery' type='hidden' value='true'>
					<input name='update' type='hidden' value='true'>
					<input type='submit' value='CONFIRM' class='btn btn-success btn-block btn-lg'>
					

		
		</form>
			<br>
			
		<a href='/events' class='btn btn-danger btn-block btn-lg'><< Im NOT Going</a>	
			<br>
				
		</div>
			
	</div>		
			<div class='clearfix'></div>
			
		<center>			

					
		</center>
						
			
	
		</div>
	</div>

	<div class='col-sm-4 hidden'>
		<br>

			<h4><?php echo get_field( 'event_quote' ); ?></h4>
			<br>
			<?php the_post_thumbnail('medium', array('alt' => get_the_title(), 'title' => '')); ?>
		
		<br><br>
		
			
			<h3>PAY $5 Online!<br><small>($10 at the DOOR)</small></h3><?php 
			
		echo do_shortcode('[stripe name="stripe Payment" description="Online Booking" amount="500"]');
			
			?><br>
	</div>
	

</div>

<div class='clearfix'></div><br>

<?php if( get_field( 'free_vip' ) ){  ?>
<div class='clearfix'></div><hr>
<div class='text-center'>
	
		<h1> First 5 VIP's<br><small> Get in FREE!</small></h1>
	
</div>
<div class='clearfix'></div><hr>

<?php } ?>
	
</div>
<div class='clearfix'></div><br>
<!--
		
		<div class='clearfix'></div><hr>
		<h1>HOSTING</h1>
		<hr>
		<center>
		
		<div class='col-sm-2 text-center hidden'>
			<br>
		</div>
	
		<?php
		foreach( $hosts as $lead ){
			if( get_field( 'event_host' , $lead->ID ) == 'No' ){ 
							continue;	
						}
			
			$userID = get_field( 'user_ID' , $lead->ID );
			
			
			//$user = wp_get_current_user();
			
			$today = strtotime('today');
			$today_end = strtotime('tomorrow');
			$date = '10/11/16'; #could be (almost) any string date


			//echo '<br>--->' . $date; 
			//echo '<br>--->' . $person->post_date;
			

				if ( strtotime( $lead->post_date ) < strtotime( $date ) ) {
					#$date occurs today
					
					//continue;
				} 
				//echo $person->post_title . "<br>";
				
				//echo get_post_meta(  $person->ID ,'vortex_system_likes' , true);
				
				?> 
				
							<div class='col-sm-4 text-center'>
							
							
		<?php 		
		
			if( get_field( 'showed_up' , $lead->ID ) == 'Yes' ){ 
				//echo "<span class='num text-center'>HERE NOW!!</span>";	
				
				
				//$temp = $query[$swap++];
				//$query[$swap] = $query[$count];
				//$query[$count] = $temp;	
				//$query = array('one' => $query['one']) + $query;
									//$count++;
			}else{
				
				//echo "<span class='num'>" . ($count+1) . "</span>";	

									//$count++;
				
			}
						
				?>
		<br><br>
		
		
		<div class='video-set well'>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>		
			
	
				<?php echo $lead->post_title; ?>
				
			</article>


			<div class='col-md-12 h3'>
				

				
			<?php 
				
				echo "<center>" . get_field( 'member_level', $lead->ID ) . "</center>";
				
					if ( has_post_thumbnail( $lead->ID ) ) {
    			
				$small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $lead->ID ), 'thumbnail' );	
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $lead->ID ), 'large' );	
						
   						if ( ! empty( $large_image_url[0] ) ) {
        						echo '<a href="' . esc_url( $large_image_url[0] ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
        						//echo get_the_post_thumbnail( $lead->ID, 'thumbnail' ); 
        						echo '</a>';

   					 	}
						?>
						<img src='<?php echo esc_url( $small_image_url[0] ); ?>' class='aligncenter' width='150'> 
						
						<?php 
					}else{
						?>
						<img src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' width='150'>
						
						<?php 
						
					}
		
				?>
			
				
			</div>

			
			<div class='clearfix'></div>
			
			 <center><?php 
			
					echo get_field( 'MX_user_age', $lead->ID ); echo " -- ";
					echo get_field( 'MX_user_height', $lead->ID ); echo " -- ";
					echo get_field( 'MX_user_weight', $lead->ID ); echo "<br>";
					//echo get_field( 'vip_position', $lead->ID ); echo " -- ";
					//echo get_field( 'vip_size', $lead->ID ); echo "in<br>";	
					
					?>
					
					<br>
<div class='pix'>				
	<a target='_blank' href='/party_guests/<?php echo $lead->post_name; ?>'>
	<?php if( get_field( 'lead_image_1', $lead->ID ) ){ ?>		
			<div class='col-xs-3 pad0'><img width='65' height='65' src='<?php echo get_field( 'lead_image_1', $lead->ID );?>' style='width: 65px; height: 65px;'></div>
	<?php }else{
		?>
		<div class='col-xs-3 pad0'><img width='65' height='65' src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' ></div>
		<?php
	}
	?>
	<?php if( get_field( 'lead_image_2', $lead->ID ) ){ ?>				
			<div class='col-xs-3 pad0'><img width='65' height='65' src='<?php echo get_field( 'lead_image_2', $lead->ID );?>' style='width: 65px; height: 65px;'></div>
	<?php }else{
		?>
		<div class='col-xs-3 pad0'><img width='65' height='65' src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' ></div>
		<?php
	}
	?>
	<?php if( get_field( 'lead_image_3', $lead->ID ) ){ ?>				
			<div class='col-xs-3 pad0'><img width='65' height='65' src='<?php echo get_field( 'lead_image_3', $lead->ID );?>' style='width: 65px; height: 65px;'></div>
	<?php }else{
		?>
		<div class='col-xs-3 pad0'><img width='65' height='65' src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' ></div>
		<?php
	}
	?>
	<?php if( get_field( 'lead_image_4', $lead->ID ) ){ ?>				
			<div class='col-xs-3 pad0'> <img width='65' height='65' src='<?php echo get_field( 'lead_image_4', $lead->ID );?>' style='width: 65px; height: 65px;'></div>
	<?php }else{
		?>
		<div class='col-xs-3 pad0'><img width='65' height='65' src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' ></div>
		<?php
	}
	?>
	</a>
		
<div class='clearfix'></div>
</div>	
					<?php
					
			
					$the_post - get_post($lead->ID);
					$content = $the_post->post_content;
					//echo $content;
					
				
					$likes = $dislike = 0; 

					$likes =  get_post_meta($lead->ID,'vortex_system_likes',true);
					$dislikes =  get_post_meta($lead->ID,'vortex_system_dislikes',true);

				
				?>
		
		
		
	<div class='clearfix'></div><br>
				<div class="col-xs-offset-3 col-xs-3 vortex-p-like 12168 ">
				
				<a class='icon-thumbs-up-1' href='/<?php echo $lead->post_type; ?>/<?php echo $lead->post_name; ?>' ><?php echo  $likes; ?></a>
			
					
				</div>
				
				<div class="col-xs-3 vortex-p-dislike 12168 ">
				<a class='icon-thumbs-down-1' href='/<?php echo $lead->post_type; ?>/<?php echo $lead->post_name; ?>' ><?php echo  $dislikes; ?></a>
				
				
				</div>
				
		<div class='clearfix'></div><br>
		
		<a target="_blank" href='<?php echo $lead->guid; ?>' class='btn btn-default'>View Profile >></a>
		<div class='clearfix'></div><br>

			<div class='clearfix'></div>
			</a>
			
			<?php 
		
	
			$user = wp_get_current_user();
			$allowed_roles = array('editor', 'administrator');
		
			if( get_field( 'showed_up' , $lead->ID ) == 'Yes' ){ 
					echo "<span class='num text-center here'>HERE NOW!!</span>";	
				}
		?>
							
	
				
		</div>
		<br>
		
	</div>
				
				
				
		<?php } ?>
		
		
		</center>
		
		
		
	
		<div class='clearfix'></div><center>
		<hr>
		<h1>Confirmed Guest's</h1>
		<hr>
		
			</center>
	-->			
			
		<?php
		$count = 0;
		
		$confirmed_guests = get_posts( array (
						
					   'posts_per_page'         =>  -1,
					   'post_type' => 'event_guests',
						
						'category_name' => 'event' . get_the_ID() ,
					      'order'                  => 'asc',
						//'orderby'                => 'meta_value_num',
						//'meta_key'               => 'vortex_system_likes',
					)     );
		
		$emails = array();
		
		foreach( $confirmed_guests as $lead ){
			array_push($emails,get_field( 'vip_email', $lead->ID )); 
			
			if( get_field( 'event_host' , $lead->ID ) == 'Yes' ){ 
							continue;	
						}
			
			
			$today = strtotime('today');
			$today_end = strtotime('tomorrow');
			$date = '10/11/16'; #could be (almost) any string date


			//echo '<br>--->' . $date; 
			//echo '<br>--->' . $person->post_date;
			

				if ( strtotime( $lead->post_date ) < strtotime( $date ) ) {
					#$date occurs today
					
					//continue;
				} 
				//echo $person->post_title . "<br>";
				
				//echo get_post_meta(  $person->ID ,'vortex_system_likes' , true);
				
				?> 
				
							<div class='col-sm-4 text-center hidden'>
		<?php 		
		
			
			echo "<span class='num'>" . ($count+1) . "</span>";	

									$count++;
						
				?>
		<br><br>
		
		
		<div class='video-set well'>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>		
			
	
				<?php echo $lead->post_title; 
				
				if( get_field( 'showed_up' , $lead->ID ) == 'Yes' ){ 
					echo "<br><span class='num text-center small'>HERE NOW!!</span>";	
				}
				?>
				
			</article>


			<div class='col-md-12 h3'>
				

				
			<?php 
				
				$guestID = get_field( 'user_ID' , $lead->ID );
				echo "<center>" . get_field( 'member_level', $guestID ) . "</center>";
				
				
				echo get_avatar($guestID);
		/*		
					if ( has_post_thumbnail( $guestID ) ) {
    			
				$small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $guestID ), 'thumbnail' );	
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $guestID ), 'large' );	
						
   						if ( ! empty( $large_image_url[0] ) ) {
        						echo '<a href="' . esc_url( $large_image_url[0] ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '">';
        						//echo get_the_post_thumbnail( $lead->ID, 'thumbnail' ); 
        						echo '</a>';

   					 	}
						?>
						
						<a target='_blank' href='<?php echo $lead->guid; ?>'>
						<img src='<?php echo esc_url( $small_image_url[0] ); ?>' class=' aligncenter' width='150'> 
						</a>
						<?php 
					}else{
						?>
						<a target='_blank' href='<?php echo $lead->guid; ?>'>
						<img src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' width='150'>
						</a>
						<?php 
						
					}
		*/
				?>
			
				
			</div>

			
			<div class='clearfix'></div>
			
			 <center><?php 
			
				//	echo get_field( 'MX_user_age', $guestID ); echo " -- ";
				//	echo get_field( 'MX_user_height_ft', $guestID ); echo "' ";
				//	echo get_field( 'MX_user_height_in', $guestID ); echo " -- ";
				//	echo get_field( 'MX_user_weight', $guestID ); echo "<br>";
				
				if(get_field( 'MX_user_position', $guestID) != "" ){
					echo get_field( 'MX_user_position', $guestID);
				}else{
					
					echo " -- ";
				}
				//	echo get_field( 'MX_user_endowment', $guestID ); echo "in<br>";	
					
					?>
					
					
					<div class='clearfix'></div><br>
<div class='pix hidden'>				
	<a target='_blank' href='/party_guests/<?php echo $lead->post_name; ?>'>
	<?php if( get_field( 'lead_image_1', $guestID ) ){ ?>		
			<div class='col-xs-3 pad0'><img width='65' height='65' src='<?php echo get_field( 'lead_image_1', $guestID );?>' style='width: 65px; height: 65px;'></div>
	<?php }else{
		?>
		<div class='col-xs-3 pad0'><img width='65' height='65' src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' ></div>
		<?php
	}
	?>
	<?php if( get_field( 'lead_image_2', $guestID ) ){ ?>				
			<div class='col-xs-3 pad0'><img width='65' height='65' src='<?php echo get_field( 'lead_image_2', $guestID );?>' style='width: 65px; height: 65px;'></div>
	<?php }else{
		?>
		<div class='col-xs-3 pad0'><img width='65' height='65' src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' ></div>
		<?php
	}
	?>
	<?php if( get_field( 'lead_image_3', $guestID ) ){ ?>				
			<div class='col-xs-3 pad0'><img width='65' height='65' src='<?php echo get_field( 'lead_image_3', $guestID );?>' style='width: 65px; height: 65px;'></div>
	<?php }else{
		?>
		<div class='col-xs-3 pad0'><img width='65' height='65' src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' ></div>
		<?php
	}
	?>
	<?php if( get_field( 'lead_image_4', $guestID ) ){ ?>				
			<div class='col-xs-3 pad0'> <img width='65' height='65' src='<?php echo get_field( 'lead_image_4', $guestID );?>' style='width: 65px; height: 65px;'></div>
	<?php }else{
		?>
		<div class='col-xs-3 pad0'><img width='65' height='65' src='http://ssixxx.com/wp-content/uploads/2016/08/man-blank-profile.png' class=' aligncenter' ></div>
		<?php
	}
	?>
	</a>
		
<div class='clearfix'></div>
</div>	
					<?php
					
//$content_post = get_post($lead->ID);
//$content = $content_post->post_content;
//$content = apply_filters('the_content', $content);
//$content = str_replace(']]>', ']]&gt;', $content);
//echo $content;
						
					//$the_post - get_post($lead->ID);
					//$content = $the_post->post_content;
					//echo $content;
					
					
					$likes = $dislike = 0; 

					$likes =  get_post_meta($lead->ID,'vortex_system_likes',true);
					$dislikes =  get_post_meta($lead->ID,'vortex_system_dislikes',true);

				
				?>
		
		

				<div class="col-xs-offset-3 col-xs-3 vortex-p-like 12168 hidden ">
				
				<a class='icon-thumbs-up-1' href='/<?php echo $lead->post_type; ?>/<?php echo $lead->post_name; ?>' ><?php echo  $likes; ?></a>
			
					
				</div>
				
				<div class="col-xs-3 vortex-p-dislike 12168 hidden">
				<a class='icon-thumbs-down-1' href='/<?php echo $lead->post_type; ?>/<?php echo $lead->post_name; ?>' ><?php echo  $dislikes; ?></a>
				
				
				</div>

		
		<a target="_blank" href='/user-profile/?ID=<?php echo $guestID; ?>' class='btn btn-default'>View Profile >></a>
		<div class='clearfix'></div><br>

			<div class='clearfix'></div>
	
			</a>
			
			<?php 
				$user = wp_get_current_user();
			$allowed_roles = array('editor', 'administrator');
		
			if( get_field( 'showed_up' , $lead->ID ) == 'Yes' ){ 
					echo "<span class='num text-center here'>HERE NOW!!</span>";	
				}else if ( is_user_logged_in() && array_intersect($allowed_roles, $user->roles ) ) {
		?>
					<a href='?update=1&here=1&ID=<?php echo $lead->ID; ?>&time=<?php echo date("g:i A"); ?>' class='btn- btn-default'>Here Now!</a>
		<?php
		
		
			}
		?>
		</div>
		<br>
		
	</div>
				
				
				
		<?php } ?>

<div class='clearfix'></div><hr>
		
			<div class='col-xs-10 col-xs-offset-1 text-center well'>		

<div class='col-sm-12 col-md-4  '>
							<h2>PARTY STATS:<br><small>(Real Time - EST)</small></h2>
						
						</div>
						<div class='col-md-4 col-sm-6'><br>
							<u>Current Date</u> <br><br><?php date_default_timezone_set("America/New_York"); 

										echo date("l - M d, Y"); ?>
						
						</div>
						<div class='col-md-4 col-sm-6'><br>
							<u>Current Time</u> <br><br><?php echo date("g:i A"); ?>
						</div>
<br>						

						<div class='clearfix'></div><hr>
				
				
				
				
			
		

<?php 

				$current_party_date = '';
				$count = 1;
				
				
				
				?>
				<?php if($count > 1){ continue; } ?>
				<hr>
			<div class='<?php if($count == 1){ echo "h2 current-party"; } ?> '>
			 
				<div class='clearfix'></div>
				<div class='col-xs-4'>
					<?php the_field('event_hosts'); ?>
				</div>
				<div class='col-xs-8 text-left'>
					Hosts
				</div>
				<div class='clearfix'></div>
				<div class='col-xs-4'>
					<?php the_field('event_rsvps'); ?>
				</div>
				<div class='col-xs-8 text-left'>
					RSVPs
				</div>
				<div class='clearfix'></div>
				<div class='col-xs-4'>
					<?php the_field('event_vips'); ?>
				</div>
				<div class='col-xs-8 text-left'>
					VIPs
				</div>
				<div class='clearfix'></div>
				<div class='col-xs-4'>
					<?php the_field('event_showed'); ?>
				</div>
				<div class='col-xs-8 text-left'>
					Showed Up
				</div>
				<div class='clearfix'></div>
			
				
				
				<div class='clearfix'></div>
			</div>	
		
	</div>	
				<div class='clearfix'></div>
<div class='clearfix'></div><hr>
		<p class='text-center'>Updated: <?php the_modified_date(); ?></p>

		
		<div class='col-xs-12 mansion'>
			<?php 
				//the_content();
				//echo do_shortcode('[gallery ids="10311,10312,9310"]'); 
			?>
		</div>
	
<div class='clearfix'></div><hr>

	<div class='col-md-6 col-md-offset-3 mansion text-center'>
		<!-- <h2> Mansion Menu </h2>-->
		<a href='/mansion/join-our-vip-list/?event=<?php the_ID(); ?>' class='btn btn-default hidden'>Join Our VIP List</a>
		<a href='/mansion/mansion-vip-list/' class='btn btn-default hidden'>View Our VIP List</a>
		<a href='/mansion/about-the-instaflixxx-mansion/' class='btn btn-default hidden'>About The InstaFliXXX Mansion</a>


		<a href='/mansion/boyz' class='btn btn-default hidden'>View Our Models</a>
		<a href='/mansion/become-a-model/' class='btn btn-default hidden'>Become A Model</a>
		
		
		<a href='/mansion/faqs/' class='btn btn-default hidden'>Frequently Asked Questions</a>
		<a href='/' class='btn btn-default'><< Return to Homepage</a>
		
		<br><br>
			
	</div>
<div class='clearfix'></div>
</div>
	<?php

get_footer(); ?>