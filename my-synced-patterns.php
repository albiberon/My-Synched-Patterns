<?php
/**
 * Plugin Name: My Synced Patterns
 * Description: Light weight plugin to list and manage your synced patterns right on your Dashboard.
 * Version: 1.0
 * Author: Albiberon
 */

function my_custom_menu_page(){
    // Code to output the content of your custom page goes here
    echo '<div class="wrap"><h1>Welcome to Synced Patterns</h1></div>';
    global $wpdb; // WordPress database class

    // Try to get potential patterns (this assumes they might be stored similarly to reusable blocks)
    $patterns_query = "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'wp_block'";
    $patterns = $wpdb->get_results($patterns_query);

    // Check if we have patterns
    if ($patterns) {
        echo '<div class="wrap"><h1>Synced Patterns</h1>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>ID</th><th>Title</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        foreach ($patterns as $pattern) {
            echo '<tr>';
            echo '<td>' . esc_html($pattern->ID) . '</td>';
            echo '<td>' . esc_html($pattern->post_title) . '</td>';
            echo '<td><a href="' . esc_url(get_edit_post_link($pattern->ID)) . '">Edit</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<div class="wrap"><h1>Synced Patterns</h1>';
        echo '<p>No synced patterns found.</p>';
        echo '</div>';
    }
}

function my_admin_menu() {
    add_menu_page(
        'Synced Patterns', 
        'Synced Patterns', 
        'manage_options', 
        'my-synced-patterns', 
        'my_custom_menu_page', 
        'dashicons-admin-generic', 
        3
    );
}

add_action('admin_menu', 'my_admin_menu');
