<? 
session_start();
if (stristr($_SERVER[REQUEST_URI],'reforum')) {
	$_SESSION['test'] = 1;
}
if ($_SESSION['test'] == 1) {
	$phone = '<span class="style22" style="font-size: 16px;"><strong>8 (495) 665 53 86</strong></span>';
	$logo = '<!--noindex--><a href="http://arsenal-holding.ru" rel="nofollow"><img src="/zhk-pervyj/images/log_ars_np.gif" alt="������� �������" title="������� �������" width="204" height="81" border="0"></a><!--/noindex-->';
}
else {
	$phone = '<p style="margin-top: 5px; margin-bottom: 5px;"><span class="style22" style="font-size: 14px; line-hight:120%"><strong>8(903) 138 21 93<br />

8(903) 138 15 34</strong></span>
';
	$logo = '<!--noindex--><a href="http://arsenal-holding.ru" rel="nofollow"><img src="/zhk-pervyj/images/log_ars.gif" alt="������� �������" title="������� �������" width="204" height="81" border="0"></a><!--/noindex-->';
}

include($_SERVER[DOCUMENT_ROOT]."/zhk-pervyj/inc/setupdb.php"); ?>
<? include($_SERVER[DOCUMENT_ROOT]."/zhk-pervyj/inc/mysqlclass.php"); ?>
<?
$menu0 = '<span class="style24"><a href="/" class="menu">����������� � ��������</a> / �� ������ / </span>';
if ($_SERVER[PHP_SELF] == '/zhk-pervyj/object/description.php') {
	$title='�� ������ � ��������. ��������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/object/description.php" class="menu">�� �������</a> /</span><span class="style23"> ��������</span>';
  $title_menu='��������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/object/position.php') {
	$title='�� ������ � ��������. ������������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/object/description.php" class="menu">�� �������</a> /</span><span class="style23"> ������������</span>';
  $title_menu='������������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/object/infrastructure.php') {
	$title='�� ������ � ��������. ��������������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/object/description.php" class="menu">�� �������</a> /</span><span class="style23"> ��������������</span>';
  $title_menu='��������������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/object/planirovki.php') {
	$title='�� ������ � ��������. ����������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/object/description.php" class="menu">�� �������</a> /</span><span class="style23"> ����������</span>';
  $title_menu='����������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/flat/description.php') {
	$title='�� ������ � ��������. ������� ��������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/flat/description.php" class="menu">�������� � �������</a> /</span><span class="style23"> ������� ��������</span>';
  $title_menu='������� ��������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/flat/shahmatka.php') {
	$title='�� ������ � ��������. �������� ����.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/flat/shahmatka.php" class="menu">�������� � �������</a> /</span><span class="style23"> �������� ����</span>';
  $title_menu='�������� ����';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/flat/spisok.php') {
	$title='�� ������ � ��������. ������ �������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/flat/shahmatka.php" class="menu">�������� � �������</a> /</span><span class="style23"> ������ �������</span>';
  $title_menu='������ �������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/object/teh_harakteristiki.php') {
	$title='�� ������ � ��������. ���. ��������������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/object/description.php" class="menu">�� �������</a> /</span><span class="style23"> ���. ��������������</span>';
  $title_menu='���. ��������������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/gallery/3d.php') {
	$title='�� ������ � ��������. 3D ������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/gallery/3d.php" class="menu">������� �������</a> /</span><span class="style23"> 3D ������</span>';
  $title_menu='3D ������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/contacts/map.php') {
	$title='�� ������ � ��������. ������� �� �����.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/contacts/contacts.php" class="menu">��������</a> /</span><span class="style23"> ������� �� �����</span>';
  $title_menu='������� �� �����';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/contacts/contacts.php') {
	$title='�� ������ � ��������. ����������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/contacts/contacts.php" class="menu">��������</a> /</span><span class="style23"> ����������</span>';
  $title_menu='����������';
}
elseif ($_SERVER[PHP_SELF] == '/zhk-pervyj/gallery/photo.php') {
	$title='�� ������ � ��������. ���������� �������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu=$menu0.'<span class="style24"><a href="/zhk-pervyj/gallery/3d.php" class="menu">������� �������</a> /</span><span class="style23"> ���������� �������</span>';
  $title_menu='���������� �������';
}
else { $title='�� ������ �������� � ������������ ��������.';
	$description='����������� � �������� - �� ������ ������������� � ��������, ������������ ������ ������ � ������� ������������ ������������. ������� ����� ��� ��� ���������� ��� � �������� �������.';
	$key='�� ������, ����������� � ��������, �������� � ��������, ������ �������� � ����������� ������, ������������ ��������';
	$menu='';
}
?>			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title><?=$title;?></title>
<meta name="Keywords" content="<?=$key;?>">
<meta name="Description" content="<?=$description;?>">
<link href="/zhk-pervyj/inc/style.css" rel="stylesheet" type="text/css">
<?if ($_SERVER[PHP_SELF] != '/contacts/contacts.php') {?>
<script type="text/javascript" src="/js/prototype.js"></script>
<script type="text/javascript" src="/js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="/js/lightbox.js"></script>
<? } ?>
<link rel="stylesheet" href="/css/lightbox.css" type="text/css" media="screen" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

