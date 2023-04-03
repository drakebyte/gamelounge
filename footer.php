<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 */

?>

</main>

<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

<footer id="colophon" class="site-footer">

		<div class="powered-by">
			<?php
			printf(
			/* translators: %s: WordPress. */
				esc_html__( 'Proudly powered by %s.', 'gamelounge' ),
				'<a href="' . esc_url( __( 'https://wordpress.org/', 'gamelounge' ) ) . '">WordPress</a>'
			);
			?>
		</div><!-- .powered-by -->

	</div><!-- .site-info -->
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
