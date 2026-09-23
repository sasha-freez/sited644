<?php
date_default_timezone_set("Europe/Moscow");

redirect();
function redirect(){

$tmp_red_group=explode('/',$_SERVER['REDIRECT_URL']);
foreach($tmp_red_group as $value){
	if ($value<>''){
		$tmp_red_group2[]=$value;
	}
}
$tmp_red_group=$tmp_red_group2;

//print_r($tmp_red_group);
//exit;



/*Редирект групп начало*/
if ($tmp_red_group[0]=='groups' && $tmp_red_group[1]<>'' && count($tmp_red_group)==2 && substr_count($tmp_red_group[1],'.html')==0 && $tmp_red_group[1]<>'page'){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /groups/".$tmp_red_group[1].'.html');
	exit();
}

if ($tmp_red_group[0]=='groups' &&  isset($_GET['page']) && $_GET['page']>0){
	header("HTTP/1.1 301 Moved Permanently");
	if (isset($_GET['gr']) && $_GET['gr']<>''){
		header("Location: /groups/page/".$_GET['page']."?gr=".$_GET['gr']);
	}
	else{
		header("Location: /groups/page/".$_GET['page']);
	}
	exit();
}
/*Редирект групп конец*/

/*Редирект новостей начало*/
if ($tmp_red_group[0]=='news' && $tmp_red_group[1]=='item.html' &&  isset($_GET['id']) && $_GET['id']>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /news/item-".$_GET['id'].'.html');
	exit();
}
/*Редирект новостей конец*/


/*Редирект репортажий начало*/
if ($tmp_red_group[0]=='reviews' && $tmp_red_group[1]=='item.html' &&  isset($_GET['id']) && $_GET['id']>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /reports/item-".$_GET['id'].'.html');
	exit();
}

if ($tmp_red_group[0]=='reviews'){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /reports");
	exit();
}
/*Редирект репортажий конец*/

/*Редирект рецензий начало*/
if ($tmp_red_group[0]=='notices' && $tmp_red_group[1]=='item.html' &&  isset($_GET['id']) && $_GET['id']>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /notices/item-".$_GET['id'].'.html');
	exit();
}
/*Редирект рецензий конец*/

/*Редирект интервью начало*/
if ($tmp_red_group[0]=='interview' && $tmp_red_group[1]=='item.html' &&  isset($_GET['id']) && $_GET['id']>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /interview/item-".$_GET['id'].'.html');
	exit();
}
/*Редирект интервью конец*/

/*Редирект видео начало*/
if ($tmp_red_group[0]=='video' && $tmp_red_group[1]=='item.html' &&  isset($_GET['id']) && $_GET['id']>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /video/item-".$_GET['id'].'.html');
	exit();
}
/*Редирект видео конец*/

/*Редирект клубов начало*/
if ($tmp_red_group[0]=='club' && $tmp_red_group[1]=='id' &&  isset($_GET['club_details']) && $_GET['club_details']>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /club/club_details-".$_GET['club_details'].'.html');
	exit();
}
/*Редирект клубов конец*/

/*Редирект музыкальные новинки начало*/
if ($tmp_red_group[0]=='music_news' && $tmp_red_group[1]=='item.html' &&  isset($_GET['id']) && $_GET['id']>0){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /posts/music_news");
	exit();
}
/*Редирект музыкальные новинки конец*/
}




/*
if ($_GET['param']=='add_club'){
	my_add_club();
}

if ($_GET['param']=='add_news'){
	my_add_news();
}

if ($_GET['param']=='add_group'){
	my_add_group();
}

if ($_GET['param']=='add_discography'){
	my_add_discography();
}

if ($_GET['param']=='add_video'){
	my_add_video();
}

if ($_GET['param']=='add_interview'){
	my_add_interview();
}

if ($_GET['param']=='add_notices'){
	my_add_notices();
}

if ($_GET['param']=='add_reports'){
	my_add_reports();
}

function my_add_reports(){
	mysql_pconnect('localhost','modernrock','mrockytghjqltim');
	mysql_query("SET NAMES UTF8");
	mysql_select_db('modernrock_site');
	$sql="
SELECT 
CONCAT('item-',site_news.id) as post_name,
site_news.name as post_title,
CONCAT(site_news.`short`,'<!--more--><br/>',site_news.`long`) as post_content,
SUBSTRING(site_news.main_pic FROM 1 FOR LOCATE('|',site_news.main_pic )-1) as pic,
site_news.`date`,
db_group.gr_name as group_name, 
site_news.`artist`,
db_club.cl_name
FROM site_news, db_club, db_group, db_avtor
WHERE (
site_news.type = '4'
AND site_news.id_club = db_club.id
AND site_news.id_group = db_group.id
AND site_news.id_avtor = db_avtor.id) ORDER BY `site_news`.`date`  DESC
	";
	$res = mysql_query($sql) or die(mysql_error());

	while ($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		
		$my_post = array(  
			'post_title' => $row['post_title'],  
			'post_content' => $row['post_content'],  
			'post_status' => 'publish',  
			'post_author' => 1,  
			'post_category' => array(5),
			'post_name' => $row['post_name'],
			'post_date' => $row['date']
		);  
		$id=wp_insert_post( $my_post ); 
		update_post_meta($id, 'attached_img', $row['pic']);
		update_post_meta($id, 'reports_group', $row['group_name']);
		update_post_meta($id, 'artist', $row['artist']);
		update_post_meta($id, 'club', $row['cl_name']);
	}
	echo "add_ok";
	exit;
}


function my_add_notices(){
	mysql_pconnect('localhost','modernrock','mrockytghjqltim');
	mysql_query("SET NAMES UTF8");
	mysql_select_db('modernrock_site');
	$sql="
SELECT 
CONCAT('item-',site_news.id) as post_name,
site_news.name as post_title,
CONCAT(site_news.`short`,'<!--more--><br/>',site_news.`long`) as post_content,
SUBSTRING(site_news.main_pic FROM 1 FOR LOCATE('|',site_news.main_pic )-1) as pic,
site_news.`date`,
db_group.gr_name as group_name, 
site_news.quote,
site_news.desc2
FROM site_news, db_club, db_group, db_avtor
WHERE (
site_news.type = '3'
AND site_news.id_club = db_club.id
AND site_news.id_group = db_group.id
AND site_news.id_avtor = db_avtor.id)
ORDER BY site_news.id DESC
	";
	$res = mysql_query($sql) or die(mysql_error());

	while ($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		
		$my_post = array(  
			'post_title' => $row['post_title'],  
			'post_content' => $row['post_content'],  
			'post_status' => 'publish',  
			'post_author' => 1,  
			'post_category' => array(9),
			'post_name' => $row['post_name'],
			'post_date' => $row['date']
		);  
		$id=wp_insert_post( $my_post ); 
		update_post_meta($id, 'attached_img', $row['pic']);
		update_post_meta($id, 'notices_group', $row['group_name']);
		update_post_meta($id, 'album', $row['quote']);
		update_post_meta($id, 'year', $row['desc2']);
	}
	echo "add_ok";
	exit;
}

function my_add_interview(){
	mysql_pconnect('localhost','modernrock','mrockytghjqltim');
	mysql_query("SET NAMES UTF8");
	mysql_select_db('modernrock_site');
	$sql="
SELECT 
CONCAT('item-',site_news.id) as post_name, 
site_news.name as post_title,
CONCAT(site_news.`short`,'<!--more--><br/>',site_news.`long`) as post_content,
SUBSTRING(site_news.main_pic FROM 1 FOR LOCATE('|',site_news.main_pic )-1) as pic,
site_news.`date`,
db_group.gr_name as group_name,
site_news.quote
FROM site_news, db_club, db_group, db_avtor
WHERE (
site_news.type = '2'
AND site_news.id_club = db_club.id
AND site_news.id_group = db_group.id
AND site_news.id_avtor = db_avtor.id) ORDER BY `site_news`.`date` DESC
	";
	$res = mysql_query($sql) or die(mysql_error());

	while ($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		
		$my_post = array(  
			'post_title' => $row['post_title'],  
			'post_content' => $row['post_content'],  
			'post_status' => 'publish',  
			'post_author' => 1,  
			'post_category' => array(10),
			'post_name' => $row['post_name'],
			'post_date' => $row['date']
		);  
		$id=wp_insert_post( $my_post ); 
		update_post_meta($id, 'attached_img', $row['pic']);
		update_post_meta($id, 'interview_group', $row['group_name']);
		update_post_meta($id, 'quote', $row['quote']);
	}
	echo "add_ok";
	exit;
}

function my_add_video(){
	mysql_pconnect('localhost','modernrock','mrockytghjqltim');
	mysql_query("SET NAMES UTF8");
	mysql_select_db('modernrock_site');
	$sql="
SELECT 
CONCAT('item-',sn.id) as post_name,
sn.name as post_title,
CONCAT(sn.`short`,'<!--more--><br/>',sn.desc3,'<br/>',sn.`long`) as post_content,
SUBSTRING(sn.main_pic FROM 1 FOR LOCATE('|',sn.main_pic )-1) as pic,
sn.date,
dg.gr_name as group_name
FROM  site_news sn
left join db_group dg on dg.id=sn.id_group
WHERE (sn.type='5' and sn.not_news='0')
	";
	$res = mysql_query($sql) or die(mysql_error());

	while ($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		
		$my_post = array(  
			'post_title' => $row['post_title'],  
			'post_content' => $row['post_content'],  
			'post_status' => 'publish',  
			'post_author' => 1,  
			'post_category' => array(7),
			'post_name' => $row['post_name'],
			'post_date' => $row['date']
		);  
		$id=wp_insert_post( $my_post ); 
		update_post_meta($id, 'attached_img', $row['pic']);
		update_post_meta($id, 'video_group', $row['group_name']);
	}
	echo "add_ok";
	exit;
}



function my_add_discography(){
	mysql_pconnect('localhost','modernrock','mrockytghjqltim');
	mysql_query("SET NAMES UTF8");
	mysql_select_db('modernrock_site');
	$sql="
								SELECT 
dgd.*,
sc.gr_name
FROM db_group_discography dgd
inner join  db_group sc on sc.id=dgd.id_db_group
	";
	$res = mysql_query($sql) or die(mysql_error());

	while ($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		$my_post = array(  
			'post_title' => $row['name'],  
			'post_content' => $row['text'],  
			'post_status' => 'publish',  
			'post_author' => 1,  
			'post_category' => array(24)
		);  
		$id=wp_insert_post( $my_post ); 
		update_post_meta($id, 'attached_img', $row['img']);
		update_post_meta($id, 'url_partner', $row['url']);
		update_post_meta($id, 'group', $row['gr_name']);
		update_post_meta($id, 'year', $row['year']);
	}
	echo "add_ok";
	exit;
}



function my_add_group(){
	mysql_pconnect('localhost','modernrock','mrockytghjqltim');
	mysql_query("SET NAMES UTF8");
	mysql_select_db('modernrock_site');
	$sql="
				SELECT 
sc.alias as post_name,
dg.gr_name as post_title,
dg.`desc`,
dg.`text`,
SUBSTRING(dg.gr_main_pic FROM 1 FOR LOCATE('|',dg.gr_main_pic )-1) as pic,
dg.land
FROM db_group dg
left join  site_content sc on sc.pagetitle=dg.gr_name
WHERE dg.gr_name<>''
	";
	$res = mysql_query($sql) or die(mysql_error());

	while ($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		$my_post = array(  
			'post_title' => $row['post_title'],  
			'post_content' => $row['desc'].'<!--more-->'.$row['text'],  
			'post_status' => 'publish',  
			'post_author' => 1,  
			'post_category' => array(12),
			'post_name' => $row['post_name']
		);  
		$id=wp_insert_post( $my_post ); 
		update_post_meta($id, 'attached_img', $row['pic']);
		update_post_meta($id, 'country', $row['land']);
	}
	echo "add_ok";
	exit;
}


function my_add_news(){
	mysql_pconnect('localhost','modernrock','mrockytghjqltim');
	mysql_query("SET NAMES UTF8");
	mysql_select_db('modernrock_site');
	$sql="
		SELECT 
CONCAT('item-',sn.id) as post_name,
sn.name as post_title,
CONCAT(sn.`short`,'<!--more--><br/>',sn.`long`,'<br/>') as post_content,
SUBSTRING(sn.main_pic FROM 1 FOR LOCATE('|',sn.main_pic )-1) as pic,
SUBSTRING(sn.pics FROM 3 FOR LOCATE('|',sn.pics)-3) as img,
sn.date,
dg.gr_name as group_name
FROM  site_news sn
left join db_group dg on dg.id=sn.id_group
WHERE sn.type='1'
	";
	$res = mysql_query($sql) or die(mysql_error());

	while ($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		$tmp_img='';
		if ($row['img']<>''){
			$tmp_img='<br/><img src="/wp-content/uploads/2012/11/'.$row['img'].'">';
		}
		
		$my_post = array(  
			'post_title' => $row['post_title'],  
			'post_content' => $row['post_content'].$tmp_img,  
			'post_status' => 'publish',  
			'post_author' => 1,  
			'post_category' => array(3),
			'post_name' => $row['post_name'],
			'post_date' => $row['date']
		);  
		$id=wp_insert_post( $my_post ); 
		update_post_meta($id, 'attached_img', $row['pic']);
		update_post_meta($id, 'news_group', $row['group_name']);
	}
	echo "add_ok";
	exit;
}

function my_add_club(){
	mysql_pconnect('localhost','modernrock','mrockytghjqltim');
	mysql_query("SET NAMES UTF8");
	mysql_select_db('modernrock_site');
	$sql="
		SELECT 
CONCAT('club_details-',id) as post_name,
cl_name as post_title,
CONCAT(`desc`,'<br/>',`map`) as post_content,
SUBSTRING(main_pic FROM 1 FOR LOCATE('|',main_pic )-1) as pic
FROM  `db_club`
where 
cl_name<>'' 
	";
	$res = mysql_query($sql) or die(mysql_error());

	while ($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		$my_post = array(  
			'post_title' => $row['post_title'],  
			'post_content' => $row['post_content'],  
			'post_status' => 'publish',  
			'post_author' => 1,  
			'post_category' => array(13),
			'post_name' => $row['post_name']
		);  
		$id=wp_insert_post( $my_post ); 
		update_post_meta($id, 'attached_img', $row['pic']);
		update_post_meta($id, 'city', 'Москва');
	}
	echo "add_ok";
	exit;
}
*/





