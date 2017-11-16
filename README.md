# 自己长期维护的项目 #

## 项目简介 ##

这是自己的一个项目，用来检验应用学习成果。也方便自己和家人的日常生活，算是一个工具集吧。
和商业的项目不同的是，首先这是开源的，谁都可以拿去任意使用。然后这也将长期维护。

## 软硬件要求 ##

|要求项|版本|说明|
|---|---|---|
|PHP|7.0以及以上|-|
|MySQL/MariaDB|-|-|
|Nginx/Apache|-|-|
|OS|Windows/Linux|-|

## 部署 ##

### URL 重写 ###

如果是 Apache 服务器的话，在代码的根目录下创建`.htaccess`文件，然后写入如下代码：

```
<IfModule mod_rewrite.c>
 RewriteEngine on
 RewriteCond %{REQUEST_FILENAME} !-d
 RewriteCond %{REQUEST_FILENAME} !-f
 RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>

```

## 验证器的使用 ##

首先新建一个校验类,比如 `ArticleAdd`,并且继承 `src\framework\Validation` 类。
    
    class ArticleAdd extends Validation{}
    
然后在类里添加验证规则，例如字符串:

    protected $title = array('require', 'string',1,20,'文章标题必须在 10 到 20 个字符以内!');
    
最后再控制器中使用该校验器，如下：

    $params = Request::post();
    (new ArticleAdd())->eachFields($params);
    
## 数据库的操作 ##

### 配置数据库 ###

比如，在`app/common/configs/`目录下新建`database.php`配置文件，示例如下:

```
return [
    'host'      =>      'localhost',
    'port'      =>      '3306',
    'db'        =>      'file',
    'user'      =>      'root',
    'password'  =>      '',
    'charset'   =>      'UTF8',
];

```

然后在`app/common/App.php`中引入改配置文件:

```
'database'    =>      include 'Database.php',
```

> 也可以把配置文件放在任意目录，只要在配置文件中正确引入即可。

### 获取数据库的实例 ###

在配置完了数据库之后，就可以在程序中获取程序的实例了:

```
$dbInstance = src\framework\Database::getInstance();
```

### 查询数据 ###

如果不加上`limit`语句的话，默认返回第一条数据。

```
$queryResult = $dbInstance->table('file')
    ->field(['id','name','path','status'])
    ->where([
        'name'  =>    ['like','%bc%'],
    ])
    ->limit(50)
    ->fetch();
```

### 更新数据 ###

如果更新成功，返回`true`,如果更新失败，返回`false`。

```
$updateResult = $dbInstance->table('file')
     ->where(['id'    =>  1])
     ->update([
        'name'  =>      'xiao',
     ]);
     
```

### 新增数据 ###

如果新增数据成功，返回`true`,如果插入失败，返回`false`。

```
$insertResult = $dbInstance->table('file')
    ->add([
        'id'    =>      2,
        'name'  =>      'ok',
        'path'  =>      '/etc/log',
        'level' =>      11,
        'status'    =>  3,
    ]);
```
