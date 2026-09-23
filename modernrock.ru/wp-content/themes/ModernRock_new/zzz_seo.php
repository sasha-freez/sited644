<?php
/*
Script Name: wpAutomateSEO 
Script URI: http://www.wpbloging.com/optimize/wpautomateseo-skript-dlya-avtomaticheskoj-seo-optimizacii-wordpress.html
Description: wpAutomateSEO скрипт для шаблонов WordPress, создающий  в полуавтоматическом режиме мета-теги title, description, keywords и закрывающий от индексации поисковиками дублирующий контент.
						Данный скрипт это продолжение моего старого скрипта SEO.php.
Author: Oleg Medinskiy oleg@wpbloging.com
Version: 2.5 Light
Author URI: http://www.wpbloging.com
Usage:
1. Перепишите данный файл в каталог с файлами вашего шаблона
2. Откройте в редакторе файл function.php и в конце файла вставьте строку <?php include_once "seo.php"; ?>
3. Удалите все мета-теги title, description, keywords в файле header.php или включите в настройка скрипта 'clean_meta'=>1. 
4. Проверьте имеется ли в файле header.php строка <?php wp_head(); ?> если нет внесите. Для автоматической чистки хедера необходимо чтобы тег wp_head(); находился перед </head>
5. Пропишите главные title, description, keywords, для всего сайта, в настройках скрипта.
6. Измените, если желаете, настройки скрипта на свой вкус.
7. Скрипт готов к работе.
Чтобы индивидуально указать мета-теги title, description, keywords к каждой публикации:
Скрипт совместим со старой версией скрипта и плагинов Platinum SEO, wpSEO, All in One Seo, Light SEO.
При этом, если вы укажите мета-теги поста с помощью скрипта, то они будут приоритетны.
В Light версии, для указания title, description, keywords, используйте произвольные поля:
title - альтернативный заголовок поста.
description - описание, мета-тег description.
keywords - ключевые слова и фразы, мета-тег keywords.
*Внимание, если вы используете Light версию скрипта, не отключайте в настройка поддержку старой версии.
Подробное описание работы скрипта читайте на странице http://www.wpbloging.com
Для получения полной версии напишите мне письмо на oleg@wpbloging.com
Подробное описание работы скрипта читайте на странице http://www.wpbloging.com/optimize/wpautomateseo-skript-dlya-avtomaticheskoj-seo-optimizacii-wordpress.html
*/
class wpseauto{

    
//Установка опций работы скрипта
var $wpseauto_var=array( 
/**** Очистка header шаблона ******/
// Внимание, для правильной очитки хедера в шаблоне, wp_head() должен стоять в самом конце хедера, перед </head>
// в случае проблем установите параметры ниже в 0 и вручную удалите в шаблоне вывод метатегов.
'clean_meta'	=>1, 		//Исключаем дублирование мета-тегов (title,description,keywords) которые уже есть в шаблоне.
'clean_code'	=>0, 		//Чистка хедера от комментариев и переносов строк. Внимание, данная функция может удалить полезные комментарии. ПРОВЕРЯЙТЕ после включения функции. 
/**** Мета-теги для главной страницы ******/
'title_home'	=>'', 	//Пусто для авто генерации title на главной, или впишите title через запятую, если не нужна авто генерация.
'descr_home'	=>'', 	//Пусто для авто генерации description на главной, или впишите description через запятую, если не нужна авто генерация.
'key_home'		=>'', 	//Пусто для авто генерации ключей на главной, или впишите ключи через запятую, если не нужна авто генерация.
/**** Подстановочные переменные ******/
'sep'					=>'&raquo;',  //Разделитель для title
'nsep'				=>',',  //Разделитель для нумерации
'prefcat'			=>'Рубрика -', //Префикс для рубрики который идет перед названием рубрики.
'prefarh'			=>'Архив за', //Префикс для рубрики который идет перед названием рубрики.
'preftag'			=>'Метка -', //Префикс для рубрики который идет перед названием рубрики.
'prefavt'			=>'Статьи автора:', //Префикс для рубрики статей автора который идет перед названием рубрики.
'prefserch'		=>'Результаты поиска по запросу -', //Префикс для страницы поиска.
'stranica'		=>'Страница ', //Префикс постраничной навигации в страницах и постах тега nextpage.
'chast'				=>'Часть ', //Префикс постраничной навигации в страницах и постах тега nextpage.
'titl404'		  =>'Ошибка 404, страница не найдена', //title для страницы ошибки
/**** Схемы для генерации title ******/
// %npage% 	 - нумерация страниц
// %nsep% 	 - разделитель для нумерации 
// %prefpag% - префикс для страницы, заменяется на подстановочные префиксы из блока выше. 
// %titlcur% - title текущей страницы
// %sep% 		 - разделитель
// %tithom%  - title главной страницы
// %blog_name% - title главной страницы, берется строго из описания блога в админке
'scheme_hom'	=>'%npage%%nsep% %tithom% ', //Схема генерации title для главной 
'scheme_cat'	=>'%npage%%nsep% %prefpag% %titlcur% %sep% %tithom%', //Схема генерации title для рубрик 
'scheme_arh'	=>'%npage%%nsep% %prefpag% %titlcur% %sep% %tithom%', //Схема генерации title для архивов
'scheme_tag'	=>'%npage%%nsep% %prefpag% %titlcur% %sep% %tithom%', //Схема генерации title меток 
'scheme_avt'	=>'%npage%%nsep% %prefpag% %titlcur% %sep% %tithom%', //Схема генерации title авторов 
'scheme_serch'=>'%npage%%nsep% %prefpag% %titlcur% %sep% %tithom%', //Схема генерации title поиска 
'scheme_post'	=>'%npage%%nsep% %titlcur% %sep% %tithom%', //Схема генерации title для страниц и статей 
/**** Настройки генерации мета-тегов ******/
'nodeskrp'		=>0, 	//Запретить description ресурса, поставьте 1 для запрета
'nokeywrds'		=>0, 	//Запретить keywords ресурса, поставьте 1 для запрета
'noforms'			=>0, 	//Запретить форму под редактором, поставьте 1 для запрета
'impold'			=>1, 	//Импортировать данные из старой версии скрипта (только настройки title,description,keywords для внутренних постов. Остальные указывайте в настройках скрипта)
'impplug'			=>1, 	//Импортировать данные из плагинов: Platinum SEO, wpSeo, All in One Seo,Light SEO (только настройки title,description,keywords для внутренних постов. Остальные указывайте в настройках скрипта)
'kolhomkey'		=>15, //Количество ключевых слов на главной странице. Если не указаны слова в key_home
'kolpagkey'		=>9,  //Количество ключевых слов на внутренних страницах.
'koldeskpost'	=>23, //Количество слов для description в публикациях при автоматической вставке.
'descpos'			=>1,  //С какого по счету предложения в посте начинать формировать description
/**** Закрываем от индексации разделы блога в мета тегах, ссылки и постр. навигацию ******/
'noindxhpag'	=>0, 	//Закрывать от индексации постраничную навигацию главной (Пока в разработке)
'noindxpgpst'	=>0, 	//Закрывать от индексации постраничную навигацию постов сформированных тегом nextpage. (Пока в разработке)
'noindxtag'		=>1, 	//Закрывать от индексации страницы и ссылки метки, постр навигацию
'noindxcom'		=>1, 	//Закрывать от индексации страницы и ссылки комментариев, постр навигацию
'noindxcat'		=>0, 	//Закрывать от индексации страницы и ссылки рубрики, постр навигацию
'noindxarh'		=>1, 	//Закрывать от индексации страницы и ссылки архива, постр навигацию
'noindxavt'		=>1, 	//Закрывать от индексации страницы и ссылки авторов, постр навигацию
'noindxsch'		=>1, 	//Закрывать от индексации страницы и ссылки поиска, постр навигацию 
'nofollnk_blgrl' 		=>1, 	//Закрывать выборочно от индексации ссылки в блогролле, если при добавлении ссылки в админке атрибуты поставить все в НЕТ то будет nofollow
'nofollnk_blgrlall' =>0, 	//Закрывать от индексации все ссылки в блогролле. Отменяет предыдущую опцию и закрывает все ссылки в блогролле.
);
var $flags;


/********************************************/
	/************ Инициируем скрипт *************/
	/********************************************/
function wpseauto(){
	if($this->wpseauto_var['clean_meta']==1 || $this->wpseauto_var['clean_code']==1) {
		add_action('init', array(&$this,'wpseauto_obstart'),1);
		add_action('wp_head', array(&$this,'wpseauto_cleanheader'));
	}else{
		add_action('wp_head', array(&$this,'wpseauto_addheader'),0);
	}
}





//Получения хедера
function wpseauto_obstart() { ob_clean(); ob_start(); }
//Формируем с чисткой хедера хедера
function wpseauto_cleanheader() {
//global $wpseauto_var;
		$weee=ob_get_contents();
		ob_end_clean();
	if($this->wpseauto_var['clean_meta']==1){
		$weee=preg_replace('/<(head.*?)>/uU',"<$1>"."\n".'||wpcr||',$weee);
		$weee=preg_replace('/<title.*?<\/title>/uU','',$weee);
		$weee=preg_replace('/<meta.*?name="description".*?\/>/uU','',$weee);
		$weee=preg_replace('/<meta.*?name="keywords".*?\/>/uU','',$weee);
		$weee=preg_replace('/<meta.*?name="robots".*?\/>/uU','',$weee);
		$weee=preg_replace('/<link.*?rel=[\'\"]canonical[\'\"].*?\/>/uU','',$weee);
		$weee=preg_replace("/[\n\r]{2,}/","\n",$weee);
	}
	if($this->wpseauto_var['clean_code']==1){
		$weee=preg_replace("/\<![ \r\n\t]*(--([^\-]|[\r\n]|-[^\-])*--[ \r\n\t]*)\>/",'',$weee);
		$weee=preg_replace("/[\n\r]{2,}/","\n",$weee);
	}
	$weee=str_replace('||wpcr||',$this->wpseauto_creat(),$weee);
	echo $weee;
}
//Добавляем в хедер теги без чистки
function wpseauto_addheader() { echo $this->wpseauto_creat(); }


/********************************************/				
/********* Функция создания тегов ***********/
/********************************************/
function wpseauto_creat(){
//global $this->wpseauto_var;
$paged=get_query_var('paged');
$wps_meta='';
if($this->wpseauto_var['title_home']=='')  $titlhome=trim(get_bloginfo('name')); else $titlhome=$this->wpseauto_var['title_home'];

			
/****************** Для главной ***************/
    if (is_home() || is_front_page()) {
				// формируем title 		
			  if(!$paged) $wps_meta.='<title>'.$titlhome.'</title>'."\n"; else $wps_meta.='<title>'.$this->_wpseauto_titlpaged($this->wpseauto_var['stranica'],$paged,'','',$this->wpseauto_var['scheme_hom'],$titlhome).'</title>'."\n";
				// формируем description 
				if($this->wpseauto_var['nodeskrp']!=1){
					if(!$paged) {
						$deskrpag=strip_tags(category_description(the_category_ID(false)));
						if($this->wpseauto_var['descr_home']!='') {
							$wps_meta.='<meta name="description" content="'.trim($this->wpseauto_var['descr_home']).'" />'."\n";
						}elseif(get_bloginfo('description')){
							$wps_meta.='<meta name="description" content="'.trim(get_bloginfo('description')).'" />'."\n";
						}else{
							$wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";
						} 
					}else{
						$wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";
						if($this->wpseauto_var['noindxhpag']==1) {
							$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
							if(function_exists('nofollow_pagin_seo')) $this->nofollow_pagin_seo();
						}
					}		
				}		
      	// формируем keywords слова из указанного параметра или из самых популярных тегов блога
      	if($this->wpseauto_var['nokeywrds']!=1){
		      if(!$paged) {
						if($this->wpseauto_var['key_home']==''){
			        $tags = get_tags( array('orderby' => 'count', 'order' => 'DESC', 'number'=>$this->wpseauto_var['kolhomkey']) );
			        if ($tags){
			          foreach ((array) $tags as $tag){$alltags[]=$tag->name;}
			          $alltags=implode(', ',$alltags);
			          $wps_meta.='<meta name="keywords" content="'.trim($alltags).'" />'."\n";
			        }  
						}else{
								$wps_meta.='<meta name="keywords" content="'.trim($this->wpseauto_var['key_home']).'" />'."\n";
						} 
					}
				}
		
/****************** Для рубрик ***************/			
    }elseif(is_category()) {
      	// формируем title 
      	if($paged){
					$wps_meta.='<title>'.$this->_wpseauto_titlpaged($this->wpseauto_var['stranica'],$paged,$this->wpseauto_var['prefcat'],single_cat_title("", false),$this->wpseauto_var['scheme_cat'],$titlhome).'</title>'."\n";
				}else{
					$wps_meta.='<title>'.$this->_wpseauto_titlnopaged('',$this->wpseauto_var['prefcat'],single_cat_title("", false),$this->wpseauto_var['scheme_cat'],$titlhome).'</title>'."\n";
				}
      	// формируем description 
      	if($this->wpseauto_var['nodeskrp']!=1){
					if(!$paged) {
						if(the_category_ID(false)) $deskr=htmlspecialchars(strip_tags(category_description(the_category_ID(false))));
						if($deskr) $wps_meta.='<meta name="description" content="'.trim($deskr).'" />'."\n"; else $wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";
						if($this->wpseauto_var['noindxcat']==1) $wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
					}else{
						$wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";					
					}
				}
				if($this->wpseauto_var['noindxcat']==1) {
					$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
					if(function_exists('nofollow_pagin_seo')) $this->nofollow_pagin_seo();
				}	
	
/****************** Для меток ***************/			
		}elseif(is_tag()) {
      	// формируем title
      	if($paged){
					$wps_meta.='<title>'.$this->_wpseauto_titlpaged($this->wpseauto_var['stranica'],$paged,$this->wpseauto_var['preftag'],single_tag_title("",false),$this->wpseauto_var['scheme_tag'],$titlhome).'</title>'."\n";
				}else{
					$wps_meta.='<title>'.$this->_wpseauto_titlnopaged('',$this->wpseauto_var['preftag'],single_tag_title("",false),$this->wpseauto_var['scheme_tag'],$titlhome).'</title>'."\n";
				}
      	// формируем description 
      	if($this->wpseauto_var['nodeskrp']!=1){
					if(!$paged) {
						$tg_id=intval(get_query_var('tag_id'));
		        $deskr=htmlspecialchars(strip_tags(str_replace(array("\n","\r"),'',tag_description($tg_id))));
						if($deskr) $wps_meta.='<meta name="description" content="'.trim($deskr).'" />'."\n"; else $wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";
						if($this->wpseauto_var['noindxtag']==1) $wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
					}else{
						$wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";				
					}  
				}	                  
						if($this->wpseauto_var['noindxtag']==1) {
							$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
							if(function_exists('nofollow_pagin_seo')) $this->nofollow_pagin_seo();
						}				
									
/****************** Для авторов ***************/			
		}elseif(is_author()) {
			global $author_name, $author;	
 			if(isset($_GET['author_name'])) $curauth = get_user_by('slug', $author_name); else $curauth = get_userdata(intval($author)); 
      	// формируем title
      	if($paged){
					$wps_meta.='<title>'.$this->_wpseauto_titlpaged($this->wpseauto_var['stranica'],$paged,$this->wpseauto_var['prefavt'],esc_attr($curauth->display_name),$this->wpseauto_var['scheme_avt'],$titlhome).'</title>'."\n";
				}else{
					$wps_meta.='<title>'.$this->_wpseauto_titlnopaged('',$this->wpseauto_var['prefavt'],esc_attr($curauth->display_name),$this->wpseauto_var['scheme_avt'],$titlhome).'</title>'."\n";
				}
      	// формируем description 
      	if($this->wpseauto_var['nodeskrp']!=1){
					if(!$paged) {
		        $deskr=htmlspecialchars($curauth->description);
						if($deskr) $wps_meta.='<meta name="description" content="'.trim($deskr).'" />'."\n"; else $wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";
						if($this->wpseauto_var['noindxavt']==1) $wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
					}else{
						$wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";					
					} 
				}
						if($this->wpseauto_var['noindxavt']==1) {
							$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
							if(function_exists('nofollow_pagin_seo')) $this->nofollow_pagin_seo();
						}
				
/****************** Для архивов ***************/
   		}elseif(is_archive()) {
	   		if(is_year()) $titarch=get_the_time("Yг.");
	   		if(is_month()) $titarch=get_the_time("F Yг.");
	   		if(is_day()) $titarch=get_the_time("j F Yг."); 		
      	if($paged){
					$wps_meta.='<title>'.$this->_wpseauto_titlpaged($this->wpseauto_var['stranica'],$paged,$this->wpseauto_var['prefarh'],$titarch,$this->wpseauto_var['scheme_arh'],$titlhome).'</title>'."\n";
				}else{
					$wps_meta.='<title>'.$this->_wpseauto_titlnopaged('',$this->wpseauto_var['prefarh'],$titarch,$this->wpseauto_var['scheme_arh'],$titlhome).'</title>'."\n";
				}	
      	// формируем description 
      	if($this->wpseauto_var['nodeskrp']!=1){
					$wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($this->_wpseauto_descrpag())).'" />'."\n";
					if($this->wpseauto_var['noindxarh']==1) {
						$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
						if(function_exists('nofollow_pagin_seo')) $this->nofollow_pagin_seo();
					}						    
				}
				
				
/****************** Для поиска  ***************/	 				
   		}elseif(is_search()) {	
      	if($paged){
					$wps_meta.='<title>'.$this->_wpseauto_titlpaged($this->wpseauto_var['stranica'],$paged,$this->wpseauto_var['prefserch'],get_search_query(),$this->wpseauto_var['scheme_serch'],$titlhome).'</title>'."\n";
				}else{
					$wps_meta.='<title>'.$this->_wpseauto_titlnopaged('',$this->wpseauto_var['prefserch'],get_search_query(),$this->wpseauto_var['scheme_serch'],$titlhome).'</title>'."\n";
				}							
   			$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
				if(function_exists('nofollow_pagin_seo')) $this->nofollow_pagin_seo();


/****************** Для ошибки 404  ***************/
   		}elseif(is_404()) {	
				$wps_meta.='<title>'.$this->wpseauto_var['titl404'].'</title>'."\r\n"; 
				$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\r\n";


/****************** Для страниц и постов ***************/			
      }elseif(is_singular()) {	
				global $post;
				$pagedp=get_query_var('page');
				$cpagedp=get_query_var('cpage');		
      // формируем title    
      	$postmeta=get_post_custom($post->ID);
      	$titlpst=stripcslashes($postmeta['_wpseauto_titl'][0]); //Проверка наличия title скрипта
      	if(!$titlpst && $this->wpseauto_var['impold']==1) $titlpst=stripcslashes($postmeta['title'][0]); //Проверка наличия title предыдущей версии скрипта или данных Platinum SEO
      	if(!$titlpst && $this->wpseauto_var['impplug']==1) $titlpst=stripcslashes($postmeta['_wpseo_edit_title'][0]); //Проверка наличия title wpseo
      	if(!$titlpst && $this->wpseauto_var['impplug']==1) $titlpst=stripcslashes($postmeta['_aioseop_title'][0]); //Проверка наличия title All in One Seo
      	if(!$titlpst && $this->wpseauto_var['impplug']==1) $titlpst=stripcslashes($postmeta['_lightseop_title'][0]); //Проверка наличия title Light SEO
      	if(!$titlpst) $titlpst.=the_title("","", false);
      	if($pagedp){
					$wps_meta.='<title>'.$this->_wpseauto_titlpaged( $this->wpseauto_var['chast'], $pagedp,'',$titlpst,$this->wpseauto_var['scheme_post'],$titlhome).'</title>'."\n";
				}else{
					$wps_meta.='<title>'.$this->_wpseauto_titlnopaged('',$this->wpseauto_var['prefavt'],$titlpst,$this->wpseauto_var['scheme_post'],$titlhome).'</title>'."\n";
				}									     	
			// формируем description 
			if($this->wpseauto_var['nodeskrp']!=1){
      	$descpst=stripcslashes($postmeta['_wpseauto_descr'][0]); //Проверка наличия description скрипта 
      	if(!$descpst && $this->wpseauto_var['impold']==1) $descpst=htmlspecialchars(stripcslashes($postmeta['description'][0])); //Проверка наличия description предыдущей версии скрипта или данных Platinum SEO
      	if(!$descpst && $this->wpseauto_var['impplug']==1) $descpst=htmlspecialchars(stripcslashes($postmeta['_wpseo_edit_description'][0])); //Проверка наличия description wpseo
      	if(!$descpst && $this->wpseauto_var['impplug']==1) $descpst=htmlspecialchars(stripcslashes($postmeta['_aioseop_description'][0])); //Проверка наличия description All in One Seo
      	if(!$descpst && $this->wpseauto_var['impplug']==1) $descpst=htmlspecialchars(stripcslashes($postmeta['_lightseop_description'][0])); //Проверка наличия description Light SEO
				if(!$descpst) {
	      	if($pagedp){
	      		$explpost=explode('<!--nextpage-->',$post->post_content);
	      		$postcont=$explpost[$pagedp-1]; 
	      	}else{
	      		$postcont=$post->post_content;
  				} 				
      		$descr=preg_replace("/\[(.*?)\]|\r|\n|&nbsp;/u"," ",strip_tags($postcont));
      		$descr=preg_replace("/\s{2,}/iu"," ",$descr); 
					if($this->wpseauto_var['descpos']>0) $descr=implode(' ',array_slice(explode('. ',$descr), $this->wpseauto_var['descpos']-1));    		
					$textdes=explode(' ',trim($descr));
	        $descr=implode(' ',array_slice($textdes, 0, $this->wpseauto_var['koldeskpost']));		        
	        $descpst=$descr;
				}
				if($descpst) $wps_meta.='<meta name="description" content="'.trim(htmlspecialchars($descpst)).'" />'."\r\n";
			}	
			// формируем keywords 
			if($this->wpseauto_var['nokeywrds']!=1){
				if(!$pagedp){
	      	$keypst=htmlspecialchars(stripcslashes($postmeta['_wpseauto_key'][0])); //Проверка наличия keywords скрипта
	      	if(!$keypst && $this->wpseauto_var['impold']==1) $keypst=htmlspecialchars(stripcslashes($postmeta['keywords'][0])); //Проверка наличия keywords предыдущей версии скрипта или данных Platinum SEO
	      	if(!$keypst && $this->wpseauto_var['impplug']==1) $keypst=htmlspecialchars(stripcslashes($postmeta['_wpseo_edit_keywords'][0])); //Проверка наличия keywords wpseo
	      	if(!$keypst && $this->wpseauto_var['impplug']==1) $keypst=htmlspecialchars(stripcslashes($postmeta['_aioseop_keywords'][0])); //Проверка наличия keywords All in One Seo
	      	if(!$keypst && $this->wpseauto_var['impplug']==1) $keypst=htmlspecialchars(stripcslashes($postmeta['_lightseop_keywords'][0])); //Проверка наличия keywords Light SEO
					if(!$keypst) {
					   $keytag=wp_get_post_tags($post->ID, array('orderby' => 'count', 'order' => 'DESC'));
	           if($keytag) foreach ((array) $keytag as $keywrdtg){$keyartg[]=$keywrdtg->name;}
	           if($keyartg) {
	             $keywrd=implode(', ',$keyartg);
	             $keypst=$keywrd;
	           }
					} 
				}    	
      	if($keypst) $wps_meta.='<meta name="keywords" content="'.trim(htmlspecialchars($keypst)).'" />'."\r\n";
			}	
				if($this->wpseauto_var['noindxpgpst']==1 && $pagedp) {
					$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\n";
				}else{	
					if($postmeta['_wpseauto_nocanonic'][0]!=1 && $postmeta['_wpseauto_noindxpst'][0]!=1) $wps_meta.='<link rel="canonical" href="'.get_permalink($post->ID).'" />'."\r\n";
					if($postmeta['_wpseauto_noindxpst'][0]==1) {
						$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\r\n";
					}elseif($cpagedp && $this->wpseauto_var['noindxcom']==1){
						$wps_meta.='<meta name="robots" content="noindex, nofollow" />'."\r\n";
					}
				}
				
				
/****************** Для остального ***************/					
      }else{
				$wps_meta.='<title>'.wp_title($this->wpseauto_var['sep'], false, 'right').$titlhome.'</title>'."\r\n";
			}	
			
return $wps_meta;    
}

