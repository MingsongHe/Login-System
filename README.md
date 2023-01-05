# Login-System 

一个完整的登录系统，用作网站页面，物联网监视/控制界面。包括注册，登录，密码修改，密码找回。
主要使用PHP编程，涉及SQL数据库访问，查找，更新，和通过邮件服务器发送电子邮件。

I've updated the login-System more security.
1) allow multiple user login                允许多用户登录
2) get user password as hash password       密码加密后加入到数据库
3) check user for the verification status   检查用户状态，没有完成验证不可以登录
4）允许用户修改密码
5）注册必须输入有效的电子邮箱地址，必须通过验证
6）有找回密码时，必须有正确的用户电子邮箱地址，然后重置密码


A simple Login System:  

User can register an account, before login user need to verify his/her account. user will received a OTP code send by PHPMailer.

User can reset his/her password, user will received a new url link send by PHPMailer to reset his/her new password.

How to use this source code:
requirement:
1) install xampp
here is the link to install xampp
apachefriends.org/index.html

First step:
1) download this repo 
2) create a folder name as login-System -> extract to your xampp folder -> htdocs -> on folder login-System
3) go to phpmyadmin -> create database loginsystem
4) copy all the query command from login.sql -> paste it under the database loginsystem sql.
5) copy the path of index.html -> paste the link -> before C:\xampp\htdocs\login-System\login-system-main\index.php -> modify to http://localhost/login-System/login-system-main/index.php
6) on the less secure on your email account which use to send out the email.
7) modify the account and password under two file -> recover_psw.php and register.php
8) now you are ready to run your login system project !
9) Happy Coding

More details refer to this youtube video with clear explanation
https://youtu.be/-1SJPDL-9o8
