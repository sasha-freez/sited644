<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header(); 
$category = get_queried_object();

?>

<div class="inside_header inside_header_archive">
	<div class="container">
		<a href="/"><img src="<? echo get_field('основной_логотип', 'option')['url'];?>" alt="GIGS"></a>
	</div>
</div>
<div class="inside_header_title">
	<div class="container">
		<h1><? single_term_title() ?></h1>
	</div>
</div>
<div class="inside_header_selector">
	<div class="container">
		<div class="inside_header_selector_wrap">
			<a href="<?=get_term_link($category->term_id);?>" class="<? if(empty($_GET['video'])) { echo 'current';}?>">Все концерты</a><a href="<?=get_term_link($category->term_id);?>?video=1" class="<? if(!empty($_GET['video'])) { echo 'current';}?>">Только с видео</a>
		</div>
	</div>
</div>

<div class="container">
	<div class="row event_row event_row_archive">
<?	
if ( get_query_var('paged') ) {
$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
$paged = get_query_var('page');
} else {
$paged = 1;
}
$query = new WP_Query( array( 'paged' => $paged ) );
if(empty($_GET['video'])) {
$args =  array(  
'cat' => $category->term_id, // ID категории, откуда вывести записи
'order' => 'ASC', // Порядок сортировки записей
'orderby' => 'meta_value',
'meta_key' => 'data_time', // ключ поля ACF
'meta_type' => 'DATETIME',
'paged' => $paged,  
);
} else {
$args =  array(  
'cat' => $category->term_id, // ID категории, откуда вывести записи
'order' => 'ASC', // Порядок сортировки записей
'meta_key' => 'data_time',
'orderby' => 'meta_value',
'meta_type' => 'DATETIME',
'paged' => $paged,
'meta_query' => array(
    array(
        'key' => 'video',
		'value'   => array(''),
        'compare' => 'NOT IN', //or "NOT EXISTS", for non-existance of this key
    )
)
);	
}

	$i = 0;
$query = new WP_Query( $args );
while ( $query->have_posts() ) { 
	$query->the_post();  $i++;
	?>
	<div class="col-xs-12 col-md-4 event_cart <?php if(!empty(get_field('video'))) echo 'event_video'; ?>">
				<a href="<?php the_permalink(); ?>">
                    <span class="event_img"><img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>"></span>
					<span class="event_name"><?php the_title(); ?></span>
					<span class="event_time"><?=date_i18n("j F Y, H:i", strtotime(get_field('data_time')))?></span>
                </a>
				</div>
				<?php echo ($i % 3 == 0) ? '<div class="clearfix"> </div>' : ''; ?> 
	
	<?
}
wp_reset_postdata();



?> 
<div class="clearfix"> </div>

</div><!-- #primary -->
<div class="pagination_wrap">
<nav class="pagination">
<?php wp_pagenavi( array( 'query' => $query )); ?>
</nav>
</div>
	
	
	
	</div><!-- #primary -->
<div class="clearfix"></div>
<?php
get_footer();
