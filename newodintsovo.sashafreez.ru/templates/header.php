<!DOCTYPE html>
<html lang="ru">
<head>
<meta content="IE=Edge" http-equiv="X-UA-Compatible"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<? include ($_SERVER[DOCUMENT_ROOT]."/templates/sett.php"); ?>
<title><?=$title;?></title>
<meta name="keywords" content="<?=$key;?>"/>
<meta name="description" content="<?=$description;?>"/>

<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

<script type="text/javascript" src="/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52e581b70722c79c"></script>
<link href="/n/css/master.css?v=5459213" rel="stylesheet" type="text/css" />

<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700|PT+Sans+Narrow:700,400&subset=cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/js/main.js?v=5459213"></script>

<script type="text/javascript" src="/lightbox/js/lightbox-2.6.min.js?v=5459213"></script>
<link rel="stylesheet" type="text/css" href="/lightbox/css/lightbox.css?v=5459213"/>

</head>
<body<?php if($_SERVER[PHP_SELF]!='/index.php') echo ' class="page_inner"'; ?>>

<header>
    <section class="container">
		<div class="logo">
			<a href="/"><img src="/n/images/logo.png" alt="ПЕРВЫЙ"></a>
		</div>
		<nav class="menu">
			<? include($_SERVER[DOCUMENT_ROOT]."/templates/menu.php"); ?>
		</nav>

		<div class="menu-l2">
			<ul>
				<li><a href="http://firstodin.ru/kspress-oczenka-kvartiryi-v-moskve-ili-podmoskove/" rel="nofollow">Экспресс-оценка</a></li>
				<li><a rel="http://firstodin.ru/#test" class="btn_pop" rel="nofollow">Обратиться к специалисту</a></li>
				<li><a href="http://firstodin.ru/ipotechnyij-kalkulyator/" rel="nofollow">Ипотечный калькулятор</a></li>
			</ul>
		</div>
		
		<div class="soc">
    		<span>Мы в соц. сетях</span>
			<a alt="Мы на Facebook" class="f" target="_blank" href="http://www.facebook.com/firstodin"></a>
			<a alt="Мы ВКонтакте" class="v" target="_blank" href="http://www.vk.com/firstodin"></a>
		</div>
		<?php if($_SERVER[PHP_SELF]!='/index.php')
			include('sn_contacts.php');
		?>
	</section>
</header>