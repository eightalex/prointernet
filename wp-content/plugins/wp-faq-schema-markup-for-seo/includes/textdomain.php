<?php

function hobcore_wp_faq_schema_load_textdomain(){
    $plugin_dir = 'wp-faq-schema-markup/-for-seo/lang';
    load_plugin_textdomain('faqs',false,$plugin_dir);
}