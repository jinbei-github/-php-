<?php require_once('Connections/news.php'); 
?>
<?php
error_reporting(0);
$keyword=$_POST[keyword];
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

mysql_select_db($database_news, $news);
$query_Recordset1 = "SELECT * FROM newstype";
$Recordset1 = mysql_query($query_Recordset1, $news) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$maxRows_Re1 = 9;
$pageNum_Re1 = 0;
if (isset($_GET['pageNum_Re1'])) {
  $pageNum_Re1 = $_GET['pageNum_Re1'];
}
$startRow_Re1 = $pageNum_Re1 * $maxRows_Re1;

mysql_select_db($database_news, $news);
$query_Re1 = "SELECT * FROM news where news_title like '%".$keyword."%' ORDER BY news_id DESC";
$query_limit_Re1 = sprintf("%s LIMIT %d, %d", $query_Re1, $startRow_Re1, $maxRows_Re1);
$Re1 = mysql_query($query_limit_Re1, $news) or die(mysql_error());
$row_Re1 = mysql_fetch_assoc($Re1);
//mysql_fetch_assoc() 函数从结果集中取得一行作为关联数组。
//返回根据从结果集取得的行生成的关联数组，如果没有更多行，则返回 false。

if (isset($_GET['totalRows_Re1'])) {
  $totalRows_Re1 = $_GET['totalRows_Re1'];
} else {
  $all_Re1 = mysql_query($query_Re1);
  $totalRows_Re1 = mysql_num_rows($all_Re1);
}
$totalPages_Re1 = ceil($totalRows_Re1/$maxRows_Re1)-1;

