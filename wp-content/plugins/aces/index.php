<?php

/*
Plugin Name: ACES Gambling [Mercury]
Plugin URI: https://mercury.is/
Description: The plugin by Space-Themes.com for the creation of new custom post types Casinos, Games, and Bonuses for the Mercury theme.
Version: 2.6.1
Author: Space-Themes.com
Author URI: https://space-themes.com/
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: aces
*/

global $aces_version;
$aces_version = '2.6.1';

global $aces_options, $aces_plugin_dir, $aces_plugin_url;

$aces_plugin_dir = untrailingslashit( plugin_dir_path( __FILE__ ) );
$aces_plugin_url = untrailingslashit( plugin_dir_url( __FILE__ ) );

function aces_init() {
	load_plugin_textdomain( 'aces', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_filter( 'init', 'aces_init' );

/*  ---  Settings  ---  */

include_once $aces_plugin_dir . '/settings/index.php';

/*  Aces Settings Init Start */

/*  ---  Casinos  ---  */

include_once $aces_plugin_dir . '/settings/casinos.php';

/*  ---  Games  ---  */

include_once $aces_plugin_dir . '/settings/games.php';

/*  ---  Bonuses  ---  */

include_once $aces_plugin_dir . '/settings/bonuses.php';

/*  ---  Geolocation  ---  */

include_once $aces_plugin_dir . '/settings/geolocation.php';

/*  Aces Settings Init End */

/*  ---  Casinos  ---  */

include_once $aces_plugin_dir . '/casinos.php';

/*  ---  Games  ---  */

include_once $aces_plugin_dir . '/games.php';

/*  ---  Bonuses  ---  */

include_once $aces_plugin_dir . '/bonuses.php';

/*  ---  Geolocation  ---  */

include_once $aces_plugin_dir . '/functions/geolocation.php';

/*  ACES Rating Stars Start */

function aces_star_rating( $args = array() ) {
    $defaults    = array(
        'rating' => 0,
        'type'   => 'rating',
        'stars_number' => 0,
        'echo'   => true,
    );
    $parsed_args = wp_parse_args( $args, $defaults );

    $rating = (float) str_replace( ',', '.', $parsed_args['rating'] );
    $stars_number = $parsed_args['stars_number'];
 
    if ( 'percent' === $parsed_args['type'] ) {
        $rating = round( $rating / $stars_number, 0 ) / 2;
    }

    $full_stars  = floor( $rating );
    $half_stars  = ceil( $rating - $full_stars );
    $empty_stars = $stars_number - $full_stars - $half_stars;
 
    $output  = '<div class="star-rating">';
    $output .= str_repeat( '<div class="star star-full" aria-hidden="true"></div>', $full_stars );
    $output .= str_repeat( '<div class="star star-half" aria-hidden="true"></div>', $half_stars );
    $output .= str_repeat( '<div class="star star-empty" aria-hidden="true"></div>', $empty_stars );
    $output .= '</div>';
 
    if ( $parsed_args['echo'] ) {
        echo $output;
    }
 
    return $output;
}

/*  ACES Rating Stars End */

/*  Custom Aces Plugin Widgets Start  */

include_once $aces_plugin_dir . '/widgets/casinos-widget-1.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-2.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-3.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-4.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-5.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-6.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-7.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-8.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-9.php';
include_once $aces_plugin_dir . '/widgets/casinos-widget-10.php';
include_once $aces_plugin_dir . '/widgets/games-widget-1.php';
include_once $aces_plugin_dir . '/widgets/games-widget-2.php';
include_once $aces_plugin_dir . '/widgets/games-widget-3.php';
include_once $aces_plugin_dir . '/widgets/games-sidebar.php';
include_once $aces_plugin_dir . '/widgets/bonuses-home.php';

/*  Custom Aces Plugin Widgets End  */

/*  Custom Aces Plugin Shortcodes Start  */

// Casinos

include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-1.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-2.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-3.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-4.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-5.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-6.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-7.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-8.php';
include_once $aces_plugin_dir . '/shortcodes/casinos-shortcode-9.php';

// Games

include_once $aces_plugin_dir . '/shortcodes/games-shortcode-1.php';
include_once $aces_plugin_dir . '/shortcodes/games-shortcode-2.php';
include_once $aces_plugin_dir . '/shortcodes/games-shortcode-3.php';
include_once $aces_plugin_dir . '/shortcodes/games-shortcode-4.php';

// Bonuses

include_once $aces_plugin_dir . '/shortcodes/bonuses-shortcode-1.php';

// Playing cards

include_once $aces_plugin_dir . '/shortcodes/cards-shortcode.php';

/*  Custom Aces Plugin Shortcodes End  */

/*  Image Uploader Start  */

function aces_image_uploader() {
    global $typenow;
    if( $typenow == 'casino' || $typenow == 'game' || $typenow == 'bonus' ) {

        if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

        wp_register_script( 'aces-image-uploader', plugin_dir_url( __FILE__ ) . 'js/image-uploader.js', array( 'jquery' ), '2.4' );
        wp_enqueue_script( 'aces-image-uploader' );
    }
}
add_action( 'admin_enqueue_scripts', 'aces_image_uploader' );

/*  Image Uploader End  */

/*  Connecting style files for the plugin - Start  */

function aces_stylesheets() {
    wp_enqueue_style('aces-style', $GLOBALS['aces_plugin_url'] . '/css/aces-style.css', array(), $GLOBALS['aces_version'], 'all');
    wp_enqueue_style('aces-media', $GLOBALS['aces_plugin_url'] . '/css/aces-media.css', array(), $GLOBALS['aces_version'], 'all');
}
add_action('wp_enqueue_scripts', 'aces_stylesheets');

/*  Connecting style files for the plugin - End  */

/*  Add logo image column in the admin panel Start  */

/*  ---  Casinos  ---  */

function aces_logo_image_column_casino( $column_ars ) {

	$column_ars = array_slice( $column_ars, 0, 1, true )
	+ array('featured_logo' => 'Logo')
	+ array_slice( $column_ars, 1, NULL, true );
	return $column_ars;
}

add_filter('manage_casino_posts_columns', 'aces_logo_image_column_casino');

/*  ---  Games  ---  */

function aces_logo_image_column_game( $column_ars ) {

	$column_ars = array_slice( $column_ars, 0, 1, true )
	+ array('featured_logo' => 'Image')
	+ array_slice( $column_ars, 1, NULL, true );
	return $column_ars;
}

add_filter('manage_game_posts_columns', 'aces_logo_image_column_game');

/*  ---  Bonuses  ---  */

function aces_logo_image_column_bonus( $column_ars ) {

	$column_ars = array_slice( $column_ars, 0, 1, true )
	+ array('featured_logo' => 'Image')
	+ array_slice( $column_ars, 1, NULL, true );
	return $column_ars;
}

add_filter('manage_bonus_posts_columns', 'aces_logo_image_column_bonus');

/*  ---  Display logo/image column  ---  */

function aces_display_logo_column( $column_name, $post_id ) {
 
	if( $column_name == 'featured_logo' ) {
		if( has_post_thumbnail( $post_id ) ) {
			$logo_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'thumbnail');
			$logo_id = get_post_thumbnail_id( $post_id );
			echo '<img data-id="' . $logo_id . '" src="' . esc_url($logo_src[0]) . '" />';
		}
	}
 
}

add_action('manage_posts_custom_column', 'aces_display_logo_column', 10, 2);

/* --- Add CSS styles for the custom logo column --- */

function aces_custom_logo_css(){
 
	echo '<style>
		#featured_logo {
			width: 100px;
		}
		td.featured_logo.column-featured_logo img {
			max-width: 100%;
			height: auto;
			border-radius: 5px;
		}
	</style>';
 
}

add_action( 'admin_head', 'aces_custom_logo_css' );

/*  Add logo image column in the admin panel End  */

/*  The standard field for the upload Background image of casino/game single page - Start  */

function aces_background_image_uploader( $name, $value = '') {
	$image = ' button">' . esc_html__( 'Upload image', 'aces' );
	$display = 'none';
 
	if( $image_attributes = wp_get_attachment_image_src( $value, 'mercury-2000-400' ) ) {
		$image = '"><img src="' . $image_attributes[0] . '" style="max-width: 100%; width: auto; display: block;" />';
		$display = 'block';
	} 
 
	return '
	<div style="margin-top: 1em;">
		<a href="#" style="display: inline-block;" class="aces_upload_background_button' . $image . '</a>
		<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . esc_attr( $value ) . '" />
		<a href="#" class="aces_remove_background_button components-button is-link is-destructive" style="margin-top: 1em; display:' . $display . '">' . esc_html__( 'Remove background image', 'aces' ) . '</a>
	</div>';
}

/*  The standard field for the upload Background image of casino/game single page - End  */

?>