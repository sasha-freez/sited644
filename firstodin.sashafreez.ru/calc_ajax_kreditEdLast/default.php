<div class="news-center">
<div class="menu-top5"><?=$registry['title']?></div>

<form action="?section=result" method="post" name="myform" class="myform" onsubmit="return false;">
<input name="todo" value="calc" type="hidden">
<input name="service_key" value="<?=rand(100000,9999999)?>" type="hidden">

<br>
<p>
<b>Вы можете рассчитать ежемесячные платежи по кредиту исходя из известной цены квартиры.<br>
Или же, напротив, зная примерный размер суммы, которую вы можете платить ежемесячно, определить размер кредита (бюджет покупки квартиры), который будет вам доступен.</b>
</p>

<script type="text/javascript">
function change_calc_type(radio_el) {
	var txt2 = '';
	if (radio_el.value == 'payment') {
		txt2 = 'Стоимость квартиры';
		document.getElementById('full_price_input').style.display = 'inline';
		document.getElementById('month_payment_input').style.display = 'none';
	} else {
		txt2 = 'Ежемесячный платеж';
		document.getElementById('full_price_input').style.display = 'none';
		document.getElementById('month_payment_input').style.display = 'inline';
	}
	document.getElementById('calc_type_text').innerHTML = txt2;
}
<?if($registry['calc_type']=='sum'):?>
function auto_change() {
	var txt2 = '';
	txt2 = 'Ежемесячный платеж';
	document.getElementById('full_price_input').style.display = 'none';
	document.getElementById('month_payment_input').style.display = 'inline';
	document.getElementById('calc_type_text').innerHTML = txt2;
	}
<?endif?>
function sizeFrame(frame) {
frame.height = 600;
//alert(frame.attr('width'));
  if(frame.contentDocument) {
    frame.height = frame.contentDocument.documentElement.scrollHeight;
  } else {
    frame.height = frame.contentWindow.document.body.scrollHeight;
  }
//alert(frame.height);
}

$(document).ready(function() {


	   sizeFrame(window.parent.document.getElementById("frameIP"));
	$('input.submit').click(function(event) {
   	   $('#chart').html('');
           var data = $('.myform').serialize();
	   $.post("?section=result", data,
		function (html) {
		    $('#data').html(html);
		    sizeFrame(window.parent.document.getElementById("frameIP"));
	   });
	   event.preventDefault();
	   return false;
	});

	$('a.getData').live('click',function(event) {
	   $('#chart').html('');
           var href = $(this).attr('href');
//alert(href);return false;
	   $.post(href, {},
		function (html) {
		    $('#data').html(html);
		    sizeFrame(window.parent.document.getElementById("frameIP"));
	   });
	   event.preventDefault();
	   return false;
	});


	$('a.getGraph').live('click',function(event) {

//alert('1');
	   $.post('menu.php', {},
		function (html) {
		    $('#data').html(html);
	   });

           var href = $(this).attr('href');
//alert(href);return false;

	   $.get(href,
		function (response) {
		$('#chart').html('');
		sprintf(response);
//alert(res);
new Morris.Bar({
  // ID of the element in which to draw the chart.
  element: 'chart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: res,
  // The name of the data record attribute that contains x-values.
  xkey: 'x',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['руб']
});


	        sizeFrame(window.parent.document.getElementById("frameIP"));	
	   });



	   event.preventDefault();
	   return false;

	});
});
</script>

<a name="params_form" id="params_form"></a>
<h5>Рассчитать</h5>
<label for="calc_type_payment"><input class="inp_radio" name="calc_type" value="payment" id="calc_type_payment" onclick="change_calc_type(this)" type="radio" <?if($registry['calc_type']=='payment' or $registry['calc_type']==''):?>checked="checked"<?endif?>>Ежемесячные платежи исходя из известной цены квартиры</label><br>
<label for="calc_type_sum"><input class="inp_radio" name="calc_type" value="sum" id="calc_type_sum" onclick="change_calc_type(this)" type="radio" <?if($registry['calc_type']=='sum'):?>checked="checked"<?endif?>>Бюджет покупки квартиры исходя из ежемесячных платежей</label><br>
<br>

