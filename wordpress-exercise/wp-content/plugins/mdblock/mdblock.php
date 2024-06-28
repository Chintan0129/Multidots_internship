<?php
/**
 * Plugin Name: Mdblock
 * Description: Dynamic block fetching questions and answers based on selected category and tag.
 * Version: 0.1.0
 * Author: chintan shah
 * License: GPL-2.0-or-later
 * Text Domain: mdblock
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


/**
 * Registers the mdblock block type.
 */
function mdblock_register_block_type() {
    // Enqueue block editor JavaScript.
    wp_register_script(
        'mdblock-editor-script',
        plugins_url('build/index.js', __FILE__),
        array('wp-blocks', 'wp-editor'),
        filemtime(plugin_dir_path(__FILE__) . 'build/index.js')
    );

    // Register the block type.
    register_block_type('create-block/mdblock', array(
        'editor_script' => 'mdblock-editor-script',
        'api_version'   => 3,
        'title'         => __('Mdblock', 'mdblock'),
        'category'      => 'widgets',
        'icon'          => 'smiley',
        'description'   => __('Dynamic block fetching questions and answers based on selected category and tag.', 'mdblock'),
        'supports'      => array(
            'html' => false
        ),
        'textdomain'    => 'mdblock',
        'render_callback' => 'mdblock_render_callback', // Render callback function
    ));
}
add_action('init', 'mdblock_register_block_type');

// Register custom API endpoint
function custom_faq_api_endpoint() {
    register_rest_route('custom-faq/v1', '/data', array(
        'methods'  => 'GET',
        'callback' => 'get_custom_faq_data',
    ));
}
add_action('rest_api_init', 'custom_faq_api_endpoint');


// Callback function to fetch data
function get_custom_faq_data($data) {
    try {
        $category = isset($data['category']) ? sanitize_text_field($data['category']) : '';
        $tag = isset($data['tag']) ? sanitize_text_field($data['tag']) : '';

        $args = array(
            'post_type'      => 'faq',
            'posts_per_page' => -1, // Retrieve all FAQs
        );

        // Filter by category if provided
        if (!empty($category)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'faq-category',
                'field'    => 'slug',
                'terms'    => $category,
            );
        }

        // Filter by tag if provided
        if (!empty($tag)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'faq-tag',
                'field'    => 'slug',
                'terms'    => $tag,
            );
        }

        $faq_posts = get_posts($args);

        $faq_data = array();

        foreach ($faq_posts as $post) {
            $tags = wp_get_post_terms($post->ID, 'faq-tag');

            $tag_data = array(); // Array to store tag names

            foreach ($tags as $tag) {
                $tag_data[] = $tag->name; // Add tag name to the array
            }

            $faq_item = array(
                'id'       => $post->ID,
                'question' => $post->post_title, // Use post title as the question
                'answer'   => $post->post_content, // Use post content as the answer
                'tags'     => $tag_data, // Assign tag names array to 'tags' key
                'category' => wp_get_post_terms($post->ID, 'faq-category'),
            );

            $faq_data[] = $faq_item;
        }
        wp_reset_postdata();
           
        $response = rest_ensure_response($faq_data);
        
        // Set response status code
        $response->set_status(200);

        // Send JSON response
        return $response;
    } catch (Exception $e) {
        // Handle any exceptions and return an error response
        $error_message = $e->getMessage();
        return new WP_Error('api_error', $error_message, array('status' => 500));
    }
}
// Render callback function for the mdblock block.

function mdblock_render_callback( $attributes ) {
    // Retrieve questions and answers from attributes
    $questionsAndAnswers = isset( $attributes['questionsAndAnswers'] ) ? $attributes['questionsAndAnswers'] : array();

    // Check if questions and answers are provided
    if ( ! empty( $questionsAndAnswers ) ) {
        // Initialize output variable
        $html_output = '';

        // Loop through questions and answers
        foreach ( $questionsAndAnswers as $faq_item ) {
            // Append FAQ HTML to output
            $html_output .= '<div class="faq-item">';
            $html_output .= '<div class="faq-question">';
            $html_output .= '<h3>' . esc_html( $faq_item['question'] ) . '</h3>';
            $html_output .= '<button class="toggle-answer">&#9660;</button>'; // Arrow icon for toggle
            $html_output .= '</div>'; // Close faq-question
            $html_output .= '<div class="faq-answer">' . wp_kses_post( $faq_item['answer'] ) . '</div>'; 
            $html_output .= '</div>'; // Close faq-item
        }

        // Return the HTML output
        return $html_output;
    } else {
        // If no questions and answers found, return alternate message
        return '<p>No questions and answers provided.</p>'; 
    }
}
function enqueue_faq_scripts() {
    wp_enqueue_script( 'faq-script', plugin_dir_url( __FILE__ ) . 'faq-script.js', array(), '1.0', true );
    wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'style.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_faq_scripts' );

