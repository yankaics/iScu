 <?php
// unicode转换为汉字
function entity2utf8onechar($unicode_c){
    $unicode_c_val = intval($unicode_c);
    $f=0x80; // 10000000
    $str = "";
    // U-00000000 - U-0000007F:   0xxxxxxx
    if($unicode_c_val <= 0x7F){      $str = chr($unicode_c_val);     }   //U-00000080 - U-000007FF:  110xxxxx 10xxxxxx   
    else if($unicode_c_val >= 0x80 && $unicode_c_val <= 0x7FF){       
    $h=0xC0; // 11000000        
    $c1 = $unicode_c_val >> 6 | $h;
        $c2 = ($unicode_c_val & 0x3F) | $f;
        $str = chr($c1).chr($c2);
    }
    //U-00000800 - U-0000FFFF:  1110xxxx 10xxxxxx 10xxxxxx
    else if($unicode_c_val >= 0x800 && $unicode_c_val <= 0xFFFF){         
    $h=0xE0; // 11100000        
    $c1 = $unicode_c_val >> 12 | $h;
        $c2 = (($unicode_c_val & 0xFC0) >> 6) | $f;
        $c3 = ($unicode_c_val & 0x3F) | $f;
        $str=chr($c1).chr($c2).chr($c3);
    }
    //U-00010000 - U-001FFFFF:  11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
    else if($unicode_c_val >= 0x10000 && $unicode_c_val <= 0x1FFFFF){         
    $h=0xF0; // 11110000        $c1 = $unicode_c_val >> 18 | $h;
        $c2 = (($unicode_c_val & 0x3F000) >>12) | $f;
        $c3 = (($unicode_c_val & 0xFC0) >>6) | $f;
        $c4 = ($unicode_c_val & 0x3F) | $f;
        $str = chr($c1).chr($c2).chr($c3).chr($c4);
    }
    //U-00200000 - U-03FFFFFF:  111110xx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx
    else if($unicode_c_val >= 0x200000 && $unicode_c_val <= 0x3FFFFFF){       
    $h=0xF8; // 11111000        
    $c1 = $unicode_c_val >> 24 | $h;
        $c2 = (($unicode_c_val & 0xFC0000)>>18) | $f;
        $c3 = (($unicode_c_val & 0x3F000) >>12) | $f;
        $c4 = (($unicode_c_val & 0xFC0) >>6) | $f;
        $c5 = ($unicode_c_val & 0x3F) | $f;
        $str = chr($c1).chr($c2).chr($c3).chr($c4).chr($c5);
    }
    //U-04000000 - U-7FFFFFFF:  1111110x 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx
    else if($unicode_c_val >= 0x4000000 && $unicode_c_val <= 0x7FFFFFFF){         
    $h=0xFC; // 11111100        $c1 = $unicode_c_val >> 30 | $h;
        $c2 = (($unicode_c_val & 0x3F000000)>>24) | $f;
        $c3 = (($unicode_c_val & 0xFC0000)>>18) | $f;
        $c4 = (($unicode_c_val & 0x3F000) >>12) | $f;
        $c5 = (($unicode_c_val & 0xFC0) >>6) | $f;
        $c6 = ($unicode_c_val & 0x3F) | $f;
        $str = chr($c1).chr($c2).chr($c3).chr($c4).chr($c5).chr($c6);
    }
    return $str;
}
function entities2utf8($unicode_c){
    $unicode_c = preg_replace("/\&\#([\da-f]{5})\;/es", "entity2utf8onechar('\\1')", $unicode_c);
    return $unicode_c;
}

function fetchUrl($url){
  $curl_hand = curl_init($url);
  curl_setopt($curl_hand,CURLOPT_RETURNTRANSFER,true);
  $curl_Data = curl_exec($curl_hand);
  if($curl_Data === false)
  {
    $this->showErrorInfo(new Exception());
  }
  curl_close($curl_hand);
  return $curl_Data;
}

$con = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);

