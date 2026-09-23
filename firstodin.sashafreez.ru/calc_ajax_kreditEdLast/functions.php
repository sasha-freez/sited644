<?php
function PHP_slashes($string,$type='add')
{
    if ($type == 'add')
    {
        if (get_magic_quotes_gpc())
        {
            return $string;
        }
        else
        {
            if (function_exists('addslashes'))
            {
                return addslashes($string);
            }
            else
            {
                return mysql_real_escape_string($string);
            }
        }
    }
    else if ($type == 'strip')
    {
        return stripslashes($string);
    }
    else
    {
        die('error in PHP_slashes (mixed,add | strip)');
    }
}
if(!function_exists('utf8_strlen'))
	{
	function utf8_strlen($s)
		{
		return preg_match_all('/./u', $s, $tmp);
		}
	}

if(!function_exists('utf8_substr'))
	{
	function utf8_substr($s, $offset, $len = 'all')
		{
		if ($offset<0) $offset = utf8_strlen($s) + $offset;
		if ($len!='all')
			{
			if ($len<0) $len = utf8_strlen2($s) - $offset + $len;
			$xlen = utf8_strlen($s) - $offset;
			$len = ($len>$xlen) ? $xlen : $len;
			preg_match('/^.{' . $offset . '}(.{0,'.$len.'})/us', $s, $tmp);
			}
			else
			{
			preg_match('/^.{' . $offset . '}(.*)/us', $s, $tmp);
			}
		return (isset($tmp[1])) ? $tmp[1] : false;
		}
	}
if(!function_exists('utf8_strpos'))
	{
function utf8_strpos($str, $needle, $offset = null)
      {
          if (is_null($offset))
          {
              return mb_strpos($str, $needle);
          }
          else
          {
              return mb_strpos($str, $needle, $offset);
          }
      }
}
function getAllcache($sql, $time=600, $filename='') {
	global $DB, $system_query_cache;
	if(!$system_query_cache)$time=0;
	$crc=md5($sql); 
	if(!empty($filename))$crc=$filename;
	$modif=time()-@filemtime ("cache/".$crc);
	if ($modif<$time)
		{
		$cache=file_get_contents("cache/".$crc);
		$cache=unserialize($cache);
		}
		else 
		{
		$cache = $DB->getAll($sql);
		$fp = @fopen ("cache/".$crc, "w");
		@fwrite ($fp, serialize($cache));
		@fclose ($fp); 
		}
        return $cache;
}
function getOnecache($sql, $time=600,$filename='') {
	global $DB, $system_query_cache;
	if(!$system_query_cache)$time=0;
	$crc=md5($sql); 
	if(!empty($filename))$crc=$filename;
	$modif=time()-@filemtime ("cache/".$crc);
	if ($modif<$time)
		{
		$cache=file_get_contents("cache/".$crc);
		$cache=unserialize($cache);
		}
		else 
		{
		$cache = $DB->getOne($sql);
		$fp = @fopen ("cache/".$crc, "w");
		@fwrite ($fp, serialize($cache));
		@fclose ($fp); 
		}
        return $cache;
}

function parseString( $str , $val, $par) {
        if ($par==1)$str = str_replace('\\','',preg_replace("/['\"`!\\/@№;:?#$%^&*()_]/","",@strval($str)));
        if ($val>=1)$str = trim( $str ); 
        if ($val>=2)$str = str_replace(' ','',$str); 
        if ($val>=3)$str = preg_replace("/[^\x20-\xFF]/","",@strval($str)); 
        if ($val>=4)$str = strip_tags( $str ); 
        if ($val>=5)$str = htmlspecialchars( $str, ENT_QUOTES );
        if ($val>=6)$str = mysql_real_escape_string( $str ); 
        return $str;
}
