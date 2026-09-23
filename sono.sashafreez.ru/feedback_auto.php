<?php

/**
 * @author Igor Pavljutshenkov
 * @copyright 2011
 */
/*Название страницы*/
$title = 'Форма обратной связи';
/*Сюда впишите адрес почты, на который нужно отсылать результаты*/
$mailto = 'savina-olga07@mail.ru';
$mailtheme = 'Новый заказ через форму обратной связи.'; //Тема формы обратной связи
$headers = 'Content-type: text/html; charset=UTF-8 ' . "\r\n";
$headers .= 'From: Форма_обратной_связи' . "\r\n";
/*
Формат ввода:
НАЗВАНИЕ ЧЕГО УГОДНО (можно писать как угодно) => переменная=параметры_через_запятую[EOL]
Обратите внимание на [EOL] в конце строки!

Варианты значения переменной:
1. titul - заголовок блока, параметры не указываются (Пример: Заголовок=>titul[EOL])
2. text - Однострочное поле, в качестве параметров идут по порядку: длина(ОБЯЗАТЕЛЬНО), максимально допустимое количество символов для ввода(НЕОБЯЗАТЕЛЬНО, по умолчанию - не ограничено), обязательно\не обязательно (НЕОБЯЗАТЕЛЬНО, по умолчанию - не обязательно).
		  (
		  Пример однострочного текстового поля длиной 20, максимально допустимое количество символов 10, не обязательно для ввода:
		  Название => text=20,10[EOL]
		  Пример однострочного текстового поля длиной 20, максимально допустимое количество символов - не ограничено, обязательно для ввода:
		  Название => text=20,*[EOL]
		  Пример однострочного текстового поля длиной 20, максимально допустимое количество символов - 20, обязательно для ввода:
		  Название => text=20,20,*[EOL]
		  )
3. любое другое значение - будет расцениваться как пустая строка. Желательно употреблять так: =>[EOL]
*/
$text = <<<TEXT
Данные автомобиля 							=> titul[EOL]
Марка 										=> text=40,*[EOL]
Регистрационный знак 						=> text=40,*[EOL]
Идентификационный номер 					=> text=40,*[EOL]
Год выпуска 								=> text=4,4,*[EOL]
Двигатель 									=> text=40,*[EOL]
Кузов 										=> text=40,*[EOL]
Шасси 										=> text=40,*[EOL]
Цвет 										=> text=40,*[EOL]
Номер ПТС 									=> text=40,*[EOL]
Кем выдан ПТС 								=> text=40,*[EOL]
Когда выдан ПТС 							=> text=40,*[EOL]
Номер свидетельства о регистрации 			=> text=40,*[EOL]
Кем выдано свидетельство 					=> text=40,*[EOL]
Когда выдано свидетельство 					=> text=40,*[EOL]
Где стоит на учете (или не стоит) 			=> text=40,*[EOL]
 											=> [EOL]
Доверитель 									=> titul[EOL]
ФИО 										=> text=40,*[EOL]
Дата рождения 								=> text=40,*[EOL]
Номер паспорта 								=> text=40,*[EOL]
Кем выдан паспорт 							=> text=40,*[EOL]
Когда выдан паспорт 						=> text=40,*[EOL]
Место жительства (по паспорту) 				=> text=40,*[EOL]
 											=> [EOL]
Поверенный 									=> titul[EOL]
ФИО 										=> text=40,*[EOL]
Дата рождения 								=> text=40,*[EOL]
Номер паспорта 								=> text=40,*[EOL]
Кем выдан паспорт 							=> text=40,*[EOL]
Когда выдан паспорт 						=> text=40,*[EOL]
Место жительства (по паспорту) 				=> text=40,*[EOL]
 											=> [EOL]
ФИО контактного лица 						=> text=40,*[EOL]
Телефон 									=> text=40,*[EOL]
Е-mail 										=> text=40,*[EOL]
Время и день посещения нотариальной конторы	=> text=40,*
TEXT;

