##hyper-admin是什么?
一个基于hyperf框架开发的简易后台管理系统

##hyper-admin有哪些功能？

* 菜单
    * 增删改查，最多可以设计三级菜单，但是由于需要，只显示二级菜单，三级菜单默认隐藏
* 角色
    * 增删改查+角色授权
* 管理员
    * 增删改查，由于本人不需要管理员单独设置权限，所以权限都是有角色赋予。如有需要，请自行添加。
* 设置
    * 包括上传设置和网站的简单设置

##操作步骤

1.创建数据库

`php bin/hyperf.php migrate`

2.导入数据

`new.sql`

3.修改配置文件和配置redis和mysql

```
APP_MANAGER_NAME=筱雅博客后台管理系统
APP_MANAGER_LOGO=/images/logo-sidebar.png
APP_USER_IMG=/images/gallery/1.jpg
APP_USER_NAME=默认名字
ALLOW_IP=127.16.20.5,127.16.20.6,127.16.20.7
```

> APP_MANAGER_NAME：后台网站title
>
> APP_MANAGER_LOGO：后台logo
>
> APP_USER_IMG：管理员默认头像
>
> APP_USER_NAME：管理员默认名字
>
> ALLOW_IP：允许访问后台的IP地址

4.启动

`php bin/hyperf.php start`

5.登录地址

`localhost/system/login`

默认密码和用户名
```
admin@admin.com
admin@admin.com
```

##其他说明

###start.sh

这个是linux的启动脚本，需要安装lsof。

###yinqi-Light-Year-Admin-Template-master.zip

这个是后台的模板





