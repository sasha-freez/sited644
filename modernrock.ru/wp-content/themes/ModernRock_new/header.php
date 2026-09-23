<!DOCTYPE html>
<html itemscope="itemscope" itemtype="http://schema.org/WebPage" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
<title><?php wp_title(''); ?></title>

<meta name="google-site-verification" content="3PwJOFAib-gAGNIsIQtkDh_40hpOLah2rTPkkiR7R_c" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<!--[if lt IE 9]><script src="/js/html5shiv.min.js"></script> <link rel="stylesheet" href="/css/old_ie.css" type="text/css" media="all" /><![endif]-->

<link rel="stylesheet" href="/css/gotham/stylesheet.css?v=23495338" type="text/css" media="all" />
<link rel="stylesheet" href="/css/master.css?v=23495338" type="text/css" media="all" />
<link rel="stylesheet" href="/css/media.css?v=23495338" type="text/css" media="all" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri() . '/style.css?ver=' . filemtime(__DIR__ . '/style.css')); ?>">
<meta name="yandex-verification" content="c0ff9f5c692f3f1f"/>
<?php wp_deregister_script('jquery'); ?>
<?php wp_head(); ?>

<meta name="fo-verify" content="68d9896f-9d91-4510-9764-de0b78ededeb"/>

<!-- Yandex.RTB -->
<script>window.yaContextCb=window.yaContextCb||[]</script>
<script src="https://yandex.ru/ads/system/context.js" async></script>
<!--/noindex-->
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
				<div class="search_hints"></div>
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
				<!-- Yandex.RTB R-A-1583992-2 -->
<div id="yandex_rtb_R-A-1583992-2"></div>
<script>window.yaContextCb.push(()=>{
  Ya.Context.AdvManager.render({
    renderTo: 'yandex_rtb_R-A-1583992-2',
    blockId: 'R-A-1583992-2'
  })
})</script>
			</div>
		</div>
    </header>
	<div class="content">
		<?php wp_reset_query();?>