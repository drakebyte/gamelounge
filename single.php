<?php
/**
 * The single template file
 */

wp_head();

get_header(); ?>

<div id="content" class="container">
    <div class="row">
		<?php
		if ( have_posts() ) : while ( have_posts() ) : the_post();
				?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <header class="entry-header alignwide">
						<?php
						the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
						<?php the_content(); ?>
                    </div><!-- .entry-content -->

                </article><!-- #post-<?php the_ID(); ?> -->
			<?php
			endwhile;
		endif;
		?>
    </div>
</div><!-- #content -->

<?php
get_footer(); ?>
