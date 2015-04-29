<?php

function showof_the_project_link($text, $no_url=false) {
    $url=get_post_meta(get_the_ID(), '_jetpack_portfolio_project_url', true);
    $project_title=get_post_meta(get_the_ID(), '_jetpack_portfolio_project_url_text', true);
    if($url && $project_title) {
        echo '<a class="showof-project-url" href="',esc_url($url),'"">', sprintf($text, $project_title),'</a>';
    } else if($no_url) {
        echo $text;
    }
}

function showof_the_subtitle($before = '', $after = '', $echo = true) {
    $subtitle = showof_get_the_subtitle();

    if ( strlen($subtitle) == 0 )
        return;

    $subtitle = $before . $subtitle . $after;

    if ( $echo )
        echo $subtitle;
    else
        return $subtitle;
}

function showof_get_the_subtitle( $post = 0 ) {
    $post = get_post( $post );

    $id = isset( $post->ID ) ? $post->ID : 0;
    $subtitle = get_post_meta($id, '_jetpack_portfolio_subtitle', true);
    if ( ! is_admin() ) {
        if ( ! empty( $post->post_password ) ) {

            /**
             * Filter the text prepended to the post subtitle for protected posts.
             *
             * The filter is only applied on the front end.
             *
             * @since 1.0
             *
             * @param string  $prepend Text displayed before the post title.
             *                         Default 'Protected: %s'.
             * @param WP_Post $post    Current post object.
             */
            $protected_subtitle_format = apply_filters( 'protected_subtitle_format', '', $post );
            $subtitle = sprintf( $protected_subtitle_format, $subtitle );
        } elseif ( isset( $post->post_status ) && 'private' == $post->post_status ) {

            /**
             * Filter the text prepended to the post subtitle of private posts.
             *
             * The filter is only applied on the front end.
             *
             * @since 1.0
             *
             * @param string  $prepend Text displayed before the post title.
             *                         Default 'Private: %s'.
             * @param WP_Post $post    Current post object.
             */
            $private_subtitle_format = apply_filters( 'private_subtitle_format', '', $post );
            $subtitle = sprintf( $private_subtitle_format, $subtitle );
        }
    }

    /**
     * Filter the post subtitle.
     *
     * @since 1.0
     *
     * @param string $subtitle The post subtitle.
     * @param int    $id    The post ID.
     */
    return apply_filters( 'the_subtitle', $subtitle, $id );
}