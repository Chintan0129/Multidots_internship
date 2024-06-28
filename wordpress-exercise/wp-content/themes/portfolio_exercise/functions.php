<?php

function add_main_stylesheet() {
    wp_enqueue_style('main-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'add_main_stylesheet');
add_theme_support('post-thumbnails');

function create_portfolio_post_type() {
    register_post_type('portfolio',
        array(
            'labels' => array(
                'name' => __('Portfolio'),
                'singular_name' => __('Portfolio')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'), 
            'menu_icon' => 'dashicons-portfolio', // Add an icon to the admin menu
            'show_in_menu' => true, // Show in the admin menu
        )
    );
}
add_action('init', 'create_portfolio_post_type');

function create_portfolio_taxonomies() {
    register_taxonomy(
        'project_type',
        'portfolio',
        array(
            'label' => __('Project Type'),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'project_category',
        'portfolio',
        array(
            'label' => __('Project Category'),
            'hierarchical' => true,
        )
    );

}
add_action('init', 'create_portfolio_taxonomies');

function add_project_client_meta_box() {
    add_meta_box(
        'project_client_meta_box',
        __('Project Client'),
        'project_client_meta_box_callback',
        'portfolio',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_project_client_meta_box');

function project_client_meta_box_callback($post) {
    $value = get_post_meta($post->ID, '_project_client', true);
    echo '<label for="project_client">Client Name: </label>';
    echo '<input type="text" id="project_client" name="project_client" value="' . esc_attr($value) . '" />';
}


function save_project_client_meta_data($post_id) {
    if (array_key_exists('project_client', $_POST)) {
        update_post_meta(
            $post_id,
            '_project_client',
            sanitize_text_field($_POST['project_client'])
        );
    }
}
add_action('save_post', 'save_project_client_meta_data');


