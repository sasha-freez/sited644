<? include ($_SERVER[DOCUMENT_ROOT]."/templates/header.php") ?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/inner.php") ?>
<?

if ($_SERVER[REQUEST_METHOD]=="POST") {
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']){
		// Выполняем необходимые действия с данными
		//$to="sasha-freez@mail.ru";
		//$to="vaelle@a-h.ru";
		$to  = "a9055050742@gmail.com,odinfirst@gmail.com 5079798@gmail.com,svp81@mail.ru,89031381534@rambler.ru,bron@newodintsovo.ru";
		$headers .= "From: noreply@newodentsovo.ru\n";
		$headers .= "X-Sender: NewOdintsovoRU\n"; 
		$headers .= "X-Mailer: PHP\n";
		//$headers .= "Return-Path: <mayer@arsenal-holding.ru>\n";
		$headers .= "Content-Type: text; charset=Windows-1251\n";

		foreach ($_POST as $key => $value) {
		$text .= "$key = $value \n";
		}

		$subj='newodintsovo.ru - Заявка на бронирование квартиры №'.$_POST['number_flat'].' '.$_POST['address'].'';
		sprintf($to,$subj,$text,$headers);
		//echo $to.'<br>';
		//echo $subj.'<br>';
		//echo $text.'<br>';
		//echo $headers.'<br>';

		echo '<p align="center" style="font-size: 10pt;"><strong>Ваша заявка на бронирование квартиры №'.$_POST['number_flat'].' принята.<br/>В ближайшее время менеджер свяжется с Вами.</strong><br/><br/>
		<a href="/govorova34/">Вернуться к описанию квартиры</a>';
		
		$dbars = new DB($dbhost, $basename, $dbuser, $dbpass);
		$sql="insert into reserve (id,id_room,address,name,email,phone,date,comments) VALUES ";
		$sql .= "(Null, '".$_POST['id_room_z']."', '".$_POST['address']."', '".$_POST['name']."', '".$_POST['email']."',  '".$_POST['phone']."','".date("Y-m-d H:i:s")."', '".$_POST['comments']."')";
		$all=$dbars->queryOneRecord($sql);

	}else {
		echo "<p align=\"center\" style=\"font-size: 10pt;\" style=\"color:#ff0000\"><strong>Число с картинки введено неверно!</strong></strong>";

	}
}
?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/inner_r.php") ?>
<? include ($_SERVER[DOCUMENT_ROOT]."/templates/footer.php") ?>