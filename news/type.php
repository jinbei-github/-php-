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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_news, $news);
$query_Recordset1 = sprintf("SELECT * FROM news WHERE news_type = %s ORDER BY news_id ASC", GetSQLValueString($colname_Recordset1, "int"));
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $news) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
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
<title>新闻分类</title>
</head>

<body>

     <div class="container">
		 <div>
		 </div>
     <!--新闻列表-->
      <div>
      	<table class="table">
           <!--记录行-->
            <thead>
            	<?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
                  记录 <?php echo ($startRow_Recordset1 + 1) ?> 到 <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> (总共 <?php echo $totalRows_Recordset1 ?>)
            </thead>
            <!--每条新闻列表-->
            <tbody>
            	<?php do { ?>
               <tr>
                 <td>新闻标题：<?php echo $row_Recordset1['news_title']; ?></td>
                 <td><a href="newscontent.php?news_id=<?php echo $row_Recordset1['news_id']; ?>">详细内容</a></td>
               </tr>     
             <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
            </tbody>
        </table>
      </div>
     <!--这是分页表格-->
      <table width="67%" border="0">
                    <tr>
                      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">第一页</a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">前一页</a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">下一个</a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">最后一页</a>
                          <?php } // Show if not last page ?></td>
                    </tr>
                  </table>
              
            <?php } // Show if recordset not empty ?>
		
      
      
    </div>
     <div>
     	<?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  
      <p>对不起，此新闻分类中没有任何新闻</p>
    
  <?php } // Show if recordset empty ?>
     </div>
      
  
  <!--这是页脚-->
	<div></div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
