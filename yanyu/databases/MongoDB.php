<?php
/**
 * MongoDB 实现类
 * User: end_wiki
 * Date: 2017/11/26
 * Time: 3:02
 */
namespace yanyu\databases;

use yanyu\exceptions\MongoDBPassWordEmptyException;
use yanyu\exceptions\CalledMethodInvalidException;
use yanyu\Error;

class MongoDB implements DatabaseInterface {

    protected $protocol = 'mongodb://';         // 协议
    protected $instance;                        // 实例

    public function __construct(array $config){
        $uri = $this->protocol;
        if(isset($config['USER']) && !empty($config['USER'])){
            // 密码不存在抛出异常
            if(!isset($config['PASSWORD']) || empty($config['PASSWORD'])){
                throw new MongoDBPassWordEmptyException();
            }
            $uri .= $config['USER'] . ':' . $config['PASSWORD'] . '@';
        }
        $uri .= $config['HOST'] . ':' . $config['PORT'];
        $this->instance = new \MongoDB\Driver\Manager($uri);
        return $this;
    }

    /**
     * 调用 MongoDB 实例的方法(避免了使用继承)
     * @param String $name 调用的方法名
     * @param array $arguments 参数
     * @return mixed
     * @throws CalledMethodInvalidException [100028]无效的方法调用异常
     */
    public function __call($name, $arguments){
        try{
            $result = call_user_func_array([$this->instance,$name],$arguments);
        }catch (Error $e){
            throw new CalledMethodInvalidException();
        }
        return $result;
    }
}