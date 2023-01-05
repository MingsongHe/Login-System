<?php
session_start();                        //开启会话, 
include('iot_connect/connection.php');

if(isset($_POST["login"])){
    $verifycode = trim($_POST['verifycode']);
    $hide_verifycode = trim($_POST['hide_verifycode']);
        if($verifycode==""){
            ?>
            <script>
            alert("验证码不能为空,请完善信息！");
            </script>
            <?php
            $email = "";
        }else if($verifycode!=$hide_verifycode){
            ?>
            <script>
            alert("验证码输入错误,请重新输入！");
            </script>
            <?php
            $email = "";
        } else {
            $email = mysqli_real_escape_string($connect, trim($_POST['email'])); //mysqli_real_escape_string 是 PHP 的内置函数，用于控制不需要的和危险的字符
            $password = trim($_POST['password']);
            $autologin = isset($_POST['autologin']) ? 1 : 0;

            $sql = mysqli_query($connect, "SELECT * FROM ufq_iot_user_login where email = '$email'");
            $count = mysqli_num_rows($sql);

            if ($count > 0) {
               $fetch = mysqli_fetch_assoc($sql);
               $hashpassword = $fetch["password"];

                 if ($fetch["status"] == 0) {
                    ?>
                    <script>
                        alert("Please verify email account before login. 用户还未验证激活。查看您的注册邮箱，完成注册验证。");
                        window.location.replace("https://www.ems156.com/zh/iot-verification/");  //注册验证页面
                    </script>
                    <?php
                  } else if (password_verify($password, $hashpassword)) {                  //登录成功
                    $_SESSION['username']=$email;                                          //保存此时登录成功的用户电子邮箱地址
                    if($autologin==1){                                                     //如果用户勾选了自动登录就把用户名和加了密的密码放到cookie里面
                    setcookie("username",$email,time()+3600*9,'/');                        //有效期设置为xx秒, 在WORDPRESS时，要'/'指明Path路径是当下目录，否则指向/wp-content/themes/easyweb视乎不明确，不行
                    setcookie("password",md5($password),time()+3600*9,'/');
                    }
                    else{
                    setcookie("username","",time()-1,'/');                                 //如果没有选择自动登录就清空cookie
                    setcookie("password","",time()-1,'/');
                    }
                    header("location: https://www.ems156.com/zh/iot-event-route-control-video-position/ ");         //全部验证都通过之后跳转到密码保护页面
                  } else {
                    ?>
                    <script>
                        alert("Password invalid, please try again. 密码错误，请重新输入。");
                    </script>
                    <?php
                  }
            }
                  else{
                    ?>
                    <script>
                        alert("Please verify email account before login. 用户电子邮箱号码不正确，请重新输入。");
                    </script>
                    <?php
                  }
    }       
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

<!doctype html>
<html lang="zh-cn">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://www.ems156.com/wp-content/themes/easyweb/iot_static/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<title>登录表单</title>
</head>
<style>
    
</style>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">登录表单</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-login-a/" style="font-weight:bold; color:black; text-decoration:underline">登录</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-register/">注册</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-alter-psw/ ">修改密码</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">登录</div>
                    <div class="card-body">
                         <form action="#" method="POST" name="login" id="userForm">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">电子邮箱地址</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">密码</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">验证码</label>
                                    <div style="display:inline;">
                                    <input type="text" id="verifycode" placeholder="" name="verifycode" class="form-control" style="width: 80px;margin-left: 15px;"/>
                                    </div>
                                    <div style="display:inline;">
                                    <input type="text" id="code" name = "code" onclick="createCode()" class="form-control" style="width: 80px;margin-left: 10px;"/>
                                    </div>
                                    <div style="display:inline;">
                                    <a id="change_code" name = "change_code" onclick="createCode()" > &nbsp;&nbsp;看不清，换一张</a>
                                    </div>
                                    <input type="hidden" id="hide_verifycode" name="hide_verifycode">     <!-- 验证码隐藏位 -->
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id = "autologin" name="autologin" value="1"> 自动登录 ( 保持九小时 )
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id='btn_submit' class="btn_login" name="login">登录</button>
                                <a href="https://www.ems156.com/zh/iot-recover-psw/" class="btn btn-link">忘记密码？点击这里</a>
                            </div>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
window.onload = function() {
    createCode();
    }; 
//产生验证码     
var code; //在全局定义验证码
function createCode() {
    code = "";
    var codeLength = 4; //验证码的长度  
    var checkCode = document.getElementById("code");
    var hide_checkCode = document.getElementById("hide_verifycode");  
    var random = new Array(2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R',
        'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'); //随机数
    for(var i = 0; i < codeLength; i++) { // 循环操作
        var index = Math.floor(Math.random() * 36); //取得随机数的索引（0~35）
        code += random[index]; //根据索引取得随机数加到code上 
    }
    checkCode.value = code; //把code值赋给验证码显示位
    hide_checkCode.value = code; //把code值赋给验证码隐藏位
}
        
const toggle = document.getElementById('togglePassword');
const password = document.getElementById('password');
toggle.addEventListener('click', function(){
    if(password.type === "password"){
        password.type = 'text';
    }else{
        password.type = 'password';
    }
    this.classList.toggle('bi-eye');
});
</script>