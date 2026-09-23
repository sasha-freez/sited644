<? include ($_SERVER[DOCUMENT_ROOT]."/templates/header.php") ?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/inner.php") ?>
<?	
$id=$_GET[id];	
$address = 'Говорова, мкр. 5а, корп. 34';	
$dbars = new DB($dbhost, $basename, $dbuser, $dbpass);	
$sql_spisok="SELECT * FROM dbars_new1 where id=".$id;
$spisok = $dbars->queryOneRecord($sql_spisok);

$sql_all_from_newflat='select * from reserve where id_room='.$id.' and res=""';
$all_from_newflat=$dbars->queryOneRecord($sql_all_from_newflat);

$floor = $spisok['floor'];
	$number_rooms = $spisok['rooms'];
	$sqr = $spisok['allsqr'];
	$price_all = number_format($spisok['price']*1000, 0, '', '\'');
	$price=number_format($spisok['price']*1000/$spisok['allsqr'], 0, '', '\'');
	$needle_len = strlen(',');
	$position_num = strpos($spisok['havephone'],',') + $needle_len;
	$number_on_floor = substr($spisok['havephone'],$position_num,1);
	
    $position_num2 = strpos($spisok['havephone'],',');
	$number_flat = substr($spisok['havephone'],0,$position_num2);
	
	$needle_len1 = strlen('сек.');
	$position_num1 = strpos($spisok['havephone'],'сек.') + $needle_len1;
	$entrance = substr($spisok['havephone'],$position_num1,1);
?>
<div class="style24">
<div class="b_room">
	<div class="p_left">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rt">
			<tr>
				<th height="25" colspan="2"><a href="/govorova34/flat/shahmatka.php">Вернуться к выбору квартиры &gt;&gt;</a></th>
			</tr>
			<tr>
				<th height="30" colspan="2">Описание квартиры</th>
			</tr>
			<tr>
				<td bgcolor="#E4E4E4" class="rt_1">Кол-во комнат</td>
				<td bgcolor="#E4E4E4" class="rt_2"><?=$number_rooms;?></td>
			</tr>
			<tr>
				<td bgcolor="#FFFFFF" class="rt_1">Площадь общая</td>
				<td bgcolor="#FFFFFF" class="rt_2"><?=$sqr;?> кв. м *</td>
			</tr>
			<tr>
				<td bgcolor="#E4E4E4" class="rt_1">Цена общая</td>
				<td bgcolor="#E4E4E4" class="rt_2"><?=$price_all;?> руб.</td>
			</tr>
			<tr>
				<td bgcolor="#FFFFFF" class="rt_1">Цена кв.м.</td>
				<td bgcolor="#FFFFFF" class="rt_2"><?=$price;?> руб.</td>
			</tr>
			<tr>
				<td bgcolor="#E4E4E4" class="rt_1">Этаж </td>
				<td bgcolor="#E4E4E4" class="rt_2"><?=$floor;?></td>
			</tr>
			<tr>
				<td bgcolor="#FFFFFF" class="rt_1">Секция</td>
				<td bgcolor="#FFFFFF" class="rt_2"><?=$entrance;?></td>
			</tr>
			<tr>
				<td bgcolor="#E4E4E4" class="rt_1">Номер на площадке</td>
				<td bgcolor="#E4E4E4" class="rt_2"><?=$number_on_floor;?></td>
			</tr>
			<tr>
				<td bgcolor="#FFFFFF" class="rt_1">Номер квартиры</td>
				<td bgcolor="#FFFFFF" class="rt_2"><?=$number_flat;?></td>
			</tr>
			<tr>
			<td bgcolor="#E4E4E4" class="rt_1">Статус</td>
			<? if ($all_from_newflat['id_room'] and $all_from_newflat['res']=='' or $number_flat == 239) { ?>
			<td bgcolor="#E4E4E4" class="rt_2">забронирована</td> 
			<? } else {  $check = 1; ?>
			<td bgcolor="#E4E4E4" class="rt_2">cвободна</td>
			<? } ?>
		</tr>
		</table>
		<? if($check==1){ ?>
		<div class="style2">Забронировать</div>
		
		<form action="/govorova34/flat/database.php" method="POST" name="reserveform" onsubmit="return validate_form();">
			<table width="224" border="0" >
			<tr align="left">
			<td class="style24">* ФИО<br>
				<input type="hidden" name="id" value="<?=$id;?>">
				<input type="hidden" name="id_room_z" value="<?=$id;?>">
				<input type="hidden" name="number_flat" value="<?=$number_flat;?>">
				<input type="hidden" name="address" value="<?=$address;?>">
				<input type="text" name="name" size="26">
			</td>
			</tr>
			<tr align="left"><td class="style24">E-mail<br>
				<input type="text" name="email" size="26">
			</td>
			</tr>
			<tr align="left">
			<td class="style24">
				* Телефон<br>
				<input type="text" name="phone" size="26">
			</td>
			</tr>
			<tr align="left">
				<td class="style24">Комментарии<br>
				<textarea name="comments"></textarea></td>
			</tr>
			<tr align="left">
				<td class="style24">Введите код,<br> который вы видите на картинке<br>
				<input type="text" name="keystring"><br><br>
				<img src="/kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>">
			</td>
			</tr>
			<tr align="left">
				<td class="style24">
					Знаком * отмечены поля, обязательные для заполнения
					<input type="submit" name="submit" value="Отправить" >
					<input type="reset" value="Сброс" >
				</td>
			</tr>
			</table>
			* Площадь указана по БТИ
		</form>
		<? } ?>
	</div>
	<div class="p_right">
		<?
		if ($entrance==2 and (1<$floor and $floor<21)) {
		$entrance = "2";
		}
		elseif ($entrance==2 and (21<=$floor and $floor<24)) {
		$entrance = "2_21";
		}
		elseif ($entrance==2 and (24<=$floor and $floor<=25)) {
		$entrance = "2_25";
		} 
		?>						
		<img src="/govorova34/images/newplan/<?=$entrance;?>_<?=$number_on_floor;?>.jpg" />
	</div>
</div>
</div>

<? include ($_SERVER[DOCUMENT_ROOT]."/templates/inner_r.php") ?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/footer.php") ?>