$array = explode('[EOL]', $text);
for ($i=0; $i<count($array); $i++) {
	$array[$i] = explode('=>',$array[$i]);
	for($k=0; $k<count($array[$i]); $k++) {
		$array[$i][$k] = trim($array[$i][$k]);
	}
}
function translit($str) 
{
    $tr = array(
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
        "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
        "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
		" "=>"_", ","=>"_", "("=>"", ")"=>"", "*"=>"",
		"!"=>"", "@"=>"", "#"=>"", "$"=>"", "%"=>"", 
		"^"=>"", "&"=>"", "<"=>"", ">"=>"", "."=>"",
		"/"=>"", "?"=>"", "`"=>"", "~"=>"", "\\"=>"",
		"|"=>"", "\""=>"", "'"=>"", "-"=>"", "+"=>""
    );
    return strtr($str,$tr);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?=$title;?></title>
</head>
<body style="margin:0; padding:0;">
<style>
div {width:600px; margin:0 auto;}
table {border: 5px double black;}
td.f_title {text-align: center; font-weight: bolder; line-height:16px; border-bottom:1px solid black;}
td.f_name {padding: 5px; width:300px;}
td.f_form {padding: 5px;}
td.f_spacer {height:5px;}
td.submit {text-align:center;}
td.submit input {width:400px;}
</style>
<div>
<?
if (!empty($_POST) && isset($_GET["post"])) {
/* Начало обработки формы */
	$message='';
	$result = array();
	for ($i=0; $i<count($array); $i++) {
		$key = $array[$i][0];
		$arr = $array[$i][1];
		if ($arr == 'titul') {array_push($result, '<b><u>'.$key.'</u></b>');}
		elseif ($arr == '') {array_push($result, '');}
		else {
			foreach ($_POST as $keyp=>$arrp) {
				if (translit($key).$i == $keyp) {
					if (preg_match('/\*/', $arr)) {
						if (strlen(trim($arrp))<1) {echo '<center>Не заполнено обязательное поле <u><b>'.$key.'</b></u><br /><a href="javascript:history.back();">Заполнить форму еще раз</a></center>'; die();}
					}
					array_push($result, $key.': '.$arrp);
				}
			}
		}
	}
	for ($i=0; $i<count($result); $i++) {
		$message.=$result[$i].PHP_EOL;
	}
	if (!mail($mailto, $mailtheme, nl2br($message), $headers)) {
		echo '<b style="font-size:14px; color:red;"><u>К сожалению, сообщение не отправлено. <a href="javascript:history.back();">Попробуйте еще раз.</a></u></b><br />'; die();} else {echo '<b style="font-size:14px; color:red;">Сообщение отправлено!</b><br />';
	}
	echo nl2br($message);
/* Конец обработки формы */
} else {
/* Начало вывода формы */
echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">'."\n";
echo '<form action="'.$_SERVER['PHP_SELF'].'?post" method="post">'."\n";
for($j=0; $j<count($array); $j++) {
	$key = $array[$j][1];
	$value = $array[$j][0];
	if ($key == 'titul') {echo "<tr><td colspan='2' class='f_title'>$value</td></tr>\n";}
	else if (preg_match('/^(text)/', $key)) {
		$param = substr($key,strpos($key,'=')+1);
		if (strpos($param, ',') > 0) {$keyarr = explode(',',$param); if(count($keyarr)==2) {$keyarr[2]='';}}
		else {unset($keyarr); $keyarr[0] = $param; $keyarr[1]=$keyarr[2]='';}
		echo "<tr><td class='f_name'>$value: ";
		if ($keyarr[1] == '*' || $keyarr[2] == '*') {echo "*";}
		echo "</td><td class='f_form'><input type='text' name='".translit($value).$j."' size='".$keyarr[0]."' "; 
		if (intval($keyarr[1]) > 0) {echo "maxlength='".$keyarr[1]."' ";} 
		echo" /></td></tr>\n";
	}
	else {echo "<tr><td colspan='2' class='f_spacer'>&nbsp;</td></tr>\n";}
}
echo '<tr><td colspan="2" class="submit"><input type="submit" name="submit" value="Отправить"/></td></tr>';
echo '</form>'."\n";
echo '</table>';
/* Конец вывода формы */
}?>
</div>
</body>
</html>