<?php
/*
$LastModified_unix = 1294844676; // время последнего изменения страницы
$LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
$IfModifiedSince = false;
if (isset($_ENV['HTTP_IF_MODIFIED_SINCE']))
    $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));  
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
    $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
    exit;
}
header('Last-Modified: '. $LastModified);
*/
?>
<!DOCTYPE html>
<html itemscope="itemscope" itemtype="http://schema.org/WebPage" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
<title><?php wp_title(''); ?></title>

<meta name="google-site-verification" content="3PwJOFAib-gAGNIsIQtkDh_40hpOLah2rTPkkiR7R_c" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="MobileOptimized" content="100%"/>
<!--[if lt IE 9]><script src="/js/html5shiv.min.js"></script> <link rel="stylesheet" href="/css/old_ie.css" type="text/css" media="all" /><![endif]-->

<link rel="stylesheet" href="/css/gotham/stylesheet.css?v=23495338" type="text/css" media="all" />
<link rel="stylesheet" href="/css/master.css?v=23495338" type="text/css" media="all" />
<link rel="stylesheet" href="/css/media.css?v=23495338" type="text/css" media="all" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/style.css">
<meta name="yandex-verification" content="c0ff9f5c692f3f1f"/>
<?php wp_deregister_script('jquery'); ?>
<?php wp_head(); ?>

<meta name="yandex-verification" content="c0ff9f5c692f3f1f" />
<meta name="fo-verify" content="68d9896f-9d91-4510-9764-de0b78ededeb"/>

</head>

<body class="custom-background">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('bannerHeader') ) { ?><?php } ?>

<div class="container" id="wrapper">
    <header>
		<div class="head_top">
			<div id="icon-menu" class="icon-menu"></div>
			<div class="logo"><a href="/">Modernrock.ru</a></div>
			<a class="lg_sounds" href="/sounds/"></a>
			<div class="search_first">
				<form method="GET" name="searchform" id="searchform" action="/groups/">
					<input type="text" name="q" id="s" class="inp first_inp" value="" placeholder="Поиск по концертам" autocomplete="off" />
					<input name="submit" class="submit" type="image" src="/images/i_search.png" alt="Найти"/>
				</form>
				<div class="search_hints">
					<!-- <a href="#"><div class="hint_item">
						<div class="hint_image"><img src="https://dev.modernrock.ru/wp-content/cache/thumb/d4/6ea7521946585d4_275x160.jpg" alt=""></div>
						<div class="hint_title">Миша Житов</div>
					</div></a>
					<a href="#"><div class="hint_item">
						<div class="hint_image"><img src="https://dev.modernrock.ru/wp-content/cache/thumb/d4/6ea7521946585d4_275x160.jpg" alt=""></div>
						<div class="hint_title">Миша Житов</div>
					</div></a> -->
				</div>
			</div>
			<div class="search" id="search">
				<form method="get" name="searchform" id="searchform" action="/search/">
					<input type="text" name="q" id="s" class="inp" value="" placeholder="Поиск по сайту"/>
					<input name="submit" class="submit" type="image" src="/images/i_search.png" alt="Найти"/>
				</form>
			</div>
		</div>
		<div class="head_bottom">
			<nav class="menu">
				<?php
					wp_nav_menu( array('menu' => 'MenuTop', 'container' => '','menu_class' => 'menu_top', 'menu_id'=> 'menu_top'));
				?>
			</nav>
			<div class="banner_t">
				<!-- noindex --><?php //if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('TopBanner') ) : endif; ?><!--/noindex-->
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2021 горизонт адептт -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3791748901160446"
     data-ad-slot="1096666468"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
     	let srch = document.querySelector('.first_inp')
		srch.addEventListener('input',()=>{
			// document.querySelector('.result_options').innerHTML = '';
			val = srch.value
			if(val.length >= 3){
						$.ajax({
				 			url: '<?= bloginfo('template_directory');?>/ajax_search.php?q='+val,
					  		success: (data)=>{
								if(document.querySelector('.search_hints').innerHTML != data){
									//console.log(document.querySelector('.search_hints').innerHTML);
									//console.log(data);
									if(val.length != 0){
										document.querySelector('.search_hints').innerHTML = data
									}
								}
						  	},
						});
			}else if(val.length == 0){
					document.querySelector('.search_hints').innerHTML = '';
			}
		})
</script>
			</div>
		</div>
    </header>
	<div class="content">
		<?php wp_reset_query();?>