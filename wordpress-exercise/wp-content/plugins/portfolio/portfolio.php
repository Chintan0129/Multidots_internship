<?php
/**
 * Plugin Name:       Portfolio
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Chintan Shah
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       portfolio
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_custom_portfolio_block_init() {
    register_block_type( __DIR__ . '/build', array(
        'render_callback' => 'render_portfolio_block'
    ) );
}
add_action( 'init', 'create_custom_portfolio_block_init' );

function register_portfolio_rest_endpoint() {
    register_rest_route('portfolio/v1', '/projects', array(
        'methods' => 'GET',
        'callback' => 'get_portfolio_projects',
    ));
}
add_action('rest_api_init', 'register_portfolio_rest_endpoint');
// Callback function for custom REST API endpoint
function get_portfolio_projects($data) {
    $category = $data->get_param('category');
    $client = $data->get_param('client');

    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => -1, 
    );

    
    if (!empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'project_category',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    if (!empty($client)) {
        $args['meta_query'] = array(
            array(
                'key' => '_project_client',
                'value' => $client,
                'compare' => '=',
            ),
        );
    }

    $projects = get_posts($args);

    $formatted_projects = array();
    foreach ($projects as $project) {
        $featured_image_url = get_the_post_thumbnail_url($project->ID, 'full'); 
        $project_data = array(
            'ID' => $project->ID,
            'post_author' => $project->post_author,
            'post_date' => $project->post_date,
            'post_content' => $project->post_content,
            'post_title' => $project->post_title,
            'post_excerpt' => $project->post_excerpt,
            'post_status' => $project->post_status,
            'comment_status' => $project->comment_status,
            'ping_status' => $project->ping_status,
            'post_modified' => $project->post_modified,
            'post_parent' => $project->post_parent,
            'guid' => $project->guid,
            'menu_order' => $project->menu_order,
            'post_type' => $project->post_type,
            'post_mime_type' => $project->post_mime_type,
            'comment_count' => $project->comment_count,
            'filter' => $project->filter,
            'category' => get_the_terms($project->ID, 'project_category'),
            'client' => get_post_meta($project->ID, '_project_client', true),
            'featured_image' => $featured_image_url,
        );
        $formatted_projects[] = $project_data;
    }

    return $formatted_projects;
}



// Enqueue editor assets
function custom_portfolio_block_enqueue_editor_assets() {
    
    wp_enqueue_script(
        'custom-portfolio-block-editor-script', 
        plugin_dir_url(__FILE__) . 'build/index.js',
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-data'), 
        filemtime(plugin_dir_path(__FILE__) . 'build/index.js'), 
    );

}


add_action('enqueue_block_editor_assets', 'custom_portfolio_block_enqueue_editor_assets');
function render_portfolio_block($attributes)
{
    
    $selectedCategories = $attributes['selectedCategories'] ?? [];
    $selectedClients = $attributes['selectedClients'] ?? [];

    
    $query_args = array(
        'post_type' => 'portfolio', 
        'posts_per_page' => -1, 
        'post_status' => 'publish', 
        'tax_query' => array(
            'relation' => 'OR', 
            array(
                'taxonomy' => 'project_category', 
                'field' => 'slug', 
                'terms' => $selectedCategories,
            ),
        ),
        'meta_query' => array(
            'relation' => 'OR', 
            array(
                'key' => '_project_client', 
                'value' => $selectedClients,
                'compare' => 'IN',
            ),
        ),
    );

    
    $portfolio_query = new WP_Query($query_args);

    if ($portfolio_query->have_posts()) {
        
        ob_start();

    
        echo '<div class="portfolio-grid">';
        while ($portfolio_query->have_posts()) {
            $portfolio_query->the_post();
          
            echo '<div class="portfolio-item">';
            echo '<div class="portfolio-thumbnail">';
            echo get_the_post_thumbnail(null, 'thumbnail'); 
            echo '</div>';
            echo '<div class="portfolio-content">';
            echo '<h2><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h2>';
            echo '<p>Date Created: ' . esc_html(get_the_date()) . '</p>';
            
            $client_name = get_post_meta(get_the_ID(), '_project_client', true);
            if (!empty($client_name)) {
                echo '<p>Client: ' . esc_html($client_name) . '</p>';
            }
            echo '<div class="portfolio-content-wrapper">';
            echo '<div class="portfolio-limited-content">' . wp_kses_post(get_the_excerpt()) . '</div>';
            echo '<div class="portfolio-full-content" style="display:none;">' . wp_kses_post(get_the_content()) . '</div>';
            echo '<a href="#" class="read-more">Read More</a>';
            echo '</div>';
            echo '</div>'; 
            echo '</div>'; 
        }
        echo '</div>'; 

        
        return ob_get_clean();
    } else {
      
        return '<p>No portfolio items found.</p>';
    }

    
    wp_reset_postdata();
}


function enqueue_portfolio_block_assets() {
  
    wp_enqueue_style(
        'portfolio-block-styles', 
        plugin_dir_url(__FILE__) . 'portfolio-styles.css', 
        array(), 
        '1.0', 
        'all' 
    );

    // Enqueue the JavaScript file
    wp_enqueue_script(
        'portfolio-block-script', 
        plugin_dir_url(__FILE__) . 'portfolio-script.js', 
        array('jquery'), 
        '1.0', 
        true 
    );
}
add_action('enqueue_block_assets', 'enqueue_portfolio_block_assets');

