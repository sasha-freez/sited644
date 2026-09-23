<?php
date_default_timezone_set("Europe/Moscow");

/** Read a scalar search parameter without treating it as HTML or SQL. */
function modernrock_search_term($key) {
    return isset($_GET[$key]) && is_string($_GET[$key])
        ? sanitize_text_field(wp_unslash($_GET[$key])) : '';
}

/** Keep the last successful API response during a short upstream outage. */
function modernrock_concerts_response($cache_key, $response, $ttl, $fallback) {
    $data = !is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200
        ? json_decode(wp_remote_retrieve_body($response), true) : null;
    if (is_array($data) && isset($data['concerts']) && is_array($data['concerts'])) {
        set_transient($cache_key, $data, $ttl);
        set_transient($cache_key . '_last_good', $data, 7 * DAY_IN_SECONDS);
        return $data;
    }
    $last_good = get_transient($cache_key . '_last_good');
    $data = is_array($last_good) && isset($last_good['concerts']) && is_array($last_good['concerts'])
        ? $last_good : $fallback;
    set_transient($cache_key, $data, MINUTE_IN_SECONDS);
    return $data;
}


add_action('wp_dashboard_setup', 'add_new_dashboard_widget' );
add_action( 'login_enqueue_scripts', 'login_enqueue_scripts' );//Кастомная форма входа с полноразмерным фоном
add_filter('admin_footer_text', 'remove_footer_admin');//Сменить надпись в подвале консоли WordPress
add_filter( 'login_headerurl', create_function('', 'return get_home_url();') );/* Ставим ссылку с логотипа на сайт, а не на wordpress.org */

/**
 * Restrict the potential slow query in the meta_form() to the current post ID.
 *
 * @see http://wordpress.stackexchange.com/a/187712/26350
 */

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


/* проверка на пользователя */
if (get_current_user_id()>0){
	wp_enqueue_style('admin', get_template_directory_uri().'/admin.css');//Подключаем css для админки
	
	add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );//Удалить элементы меню в левой панели админки WP
	//add_filter('screen_options_show_screen', 'remove_screen_options');//Удаление кнопки «Настройки экрана» с помощью хука
	add_action('wp_dashboard_setup', 'my_remove_dashboard_widgets' );// Удаление лишних виджетов из консоли WordPress
}


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
	
/* Удаляем виджеты из dashboard */
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
<p>Музыкальный портал modernrock.ru официально открылся 7 июля 2007 года. За 11 лет своего существования приоритетом для нашей команды стали новости музыки, обзоры и фотоотчеты с концертов, интервью с музыкантами и рецензии на релизы, которые современные рок группы в последнее время представляют публике с завидным постоянством. Нынешнее время для исполнителей – это время перемен, поэтому музыкальные новости, которые публикуются на нашем ресурсе, отражают не только жизнь артистов, но и все изменения и перемены в мире рок музыки. Современный рок – это уже новый этап развития этого жанра, поэтому новости рок музыки, публикуемые на нашем портале, представляют собой актуальное отражение всего того, что происходит на западной и отечественной музыкальных рок сценах. Современный зарубежный рок развивается все быстрее и быстрее, а в наше время на просторах рунета практически нет сайтов, соответствующих этой узкой, но необходимой для каждого ценителя современной рок музыки тематики. Новости музыки, а также около музыкальные новости ежедневно появляются в новостной ленте modernrock.ru, название которого символично переводится с английского как «современный рок».</p>
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

