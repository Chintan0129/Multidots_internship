<?php get_header('single'); ?>

<div class="search-results">
    <h2><?php printf( esc_html__( 'Search Results for: %s', 'portfolio_exercise' ), '<span>' . get_search_query() . '</span>' ); ?></h2>

    <?php if ( have_posts() ) : ?>
        <div class="search-results-list">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="single-portfolio-content">
                    <div class="single-portfolio-thumbnail">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="single-portfolio-details">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e( 'No search results found.', 'portfolio_exercise' ); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
