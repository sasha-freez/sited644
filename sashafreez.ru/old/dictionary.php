<?php

	//собираем массив автозамен из общего удаленного файла
	/*$csv_handle = fopen('http://www.litres.ru/static/ds/sangalov/litres_replacements.csv','rb');
	while (($data = fgetcsv($csv_handle, 1000, ";")) !== false) {
		$data[0] = mb_convert_encoding($data[0],'utf8','cp1251');
		$data[1] = mb_convert_encoding($data[1],'utf8','cp1251');
		$data[2] = mb_convert_encoding($data[2],'utf8','cp1251');
		if ($data[0] == 'автор'){
			$repl_auth_ar[$data[1]] = $data[2];
		}
		else{
			$repl_ar[$data[1]] = $data[2];
		}
		unset($data);
	}
	fclose($csv_handle);*/
	
	$repl_auth_ar['Микаловиц'] = 'Михаловиц';
	$repl_auth_ar['Литвиновы'] = 'Литвинов';
	$repl_auth_ar['ё'] = 'е';
	
	$repl_ar['(сборник)'] = '';
	$repl_ar['(Сборник)'] = '';
	$repl_ar['ё'] = 'е';
	
	$repl_ar['Танец Огня'] = 'Испытание огня';
	$repl_ar['Сладость на корочке пирога'] = 'Загадки Флавии де Люс';
	$repl_ar['Игрушка императора'] = 'Телохранитель для демона';

	

	
	
?>