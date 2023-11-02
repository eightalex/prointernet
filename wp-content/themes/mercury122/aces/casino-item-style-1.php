						<?php
							global $post;
							$casino_allowed_html = array(
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

							$casino_short_desc = wp_kses( get_post_meta( get_the_ID(), 'casino_short_desc', true ), $casino_allowed_html );
							$casino_external_link = esc_url( get_post_meta( get_the_ID(), 'casino_external_link', true ) );
							$casino_button_title = esc_html( get_post_meta( get_the_ID(), 'casino_button_title', true ) );
							$casino_button_notice = wp_kses( get_post_meta( get_the_ID(), 'casino_button_notice', true ), $casino_allowed_html );
							$casino_overall_rating = esc_html( get_post_meta( get_the_ID(), 'casino_overall_rating', true ) );

							if ($casino_button_title) {
								$button_title = $casino_button_title;
							} else {
								if ( get_option( 'casinos_play_now_title') ) {
									$button_title = esc_html( get_option( 'casinos_play_now_title') );
								} else {
									$button_title = esc_html__( 'Play Now', 'mercury' );
								}
							}

							if ($casino_external_link) {
								$external_link_url = $casino_external_link;
							} else {
								$external_link_url = get_the_permalink();
							}

							if ( get_option( 'aces_rating_stars_number' ) ) {
								$casino_rating_stars_number_value = get_option( 'aces_rating_stars_number' );
							} else {
								$casino_rating_stars_number_value = '5';
							}

							$terms = get_the_terms( $post->ID, 'casino-category' );

						?>

						<div class="space-companies-archive-item box-25 left relative">
							<div class="space-companies-archive-item-ins relative">
								<div class="space-companies-archive-item-wrap text-center relative">

									<?php
									$post_title_attr = the_title_attribute( 'echo=0' );
									if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
									<div class="space-companies-archive-item-img relative">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-120-120', "", array( "alt" => $post_title_attr ) ); ?>
										</a>
									</div>
									<?php } ?>

									<div class="space-companies-archive-item-title relative">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
									</div>

									<?php if( function_exists('aces_star_rating') ){ ?>
										<div class="space-companies-archive-item-rating relative">
											<?php aces_star_rating(
												array(
													'rating' => $casino_overall_rating,
													'type' => 'rating',
													'stars_number' => $casino_rating_stars_number_value
												)
											); ?>
										</div>
									<?php } ?>

									<?php if ($casino_short_desc) { ?>
									<div class="space-companies-archive-item-short-desc relative">
										<?php echo wp_kses( $casino_short_desc, $casino_allowed_html ); ?>
									</div>
									<?php } ?>

									<div class="space-companies-archive-item-button relative">
										<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($casino_external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
									</div>

									<?php if ($casino_button_notice) { ?>

									<div class="space-organizations-archive-item-button-notice relative">
										<?php echo wp_kses( $casino_button_notice, $casino_allowed_html ); ?>
									</div>

									<?php } ?>
							
								</div>
							</div>
						</div>