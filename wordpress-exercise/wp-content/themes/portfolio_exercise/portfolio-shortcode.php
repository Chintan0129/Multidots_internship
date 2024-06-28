<?php
/*
Template Name: shortcode
Description: A custom template for displaying portfolio projects using a shortcode.
*/

// Register shortcode
function portfolio_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'count' => -1,
        'category' => '',
        'project-type' => '',
        'client' => '', 
    ), $atts);

    // Parse comma-separated values
    $category = !empty($atts['category']) ? explode(',', $atts['category']) : array();
    $project_types = !empty($atts['project-type']) ? explode(',', $atts['project-type']) : array();
    $client = !empty($atts['client']) ? $atts['client'] : '';

    // Define query arguments
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => $atts['count'],
        // Add meta query for client name
        'meta_query' => array(
            array(
                'key' => '_project_client',
                'value' => $client,
                'compare' => 'LIKE',
            ),
        ),
    );

    // Add taxonomy query if category or project type is specified
    $tax_query = array('relation' => 'AND');
    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'project_category',
            'field' => 'slug',
            'terms' => $category,
        );
    }
    if (!empty($project_types)) {
        $tax_query[] = array(
            'taxonomy' => 'project_type',
            'field' => 'slug',
            'terms' => $project_types,
        );
    }
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    // Fetch portfolio projects
    $portfolio_query = new WP_Query($args);

    // Count the number of portfolio projects
    $portfolio_count = $portfolio_query->found_posts;

    // Output portfolio count
    echo '<div class="portfolio-count">';
    echo 'Portfolios Found: ' . $portfolio_count;
    echo '</div>';

    // Output portfolio projects
    ob_start();
    if ($portfolio_query->have_posts()) {
        echo '<div class="portfolio-grid">';
        while ($portfolio_query->have_posts()) {
            $portfolio_query->the_post();
            // Output portfolio items in grid view
            echo '<div class="portfolio-item">';
            if (has_post_thumbnail()) {
                echo '<div class="featured-image">';
                echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a>'; 
                echo '</div>';
            }
            echo '<div class="portfolio-content">';
            echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
            // Display client name
            $client_name = get_post_meta(get_the_ID(), '_project_client', true);
            echo '<div class="taxonomy">';
            echo '<p><strong>Client Name:</strong> ' . $client_name . '</p>';
            // Display project type
            $project_types = get_the_terms(get_the_ID(), 'project_type');
            if ($project_types) {
                $project_type_list = array();
                foreach ($project_types as $project_type) {
                    $project_type_list[] = $project_type->name;
                }
                echo '<p><strong>Project Type:</strong> ' . implode(', ', $project_type_list) . '</p>';
            }
            // Display project category
            $project_categories = get_the_terms(get_the_ID(), 'project_category');
            if ($project_categories) {
                $project_category_list = array();
                foreach ($project_categories as $project_category) {
                    $project_category_list[] = $project_category->name;
                }
                echo '<p><strong>Project Category:</strong> ' . implode(', ', $project_category_list) . '</p>';
            }
            echo '</div>'; // Closing taxonomy div
            echo '</div>'; // Closing portfolio-content div
            // End of portfolio item
            echo '</div>';
        }
        echo '</div>'; // Closing portfolio-grid div
    } else {
        // If no portfolios found
        echo '<p>No portfolios found.</p>';
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('md-portfolio-list', 'portfolio_shortcode');
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="content">
    <?php
    // Output the content of the page
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    ?>
</div>

