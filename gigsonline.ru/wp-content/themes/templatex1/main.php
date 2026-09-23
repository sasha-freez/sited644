<?php
/**
* Template Name: Главная страница
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
$get_rot1 = get_field( 'назначить_главную_категорию' , 'option');
?>
<?php get_header(); ?>

<header>
		<div class="container">
			<img src="<?=get_field('логотип_на_главной_странице')['url']?>" alt="<?=get_field('слоган')?>">
			<div class="slogan_row"><?=get_field('слоган')?></div>
			<div class="des_row"><?=get_field('описание_сайта')?></div>
		</div>
</header>

<main>

	<div class="container">
	<div class="row event_row">
<?	



// Find todays date in Ymd format.
//$date_now = date_i18n("Y-m-d H:i");
$date_now = date_i18n("Y-m-d");
// Query posts using a meta_query to compare two custom fields; start_date and end_date.
$posts = get_posts( array(
'posts_per_page' => '-1', // Let's show them all.   
'cat' => $get_rot1, // ID категории, откуда вывести записи

'order' => 'ASC', // Порядок сортировки записей
'orderby' => 'meta_value',
'meta_key' => 'data_time', // ключ поля ACF
'meta_type' => 'DATETIME',
       'meta_query' =>
            array(
                'key' => 'data_time', // Check the start date field
                'value' => $date_now, // Set today's date (note the similar format)
                'compare' => '>=', // Return the ones greater than today's date
                'type' => 'DATETIME' // Let WordPress know we're working with date
                ),
         
));

if( $posts ) {
	$i = 0;
	
    foreach( $posts as $post ) { $i++;
?>
				<div class="col-xs-12 col-md-6 event_cart <?php if(!empty(get_field('возможность_покупки'))) echo 'event_buy'; ?>">
				<a href="<?php the_permalink(); ?>">
                    <span class="event_img"><img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>"></span>
					<span class="event_name"><?php the_title(); ?></span>
					<span class="event_time"><?=date_i18n("j F Y, H:i", strtotime(get_field('data_time')))?></span>
                </a>
				</div>
				<?php echo ($i % 2 == 0) ? '<div class="clearfix"> </div>' : ''; ?> 
<?
    }
}	
?>	
	 
	

	</div>
	</div>
</main>

<section class="section_1">
	<div class="container">
		<div class="likea event_add" data-toggle="modal" data-target="#myzakaz" rel="outline-inward"><span><?=get_field('название_кнопки_добавить_событие', 'option')?></span></div>
		<div class="event_archive_wrap_link"><a href="<?=get_term_link($get_rot1);?>" class="event_archive"><span><?=get_term($get_rot1)->name;?></span></a></div>
	</div>
</section>


<?php get_footer();	?> 

