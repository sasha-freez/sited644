<?php
	
	//ставим 1251 локаль т.к. внешние csv в 1251
	@setlocale(LC_ALL, array("Russian_Russia.1251","ru_RU.CP1251","ru_RU.cp1251","ru_RU","RU","rus_RUS.1251"));
	
	function file_get_contents_curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
	}
	
	function multineedle_stripos($haystack, $needles, $offset=0){
		foreach($needles as $needle) {
			if (stripos($haystack, $needle, $offset) !== false){
				$found[$needle] = stripos($haystack, $needle, $offset);
			}
		}
		return (isset($found) ? $found : false);
	}
	
	function explode_xfields($data){
		//преобразует строку xfields в двумерный массив
		$xfields_array = explode('||',$data);
		foreach ($xfields_array as $xfield){
			$xfield_array = explode('|',$xfield);
			$xfields[$xfield_array[0]] = $xfield_array[1];
		}
		return is_array($xfields) ? $xfields : false;
	}

	function implode_xfields($data){
		//преобразует двумерный массив в строку xfields
		foreach ($data as $key => $value){
			$xfields[] = $key . '|' . $value;
		}
		
		if (!is_array($xfields)) return false;
		
		$xfields_string = implode('||',$xfields);
		
		return $xfields_string;
	}
	
	function delete_litres_book($hub_id){
		global $db_link;
		//удаляем книги путем простановки options=0
		$q = "UPDATE `litres_data` SET options=0 WHERE hub_id=" . $hub_id;
		mysqli_query($db_link,$q);
	}
	
	function index_local_data(){
		//функция нужна для правильного полнотекстого индексирования.
		//используется если клиентские данные в кодировке 1251

		global $table_prefix;
		
		//$q = "TRUNCATE TABLE litres_local_data";
		//mysql_query($q);

		$q = "SELECT * FROM `" . $table_prefix . "post`";

		$result = mysql_query($q);

		if (mysql_num_rows($result)>0){
			while ($row = mysql_fetch_array($result)){
				
				//$xfields = '';
				//if ($row['xfields'] != '') $xfields = explode_xfields($row['xfields']);

				$matches = ''; $author = ''; $title = '';
				
				
				$needle = 'Автор';
				
				if (preg_match("/" . $needle . "(.{3,})</iuU",$row['short_story'],$matches) !== false){
					$matches[1] = strip_tags($matches[1]);
					$matches[1] = str_replace(':','',$matches[1]);
					$matches[1] = stripslashes($matches[1]);
					$matches[1] = trim($matches[1]);
					$author = $matches[1];
				}
				
				
				/*
				$matches = '';
				if (preg_match("/Название(.{3,})</iuU",$row['full_story'],$matches) !== false){
					$matches[1] = strip_tags($matches[1]);
					$matches[1] = str_replace(':','',$matches[1]);
					$matches[1] = stripslashes($matches[1]);
					$matches[1] = trim($matches[1]);
					$title = $matches[1];
					var_dump($title);
				}
				*/
				
				$title = $row['title'];
				
				//локальные категории:
				$categories_audio = array();
				$categories_text = array();
				
				$categories = explode(',',$row['category']);
				foreach ($categories as $category){
					if (in_array($category,$categories_audio)){
						$local_book_type = 1;
						continue;
					}
					else{
						$local_book_type = 0;
					}
				}
				
				$q = "INSERT INTO litres_local_data SET 
						id = " . $row['id'] . ",
						author = '" . mysql_real_escape_string($author) . "',
						title = '" . mysql_real_escape_string($title) . "',
						type = '" . $local_book_type . "',
						litresed = " . (isset($xfields['litres']) && $xfields['litres'] != '' ? 1 : 0) . "
						ON DUPLICATE KEY UPDATE
						author = '" . mysql_real_escape_string($author) . "',
						title = '" . mysql_real_escape_string($title) . "',
						type = '" . $local_book_type . "'";
				mysql_query($q);
			}
		}
	}
	
	function compare_local_global($book_type = 0, $add_type0_links_to_type1 = false){

		global $db_link, $partner_utm_list, $partner_id, $partner_a_id, $table_prefix;

		include('dictionary.php');
		
		//ставим временный индекс
		$q = "ALTER TABLE `wp_posts` ADD FULLTEXT litres_index_on_title (`post_title`)";
		mysqli_query($db_link,$q);
		//
		//------------------------

		/*** сравниваем книги ***/
		$q = "SELECT * FROM `litres_data` WHERE 
					`type` = " . $book_type . " AND
					`hub_id` > 0
					AND (you_can_sell > 0 OR options&2)

					ORDER BY date_inserted DESC

				";

		$result = mysqli_query($db_link,$q);

		if (mysqli_num_rows($result)>0){

			while ($row = mysqli_fetch_array($result)){
				
				$litres_link = ''; $book_title_t = ''; $book_title_1 = ''; $book_title_2 = '';
				
				if ($row['author_sname'] != '' && $row['book_title'] != ''){
					$row['book_title'] = trim(strtr($row['book_title'], $repl_ar));
					$row['author_sname'] = trim(strtr($row['author_sname'], $repl_auth_ar));
					
					$row['book_title'] = preg_replace("/\(.+\)/","",$row['book_title']);
					
					if (stripos($row['book_title'],'.') !== false){
						$book_title_t = explode('.',$row['book_title']);
						$book_title_1 = trim($book_title_t[0]);
						$book_title_2 = trim(end($book_title_t));
					}
					/*
					elseif (stripos($row['book_title'],':') !== false){
						$book_title_t = explode(':',$row['book_title']);
						$book_title_1 = trim($book_title_t[0]);
						$book_title_2 = trim(end($book_title_t));
					}
					*/
					elseif (stripos($row['book_title'],'!') !== false){
						$book_title_t = explode('!',$row['book_title']);
						$book_title_1 = trim($book_title_t[0]);
						$book_title_2 = trim(end($book_title_t));
					}
					else{
						$book_title_1 = $row['book_title'];
					}
					
					if (mb_strlen($book_title_1,'utf8') < 2) $book_title_1 = $row['book_title'];
					
					$q = "SELECT *
							FROM wp_posts
							WHERE
							post_status = 'publish'
							AND
							
							(
							" . ("MATCH(post_title) AGAINST ('\"" . $book_title_1 . "\"' IN BOOLEAN MODE) OR post_title like '%" . $book_title_1 . "%'") . "
							" . (mb_strlen($book_title_2,'utf8') > 10 ? " OR MATCH(post_title) AGAINST ('\"" . $book_title_2 . "\"' IN BOOLEAN MODE)" : "") . "
							
							)
							AND
							(
								" . (mb_strlen($row['author_sname'],'utf8') > 3 ? "MATCH(post_title) AGAINST ('\"" . $row['author_sname'] . "\"' IN BOOLEAN MODE)" : "post_title like '%" . $row['author_sname'] . "%'") . "
								" .
								(
								$row['second_author_sname'] != '' ?
								"OR
									(MATCH(post_title) AGAINST ('\"" . $row['second_author_sname'] . "\"' IN BOOLEAN MODE))
									" 
								: ""						
								)
							. "
							)
							
						";
					
					if (!mysqli_ping($db_link)) {
						echo "\r\n\r\nlost mysql connection!"; /*exit;*/
						
						mysqli_close($db_link);
						$db_link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
						mysqli_query($db_link, 'SET NAMES utf8');
					}

					$res = mysqli_query($db_link,$q);
					
					if (mysqli_num_rows($res) > 0){
						while ($r = mysqli_fetch_array($res)){
						
							//создаем бекап записи в таблице `wp_posts_original`
							$q = "INSERT IGNORE INTO `wp_posts_original` (SELECT * FROM `wp_posts` WHERE ID = ".$r['ID'].")";
							mysqli_query($db_link,$q);
						
							$litres_link = '//www.litres.ru/' . ($row['litres_url'] != '' ? $row['litres_url'] . '?' : 'pages/biblio_book/?art=' . $row['hub_id'] . '&' ) . $partner_utm_list;
							
							$q = "DELETE FROM `wp_postmeta` WHERE (meta_key = 'litres_link' OR meta_key = 'litres_hub_id') AND post_id = " . $r['ID'];
							mysqli_query($db_link,$q);
							
							echo $q = "INSERT INTO `wp_postmeta` SET
									post_id = " . $r['ID'] . ",
									meta_key = 'litres_link',
									meta_value = '" . $litres_link . "'";
							mysqli_query($db_link,$q);
							
							$q = "INSERT INTO `wp_postmeta` SET
										post_id = " . $r['ID'] . ",
										meta_key = 'litres_hub_id',
										meta_value = '" . $row['hub_id'] . "'";
							mysqli_query($db_link,$q);
							
							$q = "UPDATE `litres_data` SET
								local_book_id = " . $r['ID'] . "
								WHERE hub_id = " . $row['hub_id'];
							mysqli_query($db_link,$q);
							
							//чистим post_content от ссылок на файлообменники, литресные ссылки не удаляем
							$r['post_content'] = trim(preg_replace("/<a.*(dfiles|hitfile|hil\.to|hotlink).*>.+<\/a>/iuU",'',$r['post_content']));
							
							//ссылки на литрес уже могут быть проставлены вручную в постах
							//поэтому, определяем - если ссылки на литрес нет, то добавляем ее
							if (stripos($r['post_content'],'litres') === false){
								$r['post_content'] .= '<div id="litres_button_desktop" style="text-align:center;margin:10px">
													<a href="' . $litres_link . '" target="_blank"><img src="http://au-books.com/wp-content/uploads/2014/09/button-poluchit-audioknigu2.png" alt="получить-аудиокнигу" width="300" height="49" class="aligncenter size-full wp-image-24673" /></a>
													</div>';
							}
							
							$q = "UPDATE `wp_posts` SET 
										post_content = '" . mysqli_real_escape_string($db_link,$r['post_content']) . "'
										WHERE ID = " . $r['ID'];
							mysqli_query($db_link,$q);
							
							//вырезаем ссылки на скачивание из текста полной новости
							/*
							$full_story_t1 = '';
							if (stripos($r['full_story'],'[attachment=') !== false){
								$full_story_t1 = explode('[attachment=',$r['full_story'],2);
							}
							else{
								$full_story_t1 = explode('<noindex><div id="litres"',$r['full_story'],2);
							}
							$r['full_story'] = $full_story_t1[0];
								
							$q = "UPDATE `dle_post` SET
									full_story = '" . mysqli_real_escape_string($db_link,$r['full_story']) . "'
									WHERE id = " . $r['id'];
							mysqli_query($db_link,$q);
							*/
							//-----------------------------------------------------
						}
						mysqli_free_result($res);
					}
					
				}
				echo ($k++)."\r\n";
			}
		}
		
		//убираем служебный индекс
		$q = "ALTER TABLE `wp_posts` DROP INDEX litres_index_on_title";
		mysqli_query($db_link,$q);
		//-------------------------
		
	}
	
	function compare_local_global_manual($book_type = 0){

       Global $partner_utm_list, $partner_id, $partner_a_id, $table_prefix;
		
		
		

		if (($handle = fopen("manual_compared.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 10000, ";", '"')) !== FALSE) {
				$book_data = explode('|',$data[0],2);
				$local_book_id = $book_data[0];
				$litres_link = trim($data[1]);
				
				$q = "SELECT litres_local_data.*, dle_post.xfields, dle_post.full_story
						FROM litres_local_data
						JOIN dle_post USING (id)
						WHERE
							litresed = 0
						AND
							litres_local_data.id = " . $local_book_id;
					
				$res = mysql_query($q);
						
				if (mysql_num_rows($res) > 0){
					$r = mysql_fetch_array($res);
				
					//создаем бекап записи в таблице `dle_post_original`
					$q = "INSERT IGNORE INTO `dle_post_original` (SELECT * FROM `dle_post` WHERE id = " . $local_book_id . ")";
					mysql_query($q);
				
					$xfields = '';
					if ($r['xfields'] != '') $xfields = explode_xfields($r['xfields']);
							
					if (isset($xfields['litres_link'])) unset($xfields['litres_link']);
					if (isset($xfields['litres_a_link'])) unset($xfields['litres_a_link']); //на случай если книга совпала только по автору а через какое-то время по нвазнию книги - совпадение по автору стираем, иначе будет две ссылки на странице
					if (isset($xfields['litres_hub_id'])) unset($xfields['litres_hub_id']);
					//if (isset($xfields['litres_options'])) unset($xfields['litres_options']);
					if (isset($xfields['litres_has_trial'])) unset($xfields['litres_has_trial']);
					
					$xfields['litres_link'] = $litres_link;
								
					//собираем поля xfields в кучу
					$xfields_str = implode_xfields($xfields);
							
					echo $q = "UPDATE `dle_post` SET
							xfields = '" . mysql_real_escape_string($xfields_str) . "'
							WHERE id = " . $r['id'];
					//echo "<br><br>";
					mysql_query($q);
							
					
					//вырезаем ссылки на скачивание из текста полной новости
								
					if (stripos($r['full_story'],'<!--QuoteBegin-->') !== false){
						$r['full_story'] = preg_replace("/\<\!--QuoteBegin--\>.+\<\!--QuoteEEnd--\>/i","",$r['full_story']);
					}
								
					if (stripos($r['full_story'],'<!--dle_leech_begin-->') !== false){
						$r['full_story'] = preg_replace("/\<\!--dle_leech_begin--\>.+\<\!--dle_leech_end--\>/i","",$r['full_story']);
					}
								
					$q = "UPDATE `dle_post` SET
							full_story = '" . mysql_real_escape_string($r['full_story']) . "'
							WHERE id = " . $r['id'];
					mysql_query($q);
				}
			}
			fclose($handle);
		}
	}
	
	function compare_local_global_authors($book_type = 0){
		Global $partner_utm_list, $partner_id, $partner_a_id, $table_prefix;
		
		include('dictionary.php');
		
		//ставим временный индекс
		$q = "ALTER TABLE `" . $table_prefix . "post` ADD FULLTEXT litres_index_on_xfields (`xfields`)";
		mysql_query($q);
		//------------------------
		
		/*** сравниваем авторов ***/
	 	$q = "SELECT * FROM `litres_data` WHERE 
					`type` = " . $book_type . "
					AND hub_author_id > 0
					AND hub_author_id != 47672
					GROUP BY `hub_author_id`

				";

		$result = mysql_query($q);

		if (mysql_num_rows($result)>0){

			while ($row = mysql_fetch_array($result)){
				
				$litres_a_link = '';
				
				if ($row['author_sname'] != '' && $row['book_title'] != ''){
					$row['author_sname'] = trim(strtr($row['author_sname'], $repl_auth_ar));
					$q = "SELECT * FROM " . $table_prefix . "post WHERE
							" . ($book_type == 1 ? "category LIKE '%151%'" : "category NOT LIKE '%151%'") . "
							AND
							xfields NOT LIKE '%litres_link%' AND
							(
							xfields LIKE '%" . trim($row['author_sname'] . ' ' . $row['author_name']) . "%'
							OR
							xfields LIKE '%" . trim($row['author_name'] . ' ' . $row['author_sname']) . "%'
							)
						";
					
					$res = mysql_query($q);
					
					if (mysql_num_rows($res) > 0){
						while ($r = mysql_fetch_array($res)){
						
							$litres_a_link = 'http://www.litres.ru/' . ($row['litres_a_url'] != '' ? $row['litres_a_url'] . '?'.$partner_utm_list : 'pages/biblio_authors/?subject=' . $row['hub_author_id'] . '&='.$partner_utm_list );
							
							$xfields = '';
							if ($r['xfields'] != '') $xfields = explode_xfields($r['xfields']);
							$xfields['litres_a_link'] = $litres_a_link;
							
							//собираем поля xfields в кучу
							$xfields_str = implode_xfields($xfields);
							
							$q = "UPDATE `dle_post` SET
								xfields = '" . mysql_real_escape_string($xfields_str) . "'
								WHERE id = " . $r['id'];
							echo "<br><br>";
							mysql_query($q);
						}
					}
				}
				
			}
		}
		//убираем служебный индекс
		$q = "ALTER TABLE `" . $table_prefix . "post` DROP INDEX litres_index_on_xfields";
		mysql_query($q);
		//-------------------------
	}
	
	class picture {
	     
	    private $image_file;
	     
	    public $image;
	    public $image_type;
	    public $image_width;
	    public $image_height;
	     
	     
	    public function __construct($image_file) {
	        $this->image_file=$image_file;
	        $image_info = getimagesize($this->image_file);
	        $this->image_width = $image_info[0];
	        $this->image_height = $image_info[1];
	        switch($image_info[2]) {
	            case 1: $this->image_type = 'gif'; break;//1: IMAGETYPE_GIF
	            case 2: $this->image_type = 'jpeg'; break;//2: IMAGETYPE_JPEG
	            case 3: $this->image_type = 'png'; break;//3: IMAGETYPE_PNG
	            case 4: $this->image_type = 'swf'; break;//4: IMAGETYPE_SWF
	            case 5: $this->image_type = 'psd'; break;//5: IMAGETYPE_PSD
	            case 6: $this->image_type = 'bmp'; break;//6: IMAGETYPE_BMP
	            case 7: $this->image_type = 'tiffi'; break;//7: IMAGETYPE_TIFF_II (порядок байт intel)
	            case 8: $this->image_type = 'tiffm'; break;//8: IMAGETYPE_TIFF_MM (порядок байт motorola)
	            case 9: $this->image_type = 'jpc'; break;//9: IMAGETYPE_JPC
	            case 10: $this->image_type = 'jp2'; break;//10: IMAGETYPE_JP2
	            case 11: $this->image_type = 'jpx'; break;//11: IMAGETYPE_JPX
	            case 12: $this->image_type = 'jb2'; break;//12: IMAGETYPE_JB2
	            case 13: $this->image_type = 'swc'; break;//13: IMAGETYPE_SWC
	            case 14: $this->image_type = 'iff'; break;//14: IMAGETYPE_IFF
	            case 15: $this->image_type = 'wbmp'; break;//15: IMAGETYPE_WBMP
	            case 16: $this->image_type = 'xbm'; break;//16: IMAGETYPE_XBM
	            case 17: $this->image_type = 'ico'; break;//17: IMAGETYPE_ICO
	            default: $this->image_type = ''; break;
	        }
	        $this->fotoimage();
	    }
	     
	    private function fotoimage() {
	        switch($this->image_type) {
	            case 'gif': $this->image = imagecreatefromgif($this->image_file); break;
	            case 'jpeg': $this->image = imagecreatefromjpeg($this->image_file); break;
	            case 'png': $this->image = imagecreatefrompng($this->image_file); break;
	        }
	    }
	     
	    public function autoimageresize($new_w, $new_h) {
	        $difference_w = 0;
	        $difference_h = 0;
	        if($this->image_width < $new_w && $this->image_height < $new_h) {
	            $this->imageresize($this->image_width, $this->image_height);
	        }
	        else {
	            if($this->image_width > $new_w) {
	                $difference_w = $this->image_width - $new_w;
	            }
	            if($this->image_height > $new_h) {
	                $difference_h = $this->image_height - $new_h;
	            }
	                if($difference_w > $difference_h) {
	                    $this->imageresizewidth($new_w);
	                }
	                elseif($difference_w < $difference_h) {
	                    $this->imageresizeheight($new_h);
	                }
	                else {
	                    $this->imageresize($new_w, $new_h);
	                }
	        }
	    }
	     
	    public function percentimagereduce($percent) {
	        $new_w = $this->image_width * $percent / 100;
	        $new_h = $this->image_height * $percent / 100;
	        $this->imageresize($new_w, $new_h);
	    }
	     
	    public function imageresizewidth($new_w) {
	        $new_h = $this->image_height * ($new_w / $this->image_width);
	        $this->imageresize($new_w, $new_h);
	    }
	     
	    public function imageresizeheight($new_h) {
	        $new_w = $this->image_width * ($new_h / $this->image_height);
	        $this->imageresize($new_w, $new_h);
	    }
	     
	    public function imageresize($new_w, $new_h) {
	        $new_image = imagecreatetruecolor($new_w, $new_h);
	        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $new_w, $new_h, $this->image_width, $this->image_height);
	        $this->image_width = $new_w;
	        $this->image_height = $new_h;
	        $this->image = $new_image;
	    }
	     
	    public function imagesave($image_type='jpeg', $image_file=NULL, $image_compress=100, $image_permiss='') {
	        if($image_file==NULL) {
	            switch($this->image_type) {
	                case 'gif': header("Content-type: image/gif"); break;
	                case 'jpeg': header("Content-type: image/jpeg"); break;
	                case 'png': header("Content-type: image/png"); break;
	            }
	        }
	        switch($this->image_type) {
	            case 'gif': imagegif($this->image, $image_file); break;
	            case 'jpeg': imagejpeg($this->image, $image_file, $image_compress); break;
	            case 'png': imagepng($this->image, $image_file); break;
	        }
	        if($image_permiss != '') {
	            chmod($image_file, $image_permiss);
	        }
	    }
	     
	    public function imageout() {
	        imagedestroy($this->image);
	    }
	     
	    public function __destruct() {
	         
	    }
	     
	}
	
	
?>