 1 Без рубрики
 2 Ссылки
 3 Новости news
 4 Афиша gigs
 5 Репортажи reports
 6 Посты posts
 7 Видео video
 8 Конкурсы contest
 9 Рецензии notices
 10 Интервью interview
 11 Релизы releases_cat
 12 Группы groups
 13 Клубы club
 14 MenuTop menutop
 15 MenuBottom menubottom
 16 ModernrockTV modernrock_tv
 17 Клипы clips
 18 Live live
 19 Акустика acoustics
 20 Every Time I Die every-time-i-die
 21 Топ-10 top10
 22 Любимые альбомы album
 23 Блог blog 0
 24 Дискография discography
 25 Музыкальные новинки music_news
 1323 
 21074 
 2872 билеты
 2902 Поиск
 3029 mrok sounds
 3030 альбомы leakes
/* концерты подразделы */
97
3769
3857
/* концерты подразделы города */
3858
3859
3860

tag.php - редактирование страницы тегов.






размеры картинок:
275x160


src="<?php if(preg_match('!\.(gif)$!i', $large[0])){echo $large[0];}else{echo kama_thumb_src('w=275&h=160',$large[0]);} ?>" width="275" height="160"
src="<?php echo kama_thumb_src('w=275&h=160',$large[0]);?>" width="275" height="160"
src="<?php echo kama_thumb_src('w=285&h=285',$large[0]);?>" width="285" height="285"
src="<?php echo kama_thumb_src('w=200&h=200',$large[0]);?>" width="200" height="200"

src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47"

где у нас билеты:
single-4.php
single-2872.php
single-12.php



<?php 
$args = array('showposts' => 2, 'cat' => 9);
$myposts = get_posts( $args );
foreach( $myposts as $post ){ setup_postdata($post); 
$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
?>

<div class="item">
	<div class="img"><a href="<?php the_permalink(); ?>"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title();?>"/></a></div>
	<div class="desc">
		<p class="name"><a href="<?php the_permalink(); ?>"><?php echo get_post_meta(get_the_ID(), 'notices_group', true);?></a></p>
		<p class="intro"><?php echo get_post_meta(get_the_ID(), 'album', true);?></p>
		<?php include('sn_stars.php'); ?>
	</div> 
</div>
<?php wp_reset_postdata(); }?>


https://wp-kama.ru/id_767/3-sposoba-postroeniya-tsiklov-v-wordpress.html
https://wp-kama.ru/function/query_posts#vazhno-ispolzovat-query_posts-mozhet-byt-opasno



ошибка в базе:
single-4.php
single-12.php