<?php
	
	require_once __DIR__ . '/../../../wp-config.php';

	$db_link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	mysqli_query($db_link, 'SET NAMES utf8');
	
	$partner_id = 0;                     // Получить в Литрес
	$partner_utm_source = 'here source'; // Укажите идентификатор вашей площадки. Скопировать его вы можете https://affiliate.litres.ru/websites.
	$partner_utm_erid = 'here erid';     // Токен можно получить у оператора рекламных данных (ОРД).
	$partner_utm_oid = 't5fecnyyw';      // Укажите id оффера (алиас). Для этого выберете нужный оффер https://affiliate.litres.ru/offers/?status=1&amp;limit=12&amp;currentPage=1&amp;order=order" и скопируйте его из меню в поле “id”.
	$partner_utm_sub = '';               // Дополнительная сегментация. Идентификатор, используйте для разделения статистики площадки на дополнительные срезы. Не более 16 символов.
	$partner_utm_sub2 = '';              // Дополнительная сегментация2
	$partner_utm_sub3 = '';              // Дополнительная сегментация3
	$partner_utm_sub4 = '';              // Дополнительная сегментация4
	$partner_utm_sub5 = '';              // Дополнительная сегментация5
	$partner_utm_list = '';              // utm метки в виде get параметров

	$partner_file_parts_id = 0;
	$partner_a_id = 0;                  // для совпадений только по автору
	$ftp_server = "";
	$ftp_user_name = '';
	$ftp_user_pass = '';
	
	// Собираем utm метки
	if (!empty($partner_utm_source)) {
		$partner_utm_list.= 'utm_source='.$partner_utm_source;
	}
		$partner_utm_list.= '&utm_medium=cpa_partner';

	if (!empty($partner_utm_oid)) {
		$partner_utm_list.= 'oid='.$partner_utm_oid;
	}
	
	if (!empty($partner_utm_source)) {
		$partner_utm_list.= 'wid='.$partner_utm_source;
	}
	if (!empty($partner_utm_sub)) {
		$partner_utm_list.= 'sub='.$partner_utm_sub;
	}
	if (!empty($partner_utm_sub2)) {
		$partner_utm_list.= 'sub2='.$partner_utm_sub2;
	}
	if (!empty($partner_utm_sub3)) {
		$partner_utm_list.= 'sub3='.$partner_utm_sub3;
	}
	if (!empty($partner_utm_sub4)) {
		$partner_utm_list.= 'sub4='.$partner_utm_sub4;
	}
	if (!empty($partner_utm_sub5)) {
		$partner_utm_list.= 'sub5='.$partner_utm_sub5;
	}
	if (!empty($partner_utm_erid)) {
		$partner_utm_list.= 'erid='.$partner_utm_erid;
	}
?>