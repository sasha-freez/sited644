<?php
/**
 * The template for displaying all page.
 *
 * @package storefront
 */

get_header(); ?>

<div class="page_header">
	<div class="container">
		<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(); ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="page_short"><?php echo get_field('краткое_описание'); ?></div>
	</div>
</div>

	<div class="page_content">
	<div class="container">
	

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>

		
	</div>
	</div>

<?php
get_footer();
