<?php
session_start();                        //开启会话, 
include('iot_connect/connection.php');  //开启数据库

if (isset($_POST["alter"])) {
    $newPsw = $_POST['newpsw'];
    $confirmnewPsw = $_POST['confirmnewpsw'];
    if ($newPsw != $confirmnewPsw) {
        ?>
        <script>
        alert("请确认新密码一致。");
        </script>
        <?php
    } else {
        $email = mysqli_real_escape_string($connect, trim($_POST['email'])); //mysqli_real_escape_string 是 PHP 的内置函数，用于控制不需要的和危险的字符
        $password = trim($_POST['password']);

        $sql = mysqli_query($connect, "SELECT * FROM ufq_iot_user_login where email = '$email'");
        $count = mysqli_num_rows($sql);
        if ($count > 0) {
            $fetch = mysqli_fetch_assoc($sql);
            $hashpassword = $fetch["password"];
            if ($fetch["status"] == 0) {
                ?>
            <script>
            alert("Please verify email account before login. 用户还未验证激活，请查看邮箱，完成验证。");
            window.location.replace("https://www.ems156.com/zh/iot-verification/");  //注册验证码输入页面
            </script>
            <?php
            } else if (password_verify($password, $hashpassword)) {                            //确认用户成功
                $hash = password_hash( $newPsw , PASSWORD_DEFAULT );
                $new_pass = $hash;
            mysqli_query($connect, "UPDATE ufq_iot_user_login SET password='$new_pass' WHERE email='$email'");
            ?>
            <script>
                alert("<?php echo "your password has been succesful reset. 您的密码已经修改成功。"?>");
                window.location.replace("https://www.ems156.com/zh/iot-login-a/");  //登录页面
            </script>
            <?php
            } else {
                ?>
            <script>
            alert("Password invalid, please try again. 密码错误，请重新输入。");
            </script>
            <?php
            }
        } else {
            ?>
        <script>
        alert("Please verify email account before login. 电子邮箱号码不正确，请重新输入。");
        </script>
        <?php
        }
    }
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

<!doctype html>
<html lang="zh">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://www.ems156.com/wp-content/themes/easyweb/iot_static/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<title>修改密码表单</title>
</head>
<style>    
</style>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">修改密码表单</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-login-a/">登录</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-register/">注册</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-alter-psw/" style="font-weight:bold; color:black; text-decoration:underline">修改密码</a>
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
                    <div class="card-header">修改密码</div>
                    <div class="card-body">
                         <form action="#" method="POST" name="login" id="userForm">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">电子邮箱地址</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">旧密码</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="newpsw" class="col-md-4 col-form-label text-md-right">新密码</label>
                                <div class="col-md-6">
                                    <input type="password" id="newpsw" class="form-control" name="newpsw" required>
                                    <i class="bi bi-eye-slash" id="togglenewpsw"></i>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="confirmnewpsw" class="col-md-4 col-form-label text-md-right">确认新密码</label>
                                <div class="col-md-6">
                                    <input type="password" id="confirmnewpsw" class="form-control" name="confirmnewpsw" required>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id='btn_alter' class="btn_login" name="alter">修改</button>
                                <a href="https://www.ems156.com/zh/iot-recover-psw/" class="btn btn-link">忘记密码？点击这里</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
<script>   
const toggle = document.getElementById('togglePassword');
const toggle2 = document.getElementById('togglenewpsw');
const password = document.getElementById('password');
const confirmnewpsw = document.getElementById('confirmnewpsw');
const newpsw = document.getElementById('newpsw');

toggle.addEventListener('click', function(){
    if(password.type === "password"){
    password.type = 'text';
    }else{
    password.type = 'password';
    }
    this.classList.toggle('bi-eye');
    });
toggle2.addEventListener('click', function(){
    if(confirmnewpsw.type === "password"){
        confirmnewpsw.type = 'text';
        newpsw.type = 'text';
    }else{
        confirmnewpsw.type = 'password';
        newpsw.type = 'password';
    }
    this.classList.toggle('bi-eye');
    });
</script>