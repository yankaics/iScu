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
  
  $message = '<strong>川大教务</strong><br /><ul>';
  while ($row = mysql_fetch_array($result_jiaowu)) {
    $message .= '<li><a href="'.$row['Url'].'">'.$row['Title'].'</a></li>';
  }
  $message .= '</ul>';

  $message .= '<br /><strong>川大团委</strong><br /><ul>';
  while ($row = mysql_fetch_array($result_tuanwei)) {
    $message .= '<li><a href="'.$row['Url'].'">'.$row['Title'].'</a></li>';
  }
  $message .= '</ul>';

  $message .= '<br /><strong>川大首页</strong><br /><ul>';
  while ($row = mysql_fetch_array($result_scu)) {
    $message .= '<li><a href="'.$row['Url'].'">'.$row['Title'].'</a></li>';
  }
  $message .= '</ul>';

  $mail = new SaeMail();
  $options = array("from"=>'iscumail@126.com', "to"=>'scuu@googlegroups.com', "smtp_host"=>'smtp.126.com',"smtp_username"=>'iscumail@126.com',"smtp_password"=>'finalitit',"subject"=>'[川大联播]通知摘要',"content"=>$message,"content_type"=>'HTML');
  $ret=false;
  if($mail->setOpt($options))
    $ret=$mail->send();
   
  //发送失败时输出错误码和错误信息
  if ($ret === false)
    var_dump($mail->errno(), $mail->errmsg());
?>