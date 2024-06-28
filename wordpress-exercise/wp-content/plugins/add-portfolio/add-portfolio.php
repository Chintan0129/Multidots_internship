<?php
/*
Plugin Name: Add Portfolio by CLI Command
Description: WP CLI command to add projects to the portfolio as a part of exercise.
Version: 1.0
Author: Chintan Shah
*/

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    class Add_Portfolio_CLI_Command {
        function __invoke( $args, $assoc_args ) {
            // Get the count argument or default to 1
            $count = isset( $assoc_args['count'] ) ? intval( $assoc_args['count'] ) : 1;

            // Retrieve attachment IDs from the media library
            $attachments = get_posts( array(
                'post_type'      => 'attachment',
                'posts_per_page' => -1,
                'post_status'    => 'inherit',
                'post_mime_type' => 'image',
            ) );

            // Extract attachment IDs
            $attachment_ids = wp_list_pluck( $attachments, 'ID' );

            // Loop through the specified number of times to add projects
            for ( $i = 1; $i <= $count; $i++ ) {
                $title = 'Test ' . $i;
                $content = 'Portfolio generated using CLI command.';
                // Insert a new portfolio project post
                $post_id = wp_insert_post( array(
                    'post_title'   => $title,
                    'post_content' => $content,
                    'post_type'    => 'portfolio',
                    'post_status'  => 'publish',
                ) );

                // Check if project creation was successful and if there are available attachment IDs
                if ( ! is_wp_error( $post_id ) && ! empty( $attachment_ids ) ) {
                    // Select a random attachment ID
                    $random_attachment_id = $attachment_ids[ array_rand( $attachment_ids ) ];
                    // Set the random attachment as the thumbnail for the project
                    set_post_thumbnail( $post_id, $random_attachment_id );
                    // Generate a client name for the project
                    $client_name = 'Company ' . $i;
                    // Update the post meta with the client name
                    update_post_meta( $post_id, '_project_client', $client_name );

                    // Define arrays for project categories and types
                    $categories = array( 'Hospitals', 'Farmhouse', 'Hotels' );
                    $types = array( 'Construction', 'Farming', 'Defence' );

                    // Set the taxonomy for project categories
                    $taxonomy_category = 'project_category';
                    // Check if the category exists, and if not, create it
                    if ( ! term_exists( $categories[ array_rand( $categories ) ], $taxonomy_category ) ) {
                        $term_category = wp_insert_term( $categories[ array_rand( $categories ) ], $taxonomy_category );
                        if ( ! is_wp_error( $term_category ) ) {
                            $category_id = $term_category['term_id'];
                        }
                    } else {
                        $category_id = get_term_by( 'name', $categories[ array_rand( $categories ) ], $taxonomy_category )->term_id;
                    }
                    // Assign the category to the project
                    wp_set_post_terms( $post_id, $category_id, $taxonomy_category, true );

                    // Set the taxonomy for project types
                    $taxonomy_type = 'project_type';
                    // Check if the type exists, and if not, create it
                    if ( ! term_exists( $types[ array_rand( $types ) ], $taxonomy_type ) ) {
                        $term_type = wp_insert_term( $types[ array_rand( $types ) ], $taxonomy_type );
                        if ( ! is_wp_error( $term_type ) ) {
                            $type_id = $term_type['term_id'];
                        }
                    } else {
                        // If the type exists, retrieve its ID
                        $type_id = get_term_by( 'name', $types[ array_rand( $types ) ], $taxonomy_type )->term_id;
                    }
                    // Assign the type to the project
                    wp_set_post_terms( $post_id, $type_id, $taxonomy_type, true );
                }
            }

            // Display success message
            WP_CLI::success( "$count projects added successfully." );
        }
    }

    // Register the CLI command
    WP_CLI::add_command( 'add-portfolio', 'Add_Portfolio_CLI_Command' );
}
