<?php
header('Content-Type: text/html; charset=utf-8');

$registry['title']='';
$usd='30.1';
$eur='40.3';


error_reporting(E_ERROR | E_PARSE);

include('functions.php');

if (isset($_GET['section']))$section=parseString($_GET['section'],4,1); else $section='default';

if($section=='')@$sec_path='default';else @$sec_path=$section;
$contents_view=$sec_path.'.php';
if(!file_exists($contents_view)) {$contents_view='default.php';$exists=false;} else $exists=true;
$usd=@round($usd,2);$eur=@round($eur,2);

$clear=0;
if((@$section=='default' or @$section=='') and @$_GET['value']=='')
	{
		setcookie('calc_type','', time()-3600,'/');
		setcookie('calc','', time()-3600,'/');
		setcookie('full_price','', time()-3600,'/');
		setcookie('month_payment','', time()-3600,'/');
		setcookie('first_payment','', time()-3600,'/');
		setcookie('wage','', time()-3600,'/');
		setcookie('years','', time()-3600,'/');

		setcookie('price_currency','', time()-3600,'/');
		setcookie('first_payment_currency','', time()-3600,'/');
		setcookie('wage_currency','', time()-3600,'/');

	$clear=1;
	}

if(@$section=='default' and @$_GET['value']=='edit')
	{
	}