just_concert_post();

add_action('wp_dashboard_setup', 'add_new_dashboard_widget' );
add_action( 'login_enqueue_scripts', 'login_enqueue_scripts' );//Кастомная форма входа с полноразмерным фоном
add_filter('admin_footer_text', 'remove_footer_admin');//Сменить надпись в подвале консоли WordPress
add_filter( 'login_headerurl', create_function('', 'return get_home_url();') );/* Ставим ссылку с логотипа на сайт, а не на wordpress.org */


if (get_current_user_id()>0){
	wp_enqueue_style('admin', get_template_directory_uri().'/admin.css');//Подключаем css для админки
	
	add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );//Удалить элементы меню в левой панели админки WP
	//add_filter('screen_options_show_screen', 'remove_screen_options');//Удаление кнопки «Настройки экрана» с помощью хука
	add_action('wp_dashboard_setup', 'my_remove_dashboard_widgets' );// Удаление лишних виджетов из консоли WordPress
}


function GeoCity(){
	if (isset($_POST['set_city']) && $_POST['set_city']<>''){
		$_SESSION['geocity']=$_POST['set_city'];
	}
	
	if (!isset($_SESSION['geocity']) && $_SESSION['geocity']==""){
		/*if($xml = file_get_contents('http://geoip.elib.ru/cgi-bin/getdata.pl?ip='.$_SERVER['REMOTE_ADDR'])){
			$xml=substr($xml,strpos($xml,'<Town>')+6,strlen($xml));
			$xml=substr($xml,0,strpos($xml,'<'));
			$_SESSION['geocity']=$xml;
			return $xml;
		}
		else{
			return "";
		}*/
		$_SESSION['geocity']='Москва';
	}
	else{
		return $_SESSION['geocity'];
	}
}
//GeoCity();



	function wps_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('wp-logo');
		//$wp_admin_bar->remove_menu('about');
		//$wp_admin_bar->remove_menu('wporg');
		//$wp_admin_bar->remove_menu('documentation');
		//$wp_admin_bar->remove_menu('support-forums');
		//$wp_admin_bar->remove_menu('feedback');
		//$wp_admin_bar->remove_menu('view-site');
	}
	
	function remove_screen_options(){
		return false;
	}
	
	function remove_footer_admin () {
		echo "&copy; modernrock.ru 2017";
	}
	
	function login_enqueue_scripts(){
		echo '
		 <div class="background-cover"></div>
		<style type="text/css" media="screen">
			.background-cover{
				/*background:url('.get_bloginfo('template_directory').'/images/background) no-repeat center center fixed; */
				-webkit-background-size: cover; 
				-moz-background-size: cover; 
				-o-background-size: cover; 
				background-size: cover; 
				position:fixed; 
				top:0; 
				left:0; 
				z-index:10; 
				overflow: hidden; 
				width: 100%; 
				height:100%;
			} 
			#login{ z-index:9999; position:relative; }
			.login form { box-shadow: 0px 0px 0px 0px !important; }
			.login h1 a { background:url('.get_bloginfo('template_directory').'/images/logo.png) no-repeat center top !important; } 
			input.button-primary, button.button-primary, a.button-primary{ 
				border-radius: 3px !important; 						
				background:url('.get_bloginfo('template_directory').'/images/button.jpg); 
					border:none !important;
					font-weight:normal !important;
					text-shadow:none !important;
				}
				.button:active, .submit input:active, .button-secondary:active {
					background:#5897ff !important; 
					text-shadow: none !important;
				}
				.login #nav a, .login #backtoblog a {
					color:black !important;
					text-shadow: none !important;
				}
				.login #nav a:hover, .login #backtoblog a:hover{
					color:#5897ff !important;
					text-shadow: none !important;
				}
				.login #nav, .login #backtoblog{
					text-shadow: none !important;
				}
			</style>
		';
	}
	
	/*
 * Удаляем виджеты из dashboard
 */
function my_remove_dashboard_widgets() {
  global $wp_meta_boxes;
 
  //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // Прямо сейчас
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // Плагины
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // Входящие ссылки
  //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Свежие комментарии
   
  //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Быстрая публикация
  //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // Свежие черновики
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // Блог WordPress
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // Другие новости WordPress
}


