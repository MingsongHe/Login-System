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
