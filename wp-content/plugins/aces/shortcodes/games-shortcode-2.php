<?php

function aces_games_shortcode_2($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'external_link' => '',
	    'category' => '',
	    'vendor' => '',
	    'items_id' => '',
	    'order' => '',
	    'orderby' => '',
	    'title' => ''
	), $atts ) );

	if ( !empty( $category ) & !empty( $vendor ) ) {

		$categories_id_array = explode( ',', $category );
		$vendors_id_array = explode( ',', $vendor );

		$first_args = array(
			'posts_per_page' => 1,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'game-category',
					'field'    => 'id',
					'terms'    => $categories_id_array
				),
				array(
					'taxonomy' => 'vendor',
					'field'    => 'id',
					'terms'    => $vendors_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

		$second_args = array(
			'posts_per_page' => 4,
			'offset'	     => 1,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'game-category',
					'field'    => 'id',
					'terms'    => $categories_id_array
				),
				array(
					'taxonomy' => 'vendor',
					'field'    => 'id',
					'terms'    => $vendors_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

	} else if ( !empty( $category ) ) {

		$categories_id_array = explode( ',', $category );

		$first_args = array(
			'posts_per_page' => 1,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'game-category',
					'field'    => 'id',
					'terms'    => $categories_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

		$second_args = array(
			'posts_per_page' => 4,
			'offset'	     => 1,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'game-category',
					'field'    => 'id',
					'terms'    => $categories_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

	} else if ( !empty( $vendor ) ) {

		$vendors_id_array = explode( ',', $vendor );

		$first_args = array(
			'posts_per_page' => 1,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'vendor',
					'field'    => 'id',
					'terms'    => $vendors_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

		$second_args = array(
			'posts_per_page' => 4,
			'offset'	     => 1,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'vendor',
					'field'    => 'id',
					'terms'    => $vendors_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

	} else if ( !empty( $items_id ) ) {

		$items_id_array = explode( ',', $items_id );

		$first_args = array(
			'posts_per_page' => 1,
			'post_type'      => 'game',
			'post__in'       => $items_id_array,
			'orderby'        => 'post__in',
			'no_found_rows'  => true,
			'post_status'    => 'publish'
		);

		$second_args = array(
			'posts_per_page' => 4,
			'offset'	     => 1,
			'post_type'      => 'game',
			'post__in'       => $items_id_array,
			'orderby'        => 'post__in',
			'no_found_rows'  => true,
			'post_status'    => 'publish'
		);

	} else {

		$first_args = array(
			'posts_per_page' => 1,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'orderby'  => $orderby,
			'order'    => $order
		);

		$second_args = array(
			'posts_per_page' => 4,
			'offset'	     => 1,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'orderby'  => $orderby,
			'order'    => $order
		);

	}

	$first_query = new WP_Query( $first_args );

	if ( $first_query->have_posts() ) {

		if ( get_option( 'aces_game_rating_stars_number' ) ) {
			$game_rating_stars_number_value = get_option( 'aces_game_rating_stars_number' );
		} else {
			$game_rating_stars_number_value = '5';
		}

	?>

		<div class="space-shortcode-wrap space-units-shortcode-2 relative">
			<div class="space-shortcode-wrap-ins relative">

				<?php if ( $title ) { ?>
				<div class="space-block-title relative">
					<span><?php echo esc_html($title); ?></span>
				</div>
				<?php } ?>

				<div class="space-units-2-archive-columns box-100 relative">
					<div class="space-units-2-archive-column box-50 relative first">

						<?php while ( $first_query->have_posts() ) : $first_query->the_post();
							global $post;
							$game_allowed_html = array(
								'a' => array(
									'href' => true,
									'title' => true,
									'target' => true,
									'rel' => true
								),
								'br' => array(),
								'em' => array(),
								'strong' => array(),
								'span' => array(
									'class' => true
								),
								'div' => array(
									'class' => true
								),
								'p' => array()
							);

							$game_external_link = esc_url( get_post_meta( get_the_ID(), 'game_external_link', true ) );
							$game_button_title = esc_html( get_post_meta( get_the_ID(), 'game_button_title', true ) );
							$game_button_notice = wp_kses( get_post_meta( get_the_ID(), 'game_button_notice', true ), $game_allowed_html );
							$game_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'game_permalink_button_title', true ) );
							$game_rating = esc_html( get_post_meta( get_the_ID(), 'game_rating_one', true ) );

							if ($game_button_title) {
								$button_title = $game_button_title;
							} else {
								if ( get_option( 'games_play_now_title') ) {
									$button_title = esc_html( get_option( 'games_play_now_title') );
								} else {
									$button_title = esc_html__( 'Play Now', 'aces' );
								}
							}

							if ($external_link) {
								if ($game_external_link) {
									$external_link_url = $game_external_link;
								} else {
									$external_link_url = get_the_permalink();
								}
							} else {
								$external_link_url = get_the_permalink();
							}

							if ($game_permalink_button_title) {
								$permalink_button_title = $game_permalink_button_title;
							} else {
								if ( get_option( 'games_read_review_title') ) {
									$permalink_button_title = esc_html( get_option( 'games_read_review_title') );
								} else {
									$permalink_button_title = esc_html__( 'Read Review', 'aces' );
								}
							}

							$terms = get_the_terms( $post->ID, 'game-category' );
						?>

						<div class="space-units-2-archive-item box-100 relative">
							<div class="space-units-2-archive-item-ins relative">
								<div class="space-units-2-archive-item-img-wrap box-100 relative">
									<?php
									$post_title_attr = the_title_attribute( 'echo=0' );
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-570', "", array( "alt" => $post_title_attr ) ); ?>
									<?php } ?>
									<div class="space-units-2-archive-item-overlay space-overlay absolute">

										<?php if ($game_rating) {
											if( function_exists('aces_star_rating') ){
										?>

											<div class="space-units-2-archive-item-rating absolute">
												<div class="space-rating-star-wrap relative">
													<div class="space-rating-star-background absolute"></div>
													<div class="space-rating-star-icon absolute">
														<i class="fas fa-star"></i>
													</div>
												</div>
												<strong><?php echo esc_html( number_format( round( $game_rating, 1 ), 1, '.', ',') ); ?></strong>/<?php echo esc_html( $game_rating_stars_number_value ); ?>
											</div>

										<?php
											}
										} ?>

										<div class="space-units-2-archive-item-central text-center relative">

											<?php if ($terms) { ?>
											<div class="space-units-2-archive-item-category relative">
												<?php foreach ( $terms as $term ) { ?>
											        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
											    <?php } ?>
											</div>
											<?php } ?>

											<div class="space-units-2-archive-item-title relative">
												<?php the_title(); ?>
											</div>

											<?php if ($external_link) { ?>

											<div class="space-units-2-archive-item-button1 relative">
												<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
											</div>

											<?php } ?>

											<div class="space-units-2-archive-item-button2 relative">
												<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
											</div>
										</div>

										<?php if ($game_button_notice) { ?>

										<div class="space-units-2-archive-item-tac absolute">
											
											<?php echo wp_kses( $game_button_notice, $game_allowed_html ); ?>

										</div>

										<?php } ?>

									</div>
								</div>
							</div>
						</div>

						<?php
							endwhile;
							wp_reset_postdata();
						?>

					</div>
					<div class="space-units-2-archive-column box-50 relative second">
						<div class="space-units-2-archive-items box-100 relative">
							
						<?php 
							$second_query = new WP_Query( $second_args );
							while ( $second_query->have_posts() ) : $second_query->the_post();
							global $post;
							$game_allowed_html = array(
								'a' => array(
									'href' => true,
									'title' => true,
									'target' => true,
									'rel' => true
								),
								'br' => array(),
								'em' => array(),
								'strong' => array(),
								'span' => array(
									'class' => true
								),
								'div' => array(
									'class' => true
								),
								'p' => array()
							);

							$game_external_link = esc_url( get_post_meta( get_the_ID(), 'game_external_link', true ) );
							$game_button_title = esc_html( get_post_meta( get_the_ID(), 'game_button_title', true ) );
							$game_button_notice = wp_kses( get_post_meta( get_the_ID(), 'game_button_notice', true ), $game_allowed_html );
							$game_permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'game_permalink_button_title', true ) );
							$game_rating = esc_html( get_post_meta( get_the_ID(), 'game_rating_one', true ) );

							if ($game_button_title) {
								$button_title = $game_button_title;
							} else {
								if ( get_option( 'games_play_now_title') ) {
									$button_title = esc_html( get_option( 'games_play_now_title') );
								} else {
									$button_title = esc_html__( 'Play Now', 'aces' );
								}
							}

							if ($external_link) {
								if ($game_external_link) {
									$external_link_url = $game_external_link;
								} else {
									$external_link_url = get_the_permalink();
								}
							} else {
								$external_link_url = get_the_permalink();
							}

							if ($game_permalink_button_title) {
								$permalink_button_title = $game_permalink_button_title;
							} else {
								if ( get_option( 'games_read_review_title') ) {
									$permalink_button_title = esc_html( get_option( 'games_read_review_title') );
								} else {
									$permalink_button_title = esc_html__( 'Read Review', 'aces' );
								}
							}

							$terms = get_the_terms( $post->ID, 'game-category' );
						?>

						<div class="space-units-2-archive-item box-50 relative">
							<div class="space-units-2-archive-item-ins relative">
								<div class="space-units-2-archive-item-img-wrap box-100 relative">
									<?php
									$post_title_attr = the_title_attribute( 'echo=0' );
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-570-570', "", array( "alt" => $post_title_attr ) ); ?>
									<?php } ?>
									<div class="space-units-2-archive-item-overlay space-overlay absolute">

										<?php if ($game_rating) {
											if( function_exists('aces_star_rating') ){
										?>

											<div class="space-units-2-archive-item-rating absolute">
												<div class="space-rating-star-wrap relative">
													<div class="space-rating-star-background absolute"></div>
													<div class="space-rating-star-icon absolute">
														<i class="fas fa-star"></i>
													</div>
												</div>
												<strong><?php echo esc_html( number_format( round( $game_rating, 1 ), 1, '.', ',') ); ?></strong>/<?php echo esc_html( $game_rating_stars_number_value ); ?>
											</div>

										<?php
											}
										} ?>

										<div class="space-units-2-archive-item-central text-center relative">

											<?php if ($terms) { ?>
											<div class="space-units-2-archive-item-category relative">
												<?php foreach ( $terms as $term ) { ?>
											        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
											    <?php } ?>
											</div>
											<?php } ?>

											<div class="space-units-2-archive-item-title relative">
												<?php the_title(); ?>
											</div>

											<?php if ($external_link) { ?>

											<div class="space-units-2-archive-item-button1 relative">
												<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
											</div>

											<?php } ?>

											<div class="space-units-2-archive-item-button2 relative">
												<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $permalink_button_title ); ?>"><?php echo esc_html( $permalink_button_title ); ?></a>
											</div>
										</div>

										<?php if ($game_button_notice) { ?>

										<div class="space-units-2-archive-item-tac absolute">
											
											<?php echo wp_kses( $game_button_notice, $game_allowed_html ); ?>

										</div>

										<?php } ?>

									</div>
								</div>
							</div>
						</div>

						<?php endwhile; ?>

						</div>
					</div>
				</div>
			
			</div>
		</div>

	<?php
	wp_reset_postdata();
	$game_items = ob_get_clean();
	return $game_items;
	}

}
 
add_shortcode('aces-games-2', 'aces_games_shortcode_2');