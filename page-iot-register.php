<?php
session_start();                       //开启会话
include('iot_connect/connection.php');

if(isset($_POST["register"])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    $check_query = mysqli_query($connect, "SELECT * FROM ufq_iot_user_login where email ='$email'");
    $rowCount = mysqli_num_rows($check_query);

    if(!empty($email) && !empty($password)){
        if($rowCount > 0){
            ?>
            <script>
                alert("User with email already exist! 这个电子邮箱地址已经注册。");
            </script>
            <?php
        }else{
            $password_hash = password_hash($password, PASSWORD_BCRYPT); //PASSWORD_BCRYPT - 使用 CRYPT_BLOWFISH 算法创建散列。产生$2y$....
            $result = mysqli_query($connect, "INSERT INTO ufq_iot_user_login (email, password, status) VALUES ('$email', '$password_hash', 0)");
    
            if($result){
                $otp = rand(100000,999999);        //产生随机数
                $_SESSION['otp'] = $otp;           //设置验证码
                $_SESSION['mail'] = $email;
                require "iot_mail/PHPMailerAutoload.php";
                $mail = new PHPMailer;
    
                $mail->isSMTP();
                $mail->Host='smtp.office365.com';   //邮箱服务器, 这里是 msn 的邮件服务器
                $mail->Port=587;                    //邮箱服务器端口 587
                $mail->SMTPAuth=true;
                $mail->SMTPSecure='tls';
    
                $mail->Username='电子邮箱';    //本地发出电子邮件的邮箱
                $mail->Password='邮箱密码';         //本地邮箱密码 
    
                $mail->setFrom('email account', 'OTP Verification');
                $mail->addAddress($_POST["email"]);
    
                $mail->isHTML(true);
                $mail->Subject="Your verify code 您的验证码";
                $mail->Body="<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
                    <br><br>
                    <a href='https://www.ems156.com/zh/iot-verification/'>https://www.ems156.com/zh/iot-verification/</a>
                    <p>With regrads,</p>
                    <b>EMS SUNLIGHT SERVICE 伊麦阳光服务</b>
                    http://ems156.com/";
    
                    if(!$mail->send()){
                        ?>
                        <script>
                            alert("<?php echo "Register Failed, Invalid Email 注册失败，非法的电子邮件地址"?>");
                        </script>
                        <?php
                    }else{
                        ?>
                        <script>
                            alert("<?php echo "Register Successfully, OTP sent to 注册成功，验证码已经送到：" . $email ?>");
                            window.location.replace('https://www.ems156.com/zh/iot-verification/');  //注册验证码输入页面
                        </script>
                        <?php
                     }
                }
            }
        }
    }
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>  -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://www.ems156.com/wp-content/themes/easyweb/iot_static/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<title>注册表单</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">注册表单</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-login-a/" >登录</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-register/" style="font-weight:bold; color:black; text-decoration:underline">注册</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.ems156.com/zh/iot-alter-psw/">修改密码</a>
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
                    <div class="card-header">注册</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="register">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">电子邮件地址</label>
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
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id='btn_submit' class="btn_login" name="register">注册</button>
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
<script>
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