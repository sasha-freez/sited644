<?@include('menu.php');?>
<div class="news-center">
<?@include('stat1.php');?>

<div class="menu-top5"><?=$registry['title']?></div>
<b>График платежей (<?=$registry['valut'];?>) <?if($registry['alg_type']==1):?>аннуитетный платеж<?else:?>дифференцированный платеж<?endif?></b>
<table class="services list1 rating" style="margin: 10px;" width="530">
	<tbody><tr>
		<th rowspan="2" style="text-align: center;">Месяц</th>
		<th colspan="3" style="text-align: center;">Ежемесячный платеж</th>
		<th colspan="2" style="text-align: center;">Кредит</th>		
	</tr>
	<tr>
		<th style="text-align: center;">На проценты</th>
		<th style="text-align: center;">По кредиту</th>
		<th style="text-align: center;">Всего</th>		
		<th style="text-align: center;">Погашено</th>		
		<th style="text-align: center;">Остаток</th>		
	</tr>
	<?$registry['ostatok']=$registry['size_kredit'];$pogash=0;
	for($cicl=1;$cicl<=$registry['count_mont'];$cicl++):

		if($registry['alg_type']==1) { // ануитен
			$registry['pl_month']=$k*$registry['size_kredit']; // A
		$mp=$registry['ostatok']/100*($registry['wage']/12);

		//на кредит
		$registry['kredit']=$registry['pl_month']-$mp;

		$registry['ostatok']=$registry['ostatok']-$registry['kredit'];
		$pogash=$pogash+$registry['kredit'];

		} else {//диф
		//На проценты = Остаток/100 * (Ставка/12)
		//   = 10000/100 * (/12)
		$registry['kredit']=$registry['size_kredit']/$registry['count_mont'];
			//p = Sn * P / 12, где
			//p – начисленные проценты, Sn – остаток задолженности на период, P – годовая процентная ставка по кредитy. 
		//$mp=$registry['ostatok']*$registry['wage']/12/100;
		$mp=$registry['ostatok']/100*($registry['wage']/12);

		$registry['pl_month']=$registry['kredit']+$mp; //die($registry['pl_month']);


		$pogash=$pogash+$registry['pl_month'];
		$registry['ostatok']=$registry['ostatok']-$registry['kredit'];
		}

		?>
	<tr>
		<td class="right"><?=$cicl?></td>
		<td class="right"><?=number_format(round($mp/$registry['verb'],2))?></td>
		<td class="right"><?=number_format(round($registry['kredit']/$registry['verb'],2), 2, '.', ' ');?></td>
		<td class="right"><?=number_format(round($registry['pl_month']/$registry['verb'],2), 2, '.', ' ');?></td>
		<td class="right"><?=number_format(round($pogash/$registry['verb'],2), 2, '.', ' ');?></td>
		<td class="right"><?=number_format(round($registry['ostatok']/$registry['verb'],2), 2, '.', ' ');?></td>
	</tr>
	<?endfor;?>
</table>


</div>