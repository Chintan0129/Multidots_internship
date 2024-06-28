<?php
/*
Plugin Name: Rest Api 
Description: fetch portfolio details in json  by applying filters.
Version: 1.0
Author: Chintan Shah
*/

// Register custom REST API endpoint
function register_portfolio_endpoint() {
    register_rest_route( 'md-custom', '/all-portfolio', array(
        'methods'  => 'GET',
        'callback' => 'get_portfolio_data',
    ));
}
add_action( 'rest_api_init', 'register_portfolio_endpoint' );

// Callback function to handle custom endpoint
function get_portfolio_data( $data ) {
    // Get filter parameters from request query
    $ids = $data['ids'] ?? '';
    $category = $data['category'] ?? '';
    $project_type = $data['project-type'] ?? '';
    $client = $data['client'] ?? '';

    // Define query arguments based on filter parameters
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => -1, 
        'meta_query' => array(
            array(
                'key' => '_project_client',
                'value' => $client,
                'compare' => 'LIKE',
            ),
        ),
    );

    if ( $ids ) {
        $args['post__in'] = explode( ',', $ids );
    }
    $tax_query = array('relation' => 'AND');
    if ( $category ) {
        $tax_query[] = array(
            'taxonomy' => 'project_category',
            'field' => 'slug',
            'terms' => explode( ',', $category ),
        );
    }
    if ( $project_type ) {
        $tax_query[] = array(
            'taxonomy' => 'project_type',
            'field' => 'slug',
            'terms' => explode( ',', $project_type ),
        );
    }
    if ( ! empty( $tax_query ) ) {
        $args['tax_query'] = $tax_query;
    }

    // Fetch portfolio projects
    $portfolio_query = new WP_Query( $args );
    $main_portfolio_data = array();

    // Loop through portfolio projects and build data array
    if ( $portfolio_query->have_posts() ) {
        while ( $portfolio_query->have_posts() ) {
            $portfolio_query->the_post();

            $project_category = wp_get_post_terms( get_the_ID(), 'project_category', array( 'fields' => 'names' ) );
            $project_type = wp_get_post_terms( get_the_ID(), 'project_type', array( 'fields' => 'names' ) );
            $client_name = get_post_meta( get_the_ID(), '_project_client', true );
            $description = get_the_content(); 

            // Prepare data for each portfolio item
            $portfolio_item_data = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'project_category' => $project_category,
                'project_type' => $project_type,
                'client_name' => $client_name,
                'description' => $description,
                
            );

            // Add data for each portfolio item to the main portfolio data array
            $main_portfolio_data[] = $portfolio_item_data;
        }
    }

    // Reset post data
    wp_reset_postdata();

    // Return portfolio data as JSON response
    return rest_ensure_response( $main_portfolio_data);
}
