<?php

/*  Bonuses - Post Type Start */

add_action('init', 'aces_bonuses', 0 );

function aces_bonuses() {

	$bonus_slug = 'bonus';
	if ( get_option( 'bonuses_section_slug') ) {
		$bonus_slug = get_option( 'bonuses_section_slug', 'bonus' );
	}

	$bonus_name = esc_html__('Bonuses', 'aces');
	if ( get_option( 'bonuses_section_name') ) {
		$bonus_name = get_option( 'bonuses_section_name', 'Bonuses' );
	}

	$args = array(
        'labels' => array(
			'name' => $bonus_name,
			'add_new' => esc_html__('Add New', 'aces'),
            'edit_item' => esc_html__('Edit Item', 'aces'),
            'add_new_item' => esc_html__('Add New', 'aces'),
            'view_item' => esc_html__('View Item', 'aces'),
        ),
        'singular_label' => __('bonus'),
        'public' => true,
		'publicly_queryable' => true,
        'show_ui' => true,
		'show_in_rest' => true,
		'menu_icon' => plugins_url( 'aces/images/icon.png' ),
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array(
        	'title',
        	'editor',
        	'author',
        	'comments',
        	'thumbnail',
        	'excerpt',
        	'revisions'
        ),
		'has_archive' => false,
		'rewrite' => array(
			'slug' => $bonus_slug,
			'with_front' => false
		)
    );

register_post_type( 'bonus' , $args );

/* --- Category: Custom Taxonomy --- */

$bonuses_category_title = esc_html__('Categories', 'aces');
if ( get_option( 'bonuses_category_title') ) {
	$bonuses_category_title = get_option( 'bonuses_category_title', 'Categories' );
}

$labels = array(
	'name' => $bonuses_category_title,
	'singular_name' => $bonuses_category_title,
	'search_items' => esc_html__('Find Taxonomy', 'aces'),
	'all_items' => esc_html__('All ', 'aces') . $bonuses_category_title,
	'parent_item' => esc_html__('Parent Taxonomy', 'aces'),
	'parent_item_colon' => esc_html__('Parent Taxonomy:', 'aces'),
	'edit_item' => esc_html__('Edit Taxonomy', 'aces'),
	'view_item' => esc_html__('View Taxonomy', 'aces'),
	'update_item' => esc_html__('Update Taxonomy', 'aces'),
	'add_new_item' => esc_html__('Add New Taxonomy', 'aces'),
	'new_item_name' => esc_html__('Taxonomy', 'aces'),
	'menu_name' => $bonuses_category_title
);  

$args = array(
	'labels' => $labels,
	'public' => true,
	'show_in_nav_menus' => true,
	'show_ui' => true,
	'show_in_rest' => true,
	'show_tagcloud' => true,
	'show_admin_column' => true,
	'hierarchical' => true,
	'update_count_callback' => '',
	'rewrite' => true,
	'query_var' => '',
	'capabilities' => array(),
	'_builtin' => false
);

register_taxonomy('bonus-category', 'bonus', $args);

}

/* --- Add custom slug for taxonomy 'bonus-category' --- */

if ( get_option( 'bonus_category_slug') ) {

	function aces_change_bonus_category_slug( $taxonomy, $object_type, $args ) {

		$bonus_category_slug = 'bonus-category';

		if ( get_option( 'bonus_category_slug') ) {
			$bonus_category_slug = get_option( 'bonus_category_slug', 'bonus-category' );
		}

	    if( 'bonus-category' == $taxonomy ) {
	        remove_action( current_action(), __FUNCTION__ );
	        $args['rewrite'] = array( 'slug' => $bonus_category_slug );
	        register_taxonomy( $taxonomy, $object_type, $args );
	    }

	}
	add_action( 'registered_taxonomy', 'aces_change_bonus_category_slug', 10, 3 );

}

/*  Bonuses - Post Type End */

/*  Bonuses - Additional Fields Start */

