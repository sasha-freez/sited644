<? 
$data = file_get_contents('http://samoletgroup.ru/assets/js/data.json');
$houses_arr = json_decode($data,true);


/* Из объекта в массив */
function objectToArray($d) {
	if (is_object($d)) {
		$d = get_object_vars($d);
	}
	if (is_array($d)) {
		return array_map(__FUNCTION__, $d);
	}
	else {
		return $d;
	}
}
//$houses_arr = objectToArray($houses_obj);

/* перебор массива и вывод квартир */
echo '
<style>
.list_houses{border-collapse:collapse; margin:0; padding:0;}
.list_houses td{border:1px solid #000; padding:2px 5px;}
.list_houses .thead td{font-weight:bold;}
</style>
<table class="list_houses" border="0" width="100%">
<tr class="thead">
	<td data-targ="b" class="r_korp">Корпус<i></i></td>
	<td data-targ="s" class="r_sect">Секция<i></i></td>
	<td data-targ="f" class="r_floor">Этаж<i></i></td>
	<td data-targ="n" class="r_num">Номер<i></i></td>
	<td data-targ="rc" class="r_rooms">Комнат<i></i></td>
	<td data-targ="sq" class="r_square">Площадь, м<sup>2</sup><i></i></td>
	<td data-targ="tc" class="r_price">Цена, руб.<i></i></td>
</tr>
';
foreach ($houses_arr["apartments"] as $house){
	if($house["st"]==1){
		echo '
			<tr>
				<td data-targ="b" class="r_korp">'.$house["b"].'<i></i></td>
				<td data-targ="s" class="r_sect">'.$house["s"].'<i></i></td>
				<td data-targ="f" class="r_floor">'.$house["f"].'<i></i></td>
				<td data-targ="n" class="r_num">'.$house["n"].'<i></i></td>
				<td data-targ="rc" class="r_rooms">'.$house["rc"].'<i></i></td>
				<td data-targ="sq" class="r_square">'.$house["sq"].'<i></i></td>
				<td data-targ="tc" class="r_price">'.$house["tc"].'<i></i></td>
			</tr>
		';
	}
}
echo '</table>';




//print_r($houses_arr);

/*
$result = array();
foreach ($houses_obj as $key => $value) {
    $result[] = $value->apartments;
}
print_r($result);
*/


//print_r($houses_arr);

/*
$houses = array(
    '�������'  => 'avstriya_field',
    '��������' => 'german_field',
    // ...
);
 
$fields = array();
foreach ($hfytt as $item) {
    $fields[] = ($houses[$item->name]);
}
print_r($fields);

*/

/* */



/*
   [b] => 8
    [s] => 5
    [f] => 12
    [n] => 401
    [rc] => 1
    [sq] => 37
    [cpm] => 76900
    [tc] => 2845300
    [st] => 0
$result = array();
foreach ($post_id as $key => $value) {
    $result[] = $value->post_id;
}
print_r($result);
 */
?>