<? header("HTTP/1.1 404 Not Found");
include ($_SERVER[DOCUMENT_ROOT]."/templates/header.php"); ?>
<div class="content">
	<div class="container">
		<h1>404 ОШИБКА</h1>
		<p>К сожалению, запрошенный Вами документ не существует. 

		<p>Возможно, Вы ошиблись при написании адреса или данная страница уже удалена с сервера. 
		<p>Пожалуйста, начните просмотр с <a href="/">главной страницы</a> для получения интересующей Вас информации. 
	</div>
</div>

<? include ($_SERVER[DOCUMENT_ROOT]."/templates/footer.php"); ?>