add_action( 'admin_init', 'aces_bonuses_fields' );

function aces_bonuses_fields() {
    add_meta_box( 'aces_bonuses_meta_box',
        esc_html__( 'Additional information', 'aces' ),
        'aces_bonuses_display_meta_box',
        'bonus', 'side', 'high'
    );
}

function aces_bonuses_display_meta_box( $bonus ) {
	wp_nonce_field( 'aces_bonuses_box', 'aces_bonuses_nonce' );
	$custom = get_post_custom($bonus->ID);
	$bonus_short_desc = get_post_meta( $bonus->ID, 'bonus_short_desc', true );
	$bonus_external_link = get_post_meta( $bonus->ID, 'bonus_external_link', true );
	$bonus_button_title = get_post_meta( $bonus->ID, 'bonus_button_title', true );
	$bonus_button_notice = get_post_meta( $bonus->ID, 'bonus_button_notice', true );
	$bonus_code = get_post_meta( $bonus->ID, 'bonus_code', true );
	$bonus_valid_date = get_post_meta( $bonus->ID, 'bonus_valid_date', true );
	$bonus_dark_style = isset($custom["bonus_dark_style"][0]) ? stripslashes($custom["bonus_dark_style"][0]) : '';
	$bonus_allowed_html = array(
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
?>

<div class="components-base-control bonus_short_desc">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_short_desc-0"><?php esc_html_e( 'Short description', 'aces' )?></label>
		<textarea class="components-textarea-control__input" id="bonus_short_desc-0" rows="4" name="bonus_short_desc" style="display: block; margin-bottom: 10px; width:100%;"><?php echo wp_kses($bonus_short_desc, $bonus_allowed_html); ?></textarea>
	</div>
</div>

<div class="components-base-control bonus_external_link">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_external_link-0"><?php esc_html_e( 'External URL for the', 'aces' )?> <strong><?php esc_html_e( 'Get Bonus', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="url" name="bonus_external_link" id="bonus_external_link-0" value="<?php echo esc_url($bonus_external_link); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_button_title">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_button_title-0"><?php esc_html_e( 'Custom title for the', 'aces' )?> <strong><?php esc_html_e( 'Get Bonus', 'aces' ); ?></strong> <?php esc_html_e( 'button', 'aces' ); ?></label>
		<input type="text" name="bonus_button_title" id="bonus_button_title-0" value="<?php echo esc_attr($bonus_button_title); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_button_notice">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_button_notice-0"><?php esc_html_e( 'Notification under the button', 'aces' ); ?></label>
		<textarea class="components-textarea-control__input" id="bonus_button_notice-0" rows="8" name="bonus_button_notice" style="display: block; margin-bottom: 10px; width:100%;"><?php echo wp_kses($bonus_button_notice, $bonus_allowed_html); ?></textarea>
	</div>
</div>

<div class="components-base-control bonus_code">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_code-0"><?php esc_html_e( 'Bonus Code:', 'aces' )?></label>
		<input type="text" name="bonus_code" id="bonus_code-0" value="<?php echo esc_attr($bonus_code); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_valid_date">
	<div class="components-base-control__field">
		<label class="components-base-control__label" for="bonus_valid_date-0"><?php esc_html_e( 'Valid until the date:', 'aces' )?></label>
		<input type="date" name="bonus_valid_date" id="bonus_valid_date-0" value="<?php echo esc_attr($bonus_valid_date); ?>" style="display: block; margin-bottom: 10px;" />
	</div>
</div>

<div class="components-base-control bonus_dark_style">
	<div class="components-base-control__field">
		<input type="checkbox" name="bonus_dark_style" <?php if( $bonus_dark_style == true ) { ?>checked="checked"<?php } ?> /> <?php esc_html_e( 'Dark Style', 'aces' )?>
	</div>
</div>

    <?php
}

add_action( 'save_post', 'aces_bonuses_save_fields', 10, 2 );

function aces_bonuses_save_fields( $post_id ) {
		if ( ! isset( $_POST['aces_bonuses_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['aces_bonuses_nonce'];

        if ( ! wp_verify_nonce( $nonce, 'aces_bonuses_box' ) ) {
            return $post_id;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if ( 'bonus' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        }

		$bonus_short_desc = $_POST['bonus_short_desc'];
        update_post_meta( $post_id, 'bonus_short_desc', $bonus_short_desc );

		$bonus_external_link = esc_url( $_POST['bonus_external_link'] );
        update_post_meta( $post_id, 'bonus_external_link', $bonus_external_link );

		$bonus_button_title = sanitize_text_field( $_POST['bonus_button_title'] );
        update_post_meta( $post_id, 'bonus_button_title', $bonus_button_title );

        $bonus_button_notice = $_POST['bonus_button_notice'];
        update_post_meta( $post_id, 'bonus_button_notice', $bonus_button_notice );

        $bonus_code = sanitize_text_field( $_POST['bonus_code'] );
        update_post_meta( $post_id, 'bonus_code', $bonus_code );

        $bonus_valid_date = sanitize_text_field( $_POST['bonus_valid_date'] );
        update_post_meta( $post_id, 'bonus_valid_date', $bonus_valid_date );

        $bonus_dark_style = sanitize_text_field( $_POST['bonus_dark_style'] );
        update_post_meta( $post_id, 'bonus_dark_style', $bonus_dark_style );
}

/*  Bonuses - Additional Fields End */

/*  Relationship of the Bonus and Casino Start  */

add_action( 'admin_init', 'aces_bonuses_casinos_list' );

function aces_bonuses_casinos_list() {
    add_meta_box( 'aces_bonuses_casinos_list_meta_box',
        esc_html__( 'Casinos', 'aces' ),
        'aces_bonuses_display_casinos_list_meta_box',
        'bonus', 'side', 'high'
    );
}

function aces_bonuses_display_casinos_list_meta_box( $bonus ) {
    wp_nonce_field( basename(__FILE__), 'bonus_custom_nonce' );

    $postmeta = get_post_meta( $bonus->ID, 'bonus_parent_casino', true );
    $casinos = get_posts(array( 'post_type'=>'casino', 'posts_per_page'=>-1, 'orderby'=>'post_title', 'order'=>'ASC' ));

    if( $casinos ) {
    	$elements = [];
    	foreach( $casinos as $casino ) {
    		$elements[$casino->ID] = $casino->post_title;
        }
    ?>
	<div style="max-height:200px; overflow-y:auto;">
		<ul>
	    <?php foreach ( $elements as $id => $element) {

	        if ( is_array( $postmeta ) && in_array( $id, $postmeta ) ) {
	            $checked = 'checked=checked';
	        } else {
	            $checked = null;
	        }

	        ?>

	        <li>
				<label>
	            <input type="checkbox" name="bonus_casino_item[]" value="<?php esc_attr_e($id);?>" <?php esc_attr_e($checked); ?>>
	            <?php esc_html_e($element); ?>
	        	</label>
			</li>

	    <?php } ?>
		</ul>
	</div>
    <?php
	} else {
		esc_html_e( 'No casinos', 'aces' );
	}
}

add_action( 'save_post', 'aces_bonuses_casinos_save_fields', 10, 2 );

function aces_bonuses_casinos_save_fields( $post_id ) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'bonus_custom_nonce' ] ) && wp_verify_nonce( $_POST[ 'bonus_custom_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // If the checkbox was not empty, save it as array in post meta
    if ( ! empty( $_POST['bonus_casino_item'] ) ) {
        update_post_meta( $post_id, 'bonus_parent_casino', $_POST['bonus_casino_item'] );

    // Otherwise just delete it if its blank value.
    } else {
        delete_post_meta( $post_id, 'bonus_parent_casino' );
    }

};

/*  Relationship of the Bonus and Casino End  */