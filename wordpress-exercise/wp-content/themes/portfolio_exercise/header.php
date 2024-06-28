<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="header-content">
            <h1><?php echo esc_html__('Portfolio Gallery', 'portfolio_exercise'); ?></h1>
            <?php
            // Query to count portfolios
            $portfolio_count_query = new WP_Query(array(
                'post_type' => 'portfolio',
                'posts_per_page' => -1,
                'fields' => 'ids',
            ));
            $portfolio_count = $portfolio_count_query->post_count;
            ?>
            <p><?php echo esc_html__('No. of Portfolios: ', 'portfolio_exercise') . $portfolio_count; ?></p>
            
            <!-- Search Form -->
            <div class="search-form">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <label>
                        <span class="screen-reader-text"><?php echo esc_html__('Search for:', 'portfolio_exercise'); ?></span>
                        <input type="search" class="search-field" placeholder="<?php echo esc_attr__('Search Portfolios', 'portfolio_exercise'); ?>" value="" name="s" title="<?php echo esc_attr__('Search for:', 'portfolio_exercise'); ?>">
                    </label>
                    <button type="submit" class="search-submit"><?php echo esc_html__('Search', 'portfolio_exercise'); ?></button>
                </form>
            </div>
        </div>
    </header>
