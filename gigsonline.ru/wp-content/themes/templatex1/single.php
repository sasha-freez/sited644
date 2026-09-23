<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); 
//$date_now = date_i18n("YmdHi");
$date_now = date_i18n("Ymd");
$get_rot1 = get_field( 'назначить_главную_категорию' , 'option');
?>
<div class="inside_header">
	<div class="container">
		<a href="/"><img src="<? echo get_field('основной_логотип', 'option')['url'];?>" alt="GIGS"></a>
	</div>
</div>

<div class="inside_single">
	<div class="container">
	<div class="inside_single_container">
	<div class="row single_row">
	<div class="col-xs-12 col-md-7 single_col">
		<?php 
			$post_date = substr(get_field('data_time'), 0, 8) ;
		?>
	
	
		<div class="single_head">
		<h1 class="single_head_item"><? the_title()?></h1> <div class="single_head_item single_data"><?=date_i18n("j F Y, H:i", strtotime(get_field('data_time')))?></div> <? if(!empty(get_field('cena', get_the_ID()))) { ?><div class="single_head_item single_price"><span><?=get_field('cena', get_the_ID())?></span></div><? } ?>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-12 col-md-7 single_col">
		<img src="<?=get_the_post_thumbnail_url()?>" alt="<? the_title()?>" class="single_img">
	</div>
	<div class="col-xs-12 col-md-5 single_col">
		<div class="single_text">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>
		</div>	

		<?php if(empty(get_field('возможность_покупки')) and $post_date >= $date_now) { ?>
				<? if(!empty(get_field('link'))) { ?><a href="<?=get_field('link')?>" class="single_link" target="_blank">Смотреть<br> концерт</a><?php } ?>
		<?php } elseif($post_date >= $date_now)  { ?>
				<? if(!empty(get_field('link'))) { ?><a href="<?=get_field('link')?>" class="single_link" target="_blank">Купить<br> билет</a><?php } ?>
		<?php } else {  ?>
			<div class="single_link blocked" >Концерт<br> прошел</div>
		<?php } ?>

		

	</div>	
	<div class="clearfix"></div>
	</div>	
		
	</div>
	</div>
</div>


<div class="video_container">
<div class="container">
<?=get_field('video')?>

</div>
</div>

<div class="others_container">
<div class="container">
<h4><?=get_field('other_concerts', 'option')?></h4>
<div class="row event_row">
<?	



// Find todays date in Ymd format.
$date_now = date_i18n("Y-m-d H:i");

// Query posts using a meta_query to compare two custom fields; start_date and end_date.
$posts = get_posts( array(
'posts_per_page' => '3', // Let's show them all.   
'cat' => $get_rot1, // ID категории, откуда вывести записи

'order' => 'ASC', // Порядок сортировки записей
'orderby' => 'rand',
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
				<div class="col-xs-12 col-md-4 event_cart <?php if(!empty(get_field('возможность_покупки'))) echo 'event_buy'; ?>">
				<a href="<?php the_permalink(); ?>">
                    <span class="event_img"><img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>"></span>
					<span class="event_name"><?php the_title(); ?></span>
					<span class="event_time"><?=date_i18n("j F Y, H:i", strtotime(get_field('data_time')))?></span>
                </a>
				</div>
				
<?
    }
}	
?>	
	 <div class="clearfix"> </div>

</div>
</div>
</div>

<div class="all_single">
	<a href="/">Смотреть все</a>
</div>
<?php get_footer(); ?>
