<!-- header -->
<?php get_header(); ?>

<div class="portfolio-grid">
    <?php
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => 3, //here i add 3 but if put 10 then after 10 post pagination will work
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1
    );

    $portfolio_query = new WP_Query($args);//retrieve portfolio posts
//initiate loop for post stored in porfolio_query
    if ($portfolio_query->have_posts()) :
        while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
    ?>
            <div class="portfolio-item">
                <!-- featured image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="featured-image">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    </div>
                <?php endif; ?>
                <div class="portfolio-content">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="taxonomy">
                   <!-- content -->
                        <p><strong>Project Type:</strong> <?php the_terms(get_the_ID(), 'project_type', '', ', '); ?></p>
                        <p><strong>Project Category:</strong> <?php the_terms(get_the_ID(), 'project_category', '', ', '); ?></p>
                        <p><strong>Client Name:</strong> <?php echo get_post_meta(get_the_ID(), '_project_client', true); ?></p>

                    </div>
                    
                </div>
            </div>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'No portfolios found.';
    endif;
    ?>
</div>
<!-- pagination -->
<div class="pagination">
    <?php
    echo paginate_links(array(
        'total' => $portfolio_query->max_num_pages
    ));
    ?>
</div>
<!-- footer -->
<?php get_footer(); ?>
