<?php

function aces_games_shortcode_1($atts) {

	ob_start();

	// Define attributes and their defaults

	extract( shortcode_atts( array (
	    'items_number' => 4,
	    'external_link' => '',
	    'category' => '',
	    'vendor' => '',
	    'items_id' => '',
	    'columns' => 4,
	    'order' => '',
	    'orderby' => '',
	    'title' => ''
	), $atts ) );

	if ( !empty( $category ) & !empty( $vendor ) ) {

		$categories_id_array = explode( ',', $category );
		$vendors_id_array = explode( ',', $vendor );

		$args = array(
			'posts_per_page' => $items_number,
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

		$args = array(
			'posts_per_page' => $items_number,
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

		$args = array(
			'posts_per_page' => $items_number,
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

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post__in'       => $items_id_array,
			'orderby'        => 'post__in',
			'no_found_rows'  => true,
			'post_status'    => 'publish'
		);

	} else {

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'orderby'  => $orderby,
			'order'    => $order
		);

	}

	$game_query = new WP_Query( $args );

	if ( $game_query->have_posts() ) {
	?>

	<div class="space-shortcode-wrap space-units-shortcode-1 relative relative">
		<div class="space-shortcode-wrap-ins relative">

			<?php if ( $title ) { ?>
			<div class="space-block-title relative">
				<span><?php echo esc_html($title); ?></span>
			</div>
			<?php } ?>

			<div class="space-units-archive-items box-100 relative">

				<?php while ( $game_query->have_posts() ) : $game_query->the_post();
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
					$game_short_desc = wp_kses( get_post_meta( get_the_ID(), 'game_short_desc', true ), $game_allowed_html );
					$game_external_link = esc_url( get_post_meta( get_the_ID(), 'game_external_link', true ) );
					$game_button_title = esc_html( get_post_meta( get_the_ID(), 'game_button_title', true ) );
					$game_button_notice = wp_kses( get_post_meta( get_the_ID(), 'game_button_notice', true ), $game_allowed_html );

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

					$terms = get_the_terms( $post->ID, 'game-category' );

				?>

				<div class="space-units-archive-item <?php if ($columns == 1) { ?>box-100<?php } else if ($columns == 2) { ?>box-50<?php } else if ($columns == 3) { ?>box-33<?php } else { ?>box-25<?php } ?> relative">
					<div class="space-units-archive-item-ins relative">
						<?php
						$post_title_attr = the_title_attribute( 'echo=0' );
						if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
							<div class="space-units-archive-item-img relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-450-317', "", array( "alt" => $post_title_attr ) ); ?>
								</a>
							</div>
						<?php } ?>
						<div class="space-units-archive-item-wrap text-center relative">
							<div class="space-units-archive-item-title relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</div>

							<?php if ($game_short_desc) { ?>
							<div class="space-units-archive-item-short-desc relative">
								<?php echo wp_kses( $game_short_desc, $game_allowed_html ); ?>
							</div>
							<?php } ?>

							<div class="space-units-archive-item-button relative">
								<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
							</div>

							<?php if ($game_button_notice) { ?>

							<div class="space-units-archive-item-button-notice relative">
								<?php echo wp_kses( $game_button_notice, $game_allowed_html ); ?>
							</div>

							<?php } ?>
						
						</div>
					</div>
				</div>

				<?php endwhile; ?>

			</div>
		
		</div>
	</div>

<?php
wp_reset_postdata();
$game_items = ob_get_clean();
return $game_items;
}

}
 
add_shortcode('aces-games-1', 'aces_games_shortcode_1');