/* Всё, что касается админки вынесу исполнение в админку */
if (get_current_user_id()>0){
	
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
	$ticket_promo = get_post_meta($post->ID,'ticket_promo',true);
	$ticket_pr_sale = get_post_meta($post->ID,'ticket_pr_sale',true);
	
	$tc_event = get_post_meta($post->ID,'tc_event',true);
	
	$data_buyticket_1 = get_post_meta($post->ID,'buyticket_1',true);
	$data_buyticket_1_radio = get_post_meta($post->ID,'buyticket_1_radio',true);
	$data_buyticket_2 = get_post_meta($post->ID,'buyticket_2',true);
	$data_buyticket_3 = get_post_meta($post->ID,'buyticket_3',true);
	$data_buyticket_4 = get_post_meta($post->ID,'buyticket_4',true);
	
	$db1r_1=($data_buyticket_1_radio == 'event' || empty($data_buyticket_1_radio) ? 'checked="checked"' : '');
	$db1r_2=($data_buyticket_1_radio == 'action' ? 'checked="checked"' : '');
	/* Если билеты, то можно использовать заголовок в описании */

	$auto_seo = get_post_meta($post->ID,'auto_seo',true);
	if ($auto_seo == 1){
		$auto_seo='checked="checked"';
	}
	echo '<label><input type="checkbox" name="auto_seo" id="auto_seo" '.$auto_seo.' value="1" /> <b>Не использовать АвтоСЕО</b></label><br/><br/>';
	
    $check_title = get_post_meta($post->ID,'check_title',true);
	if ($check_title=='1'){
		$check_title='checked="checked"';
	}
	
	echo '<label><input type="checkbox" name="check_title" id="check_title" '.$check_title.' value="1" /> Использовать заголовок</label><br/><br/>';
	
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
		$tmp_title=get_the_title();
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
		$tmp_title=get_the_title();
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
	
	print '<b>ConcertRU</b> <span style="font-size:11px;">ID Концерта (API)</span><br/>';
	print '<label for="buyticket"></label>';
	print '<input type="text" name="buyticket_3" value="'.$data_buyticket_3.'" style="width: 200px;">';
	print '<br/><br/>';
	
	print '<b>RedKassa</b> <span style="font-size:11px;">ID Концерта (API)</span><br/>';
	print '<label for="buyticket"></label>';
	print '<input type="text" name="buyticket_4" value="'.$data_buyticket_4.'" style="width: 200px;">';
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
	
	print '<br/><br/>';
	print '<label for="ticket_promo">Промокод:</label>';
	print '<input type="text" name="ticket_promo" value="'.$ticket_promo.'" style="width: 200px;">';
	
	print '<br/><br/>';
	print '<label for="ticket_pr_sale">Скидка по промокоду:</label>';
	print '<input type="text" name="ticket_pr_sale" value="'.$ticket_pr_sale.'" style="width: 200px;">';
	
	$data_afisha=explode('-',$data_afisha);
	if ($data_afisha[0]=="") $data_afisha[0]=date('Y');
	if ($data_afisha[1]=="") $data_afisha[1]=date('m');
	if ($data_afisha[2]=="") $data_afisha[2]=date('d');
	
	print '<br/><br/>';
	print '<b>Дата концерта</b><br/>';
	print '<input type="text" name="dey_afisha" value="'.$data_afisha[2].'" size="2" maxlength="2" style="display:inline-block; vertical-align:top;">';
	print '<select name="month_afisha" id="month_afisha" style="display:inline-block; vertical-align:top;">';
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
	print '<input type="text" name="year_afisha" value="'.$data_afisha[0].'" size="4" maxlength="4" style="display:inline-block; vertical-align:top;">';
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
	$bt4 = $_POST['buyticket_4'];
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
		update_post_meta($post_id, 'buyticket_4', $bt4);
		update_post_meta($post_id, 'ticket_ot', $_POST['ticket_ot']);
		update_post_meta($post_id, 'data_afisha', $data_afisha);
		update_post_meta($post_id, 'time_afisha', $time_afisha);
		update_post_meta($post_id, 'check_title', $ct);
		
		update_post_meta($post_id, 'ticket_promo', $_POST['ticket_promo']);
		update_post_meta($post_id, 'ticket_pr_sale', $_POST['ticket_pr_sale']);
		update_post_meta($post_id, 'auto_seo', $_POST['auto_seo']);
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
		$tmp_title=get_the_title();
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
		$tmp_title=get_the_title();
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
	
	$auto_seo = get_post_meta($post->ID,'auto_seo',true);
	if ($auto_seo == 1){
		$auto_seo='checked="checked"';
	}
	echo '<label><input type="checkbox" name="auto_seo" id="auto_seo" '.$auto_seo.' value="1" /> <b>Не использовать АвтоСЕО</b></label><br/><br/>';

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
		update_post_meta($post_id, 'auto_seo', $_POST['auto_seo']);
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
	
	$auto_seo = get_post_meta($post->ID,'auto_seo',true);
	if ($auto_seo == 1){
		$auto_seo='checked="checked"';
	}
	echo '
		<label><input type="checkbox" name="auto_seo" id="auto_seo" '.$auto_seo.' value="1" /> <b>Не использовать АвтоСЕО</b></label>
		<br/><br/>
	';
	
    print '<input type="hidden" name="town_submit" id="town_submit" value="'.wp_create_nonce('new_name_group').'" />';
	print '<input type="checkbox" name="new_name_group" id="new_name_group" '.$tmp_check.' value="'.$tmp_data.'" onclick="if (this.checked) this.value=\'true\'; else this.value=\'false\';">';
	print '<label> Показать в списке новые</label>';
	print '<br/><br/>';
	print '<label>Страна:</label> <input type="text" name="met_country" id="met_country" value="'.get_post_meta($post->ID,'country',true).'">';
	
	$genre_group = get_post_meta($post->ID,'genre_group',true);
	print '<br/><br/>';
	print '<label for="genre_group">Жанр:</label><br/>';
	print '<select name="genre_group" id="genre_group" style="width:210px;">';
	print '<option value="0">Не выбран</option>';
	$categories = get_categories('orderby=id&show_count=0&depth=1&hide_empty=0&title_li=&use_desc_for_title=1&child_of=2872');
	
	foreach($categories as $cat){
		if($genre_group == $cat->name){
			echo '<option selected="selected">'.$cat->name.'</option>';
		}else{
			echo '<option>'.$cat->name.'</option>';
		}
	}
	print "</select>";
	wp_reset_postdata();
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
		update_post_meta($post_id, 'genre_group', $_POST['genre_group']);
		update_post_meta($post_id, 'gr_banner1', $_POST['gr_banner1']);
		update_post_meta($post_id, 'gr_banner2', $_POST['gr_banner2']);
		update_post_meta($post_id, 'auto_seo', $_POST['auto_seo']);
		
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
		$tmp_title=get_the_title();
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
		$tmp_title=get_the_title();
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
		$tmp_title=get_the_title();
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
		$tmp_title=get_the_title();
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
		$tmp_title=get_the_title();
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
		$tmp_title=get_the_title();
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
		$tmp_title=get_the_title();
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
}


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
			AND p.post_title='".$title."'
	";
	$res = $wpdb->get_results($sql);
	wp_reset_postdata();
	return $res[0]->ID;
}


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

