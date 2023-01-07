<?php
session_start();  //开启会话, 获取到服务器端验证码   

if (empty($_COOKIE['username']) && empty($_COOKIE['password'])) {
    if (!isset($_SESSION['username'])) {
#        echo "您还没有登录，" . "<a href='logout.php\'>登录</a> "; //应该是这样的，但是这里不行，待查
        echo "<div style='width: 480px;
        height: 160px;
        margin: auto;           /* set div block center */
        margin-top: 150px;
        background-color: rgba(240, 240, 280, 0.5);
        border-style:solid;
        border-color:A9A9A9;
        border-radius: 10px;
        text-align: center;
        justify-content: center;'><br/><P>远程事件/中断控制网站页面（演示版）需要登录</P>
        <div style='clear: both;
        margin-top: 20px;
        margin-bottom: 20px;
        margin-left: 60px;
        margin-right: 60px;
        border: 0;
        height: 1px;
        background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));'><hr><div style='float: center;'><P>点击这里&nbsp;<a href='https://www.ems156.com/zh/iot-login-a/'>登录</a></P></div></div></div>";
        exit();
    } else {
        unset($_SESSION['username']);
    }
}
else {
    unset($_SESSION['username']);
}
?>
<!-- Start Page Content -->

<!doctype html>
<html>
<head>
   <title>EMS IOT</title>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
   <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- 提高电脑，手机 移动装置显示位置兼容性 -->
   

<style>
.img-video
  {  
  padding:4px;
  background-color:#fff;
  border:2px solid #ddd;
  border-radius:6px;
  max-width:85%;
  margin: auto;
 }
 .box{
    margin: auto;
    width: 60%;
    border: 1px solid #73AD21;
    padding: 8px;
 }
 .box2{
    margin:auto;
    width:500px;
    height:544px;
}

#setting-01 {
  width: 20%;
}
#setting-02 {
  width: 15%;
}
#setting-03 {
  width: 10%;
}
#setting-04 {
  width: 40%;
}
#setting-05 {
  width: 40%;
}
#setting-01,#setting-02,#setting-03,#setting-04,#setting-05{
    float: left;  /*向左浮动*/
    height: 110px;
}
#setting-04,#setting-05{
    float: left;  /*向左浮动*/
    height: 60px;
}

</style>

</head>

<body>
<div class="img-video">
        <div id= "iot-container" class="box" style="position:relative;top:1px;">    	      
            <video id="media" width="100%" height="100%" controls autoplay>
                <source id="video" src="https://bilingualplan.com/wp-content/uploads/2022/12/Overture-荒野大鏢客主題曲.mp4" type="video/mp4">
            </video>
        </div>
</div>
        <div style="text-align: center; position:relative;top:1px">
          <button id="m1" class="btn btn-default">第一位置</button>
          <button id="m2" class="btn btn-default">第二位置</button>
          <button id="m3" class="btn btn-default">第三位置</button>
          <button id="m4" class="btn btn-default">第四位置</button>
          <button id="m5" class="btn btn-default">第五位置</button>
        </div>     
</body>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script> <!--没有这个文件，JavaScript 功能可能失效-->
<script type="text/javascript">

     var mark = "A";
        document.getElementById("m1").onclick=function(){
        media.currentTime = 0;
        var mark = "A";
      }
        document.getElementById("m2").onclick=function(){
        media.currentTime = 75;
        mark = "A";
      }
        document.getElementById("m3").onclick=function(){
        media.currentTime = 150;
        mark = "A";
      }
        document.getElementById("m4").onclick=function(){
        media.currentTime = 225;
        mark = "A";
      }
        document.getElementById("m5").onclick=function(){
        media.currentTime = 300;
        mark = "A";
      }     
</script>
</html>