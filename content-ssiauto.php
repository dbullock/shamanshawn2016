<div class='clearfix'></div>

<div id='autos' class='services autos'>
		
		<div class='container text-center'>
		<h2>#SSI Auto Sales</h2><hr>
			
			<div class="col-xs-6 col-sm-4 col-sm-offset-2">
				
				<img class='img-responsive aligncenter' src='http://shamanshawn.com/wp-content/uploads/SSIAuto-1.jpe'>
				

				
			</div>
			<div class="col-xs-6 col-sm-4">
				<img class='img-responsive aligncenter' src='http://shamanshawn.com/wp-content/uploads/SSIAuto-for-sale.jpe'>
			

			</div>
		</div>
			<div class='clearfix'></div><hr>
	<div class='container text-center autos'>
		<h4>Our Vehicles</h4>
		
	
<hr>

<br>


			<?php 
				$args = array( 'post_type' => 'ssi_vehicles' , 'posts_per_page' => 8 , 'order' => 'RAND' );
				$trips = get_posts( $args );

				$t_id = 0;

				foreach( $trips as $lead ){
?>
	<div class='well'>

		<div class='col-xs-12 h3 red'><?php echo $lead->post_title; ?></div>
				<div class='clearfix'></div><hr>
		<div class='col-sm-3'>
		<?php
				$thumb_id = get_post_thumbnail_id( $lead->ID );
			$thumb_url_array = wp_get_attachment_image_src(  $thumb_id, 'thumbnail', true);
			$thumb_url = $thumb_url_array[0];

				 
				
				if( get_post_thumbnail_id( $lead->ID ) ){
					?>
					<img src='<?php echo $thumb_url; ?>' class='' >
					<?php
					
				}
				?>
				<br>
				(25 Photos)
				<br><br>
			
			
		<div class='clearfix'></div>
		</div>
		<div class='col-sm-6'>
			
		

			
			<div class='text-left'>
				<div class='col-sm-6'>
					<div class='col-sm-4 col-xs-6'><b>Year:</b></div>
					<div class='col-sm-8 col-xs-6'><?php echo get_field( 'MX_vehicle_year'  , $lead->ID ); ?></div>
						<div class='clearfix'></div><hr>
					<div class='col-sm-4 col-xs-6'><b>Make:</b></div>
					<div class='col-sm-8 col-xs-6'><?php echo get_field( 'MX_vehicle_make'  , $lead->ID ); ?></div>
						<div class='clearfix'></div><hr>
					<div class='col-sm-4 col-xs-6'><b>Model:</b></div>
					<div class='col-sm-8 col-xs-6'><?php echo get_field( 'MX_vehicle_model'  , $lead->ID ); ?></div>
					<div class='clearfix'></div><hr>
				</div>
				<div class='col-sm-6'>
					<div class='col-xs-6'><b>Mileage:</b></div>
					<div class='col-xs-6'><?php echo get_field( 'MX_vehicle_mileage'  , $lead->ID ); ?></div>
						<div class='clearfix'></div><hr>
					<div class='col-xs-6'><b>Condition:</b></div>
					<div class='col-xs-6'><?php echo get_field( 'MX_vehicle_condition'  , $lead->ID ); ?></div>
						<div class='clearfix'></div><hr>
					<div class='col-xs-6'><b>Transmission:</b></div>
					<div class='col-xs-6'><?php echo get_field( 'MX_vehicle_transmission'  , $lead->ID ); ?></div>
					<div class='clearfix'></div><hr>
				</div>
				
							<div class='clearfix'></div>

			</div>
			
			<div class='clearfix'></div>
					<div class='col-xs-12 h4 red'>Kelly Blue Book: $<?php echo get_field( 'MX_vehicle_kbb'  , $lead->ID ); ?></div><br>
					
			
			

			
		
		</div>
		<div class='col-sm-3'>
		
			<h4>PRICE</h4>
			<h1 class='red'>$<?php echo get_field( 'MX_vehicle_weekly'  , $lead->ID ); ?> <small class='red'>/wk</small></h1>
			<br>$<?php echo get_field( 'MX_vehicle_down'  , $lead->ID ); ?> Down + <?php echo get_field( 'MX_vehicle_term'  , $lead->ID ); ?> weeks<br><hr>
			
			<a href='/vehicle/<?php echo $lead->post_name; ?>' class='btn btn-lg btn-default btn-block'>More Info >></a>
			
			
		<div class='clearfix'></div>
		</div>
		
		<div class='clearfix'></div>
	</div>		
			<?php
			}
			
		
		
	?>
					
<div class='clearfix'></div>

		<a href='/autos' class='btn btn-lg btn-info btn-block'>View All Vehicles >></a>
<div class='clearfix'></div><br><br>
</div>

		
	
	</div>

<div class='clearfix'></div>