/* отключение превью картинок для вордпресса */
function true_remove_default_image_sizes( $sizes ) {
	unset( $sizes['thumbnail']); // отключаем миниатюры
	unset( $sizes['medium']); // отключаем средний размер
	unset( $sizes['large']); // отключаем крупный размер
	// если вы не хотите отключать всё, можете закомментировать 1-2 строчки
	return $sizes;
}
 
add_filter('intermediate_image_sizes_advanced', 'true_remove_default_image_sizes');
/* запретить индексирование отдельных страниц для attachment */
function wph_noindex_for_attachment() {
    if(get_post_mime_type()!= false) {
        echo '<meta name="robots" content="noindex, nofollow" />'.PHP_EOL;
    }
}
add_action('wp_head', 'wph_noindex_for_attachment');


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
 
 
/* SEO Headers Last-Modified  */ 
add_action( 'template_redirect', 'Sheensay_HTTP_Headers_Last_Modified' );
 
function Sheensay_HTTP_Headers_Last_Modified() {
    if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( is_admin() ) ) {
        return;
    }
 
    $last_modified = '';
 
 
    // Для страниц и записей
    if ( is_singular() ) {
        global $post;
 
        // Если пост запаролен - пропускаем его
        if ( post_password_required( $post ) )
            return;
 
        if ( !isset( $post -> post_modified_gmt ) ) {
            return;
        }
 
        $post_time = strtotime( $post -> post_modified_gmt );
        $modified_time = $post_time;
 
        // Если есть комментарий, обновляем дату
        if ( ( int ) $post -> comment_count > 0 ) {
            $comments = get_comments( array(
                'post_id' => $post -> ID,
                'number' => '1',
                'status' => 'approve',
                'orderby' => 'comment_date_gmt',
                    ) );
            if ( !empty( $comments ) && isset( $comments[0] ) ) {
                $comment_time = strtotime( $comments[0] -> comment_date_gmt );
                if ( $comment_time > $post_time ) {
                    $modified_time = $comment_time;
                }
            }
        }
 
        $last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
    }
 
 
    // Cтраницы архивов: рубрики, метки, даты и тому подобное
    if ( is_archive() || is_home() ) {
        global $posts;
 
        if ( empty( $posts ) ) {
            return;
        }
 
        $post = $posts[0];
 
        if ( !isset( $post -> post_modified_gmt ) ) {
            return;
        }
 
        $post_time = strtotime( $post -> post_modified_gmt );
        $modified_time = $post_time;
 
        $last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
    }
 
 
    // Если заголовки уже отправлены - ничего не делаем
    if ( headers_sent() ) {
        return;
    }
 
    if ( !empty( $last_modified ) ) {
        header( 'Last-Modified: ' . $last_modified );
 
        if ( !is_user_logged_in() ) {
            if ( isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) && strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) >= $modified_time ) {
                $protocol = (isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
                header( $protocol . ' 304 Not Modified' );
            }
        }
    }
}

