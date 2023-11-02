<?php

function mercury_admin_style() {
	wp_register_style( "mercury_admin_style", get_theme_file_uri("theme-functions/admin_style.css"), 10);
	wp_enqueue_style( "mercury_admin_style" );
}
add_action( 'admin_print_styles', 'mercury_admin_style' );

/* Add Mercury Welcome Page - Start */

function mercury_welcome_options(){
    add_menu_page( 
        esc_html__('Mercury Theme', 'mercury'),
        esc_html__('Mercury Theme', 'mercury'),
        'manage_options',
        'mercury_theme_page',
        'mercury_welcome_page',
        'dashicons-awards',
        64
    ); 
}
add_action( 'admin_menu', 'mercury_welcome_options' );

function mercury_welcome_page() {
        ?>  

        <div class="wrap">
            <h1><?php esc_html_e('Mercury Theme', 'mercury'); ?> <?php esc_html_e($GLOBALS['mercury_version'], 'mercury'); ?></h1>
            <div class="card">
              <p>
                <strong><?php esc_html_e('Thank you for using the Mercury theme!', 'mercury'); ?></strong><br>
                <?php esc_html_e('Please, don&#8217;t forget to rate 5 stars ★★★★★ for the theme. It helps a lot.', 'mercury'); ?><br>
                <a href="<?php echo esc_url( __( 'https://themeforest.net/downloads', 'mercury' ) ); ?>" target="_blank" title="<?php esc_attr( 'themeforest.net/downloads', 'mercury' ); ?>"><?php esc_html_e( 'themeforest.net/downloads', 'mercury' ); ?></a>
              </p>
            </div>
            <div class="card">
              <p>
                <strong><?php esc_html_e('All Mercury theme settings are in', 'mercury'); ?> <a href="<?php echo esc_url( home_url( '/wp-admin/customize.php' ) ); ?>" target="_blank" title="<?php esc_attr( 'Customize', 'mercury' ); ?>"><?php esc_html_e( 'Customize', 'mercury' ); ?></a>.</strong><br><br>
                <a href="<?php echo esc_url( __( 'https://docs.mercury.is/', 'mercury' ) ); ?>" target="_blank" title="<?php esc_attr( 'Online Documentation', 'mercury' ); ?>"><?php esc_html_e( 'Online Documentation', 'mercury' ); ?></a><br>
                <a href="<?php echo esc_url( __( 'https://spacethemes.ticksy.com/', 'mercury' ) ); ?>" target="_blank" title="<?php esc_attr( 'Need support?', 'mercury' ); ?>"><?php esc_html_e( 'Need support?', 'mercury' ); ?></a>
              </p>
            </div>

        </div>
        <?php
}

add_action( 'tgmpa_register', 'mercury_register_required_plugins' );

/* Add Mercury Welcome Page - End */

function mercury_register_required_plugins() {

	$plugins = array(

		array(
			'name'     				=> esc_html__('One Click Demo Import', 'mercury'),
			'slug'     				=> 'one-click-demo-import',
			'required' 				=> true,
			'version' 				=> '3.1.1',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),
		array(
			'name'                  => esc_html__('Mercury Addons', 'mercury'),
			'slug'                  => 'mercury-addons',
			'source'                => 'https://files.mercurytheme.com/plugins/3.9/mercury-addons-2.6.zip',
			'required'              => true,
			'version'               => '2.6',
			'force_activation'      => false,
			'force_deactivation'    => false,
			'external_url'          => '',
		),
		array(
			'name'                  => esc_html__('ACES Maker', 'mercury'),
			'slug'                  => 'aces',
			'source'                => 'https://files.mercurytheme.com/plugins/3.9/aces-3.0.zip',
			'required'              => true,
			'version'               => '3.0',
			'force_activation'      => false,
			'force_deactivation'    => false,
			'external_url'          => '',
		),
    array(
      'name'            => esc_html__('Classic Widgets', 'mercury'),
      'slug'            => 'classic-widgets',
      'required'        => true,
      'version'         => '0.2',
      'force_activation'    => false,
      'force_deactivation'  => false,
      'external_url'      => '',
    )

	);

	$config = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}

