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

get_header();

//wc_get_template( 'iot_templates/login.php' ); 

global $wpdb;
$wpdb -> show_errors();
$login_name = $wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2" , 1);
$datacollectionstate = $wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2" , 4);

$video_position = $wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2" , 19);
if ($datacollectionstate == "OFF"){
  $displaybtnon = "block";
  $displaybtnoff = "none";
}
if ($datacollectionstate == "ON"){
  $displaybtnon = "none";
  $displaybtnoff = "block";
}

// -> Start Define variables

// theme options variables
$easyweb_webnus_options	= easyweb_webnus_options();

// page options variables
$show_titlebar	= rwmb_meta( 'easyweb_page_title_bar_meta' );
$titlebar_fg	= rwmb_meta( 'easyweb_page_title_text_color_meta' );
$titlebar_bg	= rwmb_meta( 'easyweb_page_title_bg_color_meta' );
$titlebar_fs	= rwmb_meta( 'easyweb_page_title_font_size_meta' );
$sidebar_pos	= rwmb_meta( 'easyweb_sidebar_position_meta' );

// others variables
$have_sidebar	= $sidebar_pos ? true : false;

// -> End Define variables

// headline and breadcrubs
if ( $show_titlebar ) : ?>
	<section id="headline" style="<?php if ( ! empty( $titlebar_bg ) ) echo 'background-color: ' . $titlebar_bg . ';'; ?>">
		<div class="container">
			<h1 style="<?php if ( ! empty( $titlebar_fg ) ) echo 'color: ' . $titlebar_fg . ';'; if ( ! empty( $titlebar_fs ) ) echo ' font-size: ' . $titlebar_fs . ';'; ?>"><?php the_title(); ?></h1>
		</div>
	</section>
<?php endif; ?>

<!-- Start Page Content -->
<section id="main-content" class="container">

<!doctype html>
<html>
<head>
   <title>EMS IOT</title>
<!--   <link rel="stylesheet" type="text/css" href='/iot_static/iot_style.css'/> -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
   <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- 提高电脑，手机 移动装置显示位置兼容性 -->
   <script src="https://code.jquery.com/jquery-3.5.0.js"></script> <!--没有这个文件，JavaScript 功能可能失效-->

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
 <!--         <div class="btn-group">  -->
          <button id="m1" class="btn btn-default">第一首</button>
          <button id="m2" class="btn btn-default">第二首</button>
          <button id="m3" class="btn btn-default">第三首</button>
          <button id="m4" class="btn btn-default">第四首</button>
          <button id="m5" class="btn btn-default">第五首</button>
          </div>     
  <!--      </div> -->
<br>

          <div style="text-align: center;">
                <a id = "login_name">admin</a>
                <a id = "login_link_text">, 您上一次登录的时间是:  </a>
                <a id = "login_time">01-01-2022</a>
          </div>

          <div id = "Dada_collection_on_btn" align="center">
             <button id = "Dada_collection_on" class = "btn btn-block btn-md btn-primary" style = "color: rgb(255,66,66);width:80px;font-weight: 700;" onclick="Dada_collection_off_Function()">状态：开</button>
	           <p id = "mesgareaon"></p>
          </div>
	        <div id = "Dada_collection_off_btn" align="center">
             <button id = "Data_collection_off" class = "btn btn-block btn-md btn-primary" style = "color: rgb(164,164,164);width:80px;font-weight: 700;" onclick="Dada_collection_on_Function()">状态：关</button>
             <p id = "mesgareaoff"></p>
          </div>
          <div class="stat-item " data-width-tablet="180" data-width-desktop="210" align="center" style="display:none">
             <!--  <div class="stat-item " data-width-tablet="180" data-width-desktop="210" align="center"> -->
              <p id = "Data_collection_state" class="number"><?php echo ($datacollectionstate); ?></p>
          </div>
          <div>
              <span id = "video_position_no" onmouseover = "get_dada()">over demo1(取树莓派按钮状态）</span>  <!-- onmouseout = "cance_data()" -->
              <span id = "video_position_no2" onmouseover = "get_Dada()">over demo2</span><a href="http://192.168.1.172:8001/">&nbsp;&nbsp;引发路由器访问，取树莓派按钮状态</a>&nbsp;&nbsp;<button id='platformcc' class="btn btn-md btn-primary glyphicon glyphicon-upload">跳到第3首歌
          </div>
          <div id = "content" ondblclick="cance_data()">
          </div>
  <!--    <div align="center" style="display:none"> -->
      <div style="text-align: center;">
      <p id = "order_word" class="order_word"><?php echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",1)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",5)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",6)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",7)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",8)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",9)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",10)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",11)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",12)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",13)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",14));
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",15)); 
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",16));
                           echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",18));?>
          </p>
      </div>
      <br>
      