/* Зачистить текст от пробелов и переносов строк */
function clear_txt($txt){
	$txt = str_replace(array("\r","\n")," ",strip_tags($txt));
	$txt = preg_replace("!\s++!u",' ', $txt);
	return 	$txt;
}
/* Склонение городов */
function dec_city($city){
	if($city == 'Москва'){
		$city='Москве';
	}else if($city=='Санкт-Петербург' || $city=='Санкт-петербург'){
		$city='Санкт-Петербурге';
	}else{
		$city;
	}
	return $city;
}

/* del /tickets?post_type=attachment */
add_action( 'init', 'my_remove_post_formats_support', 10 );
function my_remove_post_formats_support() {
	global $_wp_post_type_features;
	unset( $_wp_post_type_features[ $post_type ][ $feature ] );
}

$postType=explode('?post_type=', $_SERVER['REQUEST_URI']);
if($postType[1]=='attachment'){
	wp_redirect('https://modernrock.ru/', 301); 
	exit;
}

/* SEO блок для modernrock.ru */
add_filter( 'wp_title', 'title_seo', 0); // title page

add_filter( 'aioseo_title', 'title_seo', 0);

function title_seo($title){// title page
	global $post, $wpdb;
	$is_paged = is_paged(); // страница пагинации
	$is_category = is_category(); // страница категория
	$is_single = is_single(); // страница пост
	$auto_seo = get_post_meta(get_the_ID(), 'auto_seo', true); // параметр, если активен, то сбросить автосео
	$cat = get_the_category($post->ID); // категория поста
	$postmeta = get_post_custom($post->ID); // собрать данные о посте
	
	$serv = $_SERVER['REQUEST_URI'];
	$section=explode('/', $serv); //$section[1]
	$page=explode('page/', $serv); //$page[1]
	
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
	
	/* [12] meta для детальной страницы группы (концерт группы) */
	if($is_single && $cat[0]->term_id == 12 && !$auto_seo){
		$city = get_post_meta(get_the_ID(), 'city', true);
		$title = ''.htmlentities($post->post_title).': концерты '.date('Y').'-'.date('Y', strtotime('+1 year')).' и билеты';
	}
	
	/* [13] meta для детальной страницы клубы */
	if($is_single && $cat[0]->term_id == 13 && !$auto_seo){
		$city = get_post_meta(get_the_ID(), 'city', true);
		$title = ''.htmlentities($post->post_title).' — афиша и концерты '.date('Y').'';	
	}
	
	/* [2872] title для детальной страницы билеты  */
	if($is_single && $cat[0]->category_parent == 2872 && !$auto_seo){
		$city = get_post_meta(get_the_ID(), 'city', true);
		$club = get_post_meta(get_the_ID(), 'club', true);
		$data = get_post_meta(get_the_ID(), 'data_afisha', true);
		
		$title = ''.htmlentities($post->post_title).' в '.dec_city($city).', билеты на '.ceil(substr($data, 8, 2)).' '.date_gigs($data,0).' '.substr($data, 0, 4).'';
	}
	
	/* title активация ручного режима */
	if($is_single && $auto_seo == 1){
		$title = $postmeta["_aioseop_title"][0];
	}
	
	/* title для всех категорий - патч плагина Category SEO */
	if($is_category){
		$field_name = 'title-element-first-page'; // выбрать сео тайтл
		$terms = get_queried_object(); // берем объекты категории
		$category_seo_title_field = category_seo_get_fields( $field_name ); // ищем по связке title-element-first-page тайтл
		$title = get_option( $category_seo_title_field[ 'id' ] . '-' . $terms->term_id);
		if(empty($title)) $title = $terms->cat_name;
		if($is_paged) {
			$paged = get_query_var('paged');
			$title.=' – cтраница '.$paged.'';
		}
	}
	
	global $seo_title; $seo_title = $title; // Делаю переменную и заголовок глобальным
	
	return $title;
}

