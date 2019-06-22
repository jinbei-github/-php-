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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin.php";
  $MM_redirectLoginFailed = "../index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_news, $news);
  
  $LoginRS__query=sprintf("SELECT username, password FROM `admin` WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $news) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- 引入 Bootstrap --> 
        <script src="../js/jquery/3.3.1/jquery.min.js"></script> 
        <link href="../css/bootstrap/3.3.7/bootstrap.min.css" rel="stylesheet"> 
        <link href="../css/reset.min.css" rel="stylesheet">
    	<link href="../css/style.css" rel="stylesheet">
        <script src="../js/bootstrap/3.3.7/bootstrap.min.js"></script>  
        <script src="../js/holder.min.js"></script>
<title>管理者登录页面</title>
<style type="text/css">
	
	.bgimage{
		width: 100%;
		height: 100%;
		padding:20% 0 0 25%;
		background-image: url(../images/1.jpg)
	}
	.formbg{
		width:50%;
		height: auto;
		background-color:black;
		opacity:0.5;
	}
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
	<div class="bgimage">
		<div class="formbg">
	

<form class="form-horizontal"ACTION="<?php echo $loginFormAction; ?>" id="form1" name="form1" method="POST"><!-- class="form-inline" 表单处于一行-->
               新闻后台管理中心
                <div class="form-group">
                    <label class="col-xs-2 control-label">用户名:</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" placeholder="usename"name="username" id="username">
                    </div>
                </div>
                <div class="form-group has-feedback"><!--右侧小图标:.has-feedback
                                                                                -->
                    <label class="col-xs-2 control-label">密码:</label>
                    <div class="col-xs-10">
                        <input type="password" class="form-control input-sm"name="password" id="password"><!--表单框大小：.input-lg.input-sm-->
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                        
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-10 col-xs-offset-2">
                        <input type="submit" value="ok" class="btn btn-primary" name="Submit"  onClick="MM_validateForm('username','','R','password','','R');return document.MM_returnValue" value="提交" >
                        <input type="reset" value="cancle" class="btn btn-danger"name="Submit2" value="重置">
                    </div>
                </div>
	</form>
	</div>
	</div>


</body>
</html>