$queryString_Re1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Re1") == false && 
        stristr($param, "totalRows_Re1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Re1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Re1 = sprintf("&totalRows_Re1=%d%s", $totalRows_Re1, $queryString_Re1);
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
<title>新闻首页</title>
<style type="text/css">
<!--
body {
	margin-top: 0px;
	background-image: url();
}
	
.style18 {color: #FFFF00}
#Layer1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	left: 142px;
	top: 592px;
}
-->
	div.col-lg-4{
		padding: 0px 5px 5px 0px;
		
	}
	div.col-md-4{
		padding: 0px 5px 5px 0px;
		
	}
	div.col-sm6-4{
		padding: 0px 5px 5px 0px;
		
	}
	div.col-xs-12{
		padding: 0px 5px 5px 0px;
		
	}
	.square{
		height: 300px;
		margin:0px 5px 5px 0px;
	}
	
	
/*
	.myContainer{
		z-index: -1;
	}
*/
</style>
</head>

<body>
	<div class="container">
          <!-- 这是导航条 -->
	<div>
<!--                    <h1 class="page-header">导航条</h1>-->
		<nav class="navbar navbar-inverse navbar-fixed-top"><!--.navbar-inverse反色.navbar-default默认灰色.navbar-fixed-top固定在顶部-->
			<div class="container">
			<div class="navbar-header">
			<a class="navbar-brand">
				<span class="glyphicon glyphicon-home"></span>
			</a>
				
				<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mynavbar"><!--汉堡菜单-->
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="mynavbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="">今日新闻</a></li>
				<li><a href="">导航1</a></li>
				<li><a href="">导航2</a></li>
				<!--新闻分类-->
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">
						新闻类别<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
					   <?php do { ?>

						<li>
						<a href="type.php?id=<?php echo $row_Recordset1['type_id']; ?>"><?php echo $row_Recordset1['type_name']; ?>
						</a>
						</li>
					   <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

					</ul>
				</li>
			</ul>
<!--
			<ul class="nav navbar-nav navbar-right">
					<li><a href="">每日任务</a></li>
			</ul>
-->
		   <!-- 查询框 -->
			<form class="navbar-form navbar-right" id="form1" name="form1" method="post" action="">

					<div class="form-group">
					  <input type="text" class="form-control" placeholder="Search"  name="keyword" id="keyword">
					</div>
<!--                                <input type="submit" name="button" id="button" value="查询" />-->
					<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span>
					</button>
			</form>
			<!--管理员登陆入口-->
			<a href="admin/admin_login.php" class="navbar-brand">
			<span class="glyphicon glyphicon-user" style="float: right"></span>
			</a>
			</div>
			</div>
		</nav>
             
            </div>
           <!-- 这是轮播动画 -->
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-top: 50px">
                    <!-- 指示灯 -->
                    <ol class="carousel-indicators">
                      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>
                  
                    <!-- 幻灯片图片 holder.js/100px400-->
                    <div class="carousel-inner">
                      <div class="item active">
                        <img src="images/1.jpg" alt="..." style="width:100%;height: 400px">
<!--
                        <div class="carousel-caption">
                            这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字这是一段描述文字
                        </div>
-->
                      </div>
                      <div class="item">
                        <img src="images/a.jpg" alt="..." style="width:100%;height: 400px">
                      </div>
                      <div class="item">
                        <img src="images/3.jpg" alt="..." style="width:100%;height: 400px">
                      </div>
                    </div>
                  
                    <!-- 左右控制 -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
            </div>
     <!-- 这是新闻区 -->
    <div class="table-responsive">
              <span class="STYLE26">最新新闻：
记录 <?php echo ($startRow_Re1 + 1) ?> 到 <?php echo min($startRow_Re1 + $maxRows_Re1, $totalRows_Re1) ?> (总共 <?php echo $totalRows_Re1 ?>）</span>
              <!-- 这是新闻列表 -->
              <?php do { ?>
                 <div class="item-row">
                  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                  <div class="square">
                  		<div class="zoom">
                                    <div class="foreground"></div>
                                    <img style="width: 100%;height: 100%" class="hidden-xs img-responsive" alt="test image one" src="admin/upload/<?php echo $row_Re1['bin_data']; ?>">
                                   <!--这是数据库中存储的二进制图片bin_data-->
                        </div>
                   		<div class="square-tile-center">
                                   <!--这是标题-->
                                   
                                    <h4 class=""> <?php echo $row_Re1['news_title']; ?></h4>
                                    <!--这是发布时间-->
                                    <p class="square-desc"><?php echo $row_Re1['news_date']; ?></p>
                                    <button class="square-button explore box foo" onclick="location.href='newscontent.php?news_id=<?php echo $row_Re1['news_id']; ?>'">查看</button>
                        </div>
                  </div>
                  </div>
                  </div>
                  <?php } while ($row_Re1 = mysql_fetch_assoc($Re1)); ?>
                   
               
               <!-- 这是页码列表 -->
              <div>
                  <ul>
                    <li style="display: inline"><?php if ($pageNum_Re1 > 0) { // Show if not first page ?>
                        <button class="square-button explore box foo" onclick="location.href='<?php printf("%s?pageNum_Re1=%d%s", $currentPage, 0, $queryString_Re1); ?>'"> 
                        <span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>
                        第一页
                        </button>
                        <?php } // Show if not first page ?></li>
                    <li style="display: inline"><?php if ($pageNum_Re1 > 0) { // Show if not first page ?>
                       <button class="square-button explore box foo" onclick="location.href='<?php printf("%s?pageNum_Re1=%d%s", $currentPage, max(0, $pageNum_Re1 - 1), $queryString_Re1); ?>'"> 
                        <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>
                        前一页
                        </button>
                        <?php } // Show if not first page ?></li>
                    <li style="display: inline"><?php if ($pageNum_Re1 < $totalPages_Re1) { // Show if not last page ?>
                       <button class="square-button explore box foo" onclick="location.href='<?php printf("%s?pageNum_Re1=%d%s", $currentPage, min($totalPages_Re1, $pageNum_Re1 + 1), $queryString_Re1); ?>'"> 
                        <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
                        下一页
                        </button>
                        <?php } // Show if not last page ?></li>
                    <li style="display: inline"><?php if ($pageNum_Re1 < $totalPages_Re1) { // Show if not last page ?>
                       <button class="square-button explore box foo" onclick="location.href='<?php printf("%s?pageNum_Re1=%d%s", $currentPage, $totalPages_Re1, $queryString_Re1); ?>'"> 
                        <span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>
                        最后一页
                        </button>
                        <?php } // Show if not last page ?></li>
                  </ul>
              </div>
              </div>

 	</div>
    <!-- 这是页脚 -->           
    <div style="background-color: black;opacity: 0.4;">
  	<!--  	<footer id="footer" style="display: block;">-->
    <div class="container">
         <hr>
        <div class="row">
              <div class="col-sm-4">
               
                    <h4>友情链接</h4>
                    <div class="">
                        <ul>
                        	<li>
                        		<button class="square-button explore box foo" onclick="http://www.bootcss.com/">
                         	Bootstrap中文网
                         </button>
                        	</li>
                        	<li>
                        		 <button class="square-button explore box foo"href="https://www.quanzhanketang.com/" >
                          	全栈课堂
                          </button>
                        	</li>
                        	<li>
                        		 <button class="square-button explore box foo"href="https://www.jquery123.com/">
                        	 jQuery中文网
                        </button>
                        	</li>
                        	<li>
                        		 <button class="square-button explore box foo"href="https://www.nodeapp.cn/">
                        	Node.js中文文档
                        </button>
                        	</li>
                        	<li>
                        		 <button class="square-button explore box foo"href="https://www.91php.com/">
                        	91PHP
                        </button>
                        	</li>
                        	<li>
                        		<button class="square-button explore box foo"href="https://www.rollupjs.com/">
                        	Rollup中文文档
                        </button>
                        	</li>
                        </ul> 
                    </div>
              
            </div>

            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">联系我们</h4>
                    <div>
                        
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">赞助商</h4>
                    <div class="content friend-links">
                        
                    </div>
                </div>
            </div>
            
        </div>
        
        <!--这里放版权所有-->
        <span style="float: right"> © 金贝2019</span>
    </div>
	<!--</footer>-->
  	</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Re1);
?>
