<? include ($_SERVER[DOCUMENT_ROOT]."/templates/header.php") ?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/inner.php") ?>
<table border="0" cellspacing="0" cellpadding="0" align="center">

		<tr>		
	<?$dbars = new DB($dbhost, $basename, $dbuser, $dbpass);
	echo spisok_kvartir_all(730,1,4,$street,$houseno,$region);
	echo spisok_kvartir_all(730,2,4,$street,$houseno,$region);
	echo spisok_kvartir_all(730,3,4,$street,$houseno,$region);
	?>
</tr></table><br>
<table border="0" cellspacing="0" cellpadding="0" align="center"><tr> <td width="479" align="left" valign="top" class="style24">
<div style="font-size:14px;">Реализация осуществляется в соответствии с 214-ФЗ<br><br> 
<!--	<span style="color: red"><strong>Акция: беспроцентная рассрочка до июля 2013 г.</strong><br> <em>(при покупке квартир до 01 мая 2013г.)</em><br>                             

</span><br><br> -->
<span style="color: red"><b> Акция от Сбербанка.</b></span> Специальная акция. Первоначальный взнос от 12%, срок кредита до 12 лет (включительно), ставка 12% на весь период. <br><br> 


<span style="color: red"><b> Акция от банка Возрождение.</b></span> "Квартира-Новостройка 2013". Первоначальный взнос от 11%, срок кредита до 15 лет (включительно), ставка 13% на весь период.<br><br> 
	<span style="color:#4F83C4;">Ипотека:<br> 
	Сбербанк<br>
Банк "Возрождение"  
</span>
</div>	<br><br>
</td></tr></table>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/inner_r.php") ?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/footer.php") ?>