<?php require_once('Connections/news.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "-1";
if (isset($_GET['news_id'])) {
  $colname_Recordset1 = $_GET['news_id'];
}
mysql_select_db($database_news, $news);
$query_Recordset1 = sprintf("SELECT * FROM news WHERE news_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $news) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- 引入 Bootstrap --> 
        <script src="js/jquery/3.3.1/jquery.min.js"></script> 
        <link href="css/bootstrap/3.3.7/bootstrap.min.css" rel="stylesheet"> 
        <link href="css/reset.min.css" rel="stylesheet">
    	<link href="css/style.css" rel="stylesheet">
        <script src="js/bootstrap/3.3.7/bootstrap.min.js"></script>  
        <script src="js/holder.min.js"></script> 
<title>新闻查看内容</title>
<style type="text/css">

	.square .square-tile-center {
    position: absolute;
    /* bottom: 35px; */
    color: white;
}
</style></head>

<body>
<div class="container">

<table class="table">
 <!--页头-->
  <tr>
  </tr>
  <!--页面内容-->
  <tr>
    <div class="thumbnail">
    
	  <img class="hidden-xs img-responsive" alt="test image one" src="admin/upload/<?php echo $row_Recordset1['bin_data'];?>">
	  <div class="caption">
		<h3>新闻标题：<?php echo $row_Recordset1['news_title']; ?></h3>
		<p>加入时间：<?php echo $row_Recordset1['news_date']; ?></p>
		<p>新闻内容：<?php echo $row_Recordset1['news_content']; ?></p> 
		<p>
		<!--评论下载标签-->
		<div>
			<!--用户在这里评论-->
			<a href="#">
		 		<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
			</a>
			
			<!--用户在这里下载-->
		 	<a href="#">
		 		<span class="glyphicon glyphicon-save" aria-hidden="true"></span>
			</a>
		</div>
		
		</p>
	  </div>
	</div>
  </tr>
  <!--页脚-->
  <tr>
  </tr>
</table>
	
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