/****************** Вспомогательные функции ***************/
//Функция обработки title
function _wpseauto_titlpaged($titl='',$numpag='',$pref='',$titlpag='',$shema='',$titlhom=''){
	return trim($titl.str_replace(array('%npage%','%nsep%','%prefpag%','%titlcur%','%sep%','%tithom%','%blog_name%'), array($this->_wpseauto_numb($numpag),$this->wpseauto_var['nsep'],$pref,$titlpag,$this->wpseauto_var['sep'],$titlhom,get_bloginfo('name')),$shema));
}
function _wpseauto_titlnopaged($titl='',$pref='',$titlpag='',$shema='',$titlhom=''){
	$titlrun=trim(str_replace(array('%prefpag%','%titlcur%','%sep%','%tithom%','%blog_name%'), array($pref,$titlpag,$this->wpseauto_var['sep'],$titlhom,get_bloginfo('name')),$shema));
	return trim(str_replace(array('%npage%','%nsep%'),'',$titlrun));
}
//Функция формирования description в постраничке
function _wpseauto_descrpag(){
	global $posts;
	if(is_front_page() || is_home()) return $posts[0]->post_title.' '.$posts[1]->post_title.' '.$posts[2]->post_title.' '.$posts[3]->post_title;
	if(is_category()) return $posts[1]->post_title.' '.$posts[3]->post_title.' '.$posts[2]->post_title.' '.$posts[0]->post_title;
	if(is_tag()) return $posts[2]->post_title.' '.$posts[0]->post_title.' '.$posts[1]->post_title.' '.$posts[3]->post_title;
	if(is_archive()) return $posts[3]->post_title.' '.$posts[1]->post_title.' '.$posts[0]->post_title.' '.$posts[2]->post_title;
}
//Функция прописи числа
function _wpseauto_numb($num,$prefs=''){
  $md = floor($num/1e9);
  $m = floor(($num - $md*1e9)/1e6);
  $t = floor(($num - $md*1e9 - $m*1e6)/1e3);
  $h = floor($num - $md*1e9 - $m*1e6 - $t*1e3);
  $result = $this->_wpseauto_parsnum($md, array('один', 'два', 'миллиард', 'миллиарда', 'миллиардов'));
  $result .= ($result != '') ? ' ' : '';
  $result .= $this->_wpseauto_parsnum($m, array('один', 'два', 'миллион', 'миллиона', 'миллионов'));
  $result .= ($result != '') ? ' ' : '';
  $result .= $this->_wpseauto_parsnum($t, array('одна', 'две', 'тысяча', 'тысячи', 'тысяч'));
  $result .= ($result != '') ? ' ' : '';
	$result .= $this->_wpseauto_parsnum($h, array('один', 'два'));
  return trim($prefs.$result);
}
function _wpseauto_parsnum($num, $words){
  $hundreds = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
  $decads = array('двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
  $fdecads = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
  $ones = array('', $words[0], $words[1], 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять');
  $result = '';
  $h = floor($num / 100);
  $result .= $hundreds[$h];
  $d = floor(($num - $h * 100) / 10);
  $c = ($num - $h * 100 - $d*10);
  $result .= ($result != '') ? ' ' : '';
  if($d == 1) { $result .= $fdecads[$c]; }
    else {
      if($d > 1) $result .= $decads[$d-2] . ' ';
      $result .= $ones[$c];
    }
  $result .= ($result != '') ? ' ' : '';
  switch ($c) {
    case 1:
      $result .= ($d != 1) ? $words[2] : $words[4];
    break;
    case 2:
    case 3:
    case 4:
      $result .= ($d != 1) ? $words[3] : $words[4];
    break;
    default:
      if ($num > 0) { $result .= $words[4]; }
  }
  return $result;
}
}
new wpseauto();
?>