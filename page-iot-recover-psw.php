<?php 
session_start();
?>

<!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://127.0.0.1/bilingualplan/wp-content/themes/easyweb/iot_static/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>用户密码找回表单</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">用户密码找回表单</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">密码找回</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="recover_psw">
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">电子邮件地址</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id='btn_recover' class="btn_login" name="recover">找回</button>
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

<?php 
    if(isset($_POST["recover"])){
        include('iot_connect/connection.php');
        $email = $_POST["email"];
        $sql = mysqli_query($connect, "SELECT * FROM ufq_iot_user_login WHERE email='$email'");
        $query = mysqli_num_rows($sql);
  	    $fetch = mysqli_fetch_assoc($sql);
        if(mysqli_num_rows($sql) <= 0){
            ?>
            <script>
                alert("<?php  echo "Sorry, no emails exists 电子邮件地址错误"?>");
            </script>
            <?php
        }else if($fetch["status"] == 0){
            ?>
               <script>
                   alert("Sorry, your account must verify first, before you recover your password 您的注册未完成验证，请按提示完成验证");
                   window.location.replace("https://www.ems156.com/zh/iot-login-a/");  //登录页面
               </script>
           <?php
        }else{
            $token = rand(100000,999999);                                     
            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;

            require "iot_mail/PHPMailerAutoload.php";
            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host='smtp.office365.com';  //邮件服务器, 这里是 msn 的邮件服务器
            $mail->Port=587;                   //服务端口
            $mail->SMTPAuth=true;
            $mail->SMTPSecure='tls';

            // h-hotel account
            $mail->Username='电子邮箱';   //用户名：完整的电子邮箱,例如：123@msn.com
            $mail->Password='邮箱密码';        //电子邮箱密码

            // send by h-hotel email
            $mail->setFrom('email', 'Password Reset');
            // get email from input
            $mail->addAddress($_POST["email"]);

            // HTML body
            $mail->isHTML(true);
            $mail->Subject="Recover your password 找回密码";
            $mail->Body="<b>Dear User</b>
            <h3>We received a request to reset your password.我们收到您找回（重置）密码的请求</h3>
            <p>Kindly click the below link to reset your password 点击下面的链接，重置您的密码</p>
            <a href='https://www.ems156.com/zh/iot-reset-psw/'>https://www.ems156.com/zh/iot-reset-psw/</a>
            <br><br>
            <p>With regrads, 诚致谢意！</p>
            <b>EMS SUNLIGHT SERVICE 伊麦阳光服务</b>";

            if(!$mail->send()){
                ?>
                <script>
                alert("<?php echo " Invalid Email 电子邮件地址错误"?>");
                </script>
                <?php
            }else{
                ?>
                <script>
                //提示信息页面 “恢复密码的邮件已经发出，请检查您的邮箱并依提示，完成密码重置。”
                window.location.replace("https://www.ems156.com/wp-content/themes/easyweb/iot_notification.html");
                </script>
                <?php
            }
        }
    }
?>