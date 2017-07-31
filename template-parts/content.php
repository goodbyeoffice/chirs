<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chirs
 */

?>

<header>

	<div class="page-link-background" id="background-<?php the_ID(); ?>" style="background-image: linear-gradient(135deg, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-left", true ); ?> 0%, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-right", true ); ?> 100%);">
		<h1 class="page-link-background-title"><?php the_title(); ?></h1>
	</div>
	<div class="page-link-background-2" id="background-<?php the_ID(); ?>">
		<h4><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Back to All Projects</a></h4>
		<h1 class="page-link-background-title"><?php the_title(); ?></h1>
	</div>
	<div class="page-link-background-image" id="background-<?php the_ID(); ?>">
		<h1 class="page-link-background-title"><?php the_title(); ?></h1>
		<img src="<?php the_post_thumbnail_url( 'large' ); ?>" />
	</div>

</header>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<div class="entry-content-container">
		<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. */
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'chirs' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chirs' ),
				'after'  => '</div>',
			) );
		?>
		</div>
	</div><!-- .entry-content -->
	
	
	<!-- The project meta section -->
	<div class="project-meta" style="background-image: linear-gradient(315deg, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-left", true ); ?> 0%, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-right", true ); ?> 100%);">
		<div class="project-meta-column-container">
			<?php if ( get_post_meta( get_the_ID(), "project_set_up_column-1-label", true ) !== '' && get_post_meta( get_the_ID(), "project_set_up_column-1-text", true ) !== '') { ?>
			<div class="project-meta-column">
				<h4><?php echo get_post_meta( get_the_ID(), "project_set_up_column-1-label", true ); ?></h4>
				<p><?php echo get_post_meta( get_the_ID(), "project_set_up_column-1-text", true ); ?></p>
			</div>
			<?php } ?>
			
			<?php if ( get_post_meta( get_the_ID(), "project_set_up_column-2-label", true ) !== '' && get_post_meta( get_the_ID(), "project_set_up_column-2-text", true ) !== '') { ?>
			<div class="project-meta-column">
				<h4><?php echo get_post_meta( get_the_ID(), "project_set_up_column-2-label", true ); ?></h4>
				<p><?php echo get_post_meta( get_the_ID(), "project_set_up_column-2-text", true ); ?></p>
			</div>
			<?php } ?>
			
			<?php if ( get_post_meta( get_the_ID(), "project_set_up_column-3-label", true ) !== '' && get_post_meta( get_the_ID(), "project_set_up_column-3-text", true ) !== '') { ?>
			<div class="project-meta-column">
				<h4><?php echo get_post_meta( get_the_ID(), "project_set_up_column-3-label", true ); ?></h4>
				<p><?php echo get_post_meta( get_the_ID(), "project_set_up_column-3-text", true ); ?></p>
			</div>
			<?php } ?>
			
			<?php if ( get_post_meta( get_the_ID(), "project_set_up_column-4-label", true ) !== '' && get_post_meta( get_the_ID(), "project_set_up_column-4-text", true ) !== '') { ?>
			<div class="project-meta-column">
				<h4><?php echo get_post_meta( get_the_ID(), "project_set_up_column-4-label", true ); ?></h4>
				<p><?php echo get_post_meta( get_the_ID(), "project_set_up_column-4-text", true ); ?></p>
			</div>
			<?php } ?>
			
			<?php if ( get_post_meta( get_the_ID(), "project_set_up_column-5-label", true ) !== '' && get_post_meta( get_the_ID(), "project_set_up_column-5-text", true ) !== '') { ?>
			<div class="project-meta-column project-meta-column-5">
				<h4><?php echo get_post_meta( get_the_ID(), "project_set_up_column-5-label", true ); ?></h4>
				<p><?php echo get_post_meta( get_the_ID(), "project_set_up_column-5-text", true ); ?></p>
			</div>
			<?php } ?>
		</div>
	</div>
	
	
	<!-- The more projects section -->
	
	<nav class="more-projects" role="navigation">
		<div class="more-projects-container">
			<h4>More Projects</h4>
				
			<div class="previous-project">
				<?php
				$next_post = get_next_post();
				if (!empty( $next_post )): ?>			
					<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
						<?php echo esc_attr( $next_post->post_title ); ?>
						<div class="gradient-overlay" style="background-image: linear-gradient(135deg, <?php echo get_post_meta( $next_post->ID, "project_set_up_gradient-left", true ); ?> 0%, <?php echo get_post_meta( $next_post->ID, "project_set_up_gradient-right", true ); ?> 100%), linear-gradient(to right, white 0%, white 100%);">
							<img class="to-blend" src="<?php echo esc_url(get_the_post_thumbnail_url( $next_post->ID, 'large' )); ?>">
							<img class="not-to-blend" src="<?php echo esc_url(get_the_post_thumbnail_url( $next_post->ID, 'large' )); ?>">
						</div>
					</a>
				<?php else:
					
					$last_post = new WP_Query( array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 1,
						'order' => 'DESC',
						'cat' => $cat_ID
					));
					
					$last_post->the_post(); ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php echo esc_attr( the_title() ); ?>
						<div class="gradient-overlay" style="background-image: linear-gradient(135deg, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-left", true ); ?> 0%, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-right", true ); ?> 100%), linear-gradient(to right, white 0%, white 100%);">
							<img class="to-blend" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'large' )); ?>">
							<img class="not-to-blend" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'large' )); ?>">
						</div>
					</a>
					
					<?php		
					wp_reset_query();
				endif; ?>
			</div>
			
			<div class="next-project">
				<?php
				$previous_post = get_previous_post();
				if (!empty( $previous_post )): ?>
					<a href="<?php echo esc_url( get_permalink( $previous_post->ID ) ); ?>">
						<?php echo esc_attr( $previous_post->post_title ); ?>
						<div class="gradient-overlay" style="background-image: linear-gradient(135deg, <?php echo get_post_meta( $previous_post->ID, "project_set_up_gradient-left", true ); ?> 0%, <?php echo get_post_meta( $previous_post->ID, "project_set_up_gradient-right", true ); ?> 100%), linear-gradient(to right, white 0%, white 100%);">
							<img class="to-blend" src="<?php echo esc_url(get_the_post_thumbnail_url( $previous_post->ID, 'large' )); ?>">
							<img class="not-to-blend" src="<?php echo esc_url(get_the_post_thumbnail_url( $previous_post->ID, 'large' )); ?>">
						</div>
					</a>
				<?php else:
					
					$first_post = new WP_Query( array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 1,
						'order' => 'ASC',
						'cat' => $cat_ID
					));
					
					$first_post->the_post(); ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php echo esc_attr( the_title() ); ?>
						<div class="gradient-overlay" style="background-image: linear-gradient(135deg, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-left", true ); ?> 0%, <?php echo get_post_meta( get_the_ID(), "project_set_up_gradient-right", true ); ?> 100%), linear-gradient(to right, white 0%, white 100%);">
							<img class="to-blend" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'large' )); ?>">
							<img class="not-to-blend" src="<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'large' )); ?>">
						</div>
					</a>
					
					<?php
					wp_reset_query();
				endif; ?>
			</div>
		</div>
	</nav>
	
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<h4 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h4>
			
			<h4 class="back"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Back to all projects</a></h4>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</article><!-- #post-## -->
