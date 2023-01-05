<?php session_start() ;
include('iot_connect/connection.php');
?>

<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://www.ems156.com/wp-content/themes/easyweb/iot_static/style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

    <title>密码找回表单</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">密码找回表单</a>
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
                    <div class="card-header">重置您的密码</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="login">
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">新密码</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required autofocus>
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id='btn_reset' class="btn_login" name="reset">重置</button>
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
if(isset($_POST["reset"])){
    include('iot_connect/connection.php');
    $psw = $_POST["password"];
    $token = $_SESSION['token'];
    $Email = $_SESSION['email'];

    $hash = password_hash( $psw , PASSWORD_DEFAULT ); //使用足够强度的单向散列算法创建密码的散列（hash），PASSWORD_DEFAULT - 使用 bcrypt 算法 (PHP 5.5.0 默认)。

    $sql = mysqli_query($connect, "SELECT * FROM ufq_iot_user_login WHERE email='$Email'");
    $query = mysqli_num_rows($sql);
  	$fetch = mysqli_fetch_assoc($sql);

if($Email){                         //判断对话是否存在，最好是操作一次后销毁对话
    $new_pass = $hash;
    mysqli_query($connect, "UPDATE ufq_iot_user_login SET password='$new_pass' WHERE email='$Email'");
    ?>
    <script>
    alert("<?php echo "your password has been succesful reset. 您的密码已经成功重置。"?>");
    window.location.replace("https://www.ems156.com/zh/iot-login-a/");  //登录页面
    </script>
    <?php
    }else{
    ?>
    <script>
    alert("<?php echo "Please try again 再试一次"?>");
    </script>
    <?php
    }
}
?>
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