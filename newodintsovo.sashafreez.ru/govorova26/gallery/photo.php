<? include ($_SERVER[DOCUMENT_ROOT]."/templates/header.php") ?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/inner.php") ?>

<? 
	$dbars = new DB($dbhost, $basename, $dbuser, $dbpass);
$sql_all_from_newflat="select * from newflat where id='575'"; 
$all_from_newflat=$dbars->queryOneRecord($sql_all_from_newflat);

$street=$all_from_newflat['street'];
$houseno=$all_from_newflat['houseno'];
$region=$all_from_newflat['region'];
$photo=$all_from_newflat['photo'];

$sql_all_from_dbars1="select * from dbars_new1 where kind=2 and region='$region' and street='$street' and houseno like ('$houseno%')";
$all_from_dbars1=$dbars->queryAllRecords($sql_all_from_dbars1);
if (!$all_from_dbars1) header('Location: http://www.arsenal-holding.ru/newflat_not_found.php');


if ($oblast==0) {
$addres=' '.$street.', '.$houseno;
$addres_w_link='<a href="show_flats.php?id='.$id.'">'.$street.', '.$houseno.'</a> - Ñץולא ןנמוחהא';
}
else {
$addres=' '.$region.', '.$street.', '.$houseno;
$addres_w_link='<a href="show_flats.php?id='.$id.'">'.$region.', '.$street.', '.$houseno.'</a> - Ñץולא ןנמוחהא';
}
?>
<!-- <script>
function photoview(what, w, width, height) 
{
  w.open(what,'','width='+width+',height='+height+',status=no,resizable=no,scrollbars=yes,toolbar=no,top=10,left=10');
}
</script> -->

<div class="style24">
<? 
		$temp_arr=unserialize($photo);
		$temp_arr=array_reverse($temp_arr);
		echo '<table border="0" cellspacing="2" cellpadding="2">';
		$i=0;
		foreach($temp_arr as $v) {
		$pos=strpos($v,"|");
		$pos1=$pos+1;
			if (($i!=0) and (($i%2)==0)) echo '</tr><tr >';
		 echo '<td align="center" valign="middle"><img src="http://arsenal-holding.ru/houses/1/images/'.substr($v,0,$pos).'" alt="" border="0">
<br>'.substr($v,$pos1).'
</td>';
		 $i++;
		 }
		 echo'</table>';
?>
</div>
	
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/inner_r.php") ?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/footer.php") ?>