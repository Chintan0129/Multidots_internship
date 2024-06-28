<?php
/**
 * Plugin Name: MySlider
 * Description: Custom slider plugin for WordPress as a part of exercise.
 * Version: 1.0
 * Author: Chintan Shah
 */

function myslider_custom_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_60ff876a216a9',
            'title' => 'Slider Fields',
            'fields' => array(
                array(
                    'key' => 'field_60ff87790e2f4',
                    'label' => 'Image URL',
                    'name' => 'image_url',
                    'type' => 'text',
                    'instructions' => 'Enter the URL of the image for the slider.',
                    'required' => true,
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_60ff878d0e2f5',
                    'label' => 'Tooltip Text',
                    'name' => 'tooltip_text',
                    'type' => 'text',
                    'instructions' => 'Enter the tooltip text for the image.',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'slider',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }
}
add_action('acf/init', 'myslider_custom_fields');

function myslider_settings_page() {
    echo '<div class="wrap">';
    echo '<h2>Slider Listing page</h2>';
    
    // Query sliders
    $sliders = new WP_Query(array(
        'post_type' => 'slider',
        'posts_per_page' => -1 
    ));

    /// Retrieve slider data
$args = array(
    'post_type' => 'slider',
    'posts_per_page' => -1, 
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    echo '<form method="post">';
    echo '<table class="widefat">';
    echo '<thead><tr>';
    echo '<th>Title</th>';
    echo '<th>Images</th>'; 
    echo '<th>Select</th>';
    echo '<th>Edit</th>';
    echo '<th>Delete</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    while ($query->have_posts()) {
        $query->the_post();
        $slider_id = get_the_ID();
        $slider_title = get_the_title();
        $image_urls = get_field('image_urls'); // Retrieve image URLs directly

        echo '<tr>';
        echo '<td>' . $slider_title . '</td>';
        echo '<td>';
        
        // Display the first image if available
        if (!empty($image_urls)) {
            $first_image_url = is_array($image_urls) ? $image_urls[0] : $image_urls;
            echo '<img src="' . esc_url($first_image_url) . '" width="100" height="100">';
        }
        
        echo '</td>';
        echo '<td>';
        echo '<input type="checkbox" name="selected_sliders[]" value="' . $slider_id . '" ' . (in_array($slider_id, get_option('selected_sliders', array())) ? 'checked' : '') . '>';
        echo '</td>';
        echo '<td><a href="' . admin_url('admin.php?page=add-slider&slider_id=' . $slider_id) . '">Edit</a></td>';
        echo '<td><a href="' . wp_nonce_url(admin_url('admin-post.php?action=delete_slider&slider_id=' . $slider_id), 'delete_slider_' . $slider_id) . '">Delete</a></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '<input type="submit" name="submit_selected_sliders" class="button-primary" value="Select Sliders">';
    echo '</form>';
} else {
    echo '<p>No sliders found.</p>';
}

wp_reset_postdata();}

