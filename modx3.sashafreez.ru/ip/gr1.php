var res = [     <?$grc=0;foreach($registry['gr_mass1'] as $grm):$grc++;?>
    { x: 'Ставка <?=$grc?> %', value: '<?=round($grm,2)?>' }<?if($grc<count($registry['gr_mass1'])):?>,<?endif?>
     <?endforeach;?>
];