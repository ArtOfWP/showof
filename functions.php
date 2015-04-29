<?php

add_action( 'wp_enqueue_scripts', 'illustratr_parent_theme_enqueue_styles' );
function illustratr_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'illustratr-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( '-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('illustratr-style')
    );
    wp_dequeue_script('illustratr-sidebar');
    if ( is_active_sidebar( 'sidebar-1' ) ) {
        wp_enqueue_script( 'illustratr-sidebar', get_stylesheet_directory_uri() . '/js/sidebar.js', array( 'jquery', 'jquery-masonry' ), '20150428', true );
    }
}

if(is_admin()) {
    /**
     * Customizer additions.
     */
    require get_stylesheet_directory() . '/inc/customizer.php';
    require get_stylesheet_directory() . '/inc/admin.php';
}
require get_stylesheet_directory() . '/inc/theme-functions.php';