// Handle selected sliders submission
add_action('admin_init', 'myslider_handle_selected_sliders');
function myslider_handle_selected_sliders() {
    if (isset($_POST['submit_selected_sliders'])) {
        if (isset($_POST['selected_sliders'])) {
            $selected_sliders = $_POST['selected_sliders'];
            update_option('selected_sliders', $selected_sliders);
        } else {
            update_option('selected_sliders', array());
        }
    }
}
function myslider_add_slider_page() {
    echo '<div class="wrap">';
    echo '<h2>Add New Slider</h2>';

    
    $slider_title = '';
    $image_urls = array();
    $tooltip_text = '';
    $autoplay_speed = '';
    $pagination = '';
    $autoplay='';

    // Check if form is submitted
    if (isset($_POST['submit'])) {
       
        
        
        $slider_title = sanitize_text_field($_POST['slider_title']);
        
        // Check if slider with the same title already exists
        $existing_slider = get_page_by_title($slider_title, OBJECT, 'slider');
        
        if ($existing_slider) {
            // Slider with the same title already exists, edit instead of creating new
            $slider_id = $existing_slider->ID;
            $post_data = array(
                'ID' => $slider_id,
                'post_title' => $slider_title,
                'post_type' => 'slider',
                'post_status' => 'publish'
            );
            wp_update_post($post_data);
        } else {
            // Create new slider
            $slider_id = wp_insert_post(array(
                'post_title' => $slider_title,
                'post_type' => 'slider',
                'post_status' => 'publish'
            ));
        }
        
        // Save uploaded images and tooltip text
        if (!empty($_FILES['images']['tmp_name'])) {
            $image_urls = []; // Initialize array to store image URLs

            // Handle multiple image uploads
            foreach ($_FILES['images']['name'] as $key => $value) {
                if ($_FILES['images']['name'][$key]) {
                    $file = array(
                        'name'     => $_FILES['images']['name'][$key],
                        'type'     => $_FILES['images']['type'][$key],
                        'tmp_name' => $_FILES['images']['tmp_name'][$key],
                        'error'    => $_FILES['images']['error'][$key],
                        'size'     => $_FILES['images']['size'][$key]
                    );
                    
                    // Upload image
                    $uploaded_file = wp_handle_upload($file, array('test_form' => false));
                    
                    // Check for errors
                    if (!isset($uploaded_file['error']) && isset($uploaded_file['url'])) {
                        // Add image URL to array
                        $image_urls[] = $uploaded_file['url'];
                    }
                }
            }

            // Save image URLs
            update_post_meta($slider_id, 'image_urls', $image_urls);
        } else {
            // If no new images are uploaded, fetch existing image URLs from post meta
            $image_urls = get_post_meta($slider_id, 'image_urls', true);
        }

        // Save tooltip text
        $tooltip_text = sanitize_text_field($_POST['tooltip_text']);
        update_post_meta($slider_id, 'tooltip_text', $tooltip_text);

        // Save autoplay speed
        $autoplay_speed = intval($_POST['autoplay_speed']);
        update_post_meta($slider_id, 'autoplay_speed', $autoplay_speed);

        // Save pagination option
        $pagination = isset($_POST['pagination']) ? sanitize_text_field($_POST['pagination']) : 'yes'; // Default to 'yes'
        update_post_meta($slider_id, 'pagination', $pagination);

        // Save autoplay option
        $autoplay = isset($_POST['autoplay']) ? sanitize_text_field($_POST['autoplay']) : 'yes'; // Default to 'yes'
        update_post_meta($slider_id, 'autoplay', $autoplay);

        // Redirect to settings page or display success message
    } elseif (isset($_GET['slider_id'])) {
        // Edit existing slider
        $slider_id = intval($_GET['slider_id']);

        // Retrieve slider title, image URLs, tooltip text, autoplay speed, pagination option, and autoplay option
        $slider_title = get_the_title($slider_id);
        $image_urls = get_post_meta($slider_id, 'image_urls', true);
        $tooltip_text = get_post_meta($slider_id, 'tooltip_text', true);
        $autoplay_speed = get_post_meta($slider_id, 'autoplay_speed', true);
        $pagination = get_post_meta($slider_id, 'pagination', true);
        $autoplay = get_post_meta($slider_id, 'autoplay', true);
    }

    // Display form for adding/editing sliders
    ?>
    <form method="post" enctype="multipart/form-data" class="myslider-settings-form">
        <label for="slider_title">Slider Title:</label>
        <input type="text" name="slider_title" id="slider_title" required value="<?php echo isset($slider_title) ? esc_attr($slider_title) : ''; ?>"><br>

        <!-- Image Upload -->
        <label for="images">Upload Images:</label>
        <input type="file" name="images[]" id="images" multiple accept="image/*">
        <?php if (isset($slider_id)) : ?>
            <div id="sortable-images" class="sortable-images">
                <?php
                if (!empty($image_urls)) {
                    foreach ($image_urls as $url) {
                        echo '<div class="sortable-image">';
                        echo '<img src="' . esc_url($url) . '" width="100" height="100">';
                        echo '<button class="delete-image" data-url="' . esc_url($url) . '">Delete</button>'; // Changed <a> to <button>
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <input type="hidden" name="slider_id" value="<?php echo esc_attr($slider_id); ?>">
        <?php endif; ?>
        <br>

        <!-- Tooltip Text -->
        <label for="tooltip_text">Tooltip Text:</label>
        <input type="text" name="tooltip_text" id="tooltip_text" value="<?php echo isset($tooltip_text) ? esc_attr($tooltip_text) : ''; ?>"><br>
        
        <!-- Autoplay Speed -->
        <label for="autoplay_speed">Autoplay Speed (ms):</label>
        <input type="number" name="autoplay_speed" id="autoplay_speed" value="<?php echo isset($autoplay_speed) ? intval($autoplay_speed) : ''; ?>"><br>

        <!-- Pagination -->
        <label for="pagination">Pagination:</label>
        <select name="pagination" id="pagination">
            <option value="yes" <?php selected($pagination, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($pagination, 'no'); ?>>No</option>
        </select><br>

        <!-- Autoplay -->
        <label for="autoplay">Autoplay:</label>
        <select name="autoplay" id="autoplay">
            <option value="yes" <?php selected($autoplay, 'yes'); ?>>Yes</option>
            <option value="no" <?php selected($autoplay, 'no'); ?>>No</option>
        </select><br>

        <input type="submit" name="submit" value="Save Slider">
    </form>
    <?php
    
    echo '</div>';
}
// jQuery code to handle delete action
add_action('admin_footer', 'myslider_admin_footer_script');
function myslider_admin_footer_script() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        // jQuery code to handle delete action
        $('.delete-image').click(function() {
            var imageUrl = $(this).data('url');
            $(this).parent().remove(); // Remove image container
        });
    });
    </script>
    <?php
}


