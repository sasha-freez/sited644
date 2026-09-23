<?php

if(isset($_POST['action']) && $_POST['action']=='subscribe' && !empty($_POST['mail']) && empty($_POST['fio'])) {
	$message='';
	$to  = "pr@modernrock.ru";
	$subject = 'Заявка c формы подписки modernrock.ru'; // тема сообщения

	$headers  = "Content-type: text/html; charset=utf-8 \r\n"; // кодировка
	$headers .= "From: pr@modernrock.ru \r\n"; // от кого
	//$headers .= "Bcc: info@me-english.ru\r\n"; // скрытые поля

	$message="=?utf-8?B?".base64_encode($message)."?=\r\n";
	$subject="=?utf-8?B?".base64_encode($subject)."?=\r\n";

	if(isset($_POST['mail'])){
		$fmail ='<p><b>Email:</b> '.$_POST['mail'].'</p>';
	};
	$_SESSION['subscribe']=$_POST['action'];
	$message = '
		<div class="h2">Подписавшийся пользователь:</div>
		'.$fmail.'
	';
	sprintf($to, $subject, $message, $headers);
	
	echo '
		<div class="subsform">
			<p class="red">Спасибо за подписку!</p>
		</div>
	';
}else{
	$subscribe = (isset($_SESSION['subscribe']) ? $_SESSION['subscribe'] : null );
	
	if($subscribe != 'subscribe'){
		echo '
			<div class="subsform">
				<div class="h3">ПОДПИСКА НА НОВОСТИ</div>
				<form id="subscribe" name="subscribe" method="POST">
					<input type="hidden" name="action" class="hide" value="subscribe"/>
					<input type="text" class="hide" value="" name="fio"/>
					<span class="input"><input type="text" placeholder="E-mail" value="" class="inp" id="mail" name="mail"/></span>
					<button class="submit">Подписаться</button>
				</form>
			</div>
		';
	}
}