</body>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>  <!--是否需要这个，待验证 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  <!--jQuery 有很多可以轻松处理 HTTP 请求的方法。需要在项目中引入 jQuery 库。-->
<script type="text/javascript">

var xmlHttp;
var event_word;
var last_event_word;

function S_xmlhttprequest(){
  if(window.ActiveXObject){
    xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
} else if(window.XMLHttpRequest){
    xmlHttp = new XMLHttpRequest();
}
}

function get_dada() {
  S_xmlhttprequest();
    xmlHttp.open("GET","https://bilingualplan.com/en/get-vdeio-position/",true); //取页面作地址，可以
//      xmlHttp.open("get","https://bilingualplan.com/wp-content/themes/easyweb/page-get-vdeio-position.php",true); //取PHP文件，好像是取第一次可以，然后就没有执行
//    xmlHttp.open("GET","https://bilingualplan.com/1-1",true); //取页面地址，可以
//    xmlHttp.open("GET","http://192.168.1.172:8001/",true);
  xmlHttp.onreadystatechange = get_event_word;
  xmlHttp.send(null);
}

function get_event_word(){
  event_word = xmlHttp.responseText;
  document.getElementById('content').innerHTML = "按钮状态："+event_word;
}

function cance_data(){
   document.getElementById('content').innerHTML = ""; 
}    

function get_Dada(){
      var req = new XMLHttpRequest();
//      req.open("get", "https://bilingualplan.com/en/covid-19-new-cases/",true);
        req.open("get", "https://bilingualplan.com/wp-content/themes/easyweb/Log-in.php",true); //取PHP文件，也可以
//      req.open("get", "http://192.168.1.172:8001", true);
//        req.open("get", "https://bilingualplan.com/en/1-1/", true);                         //取页面地址，可以
        req.onload = function(){  //load 事件，检查连线状态
          //连线完成
          var content = document.getElementById("content");
          content.innerHTML = this.responseText;
        };
        req.send();
}

//   global $wpdb;  这个类的对象已经在文件开始的地方加载(不能在这里加载），并且已经取到 $login_name 的值
     var mesg = "Waiting for...    稍等... ";
     var mark = "A";
     var login_name = '<?php echo ($login_name); ?>';
     document.getElementById("login_name").innerHTML=login_name;
     var login_time = '<?php echo ($wpdb -> get_var("SELECT * FROM `ufq_iotdata` WHERE `id` = 2",3)); ?>';
     document.getElementById("login_time").innerHTML=login_time;

     var x = document.getElementById("Dada_collection_off_btn");
          {
            x.style.display = "<?php echo "$displaybtnon"; ?>";
          }
     var x = document.getElementById("Dada_collection_on_btn");
          {
            x.style.display = "<?php echo "$displaybtnoff"; ?>";
          }  

      function Dada_collection_on_Function(){  
        $.post("https://bilingualplan.com/?datacollection=ON",this.id,function(data,status){});
        document.getElementById("mesgareaoff").innerHTML=mesg;
        location.reload(); 
       }
       
       function Dada_collection_off_Function(){  
        $.post("https://bilingualplan.com/?datacollection=OFF",this.id,function(data,status){});
        document.getElementById("mesgareaon").innerHTML=mesg;
        location.reload();
       }

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

      //setTimeout 允许我们将函数推迟到一段时间间隔之后再执行。
      //setInterval 允许我们重复运行一个函数，从一段时间间隔之后开始运行，之后以该时间间隔连续重复运行该函数。
setInterval(function(){
      //  $.get("http://192.168.1.172:8001/", function(result){              //必须在同一局域网内
      //        if (result == 1 && mark == "B"){
      //          media.currentTime = 0;
      //            mark = "A";
      //        }
      //        if (result == 0 && mark == "A"){
      //            media.currentTime = 852;   //跳到第3首歌
         //         alert(result);
       //           mark = "B";
      //        }
      //  });
    get_dada();
    if (last_event_word != event_word){
        switch(event_word)
         {
          case "1":
          media.currentTime = 0;
          break;
          case "2":
          media.currentTime = 75;
          break;
          case "3":
          media.currentTime = 150;
          break;
          case "4":
          media.currentTime = 225;
          break;
          case "5":
          media.currentTime = 300;
          break;
         }
    }
    last_event_word = event_word;
}, 2000);  //毫秒


     
$(function(){
       $("button").click(function(){
         if (this.id == 'platformcc') {
             media.currentTime = 160;
//           $.post("http://192.168.1.172:8001/",this.id,function(data,status){});  //必须在同一局域网内
          }
        });
     });           
</script>
</html>
</section>
<?php
  get_footer();