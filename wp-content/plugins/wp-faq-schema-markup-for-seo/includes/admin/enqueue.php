<?php

function hobcore_wp_faq_schema_enqueue_admin_scripts(){

    wp_register_style( 'hobcore_wp_faq_schema_admin_style', plugins_url( '/assets/css/admin-style.css', HOBCORE_WP_FAQ_SCHEMA_PLUGIN_URL ) );

    wp_enqueue_style( 'hobcore_wp_faq_schema_admin_style' );


    wp_register_script( 
        'hobcore_wp_faq_schema_admin_global_js', plugins_url( '/assets/js/admin-global.js', HOBCORE_WP_FAQ_SCHEMA_PLUGIN_URL ), ['jquery'], '1.0.0', true
    );

    wp_localize_script( 'hobcore_wp_faq_schema_admin_global_js', 'faq_obj', [
        'ajax_url'      =>  admin_url( 'admin-ajax.php' )
    ]);
    
    wp_enqueue_script( 'hobcore_wp_faq_schema_admin_global_js' );
}