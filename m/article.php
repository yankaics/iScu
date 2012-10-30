<?php
$con = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
if (!$con) {
  die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");  
mysql_select_db("app_iscu", $con);

$type = $_GET['type'];
$id = $_GET['id'];

$result = mysql_query("SELECT * FROM $type WHERE UID=$id");
$row = mysql_fetch_array($result);
$row['Content'] = "</div><p class='content'>".trim($row['Content']);
$row['Content'] = str_replace("\r\n", "</p><p class='content'>", $row['Content']);
$row['Content'] .= "</p>";
$row['Content'] = str_replace("<p class='content'></p>", "", $row['Content']);

$str = '<div class="article-title">'.$row['Title'].$row['Content'];
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
	<?php echo $str; ?>

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