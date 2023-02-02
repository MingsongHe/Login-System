# Login-System 

一个完整的登录系统，用作网站页面，物联网监视/控制界面。包括注册，登录，密码修改，密码找回。
主要使用PHP编程，涉及SQL数据库访问，查找，更新，和通过邮件服务器发送电子邮件。

I've updated the login-System more security.
1) allow multiple user login                
2) get user password as hash password       
3) check user for the verification status   
4) 允许用户修改密码.
5) 注册必须输入有效的电子邮箱地址，必须通过验证。
6)有找回密码时，必须有正确的用户电子邮箱地址，然后重置密码。

允许多用户登录
密码加密后加入到数据库, 检查用户状态，没有完成验证不可以登录 

准备工作
准备一个数据库，
建立一个数据表 请参考这个文件：ufq_iot_user_login.sql，里面有建立数据表的程序
笔者是在自己的电脑里安装了 Apache， MYSQL数据库等，
笔者有自己的网站（基于WordPress的），在网站上也调试成功了的，读者可以进入笔者的网站 www.ems156.com 换到中文（如果需要的话）， 
在“物联网网站”之下的
“IOT 登录”
实际体验。

需要根据读者自己情况调整的部分
数据库部分，要换自己的数据库名和密码，
发电子邮件部分，class.phpmailer.php 文件有3处要根据读者情况，一个是中文显示（行号：48）, 一个是电子邮箱地址,（行号：73），
第三个是在行号79处 电子邮件服务器在读者自己的电子邮箱里可以找到（有困难连线笔者）
笔者在网站上的电子邮件服务器也遇到了一点困难，如果您也不顺利，也可以联络笔者.
"""
    从27行到51行的电子邮件部分，如果是在WordPress环境，可以使用下面的代码：
    $flag = wp_mail( $email, "注册验证码 ", 'Dear user, Your verify OTP code is: '.$otp.' 
                    
                    点击链接：https://bilingualplan.com/zh/iot-verification  输入上述六位数验证码，完成注册。
                    
                    With regrads,
                    EMS SUNLIGHT SERVICE 伊麦阳光服务
                    https://bilingualplan.com' );
    """
