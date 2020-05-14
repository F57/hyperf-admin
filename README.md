~~基于hyperf写的简易后台~~

# 新版不兼容1.0，此版本已经废弃

## 包括,菜单,权限,用户,和设置.
##### **一定要配置redis** 

##### **一定要配置redis** 

##### **一定要配置redis** 

*** 
先配置.env文件

1.创建数据库
``` 
php bin/hyperf.php migrate
``` 
2.导入err.sql

3.启动
``` 
php bin/hyperf.php start
``` 
4.登录
``` 
用户名;  admin@admin.com
密码  :  admin或者123456
``` 

5.start.sh
```
这个是启动脚本.linux需要安装lsof
```

`yinqi-Light-Year-Admin-Template-master.zip`
是后台模板

如果启动失败,那么删除vendor和composer.lock,执行

`composer update`
