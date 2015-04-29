<?php

function showof_load_custom_wp_admin_style() {
    wp_register_style( 'showof_wp_admin_css', get_stylesheet_directory_uri() . '/admin-style.css', false, '1.0.0' );
    wp_enqueue_style( 'showof_wp_admin_css' );
    wp_register_script( 'showof_wp_admin_js', get_stylesheet_directory_uri() . '/js/admin.js', false, '1.0.0', true );
    wp_enqueue_script( 'showof_wp_admin_js' );
}
add_action( 'admin_enqueue_scripts', 'showof_load_custom_wp_admin_style' );

add_action( 'add_meta_boxes', 'showof_add_portfolio_metaboxes' );
function showof_add_portfolio_metaboxes() {
    add_meta_box('showof_portfolio_project_url', 'Project URL', 'showof_portfolio_project_url', 'jetpack-portfolio', 'side', 'default');
}

/**
 * @param \WP_Post $post
 */
function showof_portfolio_project_url($post) {
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
function showof_save_portfolio_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['showof_portfolio_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['showof_portfolio_nonce'], 'showof_portfolio' ) ) {
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
    // Sanitize user input.
    if(isset($_POST['jetpack_portfolio_project_url'])) {
        $url = sanitize_text_field( $_POST['jetpack_portfolio_project_url'] );
        update_post_meta( $post_id, '_jetpack_portfolio_project_url', $url);
    }
    if(isset($_POST['jetpack_portfolio_project_url_text'])) {
        $text = sanitize_text_field($_POST['jetpack_portfolio_project_url_text']);
        update_post_meta( $post_id, '_jetpack_portfolio_project_url_text', $text);
    }
    if(isset($_POST['jetpack_portfolio_subtitle'])) {
        $subtitle = sanitize_text_field($_POST['jetpack_portfolio_subtitle']);
        update_post_meta( $post_id, '_jetpack_portfolio_subtitle', $subtitle);
    }
    // Update the meta field in the database.
}
add_action( 'save_post', 'showof_save_portfolio_data' );


/**
 * Renders a subtitle field on the portfolio post type
 * @param \WP_Post $post
 */
function showof_portfolio_subtitle($post) {
    if(get_post_type($post)!=='jetpack-portfolio')
        return;
    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'showof_portfolio', 'showof_portfolio_nonce' ); ?>

    <div id="subtitlewrap">
        <?php
        /**
         * Filter the subtitle field placeholder text.
         *
         * @since 1.0
         *
         * @param string  $text Placeholder text. Default 'Enter title here'.
         * @param WP_Post $post Post object.
         */
        $subtitle_placeholder = apply_filters( 'enter_subtitle_here', __( 'Enter subtitle here' ), $post );
        $subtitle = showof_get_the_subtitle();
        ?>
        <label class="screen-reader-text" id="subtitle-prompt-text" for="subtitle"><?php echo $subtitle_placeholder; ?></label>
        <input type="text" name="jetpack_portfolio_subtitle" size="30" value="<?php echo esc_attr( htmlspecialchars( $subtitle) ); ?>" id="subtitle" spellcheck="true" autocomplete="off" />
    </div>

    <?php
}
add_action('edit_form_before_permalink', 'showof_portfolio_subtitle');
