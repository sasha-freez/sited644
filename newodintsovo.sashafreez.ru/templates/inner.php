<div class="content">
	<div class="container">
		<div class="section_name">
			<? if (stristr($_SERVER[REQUEST_URI],'zhk-pervyj')) {
				echo '<div class="big">ЖК Первый</div>';
			}
			elseif ($_SERVER[PHP_SELF] == '/govorova34/comm/index.php') {
					echo '<div class="big">МОЖАЙСКОЕ Ш., мкр. 5а</div>';
			}
			elseif (stristr($_SERVER[REQUEST_URI],'govorova34')) {
				echo '<div class="big">МОЖАЙСКОЕ Ш., мкр. 5а, к. 169</div>';
			}
			elseif (stristr($_SERVER[REQUEST_URI],'govorova31')) {
				echo '<div class="big">МОЖАЙСКОЕ Ш., мкр. 5а, к. 165</div>';
			}
			elseif (stristr($_SERVER[REQUEST_URI],'sadovaya16')) {
				echo '<a href="/sadovaya16/" class="menu_logo"><img src="/zhk-pervyj/images/16.gif" alt="Cадовая ул., мкр.2, к.16" title="Cадовая ул., мкр.2, к.16" border="0"></a>';
			}
			elseif (stristr($_SERVER[REQUEST_URI],'govorova26')) {
				echo '<a href="/govorova26/" class="menu_logo"><img src="/zhk-pervyj/images/26.gif" alt="Говорова, мкр.5а, д.26А" title="Говорова, мкр.5а, д.26А" border="0"></a>';
			}
			elseif (stristr($_SERVER[REQUEST_URI],'govorova52')) {
				echo '<a href="/govorova52/" class="menu_logo"><img src="/zhk-pervyj/images/52.gif" alt="Говорова, мкр.5а, д.26А" title="Говорова, мкр.5а, д.52" border="0"></a>';
			}
			elseif (stristr($_SERVER[REQUEST_URI],'skolkovo')) {
				echo '<a href="/skolkovo/" class="menu_logo"><img src="/zhk-pervyj/images/skl.gif" alt="п. Заречье, д. 1" title="п. Заречье, д. 1" border="0"></a>';
			}
			?>
		</div>
		
		<div class="c_menu">
			<? if (stristr($_SERVER[REQUEST_URI],'zhk-pervyj')) {?>
			<ul>
				<li class="m1">
					<a href="http://newodintsovo.ru/zhk-pervyj/object/description.php">ОБ ОБЪЕКТЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/object/description.php">ОПИСАНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/object/position.php">РАСПОЛОЖЕНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/object/infrastructure.php">ИНФРАСТРУКТУРА </a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/object/planirovki.php">ПЛАНИРОВКИ</a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/object/teh_harakteristiki.php">ТЕХ.&nbsp;ХАРАКТЕРИСТИКИ</a></li>
					</ul>
				</li>
				<li class="m2">
					<a href="http://newodintsovo.ru/zhk-pervyj/flat/shahmatka.php" class="hot">КВАРТИРЫ В ПРОДАЖЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/flat/shahmatka.php">ШАХМАТКА ДОМА</a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/flat/spisok.php">СПИСОК КВАРТИР</a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/docs/negiloe.php">НЕЖИЛЫЕ ПОМЕЩЕНИЯ</a></li>
					</ul>
				</li>
				<li class="m3">
					<a href="http://newodintsovo.ru/zhk-pervyj/gallery/3d.php">ГАЛЕРЕЯ ОБЪЕКТА</a>
					<ul>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/gallery/3d.php">3D МОДЕЛИ</a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/gallery/photo.php">ФОТОГРАФИИ СТРОЙКИ</a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/gallery/photo_pan.php">ПАНОРАМНЫЕ ВИДЫ</a></li>
					</ul>
				</li>
				
				<li class="m4">
					<a href="http://newodintsovo.ru/zhk-pervyj/docs/ipoteka.php">ДОКУМЕНТАЦИЯ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/object/planirovochnye-reshenija.php" class="red">ПЛАНИРОВОЧНЫЕ РЕШЕНИЯ</a></li>
						<li><a href="http://newodintsovo.ru/zhk-pervyj/docs/ipoteka.php">ИПОТЕКА</a></li>
					</ul>
				</li>
				<li class="m5">
					<a href="http://newodintsovo.ru/contacts/index.php">КОНТАКТЫ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/contacts/index.php">КООРДИНАТЫ</a></li>
						<li><a href="http://newodintsovo.ru/contacts/map.php">ОБЪЕКТЫ НА КАРТЕ</a></li>
					</ul>
				</li>
			</ul>

			<? } elseif (stristr($_SERVER[REQUEST_URI],'govorova34')) {?>
			<ul>
				<li class="m1">
					<a href="http://newodintsovo.ru/govorova34/">ОБ ОБЪЕКТЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova34/">ОПИСАНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova34/object/planirovki.php">ПЛАНИРОВКИ</a></li>
						<li><a href="http://newodintsovo.ru/govorova34/object/teh_harakteristiki.php">ТЕХ.ХАРАКТЕРИСТИКИ</a></li>
					</ul>
				</li>
				<li class="m2">
					<a href="http://newodintsovo.ru/govorova34/flat/shahmatka.php">КВАРТИРЫ В ПРОДАЖЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova34/flat/shahmatka.php">ШАХМАТКА ДОМА</a></li>
						<li><a href="http://newodintsovo.ru/govorova34/flat/spisok.php">СПИСОК КВАРТИР</a></li>
					</ul>
				</li>
				<li class="m3">
					<a href="http://newodintsovo.ru/govorova34/gallery/photo.php">ГАЛЕРЕЯ ОБЪЕКТА</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova34/gallery/photo.php">ФОТОГРАФИИ СТРОЙКИ</a></li>
					</ul>
				</li>
				<li class="m4">
					<a href="http://newodintsovo.ru/govorova34/comm/index.php">НЕЖИЛЫЕ ПОМЕЩЕНИЯ</a>
					<ul>
						<!--<li><a href="http://newodintsovo.ru/govorova34/comm/index.php">ОФИС 6 (160 КВ. М.)</a></li>
						<li><a href="http://newodintsovo.ru/govorova34/comm/index4.php">ОФИС 4 (184 КВ. М.)</a></li>-->
					</ul>
				</li>
				<li class="m5">
					<a href="http://newodintsovo.ru/contacts/index.php">КОНТАКТЫ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/contacts/index.php">КООРДИНАТЫ</a></li>
						<li><a href="http://newodintsovo.ru/contacts/map.php">ОБЪЕКТЫ НА КАРТЕ</a></li>
					</ul>
				</li>
			</ul>
			
			<? } elseif (stristr($_SERVER[REQUEST_URI],'govorova31')) {?>
			<ul>
				<li class="m1">
					<a href="http://newodintsovo.ru/govorova31/">ОБ ОБЪЕКТЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova31/object/description.php">ОПИСАНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova31/object/position.php">РАСПОЛОЖЕНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova31/object/infrastructure.php">ИНФРАСТРУКТУРА</a></li>
						<li><a href="http://newodintsovo.ru/govorova31/object/planirovki.php">ПЛАНИРОВКИ</a></li>
					</ul>
				</li>
				<li class="m2">
					<a href="http://newodintsovo.ru/govorova31/flat/spisok.php">КВАРТИРЫ В ПРОДАЖЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova31/flat/spisok.php">СПИСОК КВАРТИР</a></li>
					</ul>
				</li>
				<li class="m3">
					<a href="http://newodintsovo.ru/govorova31/gallery/photo.php">ГАЛЕРЕЯ ОБЪЕКТА</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova31/gallery/photo.php">ФОТОГРАФИИ СТРОЙКИ</a></li>
					</ul>
				</li>
				<li class="m4">
					<a href="http://newodintsovo.ru/govorova31/dekl.pdf" target="_blank">ДОКУМЕНТАЦИЯ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova31/dekl.pdf" target="_blank">ПРОЕКТНАЯ ДЕКЛАРАЦИЯ</a></li>
						<li><a href="http://newodintsovo.ru/govorova31/images/razr.jpeg" target="_blank">РАЗРЕШЕНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova31/images/post.jpeg" target="_blank">ПОСТАНОВЛЕНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova31/images/zakl.jpeg" target="_blank">ЗАКЛЮЧЕНИЕ</a></li>
						
					</ul>
				</li>
				<li class="m5">
					<a href="http://newodintsovo.ru/contacts/index.php">КОНТАКТЫ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/contacts/index.php">КООРДИНАТЫ</a></li>
						<li><a href="http://newodintsovo.ru/contacts/map.php">ОБЪЕКТЫ НА КАРТЕ</a></li>
					</ul>
				</li>
			</ul>
			
			<? } elseif (stristr($_SERVER[REQUEST_URI],'sadovaya16')) {?>
			<ul>
				<li class="m1">
					<a href="http://newodintsovo.ru/sadovaya16/">ОБ ОБЪЕКТЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/sadovaya16/object/description.php">Описание</a></li>
						<li><a href="http://newodintsovo.ru/sadovaya16/object/position.php">Расположение</a></li>
						<li><a href="http://newodintsovo.ru/sadovaya16/object/infrastructure.php">Инфраструктура</a></li>
						<li><a href="http://newodintsovo.ru/sadovaya16/object/planirovki.php">Планировки</a></li>
					</ul>
				</li>
				<li class="m2">
					<a href="http://newodintsovo.ru/sadovaya16/flat/spisok.php">КВАРТИРЫ В ПРОДАЖЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/sadovaya16/flat/spisok.php">Список квартир</a></li>
					</ul>
				</li>
				<li class="m3">
					<a href="http://newodintsovo.ru/sadovaya16/gallery/photo.php">ГАЛЕРЕЯ ОБЪЕКТА</a>
					<ul>
						<li><a href="http://newodintsovo.ru/sadovaya16/gallery/photo.php">Фотографии стройки</a></li>
					</ul>
				</li>
				<li class="m4">
					<ul>
						<li><a href="http://newodintsovo.ru/contacts/index.php">КОНТАКТЫ</a></li>
						<li><a href="http://newodintsovo.ru/contacts/index.php">КООРДИНАТЫ</a></li>
						<li><a href="http://newodintsovo.ru/contacts/map.php">ОБЪЕКТЫ НА КАРТЕ</a></li>
					</ul>
				</li>
			</ul>
			
			<? } elseif (stristr($_SERVER[REQUEST_URI],'govorova26')) {?>
			<ul>
				<li class="m1">
					<a href="http://newodintsovo.ru/govorova26/">ОБ ОБЪЕКТЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova26/object/description.php">ОПИСАНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova26/object/position.php">РАСПОЛОЖЕНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova26/object/infrastructure.php">ИНФРАСТРУКТУРА</a></li>
					</ul>
				</li>
				<li class="m2">
					<a href="http://newodintsovo.ru/govorova26/object/planirovki.php">ПЛАНИРОВКИ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova26/flat/spisok.php">КВАРТИРЫ В ПРОДАЖЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova26/flat/spisok.php">СПИСОК КВАРТИР</a></li>
					</ul>
				</li>
				<li class="m3">
					<a href="http://newodintsovo.ru/govorova26/gallery/photo.php">ГАЛЕРЕЯ ОБЪЕКТА</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova26/gallery/photo.php">ФОТОГРАФИИ СТРОЙКИ</a></li>
					</ul>
				</li>
				<li class="m4">
					<a href="http://newodintsovo.ru/contacts/index.php">КОНТАКТЫ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/contacts/index.php">КООРДИНАТЫ</a></li>
						<li><a href="http://newodintsovo.ru/contacts/map.php">ОБЪЕКТЫ НА КАРТЕ</a></li>
					</ul>
				</li>
			</ul>				  

			<? } elseif (stristr($_SERVER[REQUEST_URI],'govorova52')) {?>
			
			<ul>
				<li class="m1">
					<a href="http://newodintsovo.ru/govorova52/">ОБ ОБЪЕКТЕ</a>>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova52/object/description.php">ОПИСАНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova52/object/position.php">РАСПОЛОЖЕНИЕ</a></li>
						<li><a href="http://newodintsovo.ru/govorova52/object/infrastructure.php">ИНФРАСТРУКТУРА</a></li>
						<li><a href="http://newodintsovo.ru/govorova52/object/planirovki.php">ПЛАНИРОВКИ</a></li>
					</ul>
				</li>
				<li class="m2">
					<a href="http://newodintsovo.ru/govorova52/flat/spisok.php">КВАРТИРЫ В ПРОДАЖЕ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova52/flat/spisok.php">СПИСОК КВАРТИР</a></li>
						<li><a href="http://newodintsovo.ru/govorova52/flat/negiloe.php">НЕЖИЛЫЕ ПОМЕЩЕНИЯ</a></li>
					</ul>
				</li>
				<li class="m3">
					<a href="http://newodintsovo.ru/govorova52/gallery/photo.php">ГАЛЕРЕЯ ОБЪЕКТА</a>>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova52/gallery/photo.php">ФОТОГРАФИИ СТРОЙКИ</a></li>
					</ul>
				</li>
				<li class="m4">
					<a href="http://newodintsovo.ru/govorova52/decl.pdf" target="_blank">ДОКУМЕНТАЦИЯ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/govorova52/decl.pdf" target="_blank">ПРОЕКТНАЯ ДЕКЛАРАЦИЯ</a></li>
					</ul>
				</li>
				<li class="m4">
					<a href="http://newodintsovo.ru/contacts/index.php">КОНТАКТЫ</a>
					<ul>
						<li><a href="http://newodintsovo.ru/contacts/index.php">КООРДИНАТЫ</a></li>
						<li><a href="http://newodintsovo.ru/contacts/map.php">ОБЪЕКТЫ НА КАРТЕ</a></li>
					</ul>
				</li>
			</ul>
			<? } ?>
		</div>
		
		
		
		<div class="b_left">
			<? if ($_SERVER[PHP_SELF] == "/zhk-pervyj/index.php" or $_SERVER[PHP_SELF] == "/index.php") { ?>
			<!-- 3333333333333 -->
			<? }  else { ?>
				<div class="breadcrumbs"><?=$menu;?></div> 
				<? if ($title_menu) { ?>
					<h1><?=$title_menu;?></h1>
				<? }?>
			<? }?>
			<? if ($_SERVER[PHP_SELF] == "/zhk-pervyj/index.php" or $_SERVER[PHP_SELF] == "/index.php") { ?>
				<!-- 11111111111111 -->
			<? }  else { ?>	
				<!-- 22222222222222 -->
			<? }?>
				   