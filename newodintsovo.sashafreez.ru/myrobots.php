<?

$file="main.robots.txt";

//Запрос домена, определние файла robots.txt для вывода
if ($HTTP_HOST!='www.newodintsovo.ru') $file="disallow.robots.txt";

// Определение переменных для вывода
$last_modified_time = filemtime($file); 
$ETag = dechex(fileinode($file));
$ETag.= "-".dechex(filesize($file));
$ETag.= "-".dechex(((filemtime($file).str_repeat("0",6)+0) & (8589934591)));

//Вывод заголовков
header("Content-Type: text/plain; charset=windows-1251");
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT"); 
header("ETag: \"$ETag\"");
header("Accept-Ranges: bytes");
header("Content-Length: ".filesize($file));

//Вывод содержимого robots.txt
echo file_get_contents("$file");

?>
