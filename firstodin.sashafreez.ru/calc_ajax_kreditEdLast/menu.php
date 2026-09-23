<div id="graf-menu">
<table width="100%"><tr><td valign="top">
<?if($registry['error'][0]==''):?>
<a href="?section=table1" class="getData <?if($_GET['section']=='table1'):?>active<?endif?>">Посмотреть график платежей по кредиту</a>
	<?if($registry['alg_type']==1):?>
	  <a href="?section=gr1" class="getGraph <?if($_GET['section']=='gr1'):?>active<?endif?>">Зависимость ежемесячных платежей от величины ставки</a>
	  <a href="?section=gr2" class="getGraph <?if($_GET['section']=='gr2'):?>active<?endif?>">Зависимость ежемесячных платежей от срока кредитования</a>
	  <a href="?section=gr3" class="getGraph <?if($_GET['section']=='gr3'):?>active<?endif?>">Зависимость ежемесячных платежей от начального взноса</a>
	<?endif?>
<?endif?>
</td><td valign="top" align="right">
<!--
<?if($registry['error'][0]==''):?><a href="?section=result&value=print" class="<?if($_GET['section']=='1'):?>active<?endif?>">Распечатать отчёт ипотечного калькулятора</a><?endif?>
<a href="?section=default&value=edit" class="<?if($_GET['section']=='1'):?>active<?endif?>">Изменить параметры кредита</a>
<a href="?section=default" class="<?if($_GET['section']=='1'):?>active<?endif?>">Рассчитать еще один кредит</a>-->
</td></tr></table>
</div>