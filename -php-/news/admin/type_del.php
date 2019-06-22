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

if ((isset($_GET['type_id'])) && ($_GET['type_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM newstype WHERE type_id=%s",
                       GetSQLValueString($_GET['type_id'], "int"));

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
if (isset($_GET['type_id'])) {
  $colname_Recordset1 = $_GET['type_id'];
}
mysql_select_db($database_news, $news);
$query_Recordset1 = sprintf("SELECT * FROM newstype WHERE type_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $news) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>删除类型</title>
<style type="text/css">
.STYLE2 {font-size: 14px}
</style>
</head>
<body>
<form method="POST" id="form1" name="form1">
  <table width="400" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <tr>
      <td height="30" colspan="2" bgcolor="#CCCCCC" class="STYLE2">请删除新闻分类：</td>
    </tr>
    <tr>
      <td width="61" height="25">分类名称：</td>
      <td width="333"><input name="type_name" type="text" id="type_name" value="<?php echo $row_Recordset1['type_name']; ?>" />
        <input name="type_id" type="hidden" id="type_id" value="<?php echo $row_Recordset1['type_id']; ?>"></td>
    </tr>
    <tr>
      <td height="25" colspan="2">
        <input type="submit" name="Submit" value="删除" />
      <input name="Submit2" type="reset" value="重置" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
