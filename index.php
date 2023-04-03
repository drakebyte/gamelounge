<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header(); ?>

<div id="content" class="container">
	<div class="row">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/card', get_post_type() );
			endwhile;
		endif;
		?>
	</div>
</div><!-- #content -->

<?php get_footer(); ?>
