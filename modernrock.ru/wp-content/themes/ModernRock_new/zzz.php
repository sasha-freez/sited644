
<?php $large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);?>
<meta property="og:title" content="<?php wp_title(); ?>"/>
<meta property="og:url" content="http://modernrock.ru<?php echo $_SERVER[REQUEST_URI] ?>"/>
<?php if (isset($large[0])) : ?><meta property="og:image" content="<?php echo $large[0]; ?>"/><?php endif;?>

<meta property="og:site_name" content="Modernrock"/>
<?php if (!is_category() && !is_home()) : ?><?php while (have_posts()) : the_post(); ?>
<meta property="og:description" content="<?php the_content_limit(200, ""); ?>"/>
<?php endwhile; ?><?php endif; ?>

<?php if (isset($large[0])) : ?><link rel="image_src" href="<?php echo $large[0]; ?>"/><?php endif;?>



<meta name="description" content="" />
<meta name="keywords" content="" />

<link rel="canonical" href="http://modernrock.ru/news/pervyjj-kanal-pokazhet-film-lenni-kravic.html" />
<meta itemprop="image" content="http://modernrock.ru/wp-content/uploads/2014/12/lenny-kravitz_luchshie-pesni_best-songs.jpg" />

<meta property="og:title" content="Первый канал покажет фильм «Ленни Кравиц»" />
<meta property="og:description" content="Первый канал покажет фильм «Ленни Кравиц»" />
<meta property="og:url" content="http://modernrock.ru/news/pervyjj-kanal-pokazhet-film-lenni-kravic.html" />
<meta property="og:image" content="http://modernrock.ru/wp-content/uploads/2014/12/lenny-kravitz_luchshie-pesni_best-songs.jpg" />
<meta property="article:published_time" content="2016-10-25T13:34:51Z" />
<meta property="article:modified_time" content="2016-10-25T13:34:51Z" />