if (!$con) {
  die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");  
mysql_select_db("app_iscu", $con);

// Jiaowu
$content = fetchUrl('http://jwc.scu.edu.cn/jwc/frontPage.action');
preg_match_all('/<td width="440" height="360"(.*)<td width="260" height="360"/is', $content, $url_list);
preg_match_all('/<a href="(.*)"/isU', $url_list[0][0], $url);

if (strlen($url[1][9]) > 1) {
  mysql_query("DELETE FROM jiaowu");

  for ($i = 0; $i < 10; $i++) { 
    $URL[$i] = 'http://jwc.scu.edu.cn/jwc/'.$url[1][$i];

    $CONTENT = fetchUrl($URL[$i]);
    preg_match_all('/<td align="center" style="font-size:24px"><b>(.*)<\/b>/is', $CONTENT, $title);
    preg_match_all('/<font color="#999999" size="2">发布时间：(.*)录入科室/is', $CONTENT, $time);
    preg_match_all('/<input type="hidden" name="news.content" value="(.*)" id="news_content"\/>/is', $CONTENT, $value);

    $TITLE = entities2utf8($title[1][0]);
    //$TITLE = $title[1][0];
    $TIME = $time[1][0];
    $VALUE = htmlspecialchars_decode($value[1][0]);
    $VALUE = strip_tags($VALUE,"<table> <td> <tr> <tbody>");
    $VALUE = entities2utf8($VALUE);

    $sql = "INSERT INTO jiaowu (UID, Title, Content, Time, Url) VALUES ('$i', '$TITLE', '$VALUE', '$TIME', '$URL[$i]')";
    if (!mysql_query($sql, $con)) {
      die('Error: ' . mysql_error());
    }
  }
}

// Tuanwei
$content = fetchUrl('http://tuanwei.scu.edu.cn/tw/');
preg_match_all('/<table width="98%"(.*)<\/table>/isU', $content, $url_list);
preg_match_all('/<a href="(.*)"/isU', $url_list[0][0], $url);

if (strlen($url[1][7]) > 1) {
  mysql_query("DELETE FROM tuanwei");

  for ($i = 0; $i < 8; $i++) { 
    $URL[$i] = 'http://tuanwei.scu.edu.cn/tw/'.$url[1][$i];
    $CONTENT = fetchUrl($URL[$i]);
    preg_match_all('/<td colspan="3" height="55" align="center" style=" font-size:18px; font-family:(.*)<\/td>/isU', $CONTENT, $title);
    preg_match_all('/<td colspan="3" align="center">(.*)<\/td>/isU', $CONTENT, $time);
    preg_match_all('/<div class="articlecontent">(.*)<hr noshade>/isU', $CONTENT, $value);

    $TITLE = strip_tags($title[0][0]);
    $TITLE = iconv('gb2312', 'utf-8', $TITLE);
    $TIME = strip_tags($time[0][0]);
    $VALUE = strip_tags($value[1][0],"<table> <td> <tr> <tbody>");
    $VALUE = iconv('gb2312', 'utf-8', $VALUE);

    $sql = "INSERT INTO tuanwei (UID, Title, Content, Time, Url) VALUES ('$i', '$TITLE', '$VALUE', '$TIME', '$URL[$i]')";
    if (!mysql_query($sql, $con)) {
      die('Error: ' . mysql_error());
    }
  }
}

// Scu
$content = fetchUrl('http://www.scu.edu.cn/');
preg_match_all('/<td width="86%">(.*)<table class=/isU', $content, $url_list);
preg_match_all('/<a href=(.*) /isU', $url_list[0][0], $url);

if (strlen($url[1][4]) > 1) {
  mysql_query("DELETE FROM scu");

  for ($i = 0; $i < 5; $i++) { 
    $URL[$i] = 'http://www.scu.edu.cn/'.$url[1][$i];
    $CONTENT = fetchUrl($URL[$i]);
    preg_match_all('/<DIV align=center valign="bottom">(.*)<\/DIV>/isU', $CONTENT, $title);
    preg_match_all('/<DIV align=center>(.*) (.*) /isU', $CONTENT, $time);
    preg_match_all('/<DIV id=BodyLabel>(.*)<\/DIV>/isU', $CONTENT, $value);

    $TITLE = $title[1][0];
    $TITLE = iconv('gbk', 'utf-8', $TITLE);
    $TIME = $time[2][0];
    $VALUE = str_replace("<br>", "\r\n", $value[0][0]);
    $VALUE = strip_tags($VALUE,"<table> <td> <tr> <tbody> <br>");
    $VALUE = iconv('gbk', 'utf-8', $VALUE);

    $sql = "INSERT INTO scu (UID, Title, Content, Time, Url) VALUES ('$i', '$TITLE', '$VALUE', '$TIME', '$URL[$i]')";
    if (!mysql_query($sql, $con)) {
      die('Error: ' . mysql_error());
    }
  }
}

mysql_close($con);

?>