//Добавление виджета в Консоль
function new_dashboard_widget() {
    print '
	<div class="h1">Новости рок музыки со всего света.</div>
<p>Музыкальный портал modernrock.ru официально открылся 7 июля 2007 года. За 9 лет своего существования приоритетом для нашей команды стали новости музыки, обзоры и фотоотчеты с концертов, интервью с музыкантами и рецензии на релизы, которые современные рок группы в последнее время представляют публике с завидным постоянством. Нынешнее время для исполнителей – это время перемен, поэтому музыкальные новости, которые публикуются на нашем ресурсе, отражают не только жизнь артистов, но и все изменения и перемены в мире рок музыки. Современный рок – это уже новый этап развития этого жанра, поэтому новости рок музыки, публикуемые на нашем портале, представляют собой актуальное отражение всего того, что происходит на западной и отечественной музыкальных рок сценах. Современный зарубежный рок развивается все быстрее и быстрее, а в наше время на просторах рунета практически нет сайтов, соответствующих этой узкой, но необходимой для каждого ценителя современной рок музыки тематики. Новости музыки, а также около музыкальные новости ежедневно появляются в новостной ленте modernrock.ru, название которого символично переводится с английского как «современный рок».</p>
<p>Наша команда всегда оперативно предоставляет посетителем modernrock.ru самые качественные и подробные обзоры и фотоотчеты с концертов, рецензии на новинки альбомов современного рока. Это то, чем наш портал выгодно выделяется на фоне других интернет-ресурсов подобного плана. Наш ресурс освещает жизнь не только известных исполнителей, но и начинающих современных рок групп.</p>
<p>Мы сотрудничаем со многими музыкальными лейблами (Sony Music) и концертными агентствами (Stop the Silence, IceCreamDisco, Play It Loud, Promo End), постоянно проводим различные конкурсы с разными призами. Современный рок – это очень объемная сфера, поэтому modernrock.ru располагает огромным потенциалом развития. Наша команда состоит из людей, которые уже не первый год следят за отечественным и зарубежным роком, модными тенденциями и сменой популярных течений. Это позволяет нам публиковать самые актуальные и свежие новости музыки, которые позволяют посетителям нашего сайта всегда быть в курсе событий в мире современного рока.</p>
<p>modernrock.ru за время своего существования 4 раза менял свой внешний вид и техническую часть. В последнем издании сайт наконец-то обрел окончательный облик и с тех пор все новости рок музыки, отчеты о концертах, рецензии, интервью и многое другое представлены в самом удобном для обзора исполнении.</p>
<p><br/>Спасибо, что вы выбрали нас!</p>
<p>Редакция портала modernrock.ru</p>
	';
}
 
function add_new_dashboard_widget() {
  wp_add_dashboard_widget( 'new_dashboard_widget', 'Музыкальные новости от портала modernrock.', 'new_dashboard_widget' );
}

add_theme_support('custom-background'); //Используем фон для темы

function seocategorydel($catlink1) {
 $catlink1 = str_replace('/category', '', $catlink1);
 return $catlink1;
}

//add_filter('category_link', 'seocategorydel', 1, 1);


/*Отправка почты начало*/
add_filter( 'wp_mail_from', 'hg_mail_from');
add_filter( 'wp_mail_from_name', 'hg_mail_from_name');
function hg_mail_from($from_email){
	$from_email = 'support@modernrock.ru';
	return $from_email;
}
function hg_mail_from_name($from_name){
	$from_name = 'ModernRock';
	return $from_name;
}
/*Отправка почты конец*/