<link href="/css/master.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/nslider/jquery.nivo.slider.js"></script>
</head>

<body>

<div class="header">
	<div class="container">
		<a href="/"><img src="/images/header.jpg"></a>
	</div>
</div>
<div class="container">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td ><table border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td valign="top" scope="col"><table width="799" border="0" cellspacing="0" cellpadding="0">
    
     <tr>
      <td><table width="799" border="0" cellpadding="5" cellspacing="0">
       <tr>
<th width="140" scope="col" valign="top"><p align="left" class="style222" style="margin-top: 15px;"><a href="/zhk-pervyj/flat/shahmatka.php" class="menu">
<strong>�� ������<br>���. 5, �. 24</strong><br>&nbsp;<br>
<img src="/zhk-pervyj/images/odinczhk_sm.jpg" alt="�� ������" title="�� ������" width="140" height="140" border="0"></a></p>
<p align="left" class="style24" style="font-size:11px;"><strong>���������<br>������ �����.</strong><br><br>
��������� �������, �����, �������� ��������������. <br><br>
�������, ���������.<br>
<br>
<span style="color:red;"><strong>���������� � �����������.</strong></span>
</p>
</th>

<th width="140" valign="top" scope="col"><p align="left" class="style222" style="margin-top: 15px;"><a href="/govorova34/flat/shahmatka.php" class="menu"><strong>��������� �</strong></a><a href="/govorova31/flat/spisok.php" class="menu"><strong>.,<br> 
���. 5�, �. 165 </strong><br>
&nbsp;<br>
<img src="/zhk-pervyj/images/odinc2.jpg" alt="��������, ���.5�, �.31" title="��������, ���.5�, �.31" width="140" height="140" border="0"></a></p>
<p align="left" class="style24" style="font-size:11px;">
<a href="/govorova52/flat/negiloe.php" style="color:red; text-decoration:none;"><b>� ������� ���� ������� ���������</b></a><br>
<p align="left" style="font-size:11px;"><strong>
16 ����<br /> 3-� ��������� 80 �.,<br />��������� 9000000<br />
3 ���� <br /> 3-� ��������� 79 �.<br />��������� 9000000<br />
5 ���� <br /> 2-� ��������� 61 �.,<br />��������� 7150000. <br/>
������������� ����� 3-� ���,�������.</strong><strong style="color:red;"><br />������!!! �������</strong></p>



</th>

<th width="140" scope="col" valign="top"><p align="left" class="style222" style="margin-top: 15px;"><a href="/govorova34/flat/shahmatka.php" class="menu"><strong>��������� �.,<br>
���. 5�, �. 169 </strong><br />
&nbsp;<br><img src="/zhk-pervyj/images/odinc8_sm.jpg" alt="��������, ���.5�, �.34" title="��������, ���.5�, �.34" width="140" height="140" border="0"></a></p>
<p align="left" class="style24" style="font-size:11px;">
<strong style="color:red;">�����<br />
�������������</strong></p>         
<p align="left" style="font-size:11px;">��������� ������� <br/>� �������<br><br></p>
</th>

					 
<th width="140" scope="col" valign="top"><p align="left" class="style222" style="margin-top: 15px;">