add_action("wp_head", "meta_tags", 1); // meta tags seo

/* meta description, социальное мета + остальные вставки в шапку */
function meta_tags() {
	global $post;
	global $seo_title;
	
	$is_paged = is_paged(); // страница пагинации
	$is_category = is_category(); // страница категория
	$is_single = is_single(); // страница пост
	$auto_seo = get_post_meta(get_the_ID(), 'auto_seo', true); // параметр, если активен, то сбросить автосео
	$cat = get_the_category($post->ID); // категория поста
	$postmeta = get_post_custom($post->ID); // собрать данные о посте

	$serv = $_SERVER['REQUEST_URI'];
	$section = explode('/', $serv); //$section[1]
	$page = explode('page/', $serv); //$page[1]

	if($section[1]=='groups'){ // meta для детальной страницы группы
		if(!isset($page[1])){
			if(!empty($postmeta["_aioseop_description"][0])){
				$desc = $postmeta["_aioseop_description"][0];
			}else{
				$desc = 'Афиша концертов '.htmlentities($post->post_title).' в Москве, Петербурге и других городах России';
			}
			echo '<meta name="description" content="'.$desc.'"/>';	
		}else{
			echo '<meta name="description" content="Группы – Страница '.isset($page[1]).'"/>';
		}
		echo '<meta name="keywords" content="'.htmlentities($post->post_title).',купить билет '.isset($postmeta["_aioseop_keywords"][0]).'" />';
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
	
	/* [13] meta для детальной страницы клубы */
	if($is_single && $cat[0]->term_id == 13 && !$auto_seo){
		$city = get_post_meta(get_the_ID(), 'city', true);
		echo '
<meta name="description" content="Билеты на концерты в '.htmlentities($post->post_title).' в '.dec_city($city).'. По официальным ценам. Расписание, события, адрес, отзывы."/>
<meta name="keywords" content="'.$postmeta["_aioseop_keywords"][0].'" />
		';
	}
	
	/* [2872] meta для детальной страницы билеты  */
	if($is_single && $cat[0]->category_parent == 2872 && !$auto_seo){
		$city = get_post_meta(get_the_ID(), 'city', true);
		$club = get_post_meta(get_the_ID(), 'club', true);
		echo '
<meta name="description" content="'.htmlentities($post->post_title).'. '.$city.', '.$club.'. Все билеты - на modernrock.ru"/>
<meta name="keywords" content="'.$postmeta["_aioseop_keywords"][0].'" />
		';
	}
	
	/* meta активация ручного режима */
	if($is_single && $auto_seo == 1){
		echo '
<meta name="description" content="'.$postmeta["_aioseop_description"][0].'"/>
<meta name="keywords" content="'.$postmeta["_aioseop_keywords"][0].'" />
';
		$title = $postmeta["_aioseop_title"][0];
	}
	
	/* meta для всех категорий */
	if($is_category){
		$field_name = 'title-element-first-page';
		$terms = get_queried_object();
		$cat_description = clear_txt($terms->description);
		echo '	
<meta name="description" content="'.$cat_description.'"/>
<meta name="keywords" content="'.$terms->cat_name.','.$terms->category_nicename.'" />
';
	}
	
	/* социальные мета теги */
	if($is_single){
		$meta_desc = clear_txt($post->post_content);
		$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		if(strlen($meta_desc) > 300){
			$meta_desc = substr($meta_desc,0,350).'...';
		}
		echo '
<meta property="og:site_name" content="ModernRock.ru"/>
<meta property="og:title" content="'.$seo_title.'"/>
<meta property="og:description" content="'.$meta_desc.'"/> 
<meta property="og:url" content="https://modernrock.ru'.$_SERVER['REQUEST_URI'].'"/>
';
		if (isset($large[0])){
		echo '
<meta property="og:image" content="'.$large[0].'"/>
<link rel="image_src" href="'.$large[0].'"/>
';
		}

	}

}

/* function base pagination */
function b_pager($currentPage = 1, $pageOnePage = 20, $countPages = 2000, $url = '/', $url_page = '/', $prefix='', $pagerCount = 5){
	// $currentPage - Активная страница, если не задана, то первая 
	// $pagerCount - Количество пунктов пагинации на странице
	// $pageOnePage - Количество элементов на странице
	
	// Количество страниц
	$countPages = ceil($countPages / $pageOnePage);

	// $url - url первой страницы
	// $url_page - url для страниц пагинации
	// $prefix - для урла после цифры pager

	// Если страниц больше одной, выводим пагинацию
	if ($countPages > 1) {
		$left = $currentPage - 1;
		$right = $countPages - $currentPage;

		if ($left < floor($pagerCount / 2)){
			$start = 1;
		}else{
			$start = $currentPage - floor($pagerCount / 2);
		}

		$end = $start + $pagerCount - 1;

		if ($end > $countPages) {
			$start -= ($end - $countPages);
			$end = $countPages;

			if ($start < 1){
				$start = 1;
			}
		}
		
		// занулим переменные
		$firstLink = '';
		$prevLink = '';
		$pager = '';
		$nextLink = '';
		$lastLink = '';
		$prevLinkDot = '';
		$nextLinkDot = '';
		
		// prev first страница
		if ($currentPage != 1) {
			$firstLink = '<a href="'.$url.'" class="pager first">« Первая</a>';
			$prevLink = $currentPage == 2 ? $url : $url_page.($currentPage - 1).$prefix;
			$prevLink = '<a href="'.$prevLink.'" class="pager previouspostslink">«</a>';
		}

		// prev half dot страница
		if ($currentPage > $pagerCount) {
			$prevLinkDot = round($currentPage / 2);
			$prevLinkDot = '<a href="'.$url_page.$prevLinkDot.''.$prefix.'" class="pager extend">...</a>';
		}

		// страницы пагинации
		for ($i = $start; $i <= $end; $i++) {
			if ($i == $currentPage) {
				$pager.= '<span class="pager current">'.$i.'</span>';
			}else {
				$pagerLink = ($i == 1) ? $url : $url_page.$i.$prefix;
				$pager.= '<a href="'.$pagerLink.'" class="pager smaller">'.$i.'</a>';
			}
		}

		// next last страница
		if ($currentPage != $countPages) {
			$nextLink = '<a href="'.$url_page.($currentPage + 1).''.$prefix.'" class="pager nextpostslink">»</a>';
			$lastLink = '<a href="'.$url_page.$countPages.''.$prefix.'" class="pager last">Последняя »</a>';
		}

		// next half dot страница
		if (($countPages - $currentPage) > $pagerCount) {
			$nextLinkDot = round(($countPages + $currentPage) / 2);
			$nextLinkDot = '<a href="'.$url_page.$nextLinkDot.''.$prefix.'" class="pager half_dot">...</a>';
		}

		// Вывести пагинацию
		echo '
			<div class="pagination">
				<div class="wp-pagenavi"> 
					'.$firstLink.'
					'.$prevLink.'
					'.$prevLinkDot.'
					'.$pager.'
					'.$nextLink.'
					'.$nextLinkDot.'
					'.$lastLink.'
				</div>
			</div>
		';
	}
}
function gigsbot_banner() {
    $artist_name = 'Бонда с кнопкой'; // ← меняй под каждый сайт
    $bot_link    = 'https://gigsbot.ru/';
    $delay       = 2000; // 2 секунды
    $cookie_days = 1;    // раз в сутки
    ?>
    <div id="gigsbot-banner" style="display:none; position:fixed; bottom:20px; right:20px; z-index:99999; width:300px; background:#fff; border:1px solid #e0e0e0; border-radius:12px; padding:20px 22px; box-shadow:0 4px 20px rgba(0,0,0,0.12); font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; box-sizing:border-box;">
        <button onclick="gigsbotClose()" style="position:absolute; top:10px; right:14px; border:none; background:none; cursor:pointer; font-size:20px; color:#999; padding:0; line-height:1;">×</button>
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2AABEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span style="font-weight:600; font-size:15px; color:#1a1a1a;">Не пропусти концерт!</span>
        </div>
        <p style="font-size:13px; color:#666; margin:0 0 14px; line-height:1.5;">
            Выбери артистов и город — GIGSBOT сам найдёт билеты и пришлёт уведомление первым 🔔
        </p>
        <a href="<?php echo esc_url($bot_link); ?>" target="_blank" rel="noopener" style="display:block; background:#2AABEE; color:#fff; text-align:center; text-decoration:none; padding:10px 16px; border-radius:8px; font-size:14px; font-weight:500;">Подписаться в Telegram</a>
    </div>

    <script>
    (function() {
        var COOKIE_NAME = 'gigsbot_shown';
        var DELAY       = <?php echo intval($delay); ?>;
        var DAYS        = <?php echo intval($cookie_days); ?>;

        function getCookie(name) {
            var v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
            return v ? v.pop() : '';
        }
        function setCookie(name, days) {
            var d = new Date();
            d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
            document.cookie = name + '=1; expires=' + d.toUTCString() + '; path=/';
        }

        if (!getCookie(COOKIE_NAME)) {
            setTimeout(function() {
                document.getElementById('gigsbot-banner').style.display = 'block';
            }, DELAY);
        }

        window.gigsbotClose = function() {
            document.getElementById('gigsbot-banner').style.display = 'none';
            setCookie(COOKIE_NAME, DAYS);
        };

        document.getElementById('gigsbot-banner').querySelector('a').addEventListener('click', function() {
            setCookie(COOKIE_NAME, DAYS);
        });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'gigsbot_banner');
add_action('template_redirect', function() {
    if (is_category(2872)) {
        wp_redirect('https://modernrock.ru/afisha/moskva/', 301);
        exit;
    }
});
add_shortcode('news_rewriter', function() {
    if (!current_user_can('edit_posts')) {
        return '<p>Для создания новости войдите под учётной записью редактора.</p>';
    }
    $has_action = isset($_POST['news_url']) || isset($_POST['clear_cache']);
    if ($has_action && (!isset($_POST['modernrock_news_nonce'])
        || !is_string($_POST['modernrock_news_nonce'])
        || !wp_verify_nonce(wp_unslash($_POST['modernrock_news_nonce']), 'modernrock_news_rewriter'))) {
        return '<p>Проверка формы не пройдена. Обновите страницу и повторите отправку.</p>';
    }
    if (isset($_POST['clear_cache']) && !current_user_can('manage_options')) {
        return '<p>Для очистки кэша нужны права администратора.</p>';
    }
    if (isset($_POST['news_url']) && !is_string($_POST['news_url'])) {
        return '<p>Укажите ссылку на новость строкой.</p>';
    }
    $result_html = '';
    
    if (isset($_POST['news_url']) && !empty($_POST['news_url'])) {
        $url = is_string($_POST['news_url']) ? esc_url_raw(wp_unslash($_POST['news_url'])) : '';
        if (!$url || !wp_http_validate_url($url)) {
            return '<p>Укажите доступный публичный HTTP(S)-адрес новости.</p>';
        }
        
        // Парсим страницу
        $page = wp_safe_remote_get($url, [
            'limit_response_size' => 1048576,
            'timeout' => 15,
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ]);
        
        if (is_wp_error($page) || wp_remote_retrieve_response_code($page) !== 200) {
            $result_html = '<div style="color:red">Не удалось загрузить страницу новости.</div>';
        } else {
            $html = wp_remote_retrieve_body($page);
            
            // Простой парсинг
            $html = preg_replace('/<(script|style|nav|footer|header)[^>]*>.*?<\/\1>/is', '', $html);
            preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $h1);
            $title = isset($h1[1]) ? strip_tags($h1[1]) : '';
            preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $html, $ps);
            $paragraphs = array_map('strip_tags', $ps[1]);
            $paragraphs = array_filter($paragraphs, function($p) { return strlen(trim($p)) > 50; });
            $text = implode(' ', array_slice($paragraphs, 0, 15));
            $text = substr(trim($text), 0, 3000);
            
            if (empty($text)) {
                $result_html = '<div style="color:red">❌ Не удалось извлечь текст со страницы</div>';
            } else {
                // Load the API key from the ignored, server-local configuration.
                $anthropic_key_file = __DIR__ . '/anthropic.local.php';
                $anthropic_api_key = is_readable($anthropic_key_file) ? require $anthropic_key_file : '';
                if (!is_string($anthropic_api_key) || $anthropic_api_key === '') {
                    return '<p>API Anthropic не настроен на сервере.</p>';
                }
                // Отправляем в Claude
                $prompt = "Ты редактор музыкального сайта modernrock.ru. Перепиши новость коротко и по делу, без воды. Оригинальный заголовок: $title. Текст: $text. Верни ТОЛЬКО JSON без markdown: {\"title\": \"заголовок на русском\", \"content\": \"текст 2-4 абзаца на русском\"}";
                
                $claude = wp_remote_post('https://api.anthropic.com/v1/messages', [
                    'timeout' => 30,
                    'headers' => [
                        'x-api-key' => $anthropic_api_key,
                        'anthropic-version' => '2023-06-01',
                        'content-type' => 'application/json',
                    ],
                    'body' => json_encode([
                        'model' => 'claude-haiku-4-5',
                        'max_tokens' => 1000,
                        'messages' => [['role' => 'user', 'content' => $prompt]]
                    ])
                ]);
                
                if (is_wp_error($claude) || wp_remote_retrieve_response_code($claude) !== 200) {
                    $result_html = '<div style="color:red">Сервис обработки новости временно недоступен.</div>';
                } else {
                    $data = json_decode(wp_remote_retrieve_body($claude), true);
                    $text_out = isset($data['content'][0]['text']) ? $data['content'][0]['text'] : '';
                    $text_out = preg_replace('/```json|```/', '', $text_out);
                    preg_match('/\{.*\}/s', $text_out, $matches);
                    $json = isset($matches[0]) ? json_decode($matches[0], true) : null;
                    
                    if ($json && isset($json['title']) && isset($json['content'])) {
                        // Постим в WordPress
                        $post_id = wp_insert_post([
                            'post_title'    => sanitize_text_field($json['title']),
                            'post_content'  => wp_kses_post($json['content']) . "\n\n" . '<p><em>Источник: <a href="' . esc_url($url) . '">' . esc_html($url) . '</a></em></p>',
                            'post_status'   => 'draft',
                            'post_category' => [3],
                        ]);
                        
                        if ($post_id) {
                            $edit_url = admin_url("post.php?post=$post_id&action=edit");
                            $result_html = '<div style="color:green; padding:10px; background:#f0fff0; border-radius:4px;">✅ Черновик создан: <b>' . esc_html($json['title']) . '</b><br><a href="' . esc_url($edit_url) . '" target="_blank">Открыть в редакторе →</a></div>';
                        } else {
                            $result_html = '<div style="color:red">❌ Ошибка создания поста</div>';
                        }
                    } else {
                        $result_html = '<div style="color:red">❌ Claude вернул некорректный ответ: ' . esc_html($text_out) . '</div>';
                    }
                }
            }
        }
    }
    
    ob_start();
    ?>
<div style="max-width:600px; margin:20px 0;">
        <h2>Добавить новость</h2>
        
        <?php if (isset($_POST['clear_cache'])) {
            global $wpdb;
            $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_gigsbot_%' OR option_name LIKE '_transient_timeout_gigsbot_%'");
            echo '<div style="color:green; padding:10px; background:#f0fff0; border-radius:4px; margin-bottom:10px;">✅ Кеш концертов сброшен!</div>';
        } ?>
        
        <form method="post" style="margin-bottom:15px;">
            <?php wp_nonce_field('modernrock_news_rewriter', 'modernrock_news_nonce'); ?>
            <button type="submit" name="clear_cache" value="1" 
                    style="background:#555; color:#fff; border:none; padding:8px 16px; font-size:13px; border-radius:4px; cursor:pointer;">
                🔄 Сбросить кеш концертов
            </button>
        </form>
        
        <form method="post">
            <?php wp_nonce_field('modernrock_news_rewriter', 'modernrock_news_nonce'); ?>
            <input type="text" name="news_url" placeholder="Вставьте ссылку на новость"
                   value="<?php echo isset($_POST['news_url']) ? esc_attr($_POST['news_url']) : ''; ?>"
                   style="width:100%; padding:10px; font-size:15px; border:1px solid #ddd; border-radius:4px; margin-bottom:10px; box-sizing:border-box;" />
            <button type="submit" style="background:#0e920e; color:#fff; border:none; padding:10px 24px; font-size:15px; border-radius:4px; cursor:pointer;">
                Создать новость
            </button>
        </form>
        <?php if ($result_html) echo $result_html; ?>
    </div>
    <?php
    return ob_get_clean();
});
add_action('init', function() {
    if (isset($_GET['gigsbot_clear_cache'], $_GET['_wpnonce'])
        && current_user_can('manage_options') && is_string($_GET['_wpnonce'])
        && wp_verify_nonce(wp_unslash($_GET['_wpnonce']), 'modernrock_clear_gigsbot_cache')) {
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_gigsbot_%' OR option_name LIKE '_transient_timeout_gigsbot_%'");
        echo 'OK: cache cleared';
    }
});