if ( function_exists('register_sidebar') ){
	register_sidebar(array(
		'id' => 'sidebar-1',
    	'name' => 'RightBanner',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
	
	register_sidebar(array(
		'id' => 'sidebar-2',
    	'name' => 'TopBanner',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
	
	register_sidebar(array(
		'id' => 'sidebar-3',
    	'name' => 'BottomBanner',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
		'id' => 'sidebar-4',
		'name'=>'bannerHeader',
        'before_widget' => '<div class="bannerHeader">',
        'after_widget' => '</div>',
        'before_title' => '<div class="title">',
        'after_title' => '</div>',
     ));
      ////AdHub_Banner_9805 на второстепенных страницах перд комментариями
    register_sidebar(array(
		'id' => 'sidebar-5',
    	'name' => 'AdHub_Banner_9805',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    ///AdHub_Banner_9804 на главной после новостей и второстерпенных после фэйсбука
    register_sidebar(array(
		'id' => 'sidebar-6',
    	'name' => 'AdHub_Banner_9804',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
     ///биржа oyy.ru справа на главной под рецензиями, второстепенные перед виджетом VK
    register_sidebar(array(
		'id' => 'sidebar-7',
    	'name' => 'oyy_first',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
     ///RotaBan.ru Ad Code На главной над рецензиями, на второстепенных страницах на самом верху этого блока, над музыкальными новинками недели
    register_sidebar(array(
		'id' => 'sidebar-8',
    	'name' => 'RotaBan',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
	///для биржи Pingmedia
    register_sidebar(array(
		'id' => 'sidebar-9',
    	'name' => 'Pingmedia',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
}

remove_action( 'wp_head', 'wp_generator' );//Удаляем Генератор

if ( function_exists( 'add_theme_support' ) ){
	add_theme_support( 'post-thumbnails' );//Добавляем миниатюру
}


function date_gigs($date,$type="0"){//0-месяц,1-день недели,2-weeks
	$month[1] = "январ";
	$month[2] = "феврал";
	$month[3] = "март";
	$month[4] = "апрел";
	$month[5] = "ма";
	$month[6] = "июн";
	$month[7] = "июл";
	$month[8] = "август";
	$month[9] = "сентябр";
	$month[10] = "октябр";
	$month[11] = "ноябр";
	$month[12] = "декабр";
	
	if ($type=="0"){
		$mnum = date("n",strtotime($date));
		if ($mnum==3||$mnum==8) //если третий или восьмой месяц…
		{
			return $month[$mnum]."а";
		}
		else //иначе…
		{
			return $month[$mnum]."я";
		}
	}
	else{
		$mnum = date("w",strtotime($date));
		$day_arr=array(1 => 'понедельник', 2 => 'вторник', 3 => 'среда', 4 => 'четверг', 5 => 'пятница', 6 => 'суббота', 0 => 'воскресенье');
		return $day_arr[$mnum];
	}
}


function modern_comment($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
	?>
	<div class="item-comment" id="comment-<?php comment_ID(); ?>">
		<div class="img"><?php echo get_avatar($comment->user_id,$size='50','','Аватар' ); ?></div>
		<div class="comments">
			<div class="author"><?php comment_author();?></div>
			<div class="txt"> <?php comment_text(); ?> </div>
			<div class="date"><?php comment_date('d.m.Y в H:i');?></div>			
		</div>
		<div class="clear"></div>
	</div>
	<?php
}


function just_concert($idpost=0,$type=0){
//type: 0 - количество
//		1 - массив пользователей
	global $wpdb;
	if ($type==1){
		$sql = "SELECT jc.*, u.display_name, um.meta_value as avatar FROM `just_concert` jc
				inner join `".$wpdb->prefix."users` u on u.id=jc.user_id
				inner join `".$wpdb->prefix."usermeta` um on um.user_id=u.id and um.meta_key='avatar'
			WHERE 
				jc.post_id=".$idpost;
		$res = $wpdb->get_results($sql);
		wp_reset_postdata();
		$tmp=array();
		foreach ($res as $value) {
			$tmp[]=$value;
		}
		return $tmp;
	}
	else{
		$sql = "SELECT count(user_id) as count FROM `just_concert` WHERE  post_id=".$idpost;
		$res = $wpdb->get_results($sql);
		wp_reset_postdata();
		foreach ($res as $value) {
			return ($value->count);
		}
	}
}

function just_concert_post(){
	
	if (isset($_GET['param']) && $_GET['param']=='just_concert'){
		if ($_POST['user_id']>0){
			global $wpdb;
			$sql = "SELECT count(user_id) as count FROM `just_concert` WHERE  post_id=".$_POST['post_id']." and user_id=".$_POST['user_id'];
			$res = $wpdb->get_results($sql);
			if ($res[0]->count>0){
				echo "false";
			}
			else{
				$wpdb->insert('just_concert',array( 'post_id' => $_POST['post_id'], 'user_id' => $_POST['user_id'] ),array( '%d', '%d' ));
				echo "true";
			}
		}
		else{
			echo "auth";
		}
		exit;
	}
	
	if (isset($_GET['param']) && $_GET['param']=='city_list' && isset($_POST['find']) && $_POST['find']<>''){
		global $wpdb;
		$querystr = "SELECT distinct(title) FROM `city` where title like '%".$_POST['find']."%'";
		$towns = $wpdb->get_results($querystr);
		foreach ($towns as $town) {
			echo '<a href="/?set_city='.$town->title.'">'.$town->title.'</a>';
		}
		wp_reset_postdata();
		exit;
	}
	
	if (isset($_GET['param']) && $_GET['param']=='group_list' && isset($_POST['pages']) && $_POST['pages']<>''){
		if ($_POST['pages']>1){
			$offset='&offset='.($_POST['pages']-1)*48;
		}
		$r = new WP_Query('cat=12&showposts=48&orderby=title&order=ASC'.$offset);
		while ($r->have_posts()) : $r->the_post();
			echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
		endwhile;		
		wp_reset_postdata();
		exit;
	}
}

/*Параметры для афиши и билетов начало*/
add_action('admin_menu', 'new_city_add_custom_box');
function new_city_add_custom_box(){
		add_meta_box('select_your_city', // Идентификатор новой секции экрана.
		'Параметры для афиши и билетов', // Заголовок виджета.
		'city_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

/* Миниатюры добавление */
if (class_exists('MultiPostThumbnails')) {

new MultiPostThumbnails(array(
	'label' => 'Изображение для афиши',
	'id' => 'afisha-img',
	'post_type' => 'post'
	 ));

new MultiPostThumbnails(array(
	'label' => 'Изображение для слайдера',
	'id' => 'slider-img',
	'post_type' => 'post'
	 ));
}
function city_custom_box() {
	$cat = get_the_category();
	$cat_parent = $cat[0]->category_parent;

	if ($cat[0]->term_id<>4 && $cat[0]->term_id<>2872 && $cat_parent<>2872){
		print('<style>#select_your_city{display:none;}</style>');
		return "";
	}
	
	global $post, $wpdb;
    $data_city = get_post_meta($post->ID,'city',true);
	$data_club = get_post_meta($post->ID,'club',true);
	$data_group = get_post_meta($post->ID,'group_afisha',true);
	$data_buyticket = get_post_meta($post->ID,'buyticket',true);
	$data_afisha = get_post_meta($post->ID,'data_afisha',true);
	$time_afisha = get_post_meta($post->ID,'time_afisha',true);
	$ticket_ot = get_post_meta($post->ID,'ticket_ot',true);
	$tc_event = get_post_meta($post->ID,'tc_event',true);
	
	$data_buyticket_1 = get_post_meta($post->ID,'buyticket_1',true);
	$data_buyticket_1_radio = get_post_meta($post->ID,'buyticket_1_radio',true);
	$data_buyticket_2 = get_post_meta($post->ID,'buyticket_2',true);
	$data_buyticket_3 = get_post_meta($post->ID,'buyticket_3',true);
	
	$db1r_1=($data_buyticket_1_radio == 'event' || empty($data_buyticket_1_radio) ? 'checked="checked"' : '');
	$db1r_2=($data_buyticket_1_radio == 'action' ? 'checked="checked"' : '');
	/* Если билеты, то можно использовать заголовок в описании */

    $ct = get_post_meta($post->ID,'check_title',true);
	if ($ct=='1'){
		$ctp='checked="checked"';
	}
	else{
		$ctp='';
	}
	$check_title = get_post_meta($post->ID,'check_title',true);
	echo '
		<p>
			<label>
				<input type="checkbox" name="check_title" id="check_title" '.$ctp.' value="1" />
			</label>
			Использовать заголовок
		</p>
	';
	
	$tmp_post=$post;
	
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('city').'" />';
    print '<label for="city">Город: </label>';
    print '<select name="city" id="city" style="width:210px;">';
 
	$querystr = "SELECT distinct(title) FROM `city_mrok`";
	$towns = $wpdb->get_results($querystr);
	print '<option value="0">Не выбран</option>';
    foreach ($towns as $town) {
        echo '<option value="'.$town->title.'"';
        if ($data_city == $town->title) echo ' selected="selected"';
        echo '>'.$town->title.'</option>';
    }
 
    print "</select>";
	wp_reset_postdata();
	
	print '<br/><br/>';
	print '<label for="club">Клуб:</label><br/>';
	print '<select name="club" id="club" style="width:210px;">';
	print '<option value="0">Не выбран</option>';
	$r = new WP_Query('cat=13&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_club == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
		
	wp_reset_postdata();
	
	print '<br/><br/>';
	print '<label for="group_afisha">Группа:</label>';
	print '<select name="group_afisha" id="group_afisha" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_group == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
		
	wp_reset_postdata();
	
	print '<br/><br/>';

	print '<b>Кассир СПБ</b> <span style="font-size:11px;">ID Концерта (API)</span><br/>';
	print '<label for="buyticket"></label>';
	print '<input type="text" name="buyticket_1" value="'.$data_buyticket_1.'" style="width: 200px;"><br/>';
	print '<label><input type="radio" name="buyticket_1_radio" value="event" '.$db1r_1.'/>Событие</label> &nbsp;&nbsp;';
	print '<label><input type="radio" name="buyticket_1_radio" value="action" '.$db1r_2.'/>Мероприятие</label>';
	print '<br/><br/>';
	
	
	print '<b>Кассир МСК</b> <span style="font-size:11px;">ID Концерта (API)</span><br/>';
	print '<label for="buyticket"></label>';
	print '<input type="text" name="buyticket_2" value="'.$data_buyticket_2.'" style="width: 200px;">';
	print '<br/><br/>';
	
	print '<b>ConcertRU</b> <span style="font-size:11px;">ID Концерта (API)с<br/>';
	print '<label for="buyticket"></label>';
	print '<input type="text" name="buyticket_3" value="'.$data_buyticket_3.'" style="width: 200px;">';
	print '<br/><br/>';
	
	//print '<b>Купить партнерка</b> (tc-event:)<br/>';
	//print '<label for="tc-event"></label>';
	//print '<input type="text" name="tc_event" value="'.$tc_event.'" style="width: 200px;">';
	
	print '<br/><br/>';
	print '<b>Купить билет</b> <span style="font-size:11px;">(Ссылка, пономиналу)</span><br/>';
	print '<label for="buyticket"></label>';
	print '<input type="text" name="buyticket" value="'.$data_buyticket.'" style="width: 200px;">';
	print '<br/><br/>';
	
	print '<label for="ticket_ot">Билеты от:</label>';
	print '<input type="text" name="ticket_ot" value="'.$ticket_ot.'" style="width: 200px;">';
		
	$data_afisha=explode('-',$data_afisha);
	if ($data_afisha[0]=="") $data_afisha[0]=date('Y');
	if ($data_afisha[1]=="") $data_afisha[1]=date('m');
	if ($data_afisha[2]=="") $data_afisha[2]=date('d');
	
	print '<br/><br/>';
	print '<b>Дата концерта</b><br/>';
	print '<input type="text" name="dey_afisha" value="'.$data_afisha[2].'" size="2" maxlength="2">';
	print '<select name="month_afisha" id="month_afisha">';
	print '<option value="01"'.sel_month('01',$data_afisha[1]).'>Января</option>';
	print '<option value="02"'.sel_month('02',$data_afisha[1]).'>Февраля</option>';
	print '<option value="03"'.sel_month('03',$data_afisha[1]).'>Марта</option>';
	print '<option value="04"'.sel_month('04',$data_afisha[1]).'>Апреля</option>';
	print '<option value="05"'.sel_month('05',$data_afisha[1]).'>Мая</option>';
	print '<option value="06"'.sel_month('06',$data_afisha[1]).'>Июня</option>';
	print '<option value="07"'.sel_month('07',$data_afisha[1]).'>Июля</option>';
	print '<option value="08"'.sel_month('08',$data_afisha[1]).'>Августа</option>';
	print '<option value="09"'.sel_month('09',$data_afisha[1]).'>Сентября</option>';
	print '<option value="10"'.sel_month('10',$data_afisha[1]).'>Октября</option>';
	print '<option value="11"'.sel_month('11',$data_afisha[1]).'>Ноября</option>';
	print '<option value="12"'.sel_month('12',$data_afisha[1]).'>Декабря</option>';
	print "</select>";		
	print '<input type="text" name="year_afisha" value="'.$data_afisha[0].'" size="4" maxlength="4">';
	print '<label for="year_afisha">г.</label>';
	
	$time_afisha=explode(':',$time_afisha);
	if ($time_afisha[0]=="") $time_afisha[0]=date('H');
	if ($time_afisha[1]=="") $time_afisha[1]=date('i');
	print '<br/><br/>';
	print '<b>Время концерта</b><br/>';
	print '<input type="text" name="hour_afisha" value="'.$time_afisha[0].'" size="2" maxlength="2" style="text-align:right;">';
	print '<label>:</label>';
	print '<input type="text" name="min_afisha" value="'.$time_afisha[1].'" size="2" maxlength="2" style="text-align:right;">';
	
	wp_reset_postdata();
	$post=$tmp_post;
}

function sel_month($data1,$data2){
	if ($data1==$data2){
		return ' selected="selected"';
	}
}

add_action('save_post', 'example_save_postdata');

function example_save_postdata($post_id) {

    if (!wp_verify_nonce($_POST['town_submit'], 'city')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

    $t = $_POST['city'];
	$c = $_POST['club'];
	$bt = $_POST['buyticket'];
	$bt1 = $_POST['buyticket_1'];
	$bt1r = $_POST['buyticket_1_radio'];
	$bt2 = $_POST['buyticket_2'];
	$bt3 = $_POST['buyticket_3'];
	$ct = $_POST['check_title'];
	$data_afisha = $_POST['year_afisha']."-".$_POST['month_afisha']."-".$_POST['dey_afisha'];
	$time_afisha = $_POST['hour_afisha'].":".$_POST['min_afisha'];
	$cat = get_the_category();
	$cat_parent = $cat[0]->category_parent;
	if ($cat[0]->term_id==4 || $cat[0]->term_id==2872 || $cat_parent==2872){
		update_post_meta($post_id, 'city', $t);
		update_post_meta($post_id, 'club', $c);
		update_post_meta($post_id, 'group_afisha', $_POST['group_afisha']);
		update_post_meta($post_id, 'tc_event', $_POST['tc_event']);
		update_post_meta($post_id, 'buyticket', $bt);
		update_post_meta($post_id, 'buyticket_1', $bt1);
		update_post_meta($post_id, 'buyticket_1_radio', $bt1r);
		update_post_meta($post_id, 'buyticket_2', $bt2);
		update_post_meta($post_id, 'buyticket_3', $bt3);
		update_post_meta($post_id, 'ticket_ot', $_POST['ticket_ot']);
		update_post_meta($post_id, 'data_afisha', $data_afisha);
		update_post_meta($post_id, 'time_afisha', $time_afisha);
		update_post_meta($post_id, 'check_title', $ct);
	}
}
/* Параметры для афиши и билетов конец */

/* Параметры для sounds начало */
add_action('admin_menu', 'new_sounds_add_custom_box');
function new_sounds_add_custom_box(){
		add_meta_box('select_your_sounds', // Идентификатор новой секции экрана.
		'Параметры для mrock sounds', // Заголовок виджета.
		'sounds_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function sounds_custom_box() {
	$cat = get_the_category(); // выбрать текущую категорию
	if ($cat[0]->term_id<>3029){ // скрыть, если это не раздел sounds 
		print('<style>#select_your_sounds{display:none;}</style>');
		return "";
	}
	
	global $post, $wpdb;
	$data_group = get_post_meta($post->ID,'group_afisha',true); // группа
	$data_album = get_post_meta($post->ID,'album',true); // альбом
	$data_genre = get_post_meta($post->ID,'genre',true); // альбом
	$data_afisha = get_post_meta($post->ID,'data_afisha',true);
	$data_player = get_post_meta($post->ID,'code_player',true);
	$data_grad = get_post_meta($post->ID,'grad',true);
	
	$tmp_post=$post;
	print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('active_post').'" />';
	print '<label for="group_afisha">Группа:</label>';
	print '<select name="group_afisha" id="group_afisha" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_group == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
		
	wp_reset_postdata();
		
	$data_afisha=explode('-',$data_afisha);
	if ($data_afisha[0]=="") $data_afisha[0]=date('Y');
	if ($data_afisha[1]=="") $data_afisha[1]=date('m');
	if ($data_afisha[2]=="") $data_afisha[2]=date('d');
	
	print '<br/><br/>';
	print '<label for="data_album">Альбом:</label>';
	print '<input type="text" name="data_album" value="'.$data_album.'" style="width:100%;">';
	
	print '<br/><br/>';
	print '<label for="data_genre">Жанро-теги: <span style="font-size:11px;">(вводить через запятую)</span></label>';
	print '<input type="text" name="data_genre" value="'.$data_genre.'" style="width:100%;">';
	print '<br/><br/>';
	print '<label for="data_grad">Градиент: <span style="font-size:11px;">(Пример: #000000,#ffffff)</span></label>';
	print '<input type="text" name="data_grad" value="'.$data_grad.'" style="width:100%;">';
	
	print '<br/><br/>';
	print '<b>Дата</b><br/>';
	print '<input type="text" name="dey_afisha" value="'.$data_afisha[2].'" size="2" maxlength="2">';
	print '<select name="month_afisha" id="month_afisha">';
	print '<option value="01"'.sel_month('01',$data_afisha[1]).'>Января</option>';
	print '<option value="02"'.sel_month('02',$data_afisha[1]).'>Февраля</option>';
	print '<option value="03"'.sel_month('03',$data_afisha[1]).'>Марта</option>';
	print '<option value="04"'.sel_month('04',$data_afisha[1]).'>Апреля</option>';
	print '<option value="05"'.sel_month('05',$data_afisha[1]).'>Мая</option>';
	print '<option value="06"'.sel_month('06',$data_afisha[1]).'>Июня</option>';
	print '<option value="07"'.sel_month('07',$data_afisha[1]).'>Июля</option>';
	print '<option value="08"'.sel_month('08',$data_afisha[1]).'>Августа</option>';
	print '<option value="09"'.sel_month('09',$data_afisha[1]).'>Сентября</option>';
	print '<option value="10"'.sel_month('10',$data_afisha[1]).'>Октября</option>';
	print '<option value="11"'.sel_month('11',$data_afisha[1]).'>Ноября</option>';
	print '<option value="12"'.sel_month('12',$data_afisha[1]).'>Декабря</option>';
	print "</select>";		
	print '<input type="text" name="year_afisha" value="'.$data_afisha[0].'" size="4" maxlength="4">';
	print '<label for="year_afisha">г.</label>';
	print '<br/><br/>';
	print '<label for="code_player">Код плеера: <span style="font-size:11px;">(linkcol=068db6, width: 100%)</label></b><br/>';
	print '<textarea name="code_player" id="code_player" style="width:100%; height:50px; font-size:11px;">'.$data_player.'</textarea>';
	
	wp_reset_postdata();
	$post=$tmp_post;
}

add_action('save_post', 'active_sounds_postdata');

function active_sounds_postdata($post_id){
	if (!wp_verify_nonce($_POST['town_submit'], 'active_post')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	
	$data_afisha = $_POST['year_afisha']."-".$_POST['month_afisha']."-".$_POST['dey_afisha'];
	$time_afisha = $_POST['hour_afisha'].":".$_POST['min_afisha'];
	$cat = get_the_category(); // текущая категория
	
	if ($cat[0]->term_id==3029){
		update_post_meta($post_id, 'group_afisha', $_POST['group_afisha']);
		update_post_meta($post_id, 'album', $_POST['data_album']);
		update_post_meta($post_id, 'genre', $_POST['data_genre']);
		update_post_meta($post_id, 'grad', $_POST['data_grad']);
		update_post_meta($post_id, 'data_afisha', $data_afisha);
		update_post_meta($post_id, 'code_player', $_POST['code_player']);
	}
}
/* Параметры для sounds конец */

/* Параметры для leaks начало */
add_action('admin_menu', 'leaks_add_custom_box');
function leaks_add_custom_box(){
		add_meta_box('select_your_leaks', // Идентификатор новой секции экрана.
		'Параметры для leaks', // Заголовок виджета.
		'leaks_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function leaks_custom_box() {
	$cat = get_the_category(); // выбрать текущую категорию
	$cat_parent = $cat[0]->category_parent;
	
	if ($cat[0]->term_id<>3030 && $cat_parent<>3030){ // скрыть, если это не раздел sounds 
		print('<style>#select_your_leaks{display:none;}</style>');
		return "";
	}
	
	global $post, $wpdb;
	$data_group = get_post_meta($post->ID,'group_afisha',true); // группа
	$data_album = get_post_meta($post->ID,'album',true); // альбом
	$data_leaks = get_post_meta($post->ID,'data_leaks',true);
	$data_ngroup = get_post_meta($post->ID,'data_ngroup',true); // Непривязанная группа
	
	$tmp_post=$post;
	
	$ct = get_post_meta($post->ID,'act_album',true);
	if ($ct=='1'){$ctp='checked="checked"';}
	else{$ctp='';}
	$act_album = get_post_meta($post->ID,'act_album',true);
	echo '
		<label><input type="checkbox" name="act_album" id="act_album" '.$ctp.' value="1" />В главный альбом</label>
		<br/><br/>
	';
	print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('active_post').'" />';
	print '<label for="group_afisha">Группа:</label>';
	print '<select name="group_afisha" id="group_afisha" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_group == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
		
	wp_reset_postdata();
		
	$data_leaks=explode('-',$data_leaks);
	if ($data_leaks[0]=="") $data_leaks[0]=date('Y');
	print '<br/><br/>';
	print '<label for="data_album">Непривязанная группа:</label>';
	print '<input type="text" name="data_ngroup" value="'.$data_ngroup.'" style="width:100%;">';
	print '<br/><br/>';
	print '<label for="data_album">Альбом:</label>';
	print '<input type="text" name="data_album" value="'.$data_album.'" style="width:100%;">';
	print '<br/><br/>';
	print '<input type="text" name="data_leaks" value="'.$data_leaks[0].'" size="4" maxlength="4"> Год';
	print '<br/><br/>';

	wp_reset_postdata();
	$post=$tmp_post;
}

add_action('save_post', 'active_leaks_postdata');

function active_leaks_postdata($post_id){
	if (!wp_verify_nonce($_POST['town_submit'], 'active_post')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	$cat = get_the_category(); // текущая категория
	$cat_parent = $cat[0]->category_parent;
	
	if ($cat[0]->term_id==3030 || $cat_parent==3030){
		update_post_meta($post_id, 'group_afisha', $_POST['group_afisha']);
		update_post_meta($post_id, 'album', $_POST['data_album']);
		update_post_meta($post_id, 'data_leaks', $_POST['data_leaks']);
		update_post_meta($post_id, 'act_album', $_POST['act_album']);
		update_post_meta($post_id, 'data_ngroup', $_POST['data_ngroup']);
	}
}
/* Параметры для leaks конец */

/*Параметры для постов начало*/
add_action('admin_menu', 'new_active_post_add_custom_box');
function new_active_post_add_custom_box(){
		add_meta_box('select_your_active_post', // Идентификатор новой секции экрана.
		'Параметра для постов', // Заголовок виджета.
		'active_post_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function active_post_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>6 && $cat[0]->category_parent<>6){
		print('<style>#select_your_active_post{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
    $data = get_post_meta($post->ID,'active_post',true);
	$ratings_average = get_post_meta($post->ID,'ratings_average',true);
	if ($data=='true'){
		$tmp_data="true";
		$tmp_check='checked="checked"';
	}
	else{
		$tmp_data="false";
		$tmp_check='';
	}
	
	$mini_img = get_post_meta($post->ID,'mini_img',true);
	$mheck='checked="checked"';
	
	if ($mini_img==1){
		$mheck='checked="checked"';
	}else{
		$mheck='';
	}
	
	$ra = 1;
	$ra_check = '';
	if($ratings_average == 1){
		$ra_check = 'checked="checked';
	}
	
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('active_post').'" />';
	print '<input type="checkbox" name="active_post" id="active_post" '.$tmp_check.' value="'.$tmp_data.'" onclick="if (this.checked) this.value=\'true\'; else this.value=\'false\';">';
	print '<label>Показать в слайдере</label><br/><br/>';
	print '<input type="checkbox" name="mini_img" id="mini_img" '.$mheck.' value="1">';
	print '<label>НЕ показывать миниатюру</label>';
	print '<br/><br/>';
	print '<label for="news_group">Формат для постов:</label><br/>';
	print '<label><input type="checkbox" name="ratings_average" id="ratings_average" '.$ra_check.' value="'.$ra.'"> маленькая</label>';
}

add_action('save_post', 'active_post_save_postdata');

function active_post_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'active_post')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	if ($_POST['active_post']=='true'){
		$t = 'true';
	}
	else{
		$t = 'false';
	}
	$cat = get_the_category();
	if ($cat[0]->term_id==6 || $cat[0]->category_parent==6){
		update_post_meta($post_id, 'active_post', $t);
		update_post_meta($post_id, 'mini_img', $_POST['mini_img']);
		update_post_meta($post_id, 'ratings_average', $_POST['ratings_average']);
	}
}
/*Параметры для постов конец*/

/*Параметра для конкурсов начало*/
add_action('admin_menu', 'new_active_kon_add_custom_box');
function new_active_kon_add_custom_box(){
		add_meta_box('select_your_active_kon', // Идентификатор новой секции экрана.
		'Параметры для конкурса', // Заголовок виджета.
		'active_kon_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function active_kon_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>8){
		print('<style>#select_your_active_kon{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
    $data = get_post_meta($post->ID,'active_contest',true);
	$type_contest = get_post_meta($post->ID,'type_contest',true);
	if ($data=='true'){
		$tmp_data="true";
		$tmp_check='checked="checked"';
	}
	else{
		$tmp_data="false";
		$tmp_check='';
	}
	print '
		<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('active_contest').'" />
		<input type="checkbox" name="active_contest" id="active_contest" '.$tmp_check.' value="'.$tmp_data.'" onclick="if (this.checked) this.value=\'true\'; else this.value=\'false\';">
		<label for="active_contest"> Активный конкурс</label><br/>
		<label for="type_contest">Иконка <span style="font-size:11px">(0 = диск, 1 = билет)</span>:</label>
		<input type="text" name="type_contest" value="'.$type_contest.'" style="width: 200px;">
		';
}

add_action('save_post', 'active_kon_save_postdata');

function active_kon_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'active_contest')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	if ($_POST['active_contest']=='true'){
		$t = 'true';
	}
	else{
		$t = 'false';
	}
	$cat = get_the_category();
	if ($cat[0]->term_id==8){
		update_post_meta($post_id, 'type_contest', $_POST['type_contest']);
		update_post_meta($post_id, 'active_contest', $t);
	}
}
/*Параметра для конкурсов конец*/

/*Параметры для Клубов начало*/
add_action('admin_menu', 'new_club_city_add_custom_box');
function new_club_city_add_custom_box(){
		add_meta_box('select_your_new_club_city', // Идентификатор новой секции экрана.
		'Параметры для клуба', // Заголовок виджета.
		'new_club_city_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function new_club_city_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>13){
		print('<style>#select_your_new_club_city{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
    $data = get_post_meta($post->ID,'city',true);

    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('city').'" />';
	print '<label for="city">Город: </label>';
    print '<select name="city" id="city" style="width:210px;">';
 
	$querystr = "SELECT distinct(title) FROM `city`";
	$towns = $wpdb->get_results($querystr);
	print '<option value="">Не выбран</option>';
    foreach ($towns as $town) {
        echo '<option value="'.$town->title.'"';
        if ($data == $town->title) echo ' selected="selected"';
        echo '>'.$town->title.'</option>';
    }
 
    print "</select>";
	wp_reset_postdata();
	print '<br/>';
	print '<label>Адрес:</label> <input type="text" name="adr" id="adr" value="'.get_post_meta($post->ID,'address',true).'" style="width:210px;">';
	print '<br/>';
	print '<label>Телефон:</label> <input type="text" name="phone" id="phone" value="'.get_post_meta($post->ID,'phone',true).'" style="width:190px;">';
}

add_action('save_post', 'new_club_city_save_postdata');

function new_club_city_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'city')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$cat = get_the_category();
	if ($cat[0]->term_id==13){
		update_post_meta($post_id, 'city', $_POST['city']);
		update_post_meta($post_id, 'address', $_POST['adr']);
		update_post_meta($post_id, 'phone', $_POST['phone']);
	}
}
/*Параметры для Клубов конец*/

/*Параметры для Групп начало*/
add_action('admin_menu', 'new_name_group_add_custom_box');
function new_name_group_add_custom_box(){
		add_meta_box('select_your_new_name_group', // Идентификатор новой секции экрана.
		'Параметры для групп', // Заголовок виджета.
		'new_name_group_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function new_name_group_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>12){
		print('<style>#select_your_new_name_group{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
    $data = get_post_meta($post->ID,'new_name_group',true);
	if ($data=='true'){
		$tmp_data="true";
		$tmp_check='checked="checked"';
	}
	else{
		$tmp_data="false";
		$tmp_check='';
	}
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('new_name_group').'" />';
	print '<input type="checkbox" name="new_name_group" id="new_name_group" '.$tmp_check.' value="'.$tmp_data.'" onclick="if (this.checked) this.value=\'true\'; else this.value=\'false\';">';
	print '<label> Показать в новых именах</label>';
	print '<br/><br/>';
	print '<label>Страна:</label> <input type="text" name="met_country" id="met_country" value="'.get_post_meta($post->ID,'country',true).'">';
	print '<br/><br/>';
	print '<label>Рекламный баннер футболок</label><br/>';
	print '<label>Ссылка:</label><br/><input type="text" name="gr_banner1" id="gr_banner1" value="'.get_post_meta($post->ID,'gr_banner1',true).'" style="width:100%;" placeholder="http://адрес сайта">';
	print '<br/><br/>';
	print '<label>Рекламный баннер второй</label><br/>';
	print '<label>Ссылка:</label><br/><input type="text" name="gr_banner2" id="gr_banner2" value="'.get_post_meta($post->ID,'gr_banner2',true).'" style="width:100%;" placeholder="http://адрес сайта">';
}

add_action('save_post', 'new_name_group_save_postdata');

function new_name_group_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'new_name_group')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	if ($_POST['new_name_group']=='true'){
		$t = 'true';
	}
	else{
		$t = 'false';
	}
	$cat = get_the_category();
	if ($cat[0]->term_id==12){
		update_post_meta($post_id, 'new_name_group', $t);
		update_post_meta($post_id, 'country', $_POST['met_country']);
		update_post_meta($post_id, 'gr_banner1', $_POST['gr_banner1']);
		update_post_meta($post_id, 'gr_banner2', $_POST['gr_banner2']);
	}
}
/*Параметры для Групп конец*/

/*Параметра для видео начало*/
add_action('admin_menu', 'new_video_add_custom_box');
function new_video_add_custom_box(){
		add_meta_box('select_your_video', // Идентификатор новой секции экрана.
		'Параметры для видео', // Заголовок виджета.
		'video_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function video_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>7 && $cat[0]->category_parent<>7){
		print('<style>#select_your_video{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
	$data_group = get_post_meta($post->ID,'video_group',true);
	
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('video_group').'" />';
	
	$tmp_post=$post;
	
	print '<label>Группа: </label>';
	print '<select name="video_group" id="video_group" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_group == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
	wp_reset_postdata();
	$post=$tmp_post;	
}

add_action('save_post', 'video_save_postdata');

function video_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'video_group')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$cat = get_the_category();
	if ($cat[0]->term_id==7 || $cat[0]->category_parent==7){
		update_post_meta($post_id, 'video_group', $_POST['video_group']);
	}
}
/*Параметра для видео конец*/

/*Параметра для интервью начало*/
add_action('admin_menu', 'new_interview_add_custom_box');
function new_interview_add_custom_box(){
		add_meta_box('select_your_interview', // Идентификатор новой секции экрана.
		'Параметры для интервью', // Заголовок виджета.
		'interview_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function interview_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>10){
		print('<style>#select_your_interview{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
	$data_group = get_post_meta($post->ID,'interview_group',true);
	$data_quote = get_post_meta($post->ID,'quote',true);
	$ratings_average = get_post_meta($post->ID,'ratings_average',true);
	$ra = 1;
	$ra_check = '';
	if($ratings_average == 1){
		$ra = 1;
		$ra_check = 'checked="checked';
	}
	
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('interview_group').'" />';
	
	$tmp_post=$post;
	
	print '<label>Группа: </label>';
	print '<select name="interview_group" id="interview_group" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_group == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
	
	print '<br/><br/>';
	print '<label>Цитата:</label><br/><textarea name="quote" id="quote" style="width: 257px;height: 88px;">'.$data_quote.'</textarea>';
	print '<br/><br/>';
	print '<label for="news_group">Формат интервью:</label><br/>';
	print '<label><input type="checkbox" name="ratings_average" id="ratings_average" '.$ra_check.' value="'.$ra.'"> маленькая</label>';
	
	wp_reset_postdata();
	$post=$tmp_post;	
}

add_action('save_post', 'interview_save_postdata');

function interview_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'interview_group')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$cat = get_the_category();
	if ($cat[0]->term_id==10){
		update_post_meta($post_id, 'quote', $_POST['quote']);
		update_post_meta($post_id, 'interview_group', $_POST['interview_group']);
		update_post_meta($post_id, 'ratings_average', $_POST['ratings_average']);
	}
}
/*Параметра для интервью конец*/

/*Параметра для рецензий начало*/
add_action('admin_menu', 'new_notices_add_custom_box');
function new_notices_add_custom_box(){
		add_meta_box('select_your_notices', // Идентификатор новой секции экрана.
		'Параметры для рецензий', // Заголовок виджета.
		'notices_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function notices_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>9){
		print('<style>#select_your_notices{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
    $data_year = get_post_meta($post->ID,'year',true);
	$data_group = get_post_meta($post->ID,'notices_group',true);
	$data_album = get_post_meta($post->ID,'album',true);
	$data_rating = get_post_meta($post->ID,'rating',true);
	$ratings_average = get_post_meta($post->ID,'ratings_average',true);
	$ra = 1;
	$ra_check = '';
	if($ratings_average == 1){
		$ra = 1;
		$ra_check = 'checked="checked';
	}
	
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('notices_group').'" />';
	
	$tmp_post=$post;
	
	print '<label>Группа: </label>';
	print '<select name="notices_group" id="notices_group" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_group == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
	
	print '<br/><br/>';
	print '<label>Альбом:</label> <input type="text" name="album" id="album" value="'.$data_album.'">';
	print '<br/><br/>';
	print '<label>Год:</label> <input type="text" name="year" id="year" value="'.$data_year.'">';
	print '<br/><br/>';
	print '<label>Рейтинг:</label> <input type="text" name="rating" id="rating" value="'.$data_rating.'">';
	print '<br/><br/>';
	print '<label for="news_group">Формат рецензии:</label><br/>';
	print '<label><input type="checkbox" name="ratings_average" id="ratings_average" '.$ra_check.' value="'.$ra.'"> маленькая</label>';
	wp_reset_postdata();
	$post=$tmp_post;	
}

add_action('save_post', 'notices_save_postdata');

function notices_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'notices_group')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$cat = get_the_category();
	if ($cat[0]->term_id==9){
		update_post_meta($post_id, 'year', $_POST['year']);
		update_post_meta($post_id, 'album', $_POST['album']);
		update_post_meta($post_id, 'notices_group', $_POST['notices_group']);
		update_post_meta($post_id, 'rating', $_POST['rating']);
		update_post_meta($post_id, 'ratings_average', $_POST['ratings_average']);
	}
}
/*Параметра для рецензий конец*/

/*Параметра для репортажей начало*/
add_action('admin_menu', 'new_reports_add_custom_box');
function new_reports_add_custom_box(){
		add_meta_box('select_your_reports', // Идентификатор новой секции экрана.
		'Параметры для репортажа', // Заголовок виджета.
		'reports_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function reports_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>5){
		print('<style>#select_your_reports{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
    $data_club = get_post_meta($post->ID,'club',true);
	$data_group = get_post_meta($post->ID,'reports_group',true);
	$data_artist = get_post_meta($post->ID,'artist',true);
	$ratings_average = get_post_meta($post->ID,'ratings_average',true);
	$ra = 1;
	$ra_check = '';
	if($ratings_average == 1){
		$ra = 1;
		$ra_check = 'checked="checked';
	}
	
	
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('club').'" />';
	
	$tmp_post=$post;
	
	print '<label>Клуб: </label>';
	print '<select name="club" id="club" style="width:210px;">';
	print '<option value="0">Не выбран</option>';
	$r = new WP_Query('cat=13&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_club == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
	
	print '<br/><br/>';
	print '<label>Группа: </label>';
	print '<select name="reports_group" id="reports_group" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		echo '<option value="'.$tmp_title.'"';
		if ($data_group == $tmp_title) echo ' selected="selected"';
		echo '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
	
	print '<br/><br/>';
	print '<label>Артист:</label> <input type="text" name="artist" id="artist" value="'.$data_artist.'">';
	print '<br/><br/>';
	print '<label for="news_group">Формат репортажа:</label><br/>';
	print '<label><input type="checkbox" name="ratings_average" id="ratings_average" '.$ra_check.' value="'.$ra.'"> маленькая</label>';

	wp_reset_postdata();
	$post=$tmp_post;	
}

add_action('save_post', 'reports_save_postdata');

function reports_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'club')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$cat = get_the_category();
	if ($cat[0]->term_id==5){
		update_post_meta($post_id, 'club', $_POST['club']);
		update_post_meta($post_id, 'artist', $_POST['artist']);
		update_post_meta($post_id, 'reports_group', $_POST['reports_group']);
		update_post_meta($post_id, 'ratings_average', $_POST['ratings_average']);
	}
}
/*Параметра для репортажей конец*/

/*Параметры для Новостей начало*/
add_action('admin_menu', 'news_add_custom_box');
function news_add_custom_box(){
		add_meta_box('select_your_news', // Идентификатор новой секции экрана.
		'Параметры для новостей', // Заголовок виджета.
		'news_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function news_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>3){
		print('<style>#select_your_news{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('news_group').'" />';
	$data=get_post_meta($post->ID,'news_group',true);
	$data_main = get_post_meta($post->ID,'main',true);
	$ratings_average = get_post_meta($post->ID,'ratings_average',true);
	$tmp_post=$post;
	print '<label for="news_group">Группа: </label>';
	print '<select name="news_group" id="news_group" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		print '<option value="'.$tmp_title.'"';
		if ($data==$tmp_title) print ' selected="selected"';
		print '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
	
	$ra = 1;
	$ra_check = '';
	if($ratings_average == 1){
		$ra = 1;
		$ra_check = 'checked="checked';
	}
	
	if ($data_main=='true'){
		$tmp_data="true";
		$tmp_check='checked="checked"';
	}
	else{
		$tmp_data="false";
		$tmp_check='';
	}
	print '<br/><br/>';
	print '<input type="checkbox" name="main" id="main" '.$tmp_check.' value="'.$tmp_data.'" onclick="if (this.checked) this.value=\'true\'; else this.value=\'false\';">';
	print '<label> Закрепить</label>';
	print '<br/><br/>';
	print '<label for="news_group">Формат новости:</label><br/>';
	print '<label><input type="checkbox" name="ratings_average" id="ratings_average" '.$ra_check.' value="'.$ra.'"> маленькая</label>';
	
	wp_reset_postdata();
	$post=$tmp_post;
}

add_action('save_post', 'news_save_postdata');

function news_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'news_group')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$cat = get_the_category();
	if ($cat[0]->term_id==3){
		update_post_meta($post_id, 'news_group', $_POST['news_group']);
		update_post_meta($post_id, 'main', $_POST['main']);
		update_post_meta($post_id, 'ratings_average', $_POST['ratings_average']);
	}
}
/*Параметры для Новостей конец*/

/*Параметры для Дискографии начало*/
add_action('admin_menu', 'disko_add_custom_box');
function disko_add_custom_box(){
		add_meta_box('select_your_disko', // Идентификатор новой секции экрана.
		'Параметры для дискографии', // Заголовок виджета.
		'disko_custom_box', // Callback: см. функцию ниже.
		'post', // Тип записи.
		'side', // Положение: правый бок.
		'high'); // Приоритет показа.
}

function disko_custom_box() {

	$cat = get_the_category();
	if ($cat[0]->term_id<>24){
		print('<style>#select_your_disko{display:none;}</style>');
		return "";
	}
	
    global $post, $wpdb;
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('group').'" />';
	
	
	$data=get_post_meta($post->ID,'group',true);
	$data_year=get_post_meta($post->ID,'year',true);
	$data_url=get_post_meta($post->ID,'url_partner',true);
	
	
	$tmp_post=$post;
	print '<label for="group">Группа: </label>';
	print '<select name="group" id="group" style="width:210px;">';
	print '<option value="0">Не выбрана</option>';
	$r = new WP_Query('cat=12&showposts=10000&orderby=title&order=ASC');
	while ($r->have_posts()) : $r->the_post();
		$tmp_title=mysql_real_escape_string(get_the_title());
		print '<option value="'.$tmp_title.'"';
		if ($data==$tmp_title) print ' selected="selected"';
		print '>'.$tmp_title.'</option>';
	endwhile;		
	print "</select>";
	
	print '<br/><br/>';
	print '<label>Год:</label> <input type="text" name="year" id="year" value="'.$data_year.'">';
	print '<br/><br/>';
	print '<label>Купить:</label> <input type="text" name="url_partner" id="url_partner" value="'.$data_url.'">';
	wp_reset_postdata();
	$post=$tmp_post;
}

add_action('save_post', 'disko_save_postdata');

function disko_save_postdata($post_id){
    if (!wp_verify_nonce($_POST['town_submit'], 'group')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$cat = get_the_category();
	if ($cat[0]->term_id==24){
		update_post_meta($post_id, 'group', $_POST['group']);
		update_post_meta($post_id, 'year', $_POST['year']);
		update_post_meta($post_id, 'url_partner', $_POST['url_partner']);
	}
}
/*Параметры для Дискографии конец*/

function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);
 
	if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
		$content = substr($content, 0, $espacio);
		$content = $content;
		echo $content;
	}
	else {
	  echo $content;
	}
}

function disqus_embed($disqus_shortname) {
    global $post;
    wp_enqueue_script('disqus_embed', 'http://'.$disqus_shortname.'.disqus.com/embed.js');
    echo '<div id="disqus_thread"></div>
    <script type="text/javascript">
        var disqus_shortname = "'.$disqus_shortname.'";
        var disqus_title = "'.htmlentities($post->post_title).'";
        var disqus_url = "'.get_permalink($post->ID).'";
        var disqus_identifier = "'.$disqus_shortname.'-'.$post->ID.'";
    </script>';
}

function find_id_title($title,$cat){
	//Поиск поста по названию и категории
	global $wpdb;
	$sql = "
		SELECT 
			ID
		FROM $wpdb->posts p 
			LEFT JOIN $wpdb->term_relationships rel ON (p.ID = rel.object_id) 
			LEFT JOIN $wpdb->term_taxonomy tax ON (rel.term_taxonomy_id = tax.term_taxonomy_id)
		where
			tax.term_id = '13' 
			AND tax.taxonomy = 'category' 
			AND p.post_status = 'publish' 
			AND p.post_type = 'post'
			AND p.post_title='".mysql_real_escape_string($title)."'
	";
	$res = $wpdb->get_results($sql);
	wp_reset_postdata();
	return $res[0]->ID;
}

/*
function playlist(){
	$images = glob($_SERVER['DOCUMENT_ROOT']."/music/*", GLOB_NOSORT);
	//$images=array_rand($images,2);
	foreach($images as $value){
		$data[] = array(
			'title' => (string) basename($value,'.mp3'),
			'mp3'   => (string) 'http://'.$_SERVER['SERVER_NAME'].'/music/'.basename($value),
		);
	}
	$jsdata = json_encode($data);
	r
	eturn htmlspecialchars($jsdata, ENT_NOQUOTES, 'utf-8');
}
*/


/* add sasha-freez optimisation header for site */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3 );
remove_action('wp_head', 'feed_links', 2 );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );


add_filter( 'get_shortlink', function( $shortlink ) {return $shortlink;} );


add_filter( 'wp_title', 'title_seo'); // title page

function title_seo($title){// title page
	global $post, $wpdb;
	$cat = get_the_category();
	$cat_parent = $cat[0]->category_parent;
	$serv = $_SERVER['REQUEST_URI'];
	$section=explode('/', $serv); //$section[1]
	$page=explode('page/', $serv); //$page[1]
	
	//print_r($section);
	//$a=explode('-', $row[st_date]);
	//old $title = 'Концерты '.htmlentities($post->post_title).' в '.date('Y').'/'.date('Y', strtotime('+1 year')).' году – купить билеты';
	
	if($section[1]=='groups'){ // title для детальной страницы группы
		if(!$page[1]){
			$title = ''.htmlentities($post->post_title).' - концерты в '.date('Y').'/'.date('Y', strtotime('+1 year')).' году купить билеты';	
		}else{
			$title = 'Группы – Страница '.$page[1].'';
		}
	}
	if($section[2]=='russkaya-scena'){
		$title = 'Родные – современные русские группы';
	}
	
	if($section[1]=='gigs'){ // title для детальной страницы старой афиши
		if(!$page[1]){
			$club = get_post_meta(get_the_ID(), 'club', true);
			$title = 'Афиша группы '.htmlentities($post->post_title).' в '.$club.' '.date('d').'.'.date('m').'.'.date('Y').'';
		}else{
			$title = 'Группы – Страница '.$page[1].'';
		}
	}
	if($section[1]=='leaks'){ // title для страниц leaks
		if($section[3] && !$page[1]){ // Третий уровень детальная страница
			$gr = get_post_meta(get_the_ID(), 'data_ngroup', true);
			if(!$gr) {$gr = get_post_meta(get_the_ID(), 'group_afisha', true);}
			
			$album = get_post_meta(get_the_ID(), 'album', true);
			$year = get_post_meta(get_the_ID(), 'data_leaks', true);
			
			$title = ''.$gr.' — '.$album.' ('.$year.') слушать онлайн бесплатно';
			
		}else if($section[2] && !$page[1] || ($section[4] && $page[1])){ // второй уровень жанры
			$title = 'Новинки '.mb_strtolower($cat[0]->cat_name).' музыки '.date('Y').' - слушать онлайн бесплатно';
		}else{ // корневая
			$title = 'Слушать новинки музыки '.date('Y').' онлайн бесплатно, новые альбомы и песни '.date('Y').'';
		}
		if($page[1]) $title.=' - cтраница №'.$page[1].'';
	}
	
	if($section[1]=='club'){ // title для страниц club
		if(!$section[2] && !$page[2]){
			$title = 'Расписание концертов в клубах, афиша концертов и билеты';	
		}else if(!$page[1]){ // детальная
			$title = ''.htmlentities($post->post_title).' - афиша концертов на '.date('Y').'/'.date('Y', strtotime('+1 year')).' и билеты';	
		}else{ // страница пагинации
			$title = 'Расписание концертов в клубах, афиша концертов и билеты страница '.$page[1].'';
		}
	}
	/*
	if($section[1]=='tickets'){ // title для страниц tickets
		if($section[3] && !$page[1]){ // Третий уровень детальная страница
			$gr = get_post_meta(get_the_ID(), 'data_ngroup', true);
			if(!$gr) {$gr = get_post_meta(get_the_ID(), 'group_afisha', true);}
			
			$album = get_post_meta(get_the_ID(), 'album', true);
			$year = get_post_meta(get_the_ID(), 'data_leaks', true);
			
			$title = ''.$gr.' — '.$album.' ('.$year.') слушать онлайн бесплатно';
			
		}else if($section[2] && !$page[1] || ($section[4] && $page[1])){ // второй уровень жанры
			$title = 'Новинки '.mb_strtolower($cat[0]->cat_name).' музыки '.date('Y').' - слушать онлайн бесплатно';
		}else{ // корневая
			$title = 'Слушать новинки музыки '.date('Y').' онлайн бесплатно, новые альбомы и песни '.date('Y').'';
		}
		if($page[1]) $title.=' - cтраница №'.$page[1].'';
	}
	*/
	
	
	return $title;
}

add_action("wp_head", "meta_tags", 1); // meta tags seo

/* meta description */
function meta_tags() {
	global $post;
	$cat = get_the_category();
	$serv = $_SERVER['REQUEST_URI'];
	$section=explode('/', $serv); //$section[1]
	$page=explode('page/', $serv); //$page[1]
	$postmeta=get_post_custom($post->ID); // собрать данные о посте
	
	
	if($section[1]=='groups'){ // meta для детальной страницы группы
		if(!$page[1]){
			if($postmeta["_aioseop_description"][0]){
				$desc = $postmeta["_aioseop_description"][0];
			}else{
				$desc = 'Билеты на концерты группы '.htmlentities($post->post_title).' в '.date('Y').'/'.date('Y', strtotime('+1 year')).' году в Москве, Санкт-Петербурге и других городах России.';
			}
			echo '<meta name="description" content="'.$desc.'"/>';	
		}else{
			echo '<meta name="description" content="Группы – Страница '.$page[1].'"/>';
		}
		echo '
<meta name="keywords" content="'.htmlentities($post->post_title).',купить билет '.$postmeta["_aioseop_keywords"][0].'" />
';
	}
	
	if($section[1]=='gigs'){ // title для детальной страницы старой афиши
		if(!$page[1]){
			$club = get_post_meta(get_the_ID(), 'club', true);
			echo '<meta name="description" content="'.htmlentities($post->post_title).' — афиша ближайших концертов и билеты по официальным ценам в '.$club.'"/>';	
		}else{
			echo '<meta name="description" content="Афиша – Страница '.$page[1].'"/>';
		}
		echo '
<meta name="keywords" content="'.$postmeta["club"].'" />
';
	}
	
	if($section[1]=='leaks'){ // meta для страниц leaks
		$title='';
		if($section[3] && !$page[1]){ // Третий уровень детальная страница
			$gr = get_post_meta(get_the_ID(), 'data_ngroup', true);
			if(!$gr) {$gr = get_post_meta(get_the_ID(), 'group_afisha', true);}
			
			$album = get_post_meta(get_the_ID(), 'album', true);
			$year = get_post_meta(get_the_ID(), 'data_leaks', true);
			
			$title =''.$gr.' — '.$album.' ('.$year.') слушать онлайн бесплатно на музыкальном портале modernrock.ru';
			
		}else if($section[2] && !$page[1] || ($section[4] && $page[1])){ // второй уровень жанры
			$title = 'Новинки '.mb_strtolower($cat[0]->cat_name).' музыки '.date('Y').' - слушать онлайн бесплатно на музыкальном портале modernrock.ru';
		}else{ // корневая
			$title = 'Слушать новинки музыки '.date('Y').' онлайн бесплатно, новые альбомы и песни '.date('Y').' на музыкальном портале modernrock.ru';
		}
		if($page[1]) $title.='. Cтраница №'.$page[1].'';
		
		echo '
		<meta name="description" content="'.$title.'"/>
		<meta name="keywords" content="'.$postmeta["_aioseop_keywords"][0].'" />
		';
	}
	
	if($section[1]=='club'){ // meta для страниц club
		if(!$section[2] && !$page[2]){
			$title = 'Билеты на концерты в клубы по официальным ценам в Москве, афиша концертов';	
		}else if(!$page[1]){ // детальная
			$title = 'Полное расписание событий в '.htmlentities($post->post_title).'';	
		}else{ // страница пагинации
			$title = 'Билеты на концерты в клубы по официальным ценам в Москве, афиша концертов, страница '.$page[1].'';
		}
		echo '
		<meta name="description" content="'.$title.'"/>
		<meta name="keywords" content="'.$postmeta["_aioseop_keywords"][0].'" />
		';
		
	}
	
	
}


/* отключение превью картинок для вордпресса */
function true_remove_default_image_sizes( $sizes ) {
	unset( $sizes['thumbnail']); // отключаем миниатюры
	unset( $sizes['medium']); // отключаем средний размер
	unset( $sizes['large']); // отключаем крупный размер
	// если вы не хотите отключать всё, можете закомментировать 1-2 строчки
	return $sizes;
}
 
add_filter('intermediate_image_sizes_advanced', 'true_remove_default_image_sizes');


/* Удаление всех редакций
global $wpdb;
$wpdb->query(
	"
	DELETE a,b,c FROM $wpdb->posts a  
	LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id)  
	LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id)  
	WHERE a.post_type = 'revision'
	"
);
 */
?>