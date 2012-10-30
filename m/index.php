<?php
$con = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
if (!$con) {
  die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");  
mysql_select_db("app_iscu", $con);

$result_jiaowu = mysql_query("SELECT * FROM jiaowu");
$result_tuanwei = mysql_query("SELECT * FROM tuanwei");
$result_scu = mysql_query("SELECT * FROM scu");
?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>川大联播 | 订阅你自己的校园新闻</title>
  <meta name="author" content="kshift|FIT" />
  <meta name="viewport" content = "width = device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1" />
  <link rel="stylesheet" href="./m_base.css">
</head>
<body>
<ul>
  <div class="title">川大教务</div>
  <?php
    $str_jiaowu = '';
    $i = 0;
    while ($row = mysql_fetch_array($result_jiaowu)) {
      $str_jiaowu .= '<li><a href="article.php?type=jiaowu&id='.$i.'" class="content-title">'.$row['Title'].'</a><p class="content-time">'.$row['Time'].'</p></li>';
      $i++;
    }
    echo $str_jiaowu;
  ?>

  <div class="title">川大团委</div>
  <?php
    $str_tuanwei = '';
    $i = 0;
    while ($row = mysql_fetch_array($result_tuanwei)) {
      $str_tuanwei .= '<li><a href="article.php?type=tuanwei&id='.$i.'" class="content-title">'.$row['Title'].'</a><p class="content-time">'.$row['Time'].'</p></li>';
      $i++;
    }
    echo $str_tuanwei;
  ?>

  <div class="title">川大首页</div>
  <?php
    $str_scu = '';
    $i = 0;
    while ($row = mysql_fetch_array($result_scu)) {
      $str_scu .= '<li><a href="article.php?type=tuanwei&id='.$i.'" class="content-title">'.$row['Title'].'</a><p class="content-time">'.$row['Time'].'</p></li>';
      $i++;
    }
    echo $str_scu;
    ?>

</ul>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35595707-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>