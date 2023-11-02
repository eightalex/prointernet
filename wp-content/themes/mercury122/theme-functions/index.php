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
			'version' 				=> '3.0.2',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),
		array(
			'name'                  => esc_html__('Mercury Addons [Space-Themes.com]', 'mercury'),
			'slug'                  => 'mercury-addons',
			'source'                => 'https://files.mercurytheme.com/plugins/3.8.2/mercury-addons-2.4.zip',
			'required'              => true,
			'version'               => '2.4',
			'force_activation'      => false,
			'force_deactivation'    => false,
			'external_url'          => '',
		),
		array(
			'name'                  => esc_html__('ACES Gambling [Mercury]', 'mercury'),
			'slug'                  => 'aces',
			'source'                => 'https://files.mercurytheme.com/plugins/3.8.2/aces-2.6.1.zip',
			'required'              => true,
			'version'               => '2.6.1',
			'force_activation'      => false,
			'force_deactivation'    => false,
			'external_url'          => '',
		),
		array(
			'name'     				=> esc_html__('Yoast SEO', 'mercury'),
			'slug'     				=> 'wordpress-seo',
			'required' 				=> false,
			'version' 				=> '17.7.1',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
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