<?php
/**
 * Template Name: Basic Layout
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
 
 get_header();
 

 ?> 



	<?php 
	
		if( is_page('projects') ){
			
			?><br><br><br>
			<center>
			<img title='Projects' src='/wp-content/uploads/SSI-Projects-header.png'>
			</center><br>
			<?php 
		}
		
		//twentysixteen_post_thumbnail();

	
	$count = 0;
	
	$post_type = "ssi_" . $post->post_name;
	
			$args = array( 

				'post_type' => $post_type,
				'posts_per_page' => -1,
				'orderby' => 'modified'

			 );
			
			$leads = get_posts( $args );
			
		echo "<hr>";
			if( get_field( "display_title", $post->ID ) == "No" ){   }else{ 
			
				echo "<h3><center><u>" . count($leads) . "</u></center></h3>";
				the_title( '<h1 class="entry-title text-center">', '</h1>' ); 

			}

		echo "<hr>"; ?>
		
		
					
			
<button id='addnew' class='btn btn-block btn-lg btn-info '>Add New</button><br>
<div id='addnew' class='addnew clear' style='display: none;'>

<form method="post">
<div class='well taskcard'>

	<div class='col-md-12'>
		<b>Project</b><br>
		<input type="text" name="post_title" placeholder="Project Name" >
	</div>
	<div class='clearfix'></div><br>
	<div class='col-md-12'>
		<b>Project</b><br> 
		
		<select name="assigned_project" style='width: 100%;'>
		
			<option value="-">No Project</option>
			<?php
					$projects = get_posts( array('post_type' => 'ssi_projects', 'posts_per_page' => -1, 'orderby' => 'modified') );
					
					
					foreach( $projects as $lead ){
						
						?>
						
						
						<option value="<?php echo $lead->ID; ?> - <?php echo $lead->post_title; ?>"><?php echo $lead->ID; ?> - <?php echo $lead->post_title; ?></option>
						<?php
					}
						
				?>
			</select>
	</div>
	<div class='clearfix'></div><hr>
	
	<div class='col-sm-3 hidden ' >
				<b>Posted By: </b><br> <?php 
				$author = wp_get_current_user();
				//$recent_author = get_current_user( 'ID', $lead->post_author );
				//print_r($author);
				
				
				echo $author->user_nicename; ?> 
				<div class='clearfix'></div><br>
			</div>
			<div class='col-sm-4' >
				<b>Assigned To: </b><br> <select name="assigned_to" style='width: 100%;'>
					
					<option value="all">All</option>
				<?php

					foreach( $staff as $lead ){
						
						?>
						<option value="<?php echo $lead->post_name; ?>"><?php echo $lead->post_title; ?></option>
						<?php
					}
						
				?>
					
					
					
				</select> 
				<div class='clearfix'></div><br>
			</div>	
			 <div class='col-sm-4'>
			 
				<div class='col-xs-9'>
					<input type="text" name="target_hours" placeholder=".25" >
				</div>
				<div class='col-xs-3'>
					Hrs
				</div>
				<div class='clearfix'></div><br>
			 </div>
			 
			<div class='col-md-4'>
				<input type="text" name="target_budget" placeholder="$$$" >
				<div class='clearfix'></div><br>
			</div>
		<div class='clearfix'></div><br>
		<div class='col-md-6'>
		<b>Start Date</b><br>
		<input  type="text" name="trans_date" placeholder="mm/dd/yy" value="<?php echo current_time( 'm/d/y' ); ?>" >
	</div>
		<div class='col-md-6'>
		<b>Target Date</b><br>
		<input  type="text" name="target_date" placeholder="mm/dd/yy" value="<?php echo current_time( 'm/d/y' ); ?>" >
	</div>
	<div class='clearfix'></div><br>
		<b>Notes:</b>
		<textarea name="notes" id="" cols="30" rows="3"></textarea>
			<input type="submit" class="btn btn-block">
	
</div>	

			<input type="hidden" name="time" placeholder="Time" value="<?php echo current_time( 'g:i' ); ?> pm" >
			<input type='hidden' name='post_type' value='ssi_projects'>
			<input type='hidden' name='ssi_insert_post' value='1'>
			



</form>
	
</div>

		
		<?php
			
			$count = 0;
			
			foreach($leads as $brand){
				?> 
				
			<div class='well'>	
				<div class='col-md-6'> 
					<div class='col-xs-offset-1 col-xs-10 text-center'> 
					<?php
					
						echo get_the_post_thumbnail( $brand->ID);
						
					
					?>
					</div>
				</div>
				
				<div class='col-md-5'> 
				<?php
					
					//echo get_the_post_thumbnail($brand->ID);
					echo "<h3 class='text-center'>" . $brand->post_title . "</h3> ";
					echo "<br><p>" . $brand->post_excerpt . "</p>";
				?>
					
						
				<div class='col-xs-5'>
				<b>Last Activity:</b>
				
				</div>
				<div class='col-xs-7'> 
					<?php echo date('M d, Y' , strtotime($brand->post_modified)); ?>
					
				</div>
				<div class='clear'><br></div>	
					<div class=' clear'></div>
				<div class='col-xs-5'>
				<b>Project Contact:</b>
				
				</div>
				<div class='col-xs-7'> 
					<a href="<?php echo get_field('project_contact_link', $brand->ID ); ?>" target="_blank"><u><?php echo get_field('project_contact', $brand->ID ); ?></u></a>
					
				</div>
				<div class='clear'><br></div>
				<div class=' clear'></div>
				<div class='col-xs-5'>
				<b>Website Link:</b>
				
				</div>
				<div class='col-xs-7'> 
					<a href="<?php echo get_field('project_link', $brand->ID ); ?>" target="_blank"><u><?php echo get_field('project_link_title', $brand->ID ); ?></u></a>
					
				</div>
				<div class='clear'><br></div>
				<div class=' clear'></div>
				<div class='col-xs-5'>
				<b>Project Dates:</b>
				
				</div>
				<div class='col-xs-7'> 
					<?php echo get_field('project_start_date', $brand->ID ); ?>
					 -- <?php if( get_field('project_start_date',$brand->ID ) != 'on-going' ){ echo "Current";}else{ echo get_field('project_end_date', $brand->ID ); } ?>
					
				</div>
				
				<div class='clear'><br></div>
					<div class=' clear'></div>
				<div class='col-xs-5'>
				<b>Hashtags:</b>
				
				</div>
				<div class='col-xs-7'> 
					<?php 
					$posttags = get_the_tags($brand->ID);
					if ($posttags) {
					  foreach($posttags as $tag) {
						echo $tag->name . ' '; 
					  }
					}
				
				?>
					
				</div>
					<div class=' clear'></div>
				
		<!--		<div class='col-md-5'> 
				<b>Highlights:</b>
				</div>
				<div class='col-md-7'> 
					<?php echo get_field('project_budget', get_the_ID() ); ?>

				</div>
		
				<div class='clear'><br></div>
				<div class='col-md-12'>
				<a href='/web' class='btn btn-default'> Web Hosting </a>
				
				</div>
		-->			<div class='clear'><hr></div>
					<a href='/<?php echo $brand->post_type; ?>/<?php echo $brand->post_name; ?>' class='btn btn-info btn-block'>More Details >> </a>
				</div>
				<div class='clear'><br></div>
			</div> 
			
			<div class='clear'><br></div>
				
				<?php
				$count++;
				if( ($count % 1) == 0 ){ ?> <?php }
			}
	
	 ?>


<div id="primary" class="">
	<main id="main" class="container" role="main">	



		<?php


		//$args = array( 'post_type' => 'ssi_clients' , 'posts_per_page' => -1 );
		//$leads = get_posts( $args );
			 

		//print_r($leads);

		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			//get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				//comments_template();
			}

			// End of the loop.
		endwhile;
		?>
		
		

	</main><!-- .site-main -->
	
	

	<?php //get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>