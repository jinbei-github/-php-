<?php require_once('../Connections/news.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$maxRows_Re = 10;
$pageNum_Re = 0;
if (isset($_GET['pageNum_Re'])) {
  $pageNum_Re = $_GET['pageNum_Re'];
}
$startRow_Re = $pageNum_Re * $maxRows_Re;

mysql_select_db($database_news, $news);
$query_Re = "SELECT * FROM news ORDER BY news_id DESC";
$query_limit_Re = sprintf("%s LIMIT %d, %d", $query_Re, $startRow_Re, $maxRows_Re);
$Re = mysql_query($query_limit_Re, $news) or die(mysql_error());
$row_Re = mysql_fetch_assoc($Re);

if (isset($_GET['totalRows_Re'])) {
  $totalRows_Re = $_GET['totalRows_Re'];
} else {
  $all_Re = mysql_query($query_Re);
  $totalRows_Re = mysql_num_rows($all_Re);
}
$totalPages_Re = ceil($totalRows_Re/$maxRows_Re)-1;

mysql_select_db($database_news, $news);
$query_Re1 = "SELECT * FROM newstype";
$Re1 = mysql_query($query_Re1, $news) or die(mysql_error());
$row_Re1 = mysql_fetch_assoc($Re1);
$totalRows_Re1 = mysql_num_rows($Re1);

$queryString_Re = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Re") == false && 
        stristr($param, "totalRows_Re") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Re = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Re = sprintf("&totalRows_Re=%d%s", $totalRows_Re, $queryString_Re);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- 引入 Bootstrap --> 
        <script src="../js/jquery/3.3.1/jquery.min.js"></script> 
        <link href="../css/bootstrap/3.3.7/bootstrap.min.css" rel="stylesheet"> 
<!--
        <link href="../css/reset.min.css" rel="stylesheet">
    	<link href="../css/style.css" rel="stylesheet">
-->
        <script src="../js/bootstrap/3.3.7/bootstrap.min.js"></script>  
        <script src="../js/holder.min.js"></script>
<title>管理主页面</title>
<style type="text/css">
<!--
/*
body {
	margin-top: 0px;
	background-image: url(images/bg.gif);
}
*/
body,td,th {
	font-size: 12px;
}

	body{
		background-color:#383736;
	}
</style></head>

<body>
<div class="container">
	<table  align="center">
	<!--这是页头-->
  <div style="background-image: url(../images/welcomeadmin.jpg);width: 100% ;height: 400px;">
<!--      <img src="../images/welcomeadmin.jpg" width="100%" height="" > 	-->
      <!--欢迎语-->
      <div style="margin-left: 30%;padding-top: 15%">
      	<p style="color: aliceblue;font-size: 30px"> 管理员你好！请你管理新闻分类 ！</p>
      </div>
       
  </div>

    
  <!--这是内容-->
  <div width="100%">
                
           <!--添加修改删除新闻类型--> 
           <ul class="list-group">
                    <li class="list-group-item">
                    <span>新闻分类管理列表（修改删除每个新闻分类）</span>
<!--                    <a href="type_add.php">添加新闻分类</a>-->
                   <span>
                   	<button type="button" class="btn btn-default" onclick="location.href='type_add.php'">
<!--        						添加新闻分类-->
        						<span class="glyphicon glyphicon-plus"></span>
        			</button>
                   </span>
                    
                    </li>
                    <?php do { ?>
                    <li class="list-group-item ">
                    <div class="row">
  						<div class="col-md-10 col-lg-10 col-sm-10">
                    	<?php echo $row_Re1['type_name']; ?>
						</div>
                      <div class="col-md-2 col-lg-2 col-sm-2" style="text-align: right">
                      
        					<!--修改按钮-->
        					<button type="button" class="btn btn-default" onclick="location.href='type_upd.php?type_id=<?php echo $row_Re1['type_id']; ?>'">
        						<span class="glyphicon glyphicon-edit"></span>
        					</button>
        					<!--删除按钮-->
        					<button type="button" class="btn btn-default" onclick="location.href='type_del.php?type_id=<?php echo $row_Re1['type_id']; ?>'">
        						<span class="glyphicon glyphicon-trash"></span>
        					</button>
        		
        				</div>
                    </li>
                     
                    <?php } while ($row_Re1 = mysql_fetch_assoc($Re1)); ?>
           </ul>
        
        <!--这是新闻列表-->
        <div>
        <!--添加修改删除新闻--> 
       	 <ul class="list-group">
       	 <li class="list-group-item"> 
       	 	<span>新闻管理列表（修改删除每条新闻）</span>
<!--       	 <a href="news_add.php">添加新闻</a>-->
      	 <span>
      	 	<button type="button" class="btn btn-default" onclick="location.href='news_add.php'">
<!--        						添加新闻-->
        						<span class="glyphicon glyphicon-plus"></span>
        			</button>
      	 </span>
       	 
       	 </li>
       	 <?php do { ?>
  			<li class="list-group-item">
  			<div class="row">
  				<div class="col-md-10 col-lg-10 col-sm-10">
        		标题：<a href="../newscontent.php?news_id=<?php echo $row_Re['news_id']; ?>"><?php echo $row_Re['news_title']; ?></a>
        		</div>
        		<div class="col-md-2 col-lg-2 col-sm-2" style="text-align: right">
        		<!--修改按钮-->
        		<button type="button" class="btn btn-default" onclick="location.href='news_upd.php?news_id=<?php echo $row_Re['news_id']; ?>'">
        			<span class="glyphicon glyphicon-edit"></span>
        		</button>
        		<!--删除按钮-->
        		<button type="button" class="btn btn-default" onclick="location.href='news_del.php?news_id=<?php echo $row_Re['news_id']; ?>'"><span class="glyphicon glyphicon-trash"></span></button>
        		
        		</div>
  			</div>
  				
  			</li>
      	 <?php } while ($row_Re = mysql_fetch_assoc($Re)); ?>
       	 </ul>
      
        </div>
        <!--这是页码列表-->
       
		<table width="90%" border="0" align="center">
  <tr>
    <td><?php if ($pageNum_Re > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Re=%d%s", $currentPage, 0, $queryString_Re); ?>">第一页</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Re > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Re=%d%s", $currentPage, max(0, $pageNum_Re - 1), $queryString_Re); ?>">前一页</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Re < $totalPages_Re) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Re=%d%s", $currentPage, min($totalPages_Re, $pageNum_Re + 1), $queryString_Re); ?>">下一个</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_Re < $totalPages_Re) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Re=%d%s", $currentPage, $totalPages_Re, $queryString_Re); ?>">最后一页</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
      
    </div>
  <!--这是页脚-->
  <tr>

  </tr>
</table>
</div>

</body>
</html>
<?php
mysql_free_result($Re);

mysql_free_result($Re1);
?>
