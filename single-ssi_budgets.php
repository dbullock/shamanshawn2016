<?php
/**
 * 
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 

if( get_field( 'MX_user_ID', $_GET['ID'] ) ){
	$report_user_ID = get_field( 'MX_user_ID',  $_GET['ID'] );
	$has_user = 1;
	$user = get_userdata( $report_user_ID );
}

if( get_field( 'MX_user_id', $_GET['ID'] ) ){
	$report_user_ID = get_field( 'MX_user_id',  $_GET['ID'] );
	$has_user = 1;
	$user = get_userdata( $report_user_ID );
}


?>
-----------------------------------------------------------------------------------



<br>
	<h1 class="entry-title text-center hidden1">
	<?php
		// Page thumbnail and title.
		
		the_title( '', '' );
	?>'s Budget
	</h1>

<hr>

<div id='payments' class='  payment report col-md-12' style='display: block;'>
			<h5>Details</h5> 
			<div class=''>
				<?php 
								
				// ####################   Service Log	#########

				$client_profit = 0;

				?>
				<div class='clear'><br></div>
				
			
				<div class='col-xs-8 '><b>Description</b></div>

				<div class='col-xs-4  text-center'><b>Rate</b></div>
				
				<div class='clearfix'></div>

				<hr>
				
				
				
				

				<?php 
				
				
				$index  = 1;
				
				$tot_income = $tot_expense = 0;
				
				$initial_investment = 0;
				$return_rate = 0.1;
				$return_amount = 0;
				
				
				$client_profit = 0;

				// check if the repeater field has rows of data
				if( have_rows('service_log' , $lead->ID ) ):

			 	// loop through the rows of data
				    while ( have_rows('service_log', $lead->ID ) ) : the_row();
					
						if( $index == 1 ){ 
							
							$initial_investment = get_sub_field('rate'); 
							$investment_date = get_sub_field('date');
							$return_amount = $initial_investment + ($initial_investment * $return_rate  );
							$index++;
						}
					
				
				?>

			       <div class='col-xs-8 '><?php echo get_sub_field('date'); ?></div>
			
				<div class='col-xs-4  text-center'>
				
				
				<?php the_sub_field('income_expense');?> $ <?php the_sub_field('rate'); ?>
				</div>
				
				<div class='col-xs-12 '>
					<div class='clear'><hr></div>
				</div>
				
				<div class='col-xs-9 '><?php the_sub_field('service'); ?></div>
				
				
				
				<div id='trans<?php the_sub_field('trans_id'); ?>' class='hidden1  col-xs-3 ' style='display: block;'>
				
					<button id='trans<?php the_sub_field('trans_id'); ?>' class='pull-right hidden-print'> >> </button>
				</div>
				
				<?php 
					
						
				if( get_sub_field( 'flex_pay' ) == 'Yes' ){ 

				//echo " "; 

				$flex_count++;
				$flex_total += get_sub_field( 'rate' );
				

			}else if( get_sub_field( 'income_expense' ) == '-' ){ 

				//echo "- "; 


				$expense_count++;
				$client_profit -= str_replace(['+', '-'], '', filter_var( get_sub_field('rate') , FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
				$total_amount -= str_replace(['+', '-'], '', filter_var( get_sub_field('rate') , FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
				$tot_expense += str_replace(['+', '-'], '', filter_var( get_sub_field('rate') , FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
				//$tot_expense += get_field( 'trans_amount', $lead->ID );
				$trans_total = $trans_total - get_field( 'trans_amount', $lead->ID );

			}else{  

				//echo "+ ";  


				$income_count++;
				$client_profit += str_replace(['+', '-'], '', filter_var( get_sub_field('rate') , FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
				
				$total_amount += str_replace(['+', '-'], '', filter_var( get_sub_field('rate') , FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
				
				$tot_income += str_replace(['+', '-'], '', filter_var( get_sub_field('rate') , FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
				
				//$tot_income += get_field( 'trans_amount', $lead->ID );
				$trans_total = $trans_total + get_field( 'trans_amount', $lead->ID );

			}
					
					
					
					?>
				<div class='clearfix'></div>

				
				<div id='trans<?php echo get_sub_field('trans_id'); ?>' class='' style='display: none;'>
					<hr>
					
					<div class='clear well'>
					 <div class='col-xs-6 col-sm-2'><b>Date</b><br><?php echo get_sub_field('date'); ?><br><br></div>
					<div class='col-xs-6 col-sm-2'><b>Time</b><br><?php the_sub_field('time'); ?><br><br></div>
					<div class=' col-sm-2'><b>Location</b><br><?php the_sub_field('location'); ?><br><br></div>
				
					
				
					<div class=' col-sm-2'><b>Trans ID</b><br><?php the_sub_field('trans_id'); ?><br><br></div>
					<div class='clearfix'></div> <br>
					<div class='col-sm-12'><b>Links</b><br><?php the_sub_field('service'); ?><br><br></div>
					<div class='col-sm-12'><b>Service</b><br><?php the_sub_field('service'); ?><br><br></div>
					
					
					<b>Photo: </b>
						<a href='<?php echo get_the_post_thumbnail_url(get_sub_field('trans_id')); ?>'><img src='<?php echo get_the_post_thumbnail_url(get_sub_field('trans_id')); ?>' width='150px' height='150px'></a>
						
					<div class='clearfix'></div> <br>	
					<div class='col-sm-12'><b>Notes</b><br><?php the_sub_field('service'); ?><br><br></div>
					
					<div class='clearfix'></div> <br>	
					
					<button id='trans<?php the_sub_field('trans_id'); ?>' class='pull-right hidden-print'> x close </button>
					<div class='clearfix'></div>	
					</div>
				</div>
				<hr>
				

				<?php
				    endwhile;

				else :

				    // no rows found

				endif;

?>
<div id='details<?php echo $lead->ID; ?>' style='display: block;'>


		
	<button id='add_payment' class='btn btn-info btn-block hidden-print'>Add Payment</button><br>
</div>
	<div id='add_payment' class='' style='display: none;'> 
		<form method="post" action="" name="add_transaction">
				<div class='col-xs-6 col-sm-2'><input  type="text" name="trans_date" placeholder="mm/dd/yy" value="<?php echo current_time( 'm/d/y' ); ?>" ></div>
				<div class='col-xs-6 col-sm-2'><input type="text" name="trans_time" placeholder="Time" value="<?php echo current_time( 'g:i' ); ?> pm" ></div>
				<div class='clearfix visible-xs'></div>
				<div class='col-sm-2'>	<input type="text" name="trans_location" placeholder="Location" value="Location"></div>
				<div class='col-sm-4'><input type="text" name="trans_service" placeholder="Service" Value="Service"></div>
				
				<div class='col-md-1'><input type="text" name="trans_amount" placeholder="Rate"></div>
		<div class='col-md-1'>
			<input type="radio" name="income_expense" value="+">+<br>
			<input type="radio" name="income_expense" value="-">-
		</div>		
				<input type="text" name="post_content" placeholder="Enter Notes..">
				<input type="hidden" name="client_city" value="<?php echo get_field( 'MX_user_city', $lead->ID ); ?>">
				<input type="hidden" name="client_phone" value="<?php echo get_field( 'MX_user_phone', $lead->ID ); ?>">
				<input type="hidden" name="client_state" value="<?php echo get_field( 'MX_user_state', $lead->ID ); ?>">
				
				<input name="ID" type="hidden" value="<?php echo $lead->ID; ?>" />
				<input name="client_id" type="hidden" value="<?php echo $lead->ID; ?>" />

				<input name="URI" type="hidden" value="<?php echo get_page_link(); ?>" />
				<input type='hidden' name='insert_transaction' value='true'>
				<input type='hidden' name="update" value='true'>
				<input type="submit" class="pull-right">
			</form>
		</div>



				<div class='clearfix'></div>
				<hr>
			<?php 
				// #################### END Service Log	#########


				?>
			</div>
		</div>
		<div id='rental' class=' rental col-md-12' style='display: block;'>
			<h5>Summary</h5>
			
			
			<?php the_content(); ?>
			
			
			<div class='clearfix'></div>
			
			<div class='col-xs-4 col-md-4 well1'>
			
				<div class='col-xs-6 hidden'>
					Rate (weekly)
				</div>
				<div class='col-xs-6 hidden'>
					$
					<?php 
					
						echo get_field( 'room_rate', $lead->ID );
							?>
				</div>
					<div class='clear'><br></div>
				<div class='col-xs-6 hidden'>
					Security 
				</div>
				<div class='col-xs-6 hidden'>
					$
					<?php 
						echo $security;
						
							?>
				</div>
					<div class='clear'><br></div>
				<div class='col-xs-6 hidden'>
					App Fee
				</div>
				<div class='col-xs-6 hidden'>
					$
					<?php 
							if( get_field( 'app_fee', $lead->ID ) == 0  ){ 
								echo "Waived!";
							
							}else{
								echo get_field( 'app_fee', $lead->ID );
							}
							?>
				</div>
				

			</div>
			<div class='col-xs-4 col-md-4 hidden1'>
										
<!--  ///////////////////////////////  DATE MAGIC  ///////////////////////////////   -->
	<?php  			
		
		
		
			//echo "MOVEIN: " . date('Y-m-d H:i:s', strtotime(  $investment_date  ) );

		if( get_field( "move-out_date", $lead->ID ) ){ echo "<br>MOVEOUT: " . get_field( "move-out_date", $lead->ID ); }
			
			
			$rate = get_field( 'room_rate', $lead->ID );

			//$s_date = mysql2date('n/j/y', $lead->post_date );

			$s_date = date('Y-m-d H:i:s', strtotime(  $investment_date  ) );
			
			if( get_field( "move-out_date", $lead->ID ) != "" ){

				$s_date = date('Y-m-d', strtotime(  $lead->post_date  ) );
				$e_date = date("Y-m-d H:i:s", strtotime( get_field( "move-out_date", $lead->ID ) ));

				$e_date = get_field( "move-out_date", $lead->ID );
				$e_date = date('Y-m-d', strtotime(  $e_date ) );

			}else{
				
				$e_date = strtotime( "today" );
				
				$e_date = date('Y-m-d H:i:s',  $e_date );
			}
			//echo "SD==>" . $s_date . "ED==>" . $e_date;

			$date1 = date_create( $s_date );
			$date2 = date_create( $e_date );

			//echo "SD==>" . $date1 . "ED==>" . $date2;
			
			//echo get_the_time('U');
			
			//echo ' <br><br>';
			//echo human_time_diff( $date1, $date2 ) . ' ago';
			
			
			$diff=date_diff($date1,$date2);
	
			$tot_days = $diff->format("%a");
			//echo "TOTAL DAYS--->" . $tot_days;

			$weeks = floor($tot_days/7);

			$days = $tot_days - ($weeks*7);

			$app_fee = get_field( 'app_fee', $lead->ID );

		//	echo "<br>WEEKS-> " . $weeks . " DAYS-> " . $days;

	
			

	?>

<!--  ///////////////////////////////  #DATE MAGIC  ///////////////////////////////   -->


			<?php 
				//echo "<div class='col-sm-12' ><b>Last Seen: </b> " . date('n/j/y', strtotime( get_field( 'last_seen', $lead->ID ) ) ) . "</div>"; 
				//	echo "<div class='col-sm-12' ><b>Last Contacted: </b> " . date('n/j/y', strtotime( get_field( 'last_contacted', $lead->ID ) ) ) . "</div>"; 
				//	echo "<div class='col-sm-12' ><b>Added: </b> " . mysql2date('n/j/y', $lead->post_date ) . "</div>"; 
			?>

			</div>
	
			<div class='col-sm-4 col-md-4 '>
				<h4 class='visible-xs'>Budget Summary</h4>
				
				
				<div class=' well'>
			
				<div class='col-xs-6'>
					Income:
				</div>
				<div class='col-xs-6'>
					$
					<?php 
					
						echo $tot_income;
							?>
				</div>
					<div class='clear'><br></div>
				<div class='col-xs-6'>
					Expense: 
				</div>
				<div class='col-xs-6'>
					$
					<?php 
						echo $tot_expense;
						
							?>
				</div>
					<div class='clear'><br></div>
				<div class='col-xs-6'>
					Left Over:
				</div>
				<div class='col-xs-6'>
					$
					<?php 
							echo $client_profit;
							?>
				</div>
				
				<div class='clearfix'></div>
			</div>
			
			
				<div class='pull-right hidden'>
					<?php 
						
						$due = ((($weeks) * $rate)+($security + $rate + $app_fee));
						echo "Invested --->$" . $initial_investment;
					
					

						$tot_owed  += $due;

						echo "<br>Left Over--->$" . $client_profit;
						
						$percent = round((float)$return_rate * 100 ) . '%';
						echo "<br>Return rate --->$" . $percent;
						echo "<br>Return Amount --->$" . $return_amount;
						
						
						$owed = ($due - $client_profit);

					$banked = $loss = 0;
					

					if( $owed < 0 || get_field( "move-out_date", $lead->ID ) ){
						if( $owed < 0 ){ 
							$banked = (-$owed);
							//echo "<br>BANKED: $" . $banked;
						 }
						else{ 
							$loss = $owed; 
							//echo "<br>LOSS: $" . $loss;

							
						}
						if( get_field( 'security_applied', $lead->ID ) == "yes"  ){ 
								//echo "<br>SECURITY APPLIED!!";
								$final = ((-$loss) + $security);
								//echo "<br>FINAL: $" . $final;
							}

						$owed = 0; 
					}
					//	echo "<br><br>Owed: $" . $owed; 
				
						

						$tot_due += $owed;
					?>
				
				</div>
			</div>


		</div>




--------------------------------------------------------------------------------------------
<?php
	
get_footer();
?>