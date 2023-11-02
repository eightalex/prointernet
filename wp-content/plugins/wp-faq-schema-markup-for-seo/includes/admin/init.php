<?php

function hobcore_wp_faq_schema_admin_init()
{
    include('enqueue.php');
    function hobcore_wp_faq_schema_add_custom_box()
    {
        $post_types = array_values(get_post_types( array('public' => true) ));
        add_meta_box(
            'hobcore_wp_faq_schema_box_id',           // Unique ID
            'WP FAQ Schema Markup',  // Box title
            'hobcore_wp_faq_schema_custom_box_html',  // Content callback, must be of type callable
            $post_types                   // Post type
        );
    }

    //Render HTML Box from Meta Data
    function hobcore_wp_faq_schema_custom_box_html($post)
    {
        // Variables
        global $post; // Get the current post data
        $faq_script_status = false;
        $saved = get_post_meta($post->ID, 'faq_meta', true); // Get the saved values
        $faq_script_status = get_post_meta($post->ID, 'faq_script_status', true);
        $faqArray = [];
        if ($saved != null) {
            $saved = str_replace("\'", "'", $saved);

            $defaults = json_decode($saved, true); // Get the default values
            foreach ($defaults as $item) {
                $faq = [
                    'question' => stripslashes($item['question']),
                    'answer' => stripslashes($item['answer'])
                ];
                $faqArray[] = $faq;
            }
        }

        include('templates/faq-template.php');

    }

    //Save Meta Data from HTML BOX
    function hobcore_wp_faq_schema_save_metadata($post_id, $post)
    {
        if (!isset($_POST['hobcore_wp_faq_schema_form_metabox_process'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['hobcore_wp_faq_schema_form_metabox_process'], 'hobcore_wp_faq_schema_form_metabox_nonce')) {
            return;
        }

        if (!current_user_can('edit_post', $post->ID)) {
            return $post->ID;
        }
        $allowed_html = hobcore_wp_faq_schema_allowed_html_tags();

        $mainArray = [];
        if (!empty($_POST['question'])) {
            foreach ($_POST['question'] as $key => $question) {
                if($question != "" || $question != null){
                    $answer = $_POST['answer'][$key];
                    $answer = preg_replace('/\s+/S', " ", $answer);
                    $question = preg_replace('/\s+/S', " ", $question);

                    $faq = [
                        "question" => addslashes(wp_kses($question,$allowed_html)),
                        "answer" =>   addslashes(wp_kses($answer,$allowed_html)),
                    ];
                    $mainArray[] = $faq;
                }

            }
        }

        $mainArray = json_encode($mainArray,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        update_post_meta($post->ID, 'faq_meta', $mainArray);

        if ($_POST['faq_script_status']) {
            update_post_meta($post->ID, 'faq_script_status', true);
        } else {
            update_post_meta($post->ID, 'faq_script_status', false);
        }

        do_action('faq_metadata_after_saved', [
            'post_id' => $post->ID,
            'faq_meta' => $mainArray,
        ]);
    }

    function hobcore_wp_faq_schema_allowed_html_tags() {

        $allowed_tags = array(
            'a' => array(
                'class' => array(),
                'href'  => array(),
                'rel'   => array(),
                'title' => array(),
            ),
            'abbr' => array(
                'title' => array(),
            ),
            'b' => array(),
            'blockquote' => array(
                'cite'  => array(),
            ),
            'cite' => array(
                'title' => array(),
            ),
            'code' => array(),
            'del' => array(
                'datetime' => array(),
                'title' => array(),
            ),
            'dd' => array(),
            'div' => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'dl' => array(),
            'dt' => array(),
            'em' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'i' => array(),
            'img' => array(
                'alt'    => array(),
                'class'  => array(),
                'height' => array(),
                'src'    => array(),
                'width'  => array(),
            ),
            'li' => array(
                'class' => array(),
            ),
            'ol' => array(
                'class' => array(),
            ),
            'p' => array(
                'class' => array(),
            ),
            'q' => array(
                'cite' => array(),
                'title' => array(),
            ),
            'span' => array(
                'class' => array(),
                'title' => array(),
                'style' => array(),
            ),
            'strike' => array(),
            'strong' => array(),
            'ul' => array(
                'class' => array(),
            ),
        );

        return $allowed_tags;
    }


    add_action('add_meta_boxes', 'hobcore_wp_faq_schema_add_custom_box');
    add_action('save_post', 'hobcore_wp_faq_schema_save_metadata', 1, 2);


}
