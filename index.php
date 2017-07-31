<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chirs
 */

get_header(); ?>

<div class="header-desktop">

	<div class="column-group">
		<section class="chris-image">
			<img src="<?php echo get_template_directory_uri(); ?>/img/chris.jpg" id="header-photo" />
		</section>
	</div>
	
	<div id="meet-chris-close">
		<h4>Back</h4>
	</div>
	
	<div id="meet-chris">
		
		<?php
			$page = get_page_by_title( 'Meet Chris' );
			$recent = new WP_Query("page_id=".$page->ID); while($recent->have_posts()) : $recent->the_post();
			the_content();
			
			echo '<div class="meet-chris-container"><div class="meet-chris-column">' . get_post_meta( get_the_ID(), "advanced_options_column-1", true ) . '</div>';
			echo '<div class="meet-chris-column">' . get_post_meta( get_the_ID(), "advanced_options_column-2", true ) . '</div>';
			echo '<div class="meet-chris-column">' . get_post_meta( get_the_ID(), "advanced_options_column-3", true ) . '</div></div>';
			endwhile;
		?>
	</div>
	
</div>


<div class="header-mobile">
	<header>
		<section class="chris-image">
			<img src="<?php echo get_template_directory_uri(); ?>/img/chris.jpg" id="header-photo" />
		</section>
		
		<section class="site-title">
			<h1><?php bloginfo( 'name' ); ?></h1>
			<?php $description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</section>
	</header>
	
	<?php
		$page = get_page_by_title( 'Meet Chris' );
		$recent = new WP_Query("page_id=".$page->ID); while($recent->have_posts()) : $recent->the_post();
		
		echo get_post_meta( get_the_ID(), "advanced_options_column-1", true );
		
		?>
		
		<div id="read-more">Read more &rarr;</div>
		<div id="read-more-content">
		
			<?php
			echo get_post_meta( get_the_ID(), "advanced_options_column-2", true );
			echo get_post_meta( get_the_ID(), "advanced_options_column-3", true );
			endwhile;
			
		?>
		
			<div id="close">&times; Close</div>
		</div>
	
</div>


<div class="column-group">

	<div class="header-desktop">

		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
				endif;
	
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->
	
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );
				?>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->
	
	</div>

	<div id="content" class="site-content">
		
		<h4 id="mobile-work">Work</h4>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-homepage', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
wp_footer();