<h5>Вид платежа</h5>
<label for="alg_1"><input class="inp_radio_alg" id="alg_1" name="alg_type" value="1" type="radio" <?if($registry['alg_type']==1 or $registry['alg_type']==''):?>checked="checked"<?endif?>>Аннуитетный платеж</label><br>
<label for="alg_2"><input class="inp_radio_alg" id="alg_2" name="alg_type" value="2" type="radio" <?if($registry['alg_type']==2):?>checked="checked"<?endif?>>Дифференцированный платеж</label><br>
<br>


<h5>Укажите параметры кредита</h5>
	<div class="services_border">
		<table class="services">
			<tbody><tr>
				<td width="160"><span id="calc_type_text">Стоимость квартиры</span></td>
				<td align="right">
					<span id="full_price_input" style="display: inline;">
						<input size="20" style="width: 115px;" maxlength="20" name="full_price" onkeyup="format_price(event)" value="<?if($registry['full_price']>0):?><?=number_format(round($registry['full_price'],2), 0, '', ' ');?><?endif?>" type="text">
					</span>
					<span id="month_payment_input" style="display: none;">
						<input size="20" maxlength="20" style="width: 115px;" name="month_payment" onkeyup="format_price(event)" value="<?if($registry['month_payment']>0):?><?=number_format(round($registry['month_payment'],2), 0, '', ' ');?><?endif?>" type="text">
					</span>
					<select name="price_currency" style="width: 65px;">
						<option value="0" <?if($registry['price_currency']==0):?>selected="selected"<?endif?>>руб.</option>
						<option value="1" <?if($registry['price_currency']==1):?>selected="selected"<?endif?>>долл.</option>
						<option value="2" <?if($registry['price_currency']==2):?>selected="selected"<?endif?>>евро</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Первоначальный взнос</td>
				<td align="right">
				<input size="20" maxlength="20" style="width: 115px;" id="first_payment" name="first_payment" onkeyup="format_price(event); clear_value('first_payment_pr', event)" value="<?if($registry['first_payment_pr']==0 and $registry['first_payment']>0):?><?=number_format(round($registry['first_payment'],2), 0, '', ' ');?><?endif?>" type="text">
				<select name="first_payment_currency" style="width: 65px;">
					<option value="0" <?if($registry['first_payment_currency']==0):?>selected="selected"<?endif?>>руб.</option>
						<option value="1" <?if($registry['first_payment_currency']==1):?>selected="selected"<?endif?>>долл.</option>
						<option value="2" <?if($registry['first_payment_currency']==2):?>selected="selected"<?endif?>>евро</option>
					</select>
					или <input size="2" maxlength="2" style="width: 40px;" id="first_payment_pr" name="first_payment_pr" onkeyup="clear_value('first_payment', event)" value="<?=$registry['first_payment_pr']?>" type="text"> %
				</td>
			</tr>
			<tr>
				<td>Ставка кредита</td>
				<td align="right">
					<input size="6" maxlength="4" style="width: 40px;" name="wage" value="<?=$registry['wage']?>" type="text"> % годовых в
					<select name="wage_currency" style="width: 65px;">
						<option value="0" <?if($registry['wage_currency']==0):?>selected="selected"<?endif?>>руб.</option>
						<option value="1" <?if($registry['wage_currency']==1):?>selected="selected"<?endif?>>долл.</option>
						<option value="2" <?if($registry['wage_currency']==2):?>selected="selected"<?endif?>>евро</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Срок кредитования</td>
				<td align="right">
					<input size="2" maxlength="2" style="width: 40px;" name="years" value="<?=$registry['years']?>" type="text"> 

					<select name="type_period" style="width: 65px;">
						<option value="0" <?if($registry['type_period']==0):?>selected="selected"<?endif?>>лет</option>
						<option value="1" <?if($registry['type_period']==1):?>selected="selected"<?endif?>>месяцев</option>
					</select>

				</td>
			</tr>
		</tbody></table>
	</div>
	<div class="clear"></div>
<div style="margin-top: 20px;">
<input value="Рассчитать &gt;&gt; " type="submit" class="submit">
</div>
</form>
<script type="text/javascript">
change_calc_type({"value": "payment"});
<?if($registry['calc_type']=='sum'):?>
auto_change();
<?endif?>
</script>

<div style="margin-top: 20px;" id="data">
</div>


<div id="chart" style="width: 500px;"></div>

</div>