<? include ($_SERVER[DOCUMENT_ROOT]."/zhk-pervyj/inc/header_in.php") ?>
<table width="799" border="0" cellspacing="0" cellpadding="0">

          <tr>
            <th width="52" scope="col">&nbsp;</th>
            <td width="720" align="left" valign="top" class="style24">
<?			
$dbars = new DB($dbhost, $basename, $dbuser, $dbpass);	
$sql_all_from_newflat="select * from newflat where id='604'"; 
$all_from_newflat=$dbars->queryOneRecord($sql_all_from_newflat);

$street=$all_from_newflat['street'];
$houseno=$all_from_newflat['houseno'];
$region=$all_from_newflat['region'];

//Выстановление переменных по умолчанию
if (!$limit) $limit=150;
if (!$page) $page=0;
if (!$sort) $sort='pricem';
$sql_spisok="SELECT *, (price*1000/allsqr) as pricem FROM dbars_new1 where region='$region' and street='$street' and houseno like '$houseno%' order by price limit ".$page*$limit.", $limit";
	$spisok = $dbars->queryAllRecords($sql_spisok);
	

?>
<table width="100%" border="0"  cellspacing="0" cellpadding="0" class="ins">
										
											<tr align="center"><!-- <td class="ins">Секция</td> -->
												<td class="ins">Этаж</td>
												
												<td class="ins">Кол-во комнат</td>
												<td class="ins">Площадь, кв. м</td>
												
											<td class="ins">Стоимость квартиры</td>
											</tr>
<?											
for($i=0; @$spisok[$i]; $i++) {
	
	$floor = $spisok[$i]['floor'];
	$number_rooms = $spisok[$i]['rooms'];
	$sqr = $spisok[$i]['allsqr'];
	$price = number_format($spisok[$i]['price']*1000, 0, '', '\'');
	echo "<tr align='center'>
												<td class='ins'>".$floor."</td>
												
												
												<td class='ins'>".$number_rooms."</td>
												<td class='ins'>".$sqr."</td>
												
											<td class='ins'>".$price." руб.</td>
											</tr>";
}
?>	
</table> 
          </td>
            <th width="27" scope="col">&nbsp;</th>
          </tr>
        </table> 
		
		

		
		
		
		
<? include ($_SERVER[DOCUMENT_ROOT]."/zhk-pervyj/inc/footer.php"); ?>