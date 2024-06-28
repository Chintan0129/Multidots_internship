<?php
/*
Plugin Name: Custom Admin Page
Description: Adds a custom admin page just above the "Appearance" menu.
Version: 1.0
Author: chintan shah
*/

//  the admin page content function
function custom_admin_page_content() {
    ?>
    <script>
        window.location.href = 'https://training-chintans.md-staging.com/wordpress-exercise/plugin/';
    </script>
    <?php
    exit;
}



// Register the admin page
function register_custom_admin_page() {
   add_menu_page(
       'Custom Admin Page',        // Page title
       'Custom Admin Page',        // Menu title
       'manage_options',           
       'custom-admin-page',       
       'custom_admin_page_content',// Callback function to display page content
       'dashicons-admin-generic',  // Icon URL or Dashicons class
       59                            
   );
}


add_action('admin_menu', 'register_custom_admin_page');
