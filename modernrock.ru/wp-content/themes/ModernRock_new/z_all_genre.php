<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<?php while (have_posts()) : the_post(); ?>
	<h1><?php the_title();?></h1>
	<?php the_content();?>
<?php endwhile; ?>

<ul class="b_genre_list">
	<?php wp_list_categories('orderby=id&show_count=0&depth=1&hide_empty=0&title_li=&use_desc_for_title=1&child_of=2872'); ?>
</ul>