function mercury_import_files() {

  return array(
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 1', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/1/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/1/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/1/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/01.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo1.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 2', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/2/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/2/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/2/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/02.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo2.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 3', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/3/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/3/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/3/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/03.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo3.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 4', 'mercury' ),
      'categories'                   => array( 'Sports betting' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/4/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/4/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/4/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/04.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo4.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 5', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/5/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/5/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/5/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/05.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo5.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 6', 'mercury' ),
      'categories'                   => array( 'Sports betting' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/6/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/6/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/6/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/06.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo6.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 7', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/7/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/7/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/7/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/07.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo7.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 8', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/8/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/8/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/8/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/08.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo8.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 9', 'mercury' ),
      'categories'                   => array( 'Sports betting' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/9/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/9/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/9/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/09.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo9.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 10', 'mercury' ),
      'categories'                   => array( 'Magazine' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/10/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/10/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/10/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/10.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://demo10.mercury.is/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Demo 11', 'mercury' ),
      'categories'                   => array( 'Crypto' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demos/new/11/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demos/new/11/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/demos/new/11/widgets.wie',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/screenshots/new/11.png',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/01/',
    ),
  );
}

add_filter( 'pt-ocdi/import_files', 'mercury_import_files' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

function mercury_after_import_setup() {

  $front_page_id = get_page_by_title( 'Home' );

  update_option( 'show_on_front', 'page' );
  update_option( 'page_on_front', $front_page_id->ID );

	$main_menu   = get_term_by( 'name', 'Main Menu', 'nav_menu' );
  $footer_menu   = get_term_by( 'name', 'Additional Menu', 'nav_menu' );
  $top_menu   = get_term_by( 'name', 'Additional Menu', 'nav_menu' );

  set_theme_mod( 'nav_menu_locations', array(
    'main-menu'   => $main_menu->term_id,
    'footer-menu'   => $footer_menu->term_id,
    'top-menu'   => $top_menu->term_id
  ));

}

add_action( 'pt-ocdi/after_import', 'mercury_after_import_setup' );

/* Export Custom Keys - Start */
/* 

function mercury_export_option_keys( $keys ) {
    $keys[] = 'casinos_section_name';
    $keys[] = 'casinos_category_title';
    $keys[] = 'casinos_software_title';
    $keys[] = 'casinos_deposit_method_title';
    $keys[] = 'casinos_withdrawal_method_title';
    $keys[] = 'casinos_withdrawal_limit_title';
    $keys[] = 'casinos_restricted_countries_title';
    $keys[] = 'casinos_licences_title';
    $keys[] = 'casinos_languages_title';
    $keys[] = 'casinos_currencies_title';
    $keys[] = 'casinos_devices_title';
    $keys[] = 'casinos_owner_title';
    $keys[] = 'casinos_est_title';
    $keys[] = 'casinos_section_slug';
    $keys[] = 'casino_category_slug';
    $keys[] = 'casino_software_slug';
    $keys[] = 'casino_deposit_method_slug';
    $keys[] = 'casino_withdrawal_method_slug';
    $keys[] = 'casino_withdrawal_limit_slug';
    $keys[] = 'casino_restricted_countries_slug';
    $keys[] = 'casino_licence_slug';
    $keys[] = 'casino_language_slug';
    $keys[] = 'casino_currency_slug';
    $keys[] = 'casino_device_slug';
    $keys[] = 'casino_owner_slug';
    $keys[] = 'casino_est_slug';
    $keys[] = 'rating_1';
    $keys[] = 'rating_2';
    $keys[] = 'rating_3';
    $keys[] = 'rating_4';
    $keys[] = 'rating_overall';
    $keys[] = 'aces_rating_stars_number';
    $keys[] = 'casinos_play_now_title';
    $keys[] = 'casinos_read_review_title';
    $keys[] = 'casinos_pros_title';
    $keys[] = 'casinos_cons_title';
    $keys[] = 'games_section_name';
    $keys[] = 'games_category_title';
    $keys[] = 'games_vendor_title';
    $keys[] = 'games_section_slug';
    $keys[] = 'game_category_slug';
    $keys[] = 'game_vendor_slug';
    $keys[] = 'aces_game_rating_stars_number';
    $keys[] = 'games_play_now_title';
    $keys[] = 'games_read_review_title';
    $keys[] = 'games_pros_title';
    $keys[] = 'games_cons_title';
    $keys[] = 'bonuses_section_name';
    $keys[] = 'bonuses_category_title';
    $keys[] = 'bonuses_section_slug';
    $keys[] = 'bonus_category_slug';
    $keys[] = 'bonuses_get_bonus_title';
    $keys[] = 'aces_geolocation_allowed_mode';
    $keys[] = 'aces_geolocation_allowed_message';
    $keys[] = 'aces_geolocation_restricted_message';
    return $keys;
}

add_filter( 'cei_export_option_keys', 'mercury_export_option_keys' );

*/
/* Export Custom Keys - End */