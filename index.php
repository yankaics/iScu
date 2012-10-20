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
$i = 1;

?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>川大联播 | 订阅你自己的校园新闻</title>
  <meta name="author" content="kshift|FIT">

  <link rel="stylesheet" href="./style/base.css">
  <link rel="stylesheet" href="./style/960_12_col.css">
  <link rel="stylesheet" href="./style/reset.css">
  <script src="./script/jquery.min.js"></script>

  <script type="text/javascript" src="./script/mixture.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#box').bounceBox();
      $('a.button').click(function(e){
        $('#box').bounceBoxToggle();
        e.preventDefault();
      });
      $('#box').click(function(){
        $('#box').bounceBoxHide();
      });
      $('#main').click(function(){
        $('#box').bounceBoxHide();
      });
    });
    $(function() {
      var agt = navigator.userAgent,
      winVer = Number(agt.replace(/.*Windows NT (\b[\d\.] ).*/i, '$1')),
      ieVer = Number(agt.replace(/.*MSIE (\b[\d\.] ).*/i, '$1'));
      $.support.WPF = winVer >= 6 || ieVer >= 7;
      if (!$.support.WPF) {
        $('body').addClass('no-support-wpf');
      }
    })
  </script>
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

</head>
<body id="top" class="container_12">
  <!--[if lte IE 6]>
  <div id="xl">你正在使用的浏览器版本太低，将不能正常浏览本站。<br />请升级 <a href="http://windows.microsoft.com/zh-CN/internet-explorer/downloads/ie">Internet Explorer</a> 或使用 <a href="http://www.google.com/chrome/">Google Chrome</a> 浏览器。</div>
  <![endif]-->

  <!-- Main -->
  <div id="main" class="grid_10">
    <div id="jiaowu">
      <p class="list-name">川大教务</p>
      <ul>
        <?php
        while ($row = mysql_fetch_array($result_jiaowu)) {
          $row['Content'] = trim($row['Content']);
          $row['Content'] = str_replace("&nbsp;", "", $row['Content']);
          $row['Content'] = "<div class='hidden'><p class='content-hidden'>".trim($row['Content']);
          $row['Content'] = str_replace("\r\n", "</p><p class='content-hidden'>", $row['Content']);
          $row['Content'] .= "</p>";
          $row['Content'] = str_replace("<p class='content-hidden'></p>", "", $row['Content']);
        ?>
        <li>
          <div class="content" id="<?php echo"content-$i" ?>">
            <a href="more" class="content-title" id="<?php echo"content-$i" ?>"><?php echo $row['Title'] ?></a>
            <p class="content-time"><?php echo $row['Time'] ?></p>
            <?php echo $row['Content'] ?>
            <div class="showmore">
              <a href="<?php echo $row['Url'] ?>" target="_blank">查看原文</a>
              <a href="more" id="<?php echo"content-$i" ?>"><span>收起文章</span></a>
            </div></div>
          </div>
        </li>
        <?php $i++; } ?>
      </ul>
    </div>

    <div id="tuanwei">
      <p class="list-name">川大团委</p>
      <ul>
        <?php
        while ($row = mysql_fetch_array($result_tuanwei)) {
          $row['Content'] = trim($row['Content']);
          $row['Content'] = str_replace("&nbsp;", "", $row['Content']);
          $row['Content'] = "<div class='hidden'><p class='content-hidden'>".trim($row['Content']);
          $row['Content'] = str_replace("\r\n", "</p><p class='content-hidden'>", $row['Content']);
          $row['Content'] .= "</p>";
          $row['Content'] = str_replace("<p class='content-hidden'></p>", "", $row['Content']);
        ?>
        <li>
          <div class="content" id="<?php echo"content-$i" ?>">
            <a href="more" class="content-title" id="<?php echo"content-$i" ?>"><?php echo $row['Title'] ?></a>
            <p class="content-time"><?php echo $row['Time'] ?></p>
            <?php echo $row['Content'] ?>
            <div class="showmore">
              <a href="<?php echo $row['Url'] ?>" target="_blank">查看原文</a>
              <a href="more" id="<?php echo"content-$i" ?>"><span>收起文章</span></a>
            </div></div>  
          </div>
        </li>
        <?php $i++; } ?>
      </ul>
    </div>

    <div id="scu">
      <p class="list-name">川大首页</p>
      <ul>
        <?php
        while ($row = mysql_fetch_array($result_scu)) {
          $row['Content'] = trim($row['Content']);
          $row['Content'] = str_replace(" ", "", $row['Content']);
          $row['Content'] = "<div class='hidden'><p class='content-hidden'>".trim($row['Content']);
          $row['Content'] = str_replace("\r\n", "</p><p class='content-hidden'>", $row['Content']);
          $row['Content'] .= "</p>";
          $row['Content'] = str_replace("<p class='content-hidden'></p>", "", $row['Content']);
        ?>
        <li>
          <div class="content" id="<?php echo"content-$i" ?>">
            <a href="more" class="content-title" id="<?php echo"content-$i" ?>"><?php echo $row['Title'] ?></a>
            <p class="content-time"><?php echo $row['Time'] ?></p>
            <?php echo $row['Content'] ?>
            <div class="showmore">
              <a href="<?php echo $row['Url'] ?>" target="_blank">查看原文</a>
              <a href="more" id="<?php echo"content-$i" ?>"><span>收起文章</span></a>
            </div></div>  
          </div>
        </li>
        <?php $i++; } ?>
      </ul>
    </div>
  </div>
  <!-- /Main -->

  <!-- Navigation -->
  <nav id="navigation" class="grid_2">
    <a href="#" id="navigation-ribbon" class="button"><img src="./image/ribbon.png" alt="HELP"></a>
    <!-- Menu -->
    <ul>
      <li><a href="#jiaowu" class="anchor">川大教务</a></li>
      <li><a href="#tuanwei" class="anchor">川大团委</a></li>
      <li><a href="#scu" class="anchor">川大首页</a></li>
    </ul>
    <!-- /Menu -->
  </nav>
  <!-- /Navigation -->
  <div class="clear"></div>

<div id="box">
  <p><b>本站所有内容均来自四川大学网站，每日12时更新。</b></p>
  <p>操作说明:</p>
  <ul>
    <li>点击文章标题可查看全文；</li>
    <li>点击文章末尾“查看原文”可跳转至原网页；</li>
  </ul>
</div>
</body>
</html>