// Hook to add the settings page and "Add Slider" sub-menu
add_action('admin_menu', 'myslider_admin_menu');

function myslider_admin_menu() {
    add_menu_page(
        'MySlider Settings',
        'MySlider',
        'manage_options',
        'myslider-settings',
        'myslider_settings_page',
        'dashicons-images-alt2',
        30
    );

    // Add sub-menu for "Add Slider" under "MySlider"
    add_submenu_page(
        'myslider-settings',
        'Add Slider',
        'Add Slider',
        'manage_options',
        'add-slider',
        'myslider_add_slider_page'
    );
}

// Handle delete slider action
add_action('admin_post_delete_slider', 'myslider_handle_delete_slider');
function myslider_handle_delete_slider() {
    if (isset($_GET['slider_id']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_slider_' . $_GET['slider_id'])) {
        $slider_id = intval($_GET['slider_id']);
        wp_delete_post($slider_id);

        // Redirect back to settings page after deletion
        wp_redirect(admin_url('admin.php?page=myslider-settings'));
        exit;
    } else {
        wp_die('Unauthorized access.');
    }
}

function myslider_shortcode($atts) {
    // Attributes
    $atts = shortcode_atts(array(
        'autoplay_speed' => 3000,
        'stop_on_hover' => true,
        'pagination' => 'yes',
    ), $atts);

    // Retrieve selected sliders
    $selected_sliders = get_option('selected_sliders', array());

    // Retrieve slider data
    $args = array(
        'post_type' => 'slider',
        'posts_per_page' => 1, 
        'post__in' => $selected_sliders 
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        // Start slider markup
        $output = '<div class="myslider-wrapper">';
        $output .= '<div class="myslider">';

        while ($query->have_posts()) {
            $query->the_post();
            // Get image URL and tooltip text
            $image_urls = get_post_meta(get_the_ID(), 'image_urls', false);
            $autoplay_speed = get_post_meta(get_the_ID(), 'autoplay_speed', true);
            $pagination = get_post_meta(get_the_ID(), 'pagination', true);
            $autoplay = get_post_meta(get_the_ID(), 'autoplay', true);

            if (!empty($image_urls)) {
                // Add image slides
                foreach ($image_urls as $image_url) {
                    if (is_array($image_url)) {
                        foreach ($image_url as $url) {
                            $output .= '<div class="myslider-slide">';
                            $output .= '<img src="' . esc_url($url) . '" title="' . esc_attr(get_post_meta(get_the_ID(), 'tooltip_text', true)) . '">';
                            $output .= '</div>';
                        }
                    } else {
                        $output .= '<div class="myslider-slide">';
                        $output .= '<img src="' . esc_url($image_url) . '" title="' . esc_attr(get_post_meta(get_the_ID(), 'tooltip_text', true)) . '">';
                        $output .= '</div>';
                    }
                }
            }
        }

        // End slider markup
        $output .= '</div>';

        // Pagination
        $dots = ($pagination === 'yes') ? 'true' : 'false'; // Assign pagination value to dots variable

        if ($pagination === 'yes' && count($image_urls) > 1) {
            $output .= '<div class="myslider-pagination">';
            $output .= '<span class="pagination-prev">&#10094;</span>';
            $output .= '<span class="pagination-next">&#10095;</span>';
            $output .= '</div>';
        }

        $output .= '</div>';

        // Enqueue jQuery and slider library
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('slick-slider', plugin_dir_url(__FILE__) . 'slick/slick.min.js', array('jquery'), '1.0', true);
        wp_enqueue_style('slick-style', plugin_dir_url(__FILE__) . 'slick/slick.css', array(), '1.0');

        $output .= '<script>';
        $output .= 'jQuery(document).ready(function($) {';
        $output .= 'var autoplayEnabled = ' . ($autoplay === 'yes' ? 'true' : 'false') . ';'; // Use autoplay value from post meta
        $output .= 'var autoplaySpeed = ' . ($autoplay_speed ? intval($autoplay_speed) : intval($atts['autoplay_speed'])) . ';'; // Get autoplay speed from post meta or default
        $output .= 'var stopOnHover = ' . ($atts['stop_on_hover'] ? 'true' : 'false') . ';'; // Get stop on hover option
        $output .= 'var dotsEnabled = ' . $dots . ';'; // Use pagination value for dots option
        
        $output .= 'if (autoplayEnabled) {';
        $output .= '$(".myslider").slick({';
        $output .= 'autoplay: true,'; // Always enable autoplay
        $output .= 'autoplaySpeed: autoplaySpeed,';
        $output .= 'pauseOnHover: stopOnHover,';
        $output .= 'dots: dotsEnabled,';
        $output .= '});';
        $output .= '} else {';
        $output .= '$(".myslider").slick({'; // Initialize slider without autoplay
        $output .= 'autoplay: false,';
        $output .= 'pauseOnHover: stopOnHover,';
        $output .= 'dots: dotsEnabled,';
        $output .= '});';
        
        // Stop autoplay if it's not enabled
        $output .= '$(".myslider").slick("slickPause");'; // Pause the autoplay
        $output .= '}';
        $output .= '});';
        $output .= '</script>';
        
        // Output slider
        return $output;
    }

    wp_reset_postdata(); // Reset post data
}
add_shortcode('MySlider', 'myslider_shortcode');


function myslider_enqueue_styles() {
    // Enqueue custom styles
    wp_enqueue_style('myslider-custom-style', plugin_dir_url(__FILE__) . 'style.css', array('slick-style'), '1.0');
}
add_action('wp_enqueue_scripts', 'myslider_enqueue_styles');

