<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chirs
 */

?>


<h2 class="homepage-link" id="project-<?php the_ID(); ?>">
	<a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark" style="background-image: linear-gradient(to right, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-left", true ); ?> 0%, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-right", true ); ?> 100%);">
		<?php the_title(); ?><span><?php foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; } ?></span>
		<div class="homepage-link-background" id="background-<?php the_ID(); ?>" style="background-image: linear-gradient(135deg, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-left", true ); ?> 0%, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-right", true ); ?> 100%), url(<?php the_post_thumbnail_url( 'large' ); ?>);">
			<h1 class="homepage-link-background-title"><?php the_title(); ?></h1>
		</div>
		<div class="homepage-link-background-2" id="background-<?php the_ID(); ?>">
			<h1 class="homepage-link-background-title"><?php the_title(); ?></h1>
		</div>
		<div class="homepage-link-background-image" id="background-<?php the_ID(); ?>">
			<img src="<?php the_post_thumbnail_url( 'large' ); ?>" />
		</div>
	</a>
</h2>
