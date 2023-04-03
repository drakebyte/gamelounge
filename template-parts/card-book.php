<?php



?>

<div class="col-md-4 mb-4">
	<div class="card h-100">
		<div class="card-body">
			<h2 class="card-title"><?php the_title(); ?></h2>
			<span class="badge bg-success"><?php echo get_post_type(); ?></span>
            <p class="card-text">
			<?php
			$tagline = get_post_meta( get_the_ID(), 'tagline', true );
			if ( $tagline ) {
				echo $tagline;
			} else {
				the_excerpt();
			}
			?>
			</p>
		</div>
		<div class="card-footer">
			<a href="<?php the_permalink(); ?>" class="btn btn-success"><?php echo __( 'Read more', 'mytheme' ); ?></a>
		</div>
	</div>
</div>
