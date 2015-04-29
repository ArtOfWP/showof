<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Illustratr
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-area clear">
			<?php
				if ( has_nav_menu( 'social' ) ) {
					wp_nav_menu( array(
						'theme_location'  => 'social',
						'container_class' => 'menu-social',
						'menu_class'      => 'clear',
						'link_before'     => '<span class="screen-reader-text">',
						'link_after'      => '</span>',
						'depth'           => 1,
					) );
				}
			?>
			<div class="site-info <?= has_nav_menu( 'social' )?'half':'' ?>">
                <p>
				<?php if(get_theme_mod('showof_hosted_by_url')): ?>
					<a class="hosted-by" href="<?php echo esc_url(get_theme_mod('showof_hosted_by_url')) ?>" rel="generator"><?php printf( __( 'Proudly hosted by %s', 'showof' ), get_theme_mod('showof_hosted_by_text') ); ?></a>
					<?php else: ?>
                    <a href="http://wordpress.org/" rel="generator"><?php printf( __( 'Proudly powered by %s', 'illustratr' ), 'WordPress' ); ?></a>
					<?php endif; ?>
                    <span class="sep"> | </span>
				<?php printf( __( '%1$s by %2$s.', 'showof' ), 'Show Of', '<a href="http://www.artofwp.com/themes/showof" rel="designer">ArtOfWP.com</a>' ); ?>
                </p>
			</div><!-- .site-info -->
		</div><!-- .footer-area -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>