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
function showof_the_project_link($text) {
    $url=get_post_meta(get_the_ID(), '_jetpack_portfolio_project_url', true);
    $project_title=get_post_meta(get_the_ID(), '_jetpack_portfolio_project_url_text', true);
    if($url) {
        echo '<a class="showof-project-url" href="',esc_url($url),'"">', sprintf($text, $project_title),'</a>';
    } else {
        echo $text;
    }
}

add_action( 'add_meta_boxes', 'showof_add_portfolio_metaboxes' );
function showof_add_portfolio_metaboxes() {
    add_meta_box('showof_portfolio_project_url', 'Project URL', 'showof_portfolio_project_url', 'jetpack-portfolio', 'side', 'default');
}

/**
 * @param \WP_Post $post
 */
function showof_portfolio_project_url($post) {
    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'showof_portfolio_project_url', 'showof_portfolio_project_url_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $url = get_post_meta( $post->ID, '_jetpack_portfolio_project_url', true );
    $text = get_post_meta( $post->ID, '_jetpack_portfolio_project_url_text', true );

    echo '<label style="width:140px;display: inline-block;" for="showof_portfolio_project_url_field">';
    _e( 'The URL to the project', 'showof' );
    echo '</label> ';
    echo '<input type="text" id="showof_portfolio_project_url_field" name="jetpack_portfolio_project_url" value="' . esc_attr( $url ) . '" size="25" />';
    echo '<br />';
    echo '<label style="width:140px;display: inline-block;" for="showof_portfolio_project_url_text_field">';
    _e( 'Short project name', 'showof' );
    echo '</label> ';
    echo '<input type="text" id="showof_portfolio_project_url_text_field" name="jetpack_portfolio_project_url_text" value="' . esc_attr( $text) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function showof_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['showof_portfolio_project_url_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['showof_portfolio_project_url_nonce'], 'showof_portfolio_project_url' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'jetpack-portfolio' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['jetpack_portfolio_project_url'] ) ) {
        return;
    }

    // Sanitize user input.
    $url = sanitize_text_field( $_POST['jetpack_portfolio_project_url'] );
    $text = sanitize_text_field( $_POST['jetpack_portfolio_project_url_text'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_jetpack_portfolio_project_url', $url);
    update_post_meta( $post_id, '_jetpack_portfolio_project_url_text', $text);
}
add_action( 'save_post', 'showof_save_meta_box_data' );

/**
 * Customizer additions.
 */
require get_stylesheet_directory() . '/inc/customizer.php';