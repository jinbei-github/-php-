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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE newstype SET type_name=%s WHERE type_id=%s",
                       GetSQLValueString($_POST['type_name'], "text"),
                       GetSQLValueString($_POST['type_id'], "int"));

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
<meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- 引入 Bootstrap --> 
        <script src="../js/jquery/3.3.1/jquery.min.js"></script> 
        <link href="../css/bootstrap/3.3.7/bootstrap.min.css" rel="stylesheet">
        <script src="../js/bootstrap/3.3.7/bootstrap.min.js"></script>  
        <script src="../js/holder.min.js"></script>
<title>修改新闻</title>
<style type="text/css">
<!--

-->
</style>
</head>

<body>
<div class="container">
	<form method="POST" action="<?php echo $editFormAction; ?>" id="form1" name="form1">
  <table class="table">
    <tr>
      <td>请修改新闻分类：</td>
    </tr>
    
    <tr>
      <td>分类名称：</td>
      <td><input name="type_name" type="text" id="type_name" value="<?php echo $row_Recordset1['type_name']; ?>" />
      <input name="type_id" type="hidden" id="type_id" value="<?php echo $row_Recordset1['type_id']; ?>"></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
          <input type="submit" name="Submit" value="修改" />
       　   
       <input name="Submit2" type="reset" value="重置" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
