

<?php
/**
 * The template for displaying single Events .
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

get_header();
?>

<main id="site-content">

	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			$post_type = get_post_type( get_the_ID() );
			if ($post_type == 'event') { ?>
	
				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">


					<?php 
							$date = get_post_meta( get_the_ID(), '_ast_event_date', true );
							$time = get_post_meta( get_the_ID(), '_ast_event_time', true );				
							$ast_meta_location = get_post_meta( get_the_ID(), '_ast_selected_location', true );
							$priceamount = intval(get_post_meta( get_the_ID(), '_price', true ));
							$pricesymbol = get_woocommerce_currency_symbol();

							$price = $pricesymbol .''.$priceamount;


							$ids = array($ast_meta_location);
							$args = array( 
							   'post_type' => 'location', // must
							   'post__in' => $ids
							);

							$loop = new WP_Query($args);

							while ($loop->have_posts()):
							$loop->the_post();
							$location_name = get_the_title();
							$city = get_post_meta(get_the_ID(), '_ast_city', true);
							$state = get_post_meta(get_the_ID(), '_ast_state', true);
							$country = get_post_meta(get_the_ID(), '_ast_country', true);
							$latitude = get_post_meta(get_the_ID(), '_ast_Latitude', true);
							$longitude = get_post_meta(get_the_ID(), '_ast_Longitude', true);
							$maplink = get_post_meta(get_the_ID(), '_ast_google_map_link', true);

							$location = '<a target="__blank" href="'.$maplink.'">' . $city . ', '. $state .', '.$country.'</a>';
							endwhile;
							wp_reset_query();

					?>
					<?php 
						if (has_post_thumbnail( $post->ID ) ): 
							$fullpath = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
							$image = $fullpath[0];
						else : 
							$image = get_stylesheet_directory_uri(). '/assets/images/default-banner.jpg';			
						endif; 
					?>
					<div class="single-event-header" style="background-image: url('<?php echo $image; ?>'); background-size: cover;">
						<div class="container">
							<div class="row">
								<div class="col-12">
									<?php 
										echo "<h1 style='color:#fff;'>".get_the_title()."</h1>"; 
										echo "<p class='ast-meta-head'><span class='location icon fa fa-location-arrow'> <strong> Location : </strong>".$location_name."</span></p>";
										echo "<p class='ast-meta-head'><span class='date icon fa fa-calendar'> <strong>Date : </strong>".$date."</span></p> ";
										echo "<p class='ast-meta-head'><span class='time icon fa fa-clock-o'> <strong>Time : </strong>".$time."</span></p>";
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="single-event-body" style="padding: 100px 0;">
						<div class="container">
							<div class="row">
								<div class="col-lg-6">
									<div class="body-event-content">
										<img src="<?php echo $image; ?>" alt="<?php the_title(); ?>">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="body-event-sidebar" style="width:100%;">
										<?php 
											
				                         	
											echo "<h3 class='mt-1 mb-1'>".get_the_title()."</h3>";
											echo "<p class='ast-meta'><span class='location icon fa fa-location-arrow'> <strong> Location : </strong>".$location_name."</span> ";
											echo "<span class='date icon fa fa-calendar'> <strong>Date : </strong>".$date."</span> ";
											echo "<span class='time icon fa fa-clock-o'> <strong>Time : </strong>".$time."</span></p>";
											echo "<p class='ast-meta'><strong>Price : </strong>" . $price ."</p>";
										?>
										<?php the_content(); ?>
										<?php 
											$page_id = get_option('ast_event_registration_page_id');  

											//print_r($page_id);
									        if (!empty($page_id)) {
									            foreach ($page_id as $key => $value) {    
									            	if ($key == "ast-event-register") {
									            		//echo $key ."<br>";
									            		echo '<a class"btn btn-primary" href="'.add_query_arg('eid', get_the_ID(), get_permalink($value)).'">Book Now</a>';
									            	}					            	
									            }
									        }
										?>
										
										
									</div>
								</div>
							</div>
						</div>
						<div class="container">
							<div class="row">
								<div class="col-12">
									<div class="body-event-sidebar" style="width:100%;">

										<?php 
											echo "<h5 class='mb-1'>Additional Details :</h5>";
										?>
										<h5 class="event-sidebar-title">Event Types</h5>
										<?php   
											// Get terms for post
											$terms = get_the_terms( $post->ID , 'event-types' );
											// Loop over each item since it's an array							
											if ( $terms != null ){		
											 	echo "<ul>";
												foreach( $terms as $term ) {
												 // Print the name method from $term which is an OBJECT
												 echo "<li>".$term->name."</li>";
												 // Get rid of the other data stored in the object, since it's not needed
												 	unset($term);
												}
												echo "</ul>";
											} 
										?>
										<h5 class="event-sidebar-title">Date and Time</h5>
										<ul>
											<li><?php echo "<strong>Date</strong> : ".$date; ?></li>
											<li><?php echo "<strong>Time</strong> : ".$time; ?></li>
										</ul>

										<h5 class="event-sidebar-title">Location</h5>
										<ul>							
											<li><?php echo '<a target="__blank" href="'.$maplink.'">' . $location_name . '</a>';?></li>
										</ul>

										<h5 class="event-sidebar-title">Registration End Date</h5>
										<ul>							
											<li><?php echo "<strong>Date</strong> : ".$date; ?></li>
										</ul>

									</div>
								</div>
							</div>
						</div>
						<?php

							if ( is_single() ) {

								$next_post = get_next_post();
								$prev_post = get_previous_post();
								if ( $next_post || $prev_post ) {

									$pagination_classes = '';
									if ( ! $next_post ) {
										$pagination_classes = ' only-one only-prev';
									} elseif ( ! $prev_post ) {
										$pagination_classes = ' only-one only-next';
									} ?>


									<nav class="pagination-single section-inner<?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e( 'Post', 'twentytwenty' ); ?>">
										<div class="pagination-single-inner">
											<?php
											if ( $prev_post ) {
												?>

												<a class="previous-post" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
													<span class="arrow" aria-hidden="true">&larr;</span>
													<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $prev_post->ID ) ); ?></span></span>
												</a>

												<?php
											}

											if ( $next_post ) {
												?>

												<a class="next-post" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
													<span class="arrow" aria-hidden="true">&rarr;</span>
														<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $next_post->ID ) ); ?></span></span>
												</a>
												<?php
											}
											?>

										</div><!-- .pagination-single-inner -->
									</nav><!-- .pagination-single -->

							<?php }
							}

						?>
					</div>




				</article><!-- .post -->
			
			<?php }
		}
		wp_reset_query();
	}

	?>

</main><!-- #site-content -->



<?php get_footer(); ?>
