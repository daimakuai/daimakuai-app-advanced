<p align="center">
    <a href="https://github.com/daimakuai" target="_blank">
        <img src="logo.png" height="100px">
    </a>
    <h1 align="center">Daimakuai Advanced Project Template</h1>
    <br>
</p>


目录结构
-------------------

      app/		  contains assets definition
      config/             contains application configurations
      controllers/        contains Web controller classes
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      resources/          contains view files for the Web application
      public/             contains the entry script and Web resources

环境要求
------------

您的Web服务器支持的这个项目模板的最低要求 PHP 7.0.0.


安装方法
------------

### 首先安裝 Composer

如果沒有安裝 [Composer](http://getcomposer.org/), 您可以按照以下的说明安装它
在 [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

然后您可以使用下面的命令来安装这个项目模板:

```
composer create-project --prefer-dist --stability=dev daimakuai/daimakuai-app-advanced  -vvv


php artisan vendor:publish --provider="Jblv\Admin\AdminServiceProvider"


创建数据库，修改 .env  文件里的数据库配置


php artisan admin:install


php artisan serve


浏览器打开 http://127.0.0.1:8000/admin  ,使用用户名 `admin` 和密码 `admin`登陆.



```


DIRECTORY STRUCTURE
-------------------

      app/		  contains assets definition
      config/             contains application configurations
      controllers/        contains Web controller classes
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      resources/          contains view files for the Web application
      public/             contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.0.0.

INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

```
composer create-project --prefer-dist --stability=dev daimakuai/daimakuai-app-advanced  -vvv


php artisan vendor:publish --provider="Jblv\Admin\AdminServiceProvider"


创建数据库，修改 .env  文件里的数据库配置


php artisan admin:install


php artisan serve


visit http://127.0.0.1:8000


```