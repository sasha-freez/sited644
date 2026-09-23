var res = [     <?$grc=0;foreach($registry['gr_mass2'] as $key => $grm):$grc++;?>
    { x: '<?=$key?>', value: '<?=round($grm,2)?>' }<?if($grc<count($registry['gr_mass2'])):?>,<?endif?>
     <?endforeach;?>
];
