# 个人博客

## 验证器的使用 ##

首先新建一个校验类,比如 `ArticleAdd`,并且继承 `src\framework\Validation` 类。
    
    class ArticleAdd extends Validation{}
    
然后在类里添加验证规则，例如字符串:

    protected $title = array('require', 'string',1,20,'文章标题必须在 10 到 20 个字符以内!');
    
最后再控制器中使用该校验器，如下：

    $params = Request::post();
    (new ArticleAdd())->eachFields($params);
