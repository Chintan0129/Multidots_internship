<?php
/**
 * Plugin Name:       List Pages
 * Description:       Exercise
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Chintan shah
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       list-pages
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
function create_block_list_pages_block_init() {
	register_block_type( __DIR__ . '/build', array(
		'render_callback' => 'render_list_pages_block', 
	) );
}
add_action( 'init', 'create_block_list_pages_block_init' );


function render_list_pages_block( $attributes ) {
   
    if ( isset( $attributes['selectedPages'] ) ) {
        $selected_pages = $attributes['selectedPages'];
        
        
        $output = '<ul>';
        foreach ( $selected_pages as $page_id ) {
          $page_title = get_the_title( $page_id );
          $permalink = get_permalink( $page_id ); 
          $output .= '<li><a href="' . esc_url( $permalink ) . '">' . esc_html( $page_title ) . '</a></li>'; 
}
        $output .= '</ul>';

        return $output;
    } else {
        return '<p>No pages selected</p>';
    }
}

function list_pages_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'list-pages-editor-script', 
        plugins_url('build/index.js', __FILE__), 
        array( 'wp-blocks', 'wp-components', 'wp-element', 'wp-api-fetch' ), 
        filemtime( plugin_dir_path( __FILE__ ) . 'build/index.js' ) 
    );
}
add_action('enqueue_block_editor_assets', 'list_pages_enqueue_block_editor_assets');
