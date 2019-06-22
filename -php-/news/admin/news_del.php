<?php require_once('../Connections/news.php'); ?>
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

if ((isset($_GET['news_id'])) && ($_GET['news_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM news WHERE news_id=%s",
                       GetSQLValueString($_GET['news_id'], "int"));

  mysql_select_db($database_news, $news);
  $Result1 = mysql_query($deleteSQL, $news) or die(mysql_error());

  $deleteGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>删除新闻</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
	color: #FF0000;
}
body {
	margin-top: 0px;
}
.STYLE1 {color: #FF0000}
.STYLE2 {color: #000000}
-->
</style></head>

<body>
<form id="form1" name="form1">
  <table width="561" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#99CCCC">
    <tr>
      <td height="30" colspan="2">管理员，你好，你要删除此新闻吗？</td>
    </tr>
    <tr>
      <td width="93" height="20">新闻标题：</td>
      <td width="462"><label>
        <input name="textfield" type="text" value="<?php echo $row_Recordset1['news_title']; ?>" size="30" />
        <input name="news_id" type="hidden" id="news_id" value="<?php echo $row_Recordset1['news_id']; ?>">
      </label></td>
    </tr>
    <tr>
      <td height="20">新闻分类：</td>
      <td><label>
        <select name="select">
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
        <span class="STYLE1">&nbsp;&nbsp;&nbsp;&nbsp;作者<span class="STYLE2"></span>
          <label>
          <input name="textfield2" type="text" value="<?php echo $row_Recordset1['news_author']; ?>" size="12" />
          </label>
        </span></td>
    </tr>
    <tr>
      <td height="20">新闻内容：</td>
      <td>
        <span class="STYLE1">
          <label>
          <textarea name="content" cols="50" rows="15" id="content"><?php echo $row_Recordset1['news_content']; ?></textarea>
          </label>
        </span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="Submit" value="删除" />
        &nbsp;&nbsp;
        <input type="reset" name="Submit2" value="取消" />
        &nbsp;&nbsp;        </td>
    </tr>
  </table>

  
  
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
