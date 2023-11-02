<?php

function aces_geolocation_settings_init() {

    /*  Geolocation settings tab - Start  */

    /*  --- The setting sections ---  */

    add_settings_section(
        'aces_geolocation_tab_enable',
        esc_html__( 'Enable geolocation', 'aces' ),
        'aces_geolocation_tab_enable_callback',
        'aces_geolocation_tab'
    );

    add_settings_section(
        'aces_geolocation_tab_api',
        esc_html__( 'API key', 'aces' ),
        'aces_geolocation_tab_api_callback',
        'aces_geolocation_tab'
    );

    /*  --- Descriptions ---  */

    function aces_geolocation_tab_enable_callback( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <a href="<?php echo esc_url( __( 'https://ipdata.co/', 'aces' ) ); ?>" target="_blank"><?php esc_html_e( 'ipdata.co', 'aces' ); ?></a> <?php esc_html_e( 'provides API for the geolocation service.', 'aces' ); ?> <strong><?php esc_html_e( 'The Free API is limited to 1,500 daily requests.', 'aces' ); ?></strong>
        </p>
        <?php
    }

    function aces_geolocation_tab_api_callback( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <strong><?php esc_html_e( 'You can get a free API key (for non-commercial usage only) on the', 'aces' ); ?> <a href="<?php echo esc_url( __( 'https://ipdata.co/', 'aces' ) ); ?>" target="_blank"><?php esc_html_e( 'ipdata.co', 'aces' ); ?></a> <?php esc_html_e( 'website after registration.', 'aces' ); ?></strong>
        </p>
        <?php
    }

    /*  ----------------

    Enable geolocation setting checkbox

    ----------------  */

    add_settings_field(
        'aces_geolocation_enable',
        esc_html__( 'Enable geolocation', 'aces' ),
        'aces_geolocation_enable_callback',
        'aces_geolocation_tab',
        'aces_geolocation_tab_enable',
        array(
            'id' => 'aces_geolocation_enable', 
            'option_name' => 'aces_geolocation_enable'
        )  
    );
    register_setting( 'aces_geolocation_tab', 'aces_geolocation_enable', 'esc_attr');

    function aces_geolocation_enable_callback($args) {
        $option = get_option( 'aces_geolocation_enable' );
        $id = $args['id'];
        $option_name = $args['option_name'];
        ?>
        <input type="checkbox" name="aces_geolocation_enable" value="1" <?php checked(1, get_option('aces_geolocation_enable'), true); ?> />
        <?php
    }

    /*  ----------------

    API key setting field

    ----------------  */

    /*  --- API key ---  */

    add_settings_field(
        'aces_geolocation_api_key',
        esc_html__( 'API key (Required)*', 'aces' ),
        'aces_geolocation_api_key_callback',
        'aces_geolocation_tab',
        'aces_geolocation_tab_api',
        array(
            'id' => 'aces_geolocation_api_key', 
            'option_name' => 'aces_geolocation_api_key'
        )  
    );
    register_setting( 'aces_geolocation_tab', 'aces_geolocation_api_key', 'esc_attr');

    function aces_geolocation_api_key_callback($args) {
        $option = esc_attr(get_option($args['option_name']));
        $id = $args['id'];
        $option_name = $args['option_name'];
        ?>
        <input type="text" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($option_name); ?>" value="<?php echo esc_attr($option); ?>" class="regular-text" style="width: 35em;" />
        <?php
    }

    /*  Geolocation settings tab - End  */

}

add_action( 'admin_init', 'aces_geolocation_settings_init' );