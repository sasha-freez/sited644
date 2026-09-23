<?php
/**
* Template Name: SEO-страница
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
?>
<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="container">
			<div class="page_in_bread">
			<?php kama_breadcrumbs(); ?>
			</div>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
			<?=do_shortcode("[product_category category='411' per_page='12' columns='3' limit='12']")?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->





<?php get_footer();	?> 

