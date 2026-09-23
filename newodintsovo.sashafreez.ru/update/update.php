<? include ($_SERVER[DOCUMENT_ROOT]."/zhk-pervyj/inc/header_in.php") ?>
<table width="799" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="52" scope="col">&nbsp;</th>
            <td width="479" align="left" valign="top" class="style24">
<?			
$dbars = new DB($dbhost, $basename, $dbuser, $dbpass);	
$dbars->queryOneRecord("DELETE FROM newod_flat");
$f = fopen("shahmatka.csv", "rt") or die("Îøèáêà!");
for ($i=0; $data=fgetcsv($f,1000,";"); $i++) {  
	$num = count($data);  

$r=$dbars->queryOneRecord("insert into newod_flat values ('Null' ,'$data[0]' ,'$data[1]' ,'$data[2]' ,'$data[3]' ,'$data[4]' ,'$data[5]' ,'$data[6]' ,'$data[7]','$data[8]')");
}
fclose($f);	
echo "I am. I say you Ok!";
?>	
          </td>
            <th width="27" scope="col">&nbsp;</th>
          </tr>
        </table> 
		
		

		
		
		
		
<? include ($_SERVER[DOCUMENT_ROOT]."/zhk-pervyj/inc/footer.php"); ?>