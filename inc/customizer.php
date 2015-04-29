<?php
/**
 * ShowOf Theme Customizer
 *
 * @package ShowOf
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function showof_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'showof_hosted_by_url', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ) );

    $wp_customize->add_setting( 'showof_hosted_by_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ) );

    $wp_customize->add_control( 'showof_hosted_by_url', array(
        'label'             => __( 'Affiliate link to your host', 'showof' ),
        'section'           => 'illustratr_theme_options',
        'type'              => 'text',
        'settings'          => 'showof_hosted_by_url'
    ) );

    $wp_customize->add_control( 'showof_hosted_by_text', array(
        'label'             => __( 'Affiliate link text', 'showof' ),
        'section'           => 'illustratr_theme_options',
        'type'              => 'text',
        'settings'          => 'showof_hosted_by_text'
    ) );

}
add_action( 'customize_register', 'showof_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function showof_customize_preview_js() {
    wp_enqueue_script( 'showof_customizer', get_stylesheet_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20150429', true );
}
add_action( 'customize_preview_init', 'showof_customize_preview_js' );
