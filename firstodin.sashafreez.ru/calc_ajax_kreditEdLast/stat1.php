<p>Стоимость квартиры: <b><i><?=number_format(round($registry['full_price']*$registry['coeff1']/$registry['verb'],2), 2, '.', ' ');?> <?=$registry['valut'];?></i></b><br/>
Первоначальный взнос: <b><i><?=number_format(round(($registry['first_payment']*$registry['coeff2']/$registry['verb']),2), 2, '.', ' ');?> <?=$registry['valut'];?></i></b> (<b><i><?=number_format(round($registry['percent'],2), 2, '.', ' ');?></i></b>%)<br/>
Размер кредита: <b><i><?=number_format(round($registry['size_kredit']/$registry['verb'],2), 2, '.', ' ');?> <?=$registry['valut'];?></i></b><br/>
Ставка кредита: <b><i><?=number_format(round($registry['wage'],2), 2, '.', ' ');?></i></b> % годовых<br/>
Срок кредитования: <b><i><?=intval($registry['years']);?></i></b> <?if($registry['type_period']==1):?>месяцев<?else:?>лет<?endif?><br/>
Кол-во платежей: <b><i><?=$registry['count_mont']?></i></b><br/></p>

<p>Ежемесячный платеж: 
	<?if($registry['alg_type']==1):?>
	<b><i><?=number_format(round($registry['pl_month']/$registry['verb'],2), 2, '.', ' ');?> <?=$registry['valut'];?></i></b>. 
	или: <b><i><?=number_format(round($registry['pl_month_percent'],2), 2, '.', ' ');?></i></b>% от стоимости квартиры
	<?else:?>

	<?endif?><br/>
Полные затраты с учетом процентов: <b><i><?=number_format(round(($registry['full_summ_percent']+($registry['first_payment']*$registry['coeff2']))/$registry['verb'],2), 2, '.', ' ');?> <?=$registry['valut'];?></i></b>. 
или: <b><i><?=number_format(round($registry['full_percent'],2), 2, '.', ' ');?></i></b>% от стоимости квартиры<br/>

Величина переплаты: <b><i><?=number_format(round($registry['pereplata']/$registry['verb'],2), 2, '.', ' ');?> <?=$registry['valut'];?></i></b>. или: <b><i><?=number_format(round($registry['pereplata_perc'],2), 2, '.', ' ');?></i></b>% от стоимости квартиры<br/></p>