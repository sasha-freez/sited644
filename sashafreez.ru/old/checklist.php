<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h3>НЕСОВПАДЕНИЯ</h3>
<?php
	
	ini_set('error_reporting', E_ALL);
	ini_set ('display_errors', 1);
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	ini_set("mysql.trace_mode","On");
	
	include("config.php");
	include("functions.php");
	
	$q = "SELECT count(*) AS c FROM `wp_posts` WHERE post_status='publish'";
	$result = mysqli_query($db_link,$q);
	$row = mysqli_fetch_array($result);
	$total_count = $row['c'];
	
	$q = "SELECT post_id FROM `wp_postmeta`
			WHERE
				`meta_key`='litres_link'
			";
	$result = mysqli_query($db_link,$q);
	$litresed_count = mysqli_num_rows($result);
	
	while ($row = mysqli_fetch_array($result)){
		$ids[] = $row['post_id'];
	}
	$ids = implode(',',$ids);
	
	$q = "SELECT * FROM `wp_posts`
			WHERE
				post_status='publish'
				AND
				ID NOT IN (" . $ids . ")
			ORDER BY ID";
	$result = mysqli_query($db_link,$q);
	
	echo 'В базе: ' . $total_count . ' | ' . 'Совпало по названию: ' . $litresed_count . ' | '  . 'Дополнительно совпало по автору: ' . $litresed_a_count . ' | '. 'Не совпало: ' . ($total_count - $litresed_count) . "<br><br>"; 
	
	while ($row = mysqli_fetch_array($result)){
		echo $row['ID'] . '|' . $row['post_title'] . "<br>";
	}
?>

</body>
</html>