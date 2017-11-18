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

### 基本使用 ###

首先新建一个校验类,比如 `ArticleAdd`,并且继承 `src\framework\Validation` 类。
    
    class ArticleAdd extends Validation{}
    
然后在类里添加验证规则，例如字符串:

    protected $title = array('require', 'string',1,20,'文章标题必须在 10 到 20 个字符以内!');
    
最后再控制器中使用该校验器，如下：

    $params = Request::post();
    (new ArticleAdd())->eachFields($params);
    
### 方法验证中使用参数注入 ###

对于复杂的校验，我们可以使用方法校验。即指定类型为`Method`,
自己指定方法所在的类名和方法名，如下代码:

```
protected $word = [
     'type'      =>  'Method',
     'class'     =>  'app\\common\\verifications\\WordAdd',
     'method_name'   =>  'wordMustNotExist',
     'message'       =>  '该单词已经存在!'
];

```
实用方法验证可以对单个值进行复杂的校验，比如检查是否在数据库中存在。
但有时候我们需要借助其他的参数来校验某个参数，比如我们需要检查某个用户下
是否已经存在某个数据的时候，我们可以使用在方法验证中使用参数注入。

在方法验证中，我们可以使用`injection_args`属性来指定注入的参数，前提是注入的参数
需要出现在校验的参数中，可以通过如下的代码加入欲注入的参数:

```
$params = Request::post();
$params['user_id'] = $this->uid;
// 在校验类中指定注入参数
protected $word = [
    // 其他参数
    'injection_args' => ['user_id'],    // 参数注入
    'message'   =>  '该用户已经添加该单词'
];
```

### 多重验证 ###

有时候，我们需要对一个字段进行复杂的组合验证。比如在单词本的应用中，在添加一个单词的时候，
,即需要检验其基本的数据类型，又要检验其是否在数据表中存在。
这时候，我们就可以使用多重验证功能。

在验证类中，添加验证规则如下,与基本验证不同的是，多重验证是二维数组:

```
protected $word = [
        [
            'require'   =>  true,
            'type'      =>  'String',
            'length'    =>  '1,64',
            'message'   =>  '单词必须在 1 到 64 个字符以内!'
        ],
        [
            'type'      =>  'Method',
            'class'     =>  'app\\common\\verifications\\WordAdd',
            'method_name'   =>  'wordMustNotExist',
            'message'       =>  '该单词已经存在!'
        ]
    ];
```
多重验证允许我们将多个验证规则写成二维数组。


    
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
