<?php

	ini_set('error_reporting', E_ALL);
	ini_set ('display_errors', 1);
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	ini_set("mysql.trace_mode","On");

	ini_set('memory_limit', '1600M');
	ini_set('max_execution_time','1200');
	ini_set('mysql.connect_timeout', 1000);
	
	include("config.php");
	include("functions.php");
	
	//index_local_data();
	

	//электронные книги
	//синтаксис compare_local_global($book_type,$add_type0_links_to_type1);
	
	//электронные книги
	//compare_local_global(0,false);
	
	//электронные книги pdf
	//compare_local_global(4,false);
	
	//аудиокниги
	compare_local_global(1);
	
	//аудиокнигам, которых нет в литрес добавляем ссылки на обычные книги вырезая пиратские ссылки
	//compare_local_global(0,true);
	
	//электронные авторы
	//compare_local_global_authors(0);
	
	//аудио авторы
	//compare_local_global_authors(1);
	
	//электронные книги, сопоставленные вручную
	//compare_local_global_manual(0);
	
	echo 'finished';
	
	//update dle_post, dle_post_original set dle_post.full_story=dle_post_original.full_story, dle_post.xfields=dle_post_original.xfields where dle_post.id=dle_post_original.id and dle_post.id=33687 

?>