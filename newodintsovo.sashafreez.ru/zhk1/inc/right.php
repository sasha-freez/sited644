<?

$form_ok=''; $fname=''; $fphone=''; $fmail=''; $fmess=''; $message='';
if(isset($_POST['name'])) {
$today = date("d.m.y");
//$to  = "a9055050742@gmail.com,odinfirst@gmail.com 5079798@gmail.com,svp81@mail.ru,89031381534@rambler.ru,bron@newodintsovo.ru";
$to  ="sashafree@gmail.com, sansog@yandex.ru";
$subject = 'Заявка с сайта newodintsovo.ru/zhk_rublevskiy'; // тема сообщения

$headers  = "Content-type: text/html; charset=win-1241 \r\n"; // кодировка
$headers .= "From: info@zhk-rublevskiy.ru \r\n"; // от кого
//$headers .= "Bcc: birthday-archive@example.com\r\n"; // скрытые поля


//$subject="=?win-1241?B?".base64_encode($emailsubject)."?=\r\n";
$message="=?win-1241?B?".base64_encode($message)."?=\r\n";
$subject="=?win-1241?B?".base64_encode($subject)."?=\r\n";

//$headers="=?win-1241?B?".base64_encode($emailsubject)."?=\r\n";

if($_POST['check'] == 1) {
$check_title='Форма "Заказать просмотр"';
}else if($_POST['check'] == 2){
$check_title='Форма "Задать вопросы менеджеру"';
}else if($_POST['check'] == 3){
$check_title='Форма "Оставьте заявку"';
}

if(isset($_POST['name'])){
	$fname ='<p><b>Имя:</b> '.$_POST['name'].'</p>';
};
if(isset($_POST['phone'])){
	$fphone ='<p><b>Телефон:</b> '.$_POST['phone'].'</p>';
};
if(isset($_POST['mail'])){
	$fmail ='<p><b>Email:</b> '.$_POST['mail'].'</p>';
};
if(isset($_POST['mess'])){
	$fmess ='<p><b>Сообщение:</b> '.$_POST['mess'].'</p>';
};

//print_r('test');
$form_ok='
<div class="form_popup" style="display:block; margin-top:-90px;"><a class="close"></a>
	<p><b>Спасибо за заявку,<br/> в ближайшее время с Вами<br/> свяжется наш сотрудник.</b></p>
</div>
';


$message = '
<h3>'.$check_title.'</h3>
'.$fname.'
'.$fphone.'
'.$fmail.'
'.$fmess.'


';

//sprintf($to, $subject, $message, $headers);

}

?>
<? echo $form_ok; ?>
<div class="bl_right">
	<div class="form form1">
		<form action="" method="post">
			<input name="check" type="hidden" value="1" />
			<div class="title">
				Представитель на объекте:<br/>
				<span>Андрей <b>+7-962-369-20-73</b></span>
			</div>
			<div class="input name"><span class="icon"></span>
				<input name="name" type="text" value="Введите имя: *" onblur="if(this.value=='') this.value='Введите имя: *';" onfocus="if(this.value=='Введите имя: *') this.value='';" />
			</div>
			<div class="input phone"><span class="icon"></span>
				<input name="phone" type="text" value="Введите телефон: *" onblur="if(this.value=='') this.value='Введите телефон: *';" onfocus="if(this.value=='Введите телефон: *') this.value='';" />
			</div>
			<div class="input mail"><span class="icon"></span>
				<input name="mail" type="text" value="Введите E-mail: *" onblur="if(this.value=='') this.value='Введите E-mail: *';" onfocus="if(this.value=='Введите E-mail: *') this.value='';" />
			</div>

			<div class="infos">
				Ваши контактные данные<br/>
				в безопасности и не будут переданы
				третьим лицам
			</div>
			<a class="btn btn-small" onclick="$(this).closest('form').submit();">Оставьте заявку</a>
		</form>
	</div>

	<!--
	<div class="gal-list">
		<h2>Фотографии объекта</h2>
	</div>
	-->
</div>