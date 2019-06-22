<?php require_once('../Connections/news.php'); ?>
<?php
error_reporting(0);
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE news SET news_title=%s, news_type=%s, news_content=%s, news_date=%s, news_author=%s,bin_data=%s WHERE news_id=%s",
                       GetSQLValueString($_POST['news_title'], "text"),
                       GetSQLValueString($_POST['news_type'], "text"),
                       GetSQLValueString($_POST['news_content'], "text"),
                       GetSQLValueString($_POST['news_date'], "date"),
                       GetSQLValueString($_POST['news_author'], "text"),
					   GetSQLValueString($_POST['bin_data'], "text"),
                       GetSQLValueString($_POST['news_id'], "int")
					   );

  mysql_select_db($database_news, $news);
  $Result1 = mysql_query($updateSQL, $news) or die(mysql_error());

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

mysql_select_db($database_news, $news);
$query_Recordset2 = "SELECT * FROM newstype";
$Recordset2 = mysql_query($query_Recordset2, $news) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<?php
header("content-type:text/html;charset=utf-8");  //设置编码
// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
echo $_FILES["file"]["size"];
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2048000)   // 小于 200 kb
&& in_array($extension, $allowedExts))
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
		echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
		echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
		echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";
		
		// 判断当期目录下的 upload 目录是否存在该文件
		// 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
		if (file_exists("upload/" . $_FILES["file"]["name"]))
		{
			echo $_FILES["file"]["name"] . " 文件已经存在。 ";
		}
		else
		{
			// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
			move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
			echo "文件存储在: " . "upload/" . $_FILES["file"]["name"];
		}
	}
}
else
{
	echo "非法的文件格式";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- 引入 Bootstrap --> 
        <script src="../js/jquery/3.3.1/jquery.min.js"></script> 
        <link href="../css/bootstrap/3.3.7/bootstrap.min.css" rel="stylesheet">
        <script src="../js/bootstrap/3.3.7/bootstrap.min.js"></script>  
        <script src="../js/holder.min.js"></script>
<title>更新新闻</title>
<style type="text/css">
<!--

-->
</style></head>

<body>
<div class="container">
<form action="" method="post" enctype="multipart/form-data">
	<label for="file">文件名：</label>
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="提交">
</form>
	<form method="POST" action="<?php echo $editFormAction; ?>" id="form1" name="form1">
  <table class="table">
    <tr>
      <td>管理员，你好！请你修改新闻！</td>
    </tr>
    <tr>
      <td>新闻标题：</td>
      <td ><label>
        <input name="news_title" type="text" id="news_title" value="<?php echo $row_Recordset1['news_title']; ?>" size="30" />
        <input name="news_id" type="hidden" id="news_id" value="<?php echo $row_Recordset1['news_id']; ?>">
      </label></td>
    </tr>
    <tr>
      <td height="20">更新时间：</td>
      <td><label>
        <input name="news_date" type="text" id="news_date" value="<?php
date_default_timezone_set('Asia/Shanghai');
echo date("Y-m-d");
?>
" size="30"  />
      </label></td>
    </tr>
    <tr>
      <td height="20">新闻分类：</td>
      <td><label>
        <select name="news_type" id="news_type">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['type_id']?>"<?php if (!(strcmp($row_Recordset2['type_id'], $row_Recordset2['type_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['type_name']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select>
        </label>
        <span class="STYLE1">&nbsp;&nbsp;&nbsp; <span class="STYLE2">作者</span>
          <label>
          <input name="news_author" type="text" id="news_author" value="<?php echo $row_Recordset1['news_author']; ?>" size="12" />
          </label>
        </span></td>
    </tr>
    <tr>
      <td height="20">新闻内容：</td>
      <td>
        <span class="STYLE1">
          <label>
          <textarea name="news_content" cols="80" rows="20" id="news_content"><?php echo $row_Recordset1['news_content']; ?></textarea>
          </label>
        </span></td>
    </tr>
    <tr>
    	上传文件到upload文件夹的文件名:
		  <input type="text" name="bin_data" id="bin_data" size="40" value="<?php echo $row_Recordset1['bin_data']; ?>"><br>
    </tr>
    <tr>
      <td colspan="2">
          <input type="submit" name="Submit" value="更新" />
        &nbsp;&nbsp;
        <input name="Submit2" type="reset" value="重置" />
        &nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
