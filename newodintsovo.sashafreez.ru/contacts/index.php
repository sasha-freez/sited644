<? include ($_SERVER[DOCUMENT_ROOT]."/templates/header.php") ?>
<div class="content">
<div class="container">
	<h1>Контакты</h1>
	<div class="p_contact">
		<p><strong>Адрес:</strong> 143005, Россия, Московская область, Одинцово, Можайское шоссе дом 58а</p>
		<div class="row rl">
				<span class="name">Телефон многоканальный</span>
				<span class="tel">+7 (495) 66-55-385</span>
			</div>
			<div class="row rr">
				<span class="name">Телефоны менеджеров отдела продаж</span>
				<span class="tel">+7(903) 138-21-93,<span class="r"></span> +7(903) 138-15-34, <span class="r"></span> <span class="tlast">+7(962) 369-20-73</span></span>
			</div>
		<p><strong>Департамент новостроек:</strong> Отдел продаж новостроек (продажа квартир в новостройках Москвы и Подмосковья)</p> 
	</div>
	
	<h2>Карта сайта</h2>
	<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=Vy6z9zZBImuZvfkdcSyy4_ufxulTiHcB&width=700&height=450"></script>
	
	<br/><br/>

	<h3>Карта объектов</h3>
	<div id="main">

	<map name="map">
		<area alt="Говорова, мкр.5а, д.26А" title="Говорова, мкр.5а, д.26А" shape="circle" coords="335,154,6" nohref onMouseOver="showhide('gov26_info')" onMouseOut="hide('gov26_target','gov26_info')" onClick="showhide('gov26_info')">
		<area alt="ЖК ПЕРВЫЙ" title="ЖК ПЕРВЫЙ" shape="circle" coords="412,135,6" nohref onMouseOver="showhide('zhk_info')" onMouseOut="hide('zhk_target','zhk_info')" onClick="showhide('zhk_info')">
		<area alt="МОЖАЙСКОЕ Ш., мкр. 5а, к. 165" title="МОЖАЙСКОЕ Ш., мкр. 5а, к. 165" shape="circle" coords="438,130,6" nohref onMouseOver="showhide('gov31_info')" onMouseOut="hide('gov31_target','gov31_info')" onClick="showhide('gov31_info')">
		<area alt="Говорова, мкр.5а, д.52" title="Говорова, мкр.5а, д.52" shape="CIRCLE" coords="455,118,8" nohref onMouseOver="showhide('gov52_info')" onMouseOut="hide('gov52_target','gov52_info')" onClick="showhide('gov52_info')">
		<area alt="МОЖАЙСКОЕ Ш., мкр. 5а, к. 169" title="МОЖАЙСКОЕ Ш., мкр. 5а, к. 169"  coords="458,134,10" shape="CIRCLE" nohref onMouseOver="showhide('gov34_info')" onMouseOut="hide('gov34_target','gov34_info')" onClick="showhide('gov34_info')">
	</map>
	<img src="/zhk-pervyj/images/map.jpg" width="700" height="483"  alt="Новостройки в Одинцово" title="Новостройки в Одинцово" border="0" usemap="#map">

	<!-- start zone -->
	<div style="position: absolute; top: 0px; left: 0px; cursor: hand; display: inline;">
		<!-- Цвет, цель, target -->
		<div id="gov34_target" style="position: absolute; top: 0px; left: 0px; display:none;">
		<div style="width: 50px; height: 33px; position: absolute; top:0px; left:0px; display: inline-block;"></div>
		</div>
		<!-- Табличка с информацией -->
		<div id="gov34_info" class="info" style="position: absolute; top: -22px; left: 370px; width: 300px; display: none;" onClick="showhide('gov34_info'), showhide('gov34_target')">
			<table width="100%">
			<tr valign="top"><td colspan="2"><strong>МОЖАЙСКОЕ Ш., мкр. 5а, к. 169</strong></td></tr>
			<tr valign="top">
			<td rowspan="2"><img src="/zhk-pervyj/images/odinc8_sm.jpg" alt="МОЖАЙСКОЕ Ш., мкр. 5а, к. 169" title="МОЖАЙСКОЕ Ш., мкр. 5а, к. 169" width="100" height="100" border="0" align="left"></td> 
			<td>Серия ТМ 25<br>
			Этажность:<br>	переменная, 22-25-19

			<br><a href="/govorova34/flat/shahmatka.php">Подробнее об объекте >></a>
			</td></tr>
			<tr><td nowrap align="right">закрыть <strong>X</strong></td></tr></table>
			<div style="position: absolute; top:135px; left: 80px;" class="com_down"></div>
		</div>
	</div>
	<!-- end of zone -->


	<!-- start zone -->
	<div style="position: absolute; top: 0px; left: 0px; cursor: hand; display: inline;">

		<!-- Цвет, цель, target -->
		<div id="gov26_target" style="position: absolute; top: 0px; left: 0px; display:none;">
			<div style="width: 50px; height: 33px; position: absolute; top:0px; left:0px; display: inline-block;"></div>
		</div>
		<!-- Табличка с информацией -->
		<div id="gov26_info" class="info" style="position: absolute; top: -5px; left: 250px; width: 300px; display: none;" onClick="showhide('gov26_info'), showhide('gov26_target')">
			<table width="100%">
			<tr valign="top"><td colspan="2"><strong>Говорова, мкр.5, д.26А</strong></td></tr>
			<tr valign="top">
			<td rowspan="2"><img src="/zhk-pervyj/images/odinc1_sm.jpg" alt="Говорова, мкр.5, д.26А" title="Говорова, мкр.5, д.26А" width="100" height="100" border="0" align="left"></td> 
			<td>Монолитно-кирпичный дом<br>
			22 этажа, 2 секции<br>
			ВСЕ КВАРТИРЫ ПРОДАНЫ.
			<br>
			</td></tr>
			<tr><td nowrap align="right">закрыть <strong>X</strong></td></tr></table>
			<div style="position: absolute; top:135px; left: 80px;" class="com_down"></div>
		</div>

	</div>
	<!-- end of zone -->


	<!-- start zone -->
	<div style="position: absolute; top: 0px; left: 0px; cursor: hand; display: inline;">

		<!-- Цвет, цель, target -->
		<div id="zhk_target" style="position: absolute; top: 0px; left: 0px; display:none;">
			<div style="width: 50px; height: 33px; position: absolute; top:0px; left:0px; display: inline-block;"></div>
		</div>
		<!-- Табличка с информацией -->
		<div id="zhk_info" class="info" style="position: absolute; top: -20px; left: 325px; width: 300px; display: none;" onClick="showhide('zhk_info'), showhide('zhk_target')">
			<table width="100%">
			<tr valign="top"><td colspan="2"><strong>ЖК Первый</strong></td></tr>
			<tr valign="top">
			<td rowspan="2"><a href="/zhk-pervyj/"><img src="/zhk-pervyj/images/odinczhk_sm.jpg" alt="ЖК Первый" title="ЖК Первый" width="100" height="100" border="0" align="left"></a></td> 
			<td>Бул. Маршала Крылова, к.24<br>
			22 этажа, 4 секции<br>
			Срок сдачи 2 кв. 2013
			<br><a href="/zhk-pervyj/">Подробнее об объекте >></a>
			</td></tr>
			<tr><td nowrap align="right">закрыть <strong>X</strong></td></tr></table>
			<div style="position: absolute; top:135px; left: 80px;" class="com_down"></div>
		</div>

	</div>
	<!-- end of zone -->


	<!-- start zone -->
	<div style="position: absolute; top: 0px; left: 0px; cursor: hand; display: inline;">

		<!-- Цвет, цель, target -->
		<div id="gov31_target" style="position: absolute; top: 0px; left: 0px; display:none;">
			<div style="width: 50px; height: 33px; position: absolute; top:0px; left:0px; display: inline-block;"></div>
		</div>
		<!-- Табличка с информацией -->
		<div id="gov31_info" class="info" style="position: absolute; top: -22px; left: 350px; width: 300px; display: none;" onClick="showhide('gov31_info'), showhide('gov31_target')">
			<table width="100%">
			<tr valign="top"><td colspan="2"><strong>МОЖАЙСКОЕ Ш., мкр. 5а, к. 165</strong></td></tr>
			<tr valign="top"><td rowspan="2"><A href="/govorova31/"><img src="/zhk-pervyj/images/odinc2_sm.jpg" alt="Говорова, мкр.5а, д.26А" title="МОЖАЙСКОЕ Ш., мкр. 5а, к. 165" width="100" height="100" border="0" align="left"></A></td> <td>  Серия П-44Т<br>
			17 этажей, 6 секций<br>
			Заселение.
			<br><A href="/govorova31/">Подробнее об объекте >></A</td></tr>
			<tr><td nowrap align="right">закрыть <strong>X</strong></td></tr>
			</table>
			<div style="position: absolute; top:134px; left: 82px;" class="com_down"></div>
		</div>

	</div>
	<!-- end of zone -->		


	<!-- start zone -->
	<div style="position: absolute; top: 0px; left: 0px; cursor: hand; display: inline;">
		<!-- Цвет, цель, target -->
		<div id="gov52_target" style="position: absolute; top: 0px; left: 0px; display:none;">
			<div style="width: 50px; height: 33px; position: absolute; top:0px; left:0px; display: inline-block;"></div>
		</div>
		<!-- Табличка с информацией -->
		<div id="gov52_info" class="info" style="position: absolute; top: -40px; left: 367px; width: 300px; display: none;" onClick="showhide('gov52_info'), showhide('gov52_target')">
			<table width="100%">
			<tr valign="top"><td colspan="2"><strong>Говорова, мкр.5а, д.52</strong></td></tr>
			<tr valign="top"><td rowspan="2"><img src="/zhk-pervyj/images/odinc3_sm.jpg" alt="Говорова, мкр.5а, д.52" title="МОЖАЙСКОЕ Ш., мкр. 5а, к. 165" width="100" height="100" border="0" align="left"></td> <td> Серия П-44Т/П44К<br>
			17 этажней, 6 секций<br>
			Ключи. Заселение.<BR/>
			<A href="/govorova52/">Подробнее об объекте >></A>
			</td></tr>
			<tr><td colspan="2" align="right">закрыть <strong>X</strong></td></tr>
			</table>
			<div style="position: absolute; top:135px; left: 82px;" class="com_down"></div>
		</div>
	</div>
	<!-- end of zone -->				


	<!-- start zone -->
	<div style="position: absolute; top: 0px; left: 0px; cursor: hand; display: inline;">
	<!-- Цвет, цель, target -->
	<div id="16_target" style="position: absolute; top: 0px; left: 0px; display:none;">
		<div style="width: 50px; height: 33px; position: absolute; top:0px; left:0px; display: inline-block;"></div>
	</div>
		<!-- Табличка с информацией -->
		<div id="16_info" class="info" style="position: absolute; top: 86px; left: 80px; width: 300px; display: none;" onClick="showhide('16_info'), showhide('16_target')">
			<table width="100%">
			<tr valign="top"><td colspan="2"><strong>Садовая ул., мкр.2, к.16</strong></td></tr>
			<tr valign="top"><td  rowspan="2"><img src="/zhk-pervyj/images/odinc5_sm.jpg" alt="Садовая ул., мкр.2, к.16" title="Садовая ул., мкр.2, к.16" width="100" height="100" border="0" align="left"></td> <td> Монолитно-кирпичный дом<br>
			24-25 этажей, 3 секции<br>
			Срок сдачи 2 кв. 2013<BR/>
			<A href="http://arsenal-holding.ru/houses/1/houses_list.php?id=672">Подробнее об объекте >></A>
			</td></tr>
			<tr><td colspan="2" align="right">закрыть <strong>X</strong></td></tr></table>
			<div style="position: absolute; top:135px; left: 82px;" class="com_down"></div>
		</div>
	</div>
	<!-- end of zone -->					

	
	
	</div>

	
</div>		
</div>	

<? include ($_SERVER[DOCUMENT_ROOT]."/templates/footer.php") ?>