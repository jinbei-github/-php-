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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO news (news_title, news_type, news_content, news_date, news_author,bin_data) VALUES (%s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['news_title'], "text"),
                       GetSQLValueString($_POST['news_type'], "text"),
                       GetSQLValueString($_POST['news_content'], "text"),
                       GetSQLValueString($_POST['news_date'], "date"),
                       GetSQLValueString($_POST['news_author'], "text"),
					   GetSQLValueString($_POST['bin_data'], "text"));
	

  mysql_select_db($database_news, $news);
  $Result1 = mysql_query($insertSQL, $news) or die(mysql_error());

  $insertGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_news, $news);
$query_Recordset1 = "SELECT * FROM newstype";
$Recordset1 = mysql_query($query_Recordset1, $news) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
<title>添加新闻</title>
<style type="text/css">
<!--

-->
</style>
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
</head>

<body>
	<div class="container">
	<form action="" method="post" enctype="multipart/form-data">
	<label for="file">文件名：</label>
	<input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="提交">
</form>
		<form method="POST" action="<?php echo $editFormAction; ?>" name="form1" id="form1" onSubmit="MM_validateForm('news_title','','R','news_author','','R','news_content','','R');return document.MM_returnValue">
  <table class="table">
   <thead>
  <h3>请添加新闻：</h3>
   </thead>
    <tbody>
    	 <tr>
      <td>新闻标题：</td>
      <td width="508">
       	<label>
        <input name="news_title" type="text" id="news_title" size="30" />
        </label>
          <span>* </span>
       </td>
    </tr>
    <tr>
      <td>新闻分类：</td>
      <td>
       <label>
        <select name="news_type" id="news_type">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['type_id']?>"<?php if (!(strcmp($row_Recordset1['type_id'], $row_Recordset1['type_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['type_name']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
        </label>
          <span class="STYLE1">*作者：<span class="STYLE2"></span>
          <label>
          <input name="news_author" type="text" id="news_author" size="14" />
          </label>
          *</span></td>
    </tr>
    <tr>
      <td>新闻内容：</td>
      <td>
          <span>
          <label>
          <textarea name="news_content" cols="60" rows="20" id="news_content"></textarea>
          </label>
          *
          <!--这是时间框，已隐藏-->
          <input name="news_date" type="hidden" id="news_date" value="<?php
date_default_timezone_set('Asia/Shanghai');
echo date("Y-m-d");
?>">
          </span></td>
    </tr>
    <tr>
<!--
    	<td>上传相关的图片:</td>
    	<td>
    		<input type="file">
    	</td>
-->
<!--    	<form method="post" action="upimage.php" enctype="multipart/form-data">-->
<!--
		  描述:
		  <input type="text" name="form_description" size="40">
		  <input type="hidden" name="MAX_FILE_SIZE" value="1000000"> <br>
-->
		  上传文件到upload文件夹的文件名:
		  <input type="text" name="bin_data" id="bin_data" size="40"><br>
<!--		  <input type="submit" name="submit" value="submit">-->
<!--		</form>-->
    </tr>
    <tr>
      <td colspan="2">
          <input name="submit" type="submit" onClick="MM_validateForm('news_title','','R','news_author','','R','news_content','','R');return document.MM_returnValue" value="添加" />
        &nbsp;&nbsp;
        <input type="reset" name="Submit2" value="重置" />
        &nbsp;&nbsp;<span class="STYLE1">*</span>带*号为必填项目</td>
    </tr>
    </tbody>
   
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>

	</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>