if((@$_POST['todo']=='calc' or @$_COOKIE['calc']==1) and $clear==0)
	{

	if(intval(str_replace(' ','',$_POST['full_price']))>0):
		$registry['full_price']	 	= intval(str_replace(' ','',$_POST['full_price']));
	elseif(intval($_COOKIE['full_price'])>0 and $_POST['todo']<>'calc'):
		$registry['full_price']	 	= intval($_COOKIE['full_price']);
	elseif(intval($_POST['month_payment'])==0): $registry['error'][0]='error';$registry['error'][1].='Укажите стоимость квартиры<br/>';
	endif;

	if(intval($_POST['month_payment'])>0):
		$registry['month_payment']	 	= intval(str_replace(' ','',$_POST['month_payment']));
	elseif(intval($_COOKIE['month_payment'])>0 and $_POST['todo']<>'calc'):
		$registry['month_payment']	 	= intval($_COOKIE['month_payment']);
	elseif(intval($registry['full_price'])==0): $registry['error'][0]='error';$registry['error'][1].='Укажите ежемесячный платеж<br/>';
	endif;

	if(intval($_POST['first_payment'])>0):
		$registry['first_payment']	= intval(str_replace(' ','',$_POST['first_payment']));
	elseif(intval($_COOKIE['first_payment'])>0 and $_POST['todo']<>'calc'):
		$registry['first_payment'] 	= intval($_COOKIE['first_payment']);
	else: $registry['first_payment']	= 0;
	endif;

	if(intval($_POST['first_payment_pr'])>0):
		$registry['first_payment_pr']	= intval(str_replace(' ','',$_POST['first_payment_pr']));
	elseif(intval($_COOKIE['first_payment_pr'])>0 and $_POST['todo']<>'calc'):
		$registry['first_payment_pr'] 	= intval($_COOKIE['first_payment_pr']);
	else: $registry['first_payment_pr']	= 0;
	endif;

	if(intval($_POST['wage'])>0):
		$registry['wage']	= intval(str_replace(' ','',$_POST['wage']));
	elseif(intval($_COOKIE['wage'])>0 and $_POST['todo']<>'calc'):
		$registry['wage']	 	= intval($_COOKIE['wage']);
	else: {$registry['error'][0]='error';$registry['error'][1].='Укажите кредитную ставку<br/>';}
	endif;

	if(intval($_POST['years'])>0):	
		$registry['years']		= intval(str_replace(' ','',$_POST['years']));
	elseif(intval($_COOKIE['years'])>0 and $_POST['todo']<>'calc'):
		$registry['years']	 	= intval($_COOKIE['years']);
	else: {$registry['error'][0]='error';$registry['error'][1].='Укажите срок кредитования<br/>';}
	endif;

	if(intval($_POST['price_currency'])>0):	
		$registry['price_currency']		= intval(str_replace(' ','',$_POST['price_currency']));
	elseif(intval($_COOKIE['price_currency'])>0 and $_POST['todo']<>'calc'):
		$registry['price_currency']	 	= intval($_COOKIE['price_currency']);
	endif;

	if(intval($_POST['first_payment_currency'])>0):	
		$registry['first_payment_currency']		= intval(str_replace(' ','',$_POST['first_payment_currency']));
	elseif(intval($_COOKIE['first_payment_currency'])>0 and $_POST['todo']<>'calc'):
		$registry['first_payment_currency']	 	= intval($_COOKIE['first_payment_currency']);
	endif;

	if(intval($_POST['wage_currency'])>0):	
		$registry['wage_currency']		= intval(str_replace(' ','',$_POST['wage_currency']));
	elseif(intval($_COOKIE['wage_currency'])>0 and $_POST['todo']<>'calc'):
		$registry['wage_currency']	 	= intval($_COOKIE['wage_currency']);
	endif;
	if(strval($_POST['calc_type'])>''):	
		$registry['calc_type']		= strval($_POST['calc_type']);
	elseif(strval($_COOKIE['calc_type'])>'' and $_POST['todo']<>'calc'):
		$registry['calc_type']	 	= strval($_COOKIE['calc_type']);
	endif;

	//Аннуитетный платеж 1 || Дифференцированный платеж 2
	if(intval($_POST['alg_type'])>''):	
		$registry['alg_type']		= intval($_POST['alg_type']);
	elseif(intval($_COOKIE['alg_type'])>'' and $_POST['todo']<>'calc'):
		$registry['alg_type']	 	= intval($_COOKIE['alg_type']);
	endif;

	// установка периода месяцы или годы, 0 - годы, 1 - мес
	if(strval($_POST['type_period'])>''):	
		$registry['type_period']		= strval($_POST['type_period']);
	elseif(strval($_COOKIE['type_period'])>'' and $_POST['todo']<>'calc'):
		$registry['type_period']	 	= strval($_COOKIE['type_period']);
	endif;


	//рассчет коэф. для валют
	$registry['coeff1']=1;
	if($registry['price_currency']==1)$registry['coeff1']=$usd;
	if($registry['price_currency']==2)$registry['coeff1']=$eur;

	$registry['valut']='руб';
	$registry['verb']=1;
	if($registry['wage_currency']==1){$registry['valut']='USD';$registry['verb']=$usd;}
	if($registry['wage_currency']==2){$registry['valut']='EUR';$registry['verb']=$eur;}

	$registry['coeff2']=1;
	if($registry['first_payment_currency']==1)$registry['coeff2']=$usd;
	if($registry['first_payment_currency']==2)$registry['coeff2']=$eur;

	//первоначальный взнос, рассчет если указано в процентах
	if($registry['first_payment_pr']>0)$registry['first_payment']=$registry['full_price']/100*$registry['first_payment_pr'];


	if($registry['type_period']==1) $monthInYear=1; else $monthInYear=12; // года или меясцы
	if($registry['month_payment']>0 and $registry['calc_type']=='sum') // вычисления по Бюджет покупки квартиры исходя из ежемесячных платежей
		{
		$registry['count_mont']=$registry['years']*$monthInYear;
		$iw=$registry['wage']/12/100;
		$registry['full_price']=
			($registry['month_payment']*
			(pow((1+$iw),$registry['count_mont'])-1) /
			(pow((1+$iw),$registry['count_mont'])) /
			$iw)+$registry['first_payment'];
		}

	$percent_local=round($registry['first_payment']/(($registry['full_price']*$registry['coeff1'])/100),2); // вычисление процеента первого взноса, для временного условия
	if($registry['first_payment']>($registry['full_price']*$registry['coeff1'])){$registry['error'][0]='error';$registry['error'][1].='Слишком большая величина первоначального взноса.<br/>';}
	if(intval($percent_local)>89 or $registry['first_payment_pr']>89){$registry['error'][0]='error';$registry['error'][1].='Величина первоначального взноса не может составлять более 89% от стоимости квартиры<br/>';}
	if($registry['error'][0]=='error')
		{


		}

		else
		{
		setcookie('calc',1, time()+3600,'/');
		setcookie('full_price',$registry['full_price'], time()+3600,'/');
		setcookie('month_payment',$registry['month_payment'], time()+3600,'/');
		setcookie('first_payment',$registry['first_payment'], time()+3600,'/');
		setcookie('first_payment_pr',$registry['first_payment_pr'], time()+3600,'/');
		setcookie('wage',$registry['wage'], time()+3600,'/');
		setcookie('years',$registry['years'], time()+3600,'/');
		setcookie('price_currency',$registry['price_currency'], time()+3600,'/');
		setcookie('first_payment_currency',$registry['first_payment_currency'], time()+3600,'/');
		setcookie('wage_currency',$registry['wage_currency'], time()+3600,'/');
		setcookie('calc_type',$registry['calc_type'], time()+3600,'/');
		setcookie('type_period',$registry['type_period'], time()+3600,'/');
		setcookie('alg_type',$registry['alg_type'], time()+3600,'/');

		$registry['percent']=round(($registry['first_payment']*$registry['coeff2'])/(($registry['full_price']*$registry['coeff1'])/100),2);
		$registry['size_kredit']=($registry['full_price']*$registry['coeff1'])-($registry['first_payment']*$registry['coeff2']);		//S
		$registry['count_mont']=$registry['years']*$monthInYear;                                  //Т


		// расчет для графика 1, Зависимость ежемесячных платежей от величины ставки
		$i=$registry['wage']/12/100;
		$k=($i*pow((1+$i),$registry['count_mont']))/(pow((1+$i),$registry['count_mont'])-1); //K

		if($registry['alg_type']==1) { // ануитен
			$registry['pl_month']=$k*$registry['size_kredit']; // A


		} else {//диф

				//b = S / N , где
				//b – основной платёж, S – размер кредита, N – количество месяцев.
			$b=$registry['size_kredit']/$registry['count_mont'];
				//p = Sn * P / 12, где
				//p – начисленные проценты, Sn – остаток задолженности на период, P – годовая процентная ставка по кредитy. 
			$p=$registry['size_kredit']*$registry['wage']/12/100;

			$registry['pl_month']=$b+$p; 
			//die($registry['pl_month']);

			$registry['full_summ_percent']=0;
			$registry['ostatok']=$registry['size_kredit'];
			for($cicl=1;$cicl<=$registry['count_mont'];$cicl++):
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

			endfor;	

		// Доп. параметры
		$registry['full_summ_percent']=$pogash;
		$registry['full_percent']=(($registry['full_summ_percent']+($registry['first_payment']*$registry['coeff2']))/(($registry['size_kredit']+($registry['first_payment']*$registry['coeff2']))/100));

		$registry['pereplata']=($registry['full_summ_percent']+($registry['first_payment']*$registry['coeff2']))-($registry['full_price']*$registry['coeff1']);
		$registry['pereplata_perc']=($registry['pereplata']/(($registry['size_kredit']+($registry['first_payment']*$registry['coeff2']))/100));

		}
		$registry['pl_month_percent']=($registry['pl_month']/(($registry['size_kredit']+($registry['first_payment']*$registry['coeff2']))/100));

		for($gr1=1;$gr1<=12;$gr1++):
			$i=$gr1/12/100;
			$k=($i*pow((1+$i),$registry['count_mont']))/(pow((1+$i),$registry['count_mont'])-1); //K
			$gr_mass1[]=$k*$registry['size_kredit']/$registry['verb']; // A
		endfor;
		$registry['gr_mass1']=$gr_mass1;
		// ----
	
		// расчет для графика 2, Зависимость параметров кредита от срока кредитования
		$rek=$registry['years'];
		$flag=0; // в какую сторону идем, 0 назад, 1 вперед
		for($gr1=1;$gr1<=12;$gr1++):
		if($flag==0)$rek=$rek-1;
		if($flag==1)$rek=$rek+1;
		if($rek==0 or $gr1==7){$flag=1;$rek=$registry['years'];}
		$countmon[$rek]=$rek*$monthInYear; // массив с периодами в МЕС
		endfor;

		foreach($countmon as $key => $cpi ):
			$i=$registry['wage']/12/100;
			$k=($i*pow((1+$i),$cpi))/(pow((1+$i),$cpi)-1); //K
			$gr_mass2[$key]=$k*$registry['size_kredit']/$registry['verb']; // A
		endforeach;
		ksort($gr_mass2);
		$registry['gr_mass2']=$gr_mass2;
		// ----
		// расчет для графика 3, Зависимость параметров кредита от начального взноса
		$rek=$registry['percent'];
		$flag=1; // в какую сторону идем, 0 назад, 1 вперед
		for($gr1=1;$gr1<=12;$gr1++):
			if($flag==0)$rek=$rek-1;
			if($flag==1)$rek=$rek+1;
			if($rek==0 or $gr1==7){$flag=1;$rek=$registry['years'];}
			$countperc[$rek]=$rek; // массив с периодами в МЕС
		endfor;

		foreach($countperc as $key => $cpi ):
			$i=$registry['wage']/12/100;
			$k=($i*pow((1+$i),$registry['count_mont']))/(pow((1+$i),$registry['count_mont'])-1); //K
			$gr_mass3[$key]=$k*(($registry['full_price']*$registry['coeff1'])-(($registry['full_price']*$registry['coeff1'])/100*$cpi))/$registry['verb']; // A
		endforeach;
		ksort($gr_mass3);
		$registry['gr_mass3']=$gr_mass3;
		// ----
		if($registry['alg_type']==1) { // ануитен
		// Доп. параметры
		$registry['full_summ_percent']=$registry['pl_month']*$registry['count_mont'];
		$registry['full_percent']=(($registry['full_summ_percent']+($registry['first_payment']*$registry['coeff2']))/(($registry['size_kredit']+($registry['first_payment']*$registry['coeff2']))/100));
		$registry['pereplata']=($registry['full_summ_percent']+($registry['first_payment']*$registry['coeff2']))-($registry['full_price']*$registry['coeff1']);
		$registry['pereplata_perc']=($registry['pereplata']/(($registry['size_kredit']+($registry['first_payment']*$registry['coeff2']))/100));
		}

		// ----
		if($section=='gr1') $registry['title']='Зависимость ежемесячных платежей от величины ставки';
		if($section=='gr2') $registry['title']='Зависимость параметров кредита от срока кредитования';
		if($section=='gr3') $registry['title']='Зависимость параметров кредита от начального взноса';
		if($section=='table1') $registry['title']='Посмотреть график платежей по кредиту';
		}
	}
if($section=='default')@include('header.php');
@include($contents_view);
