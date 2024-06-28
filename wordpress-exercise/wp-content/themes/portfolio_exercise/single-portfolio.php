<?php
// header 
get_header('single');
if (have_posts()) :
    while (have_posts()) : the_post();
?>
    <div class="single-portfolio-item">
        <div class="single-portfolio-content">
            <!-- thumbnail -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="single-portfolio-thumbnail">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
            <?php endif; ?>
            <div class="single-portfolio-details">
                <h2>Project-title:<?php the_title(); ?></h2>
                <div class="single-portfolio-content-body">
                    <!-- description -->
                   <p>Description:<?php the_content(); ?><p> 
                </div>
                <!-- other info -->
                <div class="single-portfolio-taxonomy">
                    <p><strong>Project Type:</strong> <?php the_terms(get_the_ID(), 'project_type', '', ', '); ?></p>
                    <p><strong>Project Category:</strong> <?php the_terms(get_the_ID(), 'project_category', '', ', '); ?></p>
                    <p><strong>Client Name:</strong> <?php echo get_post_meta(get_the_ID(), '_project_client', true); ?></p>
                    <p><strong>Date Added:</strong> <?php the_date(); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php
    endwhile;
else :
    echo 'Portfolio not found.';
endif;
get_footer();
?>