<a href="/zhk_rublevskiy/" class="menu"><strong>�� ���������<br/>&nbsp;</strong><br/> <br/> 
<img src="/zhk_rublevskiy/images/house_small.png" alt="�� ���������" title="�� ���������" width="140" height="140" border="0"></a></p>
<p align="left" class="style24" style="font-size:11px;"><strong>�������� <br/>�� ����������� <br/>�� ����� <br/><span style="color:red;">������ �����</span></strong></p>
</th>

			    <th width="140" valign="top" scope="col" ><p align="left" class="style222" style="margin-top: 15px;"><a href="/govorova26/flat/spisok.php" class="menu"><strong>��������,<br> ���. 5,&nbsp;�. 26�</strong><br>&nbsp;<br>
 <img src="/zhk-pervyj/images/odinc1.jpg" alt="��������, ���.5, �.26�" title="��������, ���.5, �.26�" width="140" height="140" border="0"></a></p>
 <p align="left" class="style24" style="font-size:11px;">
<!-- <span style="color:red;"><strong>�������� ���� 2-x ��������� ��������.</strong></span><br> ������� 80 ��. �<br><br>-->
 <span style="color:red;"><strong>������� ���������</strong></span><br><br>
  � ������� ���� ������� ���������<br><br>

  ��� ������ ������, �������-������.
  
 </p>
				    
		      </th>
       </tr>

      </table></td>
     </tr>
    </table></td>
    <th valign="top" width="204" scope="col"><table width="204" border="0" cellpadding="0" cellspacing="0">
     <tr>
      <th valign="top" scope="col"><p style="margin-top:0px; margin-bottom:0px;"><span class="style22">�������� ����������<br> �� ������:<br>&nbsp;<br></span>
			<!-- <span class="style22" style="font-size: 16px;"><strong>8(903) 138-21-93</strong></span></p> -->
			<?=$phone;?> 
			</th>
     </tr>
     <tr>
      <td valign="top"><table width="204" border="0" cellspacing="0" cellpadding="0" style="margin-top:0px;">
       <tr>
        <th valign="top" scope="col"><a href="/contacts/map.php" class="menu_small"><img src="/zhk-pervyj/images/karts_small.gif" alt="���������� �� ����� �� ������" title="���������� �� ����� �� ������" border="0"></a></th>
       </tr>
       <tr>
        <td><div align="center"><span class="style22"><a href="/contacts/map.php" class="menu_small">���������� �� ����� &gt;&gt;</a></span> </div><p></p>
<table align="center">
<tr valign="middle">
<td><a href="http://www.facebook.com/firstodin" class="menu_small" target="_blank"><img src="/facebook.png" alt="�� �� Facebook" title="�� �� Facebook" width="15" height="15" border="0" ></a></td>
<td><span class="style22"><a href="http://www.facebook.com/firstodin" class="menu_small" target="_blank"><strong>�� �� Facebook</strong></a></span> </div></td>
</tr>
<tr valign="middle">
<td><a href="http://www.vk.com/firstodin" class="menu_small" target="_blank"><img src="/vkontakte-icon.png" alt="�� ���������" title="�� ���������" width="15" height="15" border="0" ></a></td>
<td><span class="style22"><a href="http://www.vk.com/firstodin" class="menu_small" target="_blank"><strong>�� ���������</strong></a></span> </div></td>
</tr>
</table>

</td>
       </tr>
      </table></td>
     </tr>
    </table></th>
   </tr>
  </table></td>
 </tr>

  <tr>
  <td valign="top"><table border="0" cellspacing="0" cellpadding="0">
   	 
   <tr>

    <th valign="top" style="margin-right:10px;">
