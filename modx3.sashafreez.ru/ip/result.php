<?if($_GET['value']=='print'):?>
<style>
#header,#navigation,#footer{display:none;}
div#content{margin:0;position:absolute;left:0;padding:0}
#wrapper,div#container{margin:0;}
</style>
<?endif;?>
<?if($registry['error'][0]=='error'):?>
	<div class="error"><?=$registry['error'][1]?></div>
<?endif?>

<?if(empty($registry['error'][0]))@include('stat1.php');?>

<?@include('menu.php');?>
