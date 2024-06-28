<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html__('Portfolio', 'portfolio_exercise'); ?></title>
    <?php wp_head(); ?>
    <style>
        header {
            background-color: #333; 
            color: #fff; 
            padding: 20px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-content h1 {
            font-size: 24px; 
            margin: 0;
        }

        .header-content .back-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff; 
            color: #fff; 
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .header-content .back-button:hover {
            background-color: #0056b3; 
        }
    </style>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="header-content">
        <h1><?php single_post_title(); ?></h1>
        <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="back-button"><?php echo esc_html__('Back', 'portfolio_exercise'); ?></a>

    </div>
</header>
