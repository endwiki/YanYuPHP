<?php
/**
 * Redis 实现类
 * User: end_wiki
 * Date: 2017/11/26
 * Time: 0:38
 */
namespace yanyu\databases;

use yanyu\Error;
use yanyu\exceptions\CalledMethodInvalidException;
use yanyu\exceptions\ClassNotFoundException;
use yanyu\exceptions\RedisAuthErrorException;
use yanyu\exceptions\RedisConnectFailedException;
use yanyu\exceptions\RedisExtensionNotFoundException;

class Redis implements DatabaseInterface {

    protected $instance;        // 实例

    /**
     * Redis constructor.
     * @param array $config 数据库配置
     * @throws RedisAuthErrorException [100027]Redis 认证失败:密码错误异常
     * @throws RedisConnectFailedException [100026]Redis 连接失败异常
     * @throws RedisExtensionNotFoundException [100037]Redis 扩展没有安装异常
     */
    public function __construct(array $config){
        try{
            $redis = new \Redis();
        }catch (ClassNotFoundException $e){
            throw new RedisExtensionNotFoundException();
        }
        // 连接服务器
        try{
            $redis->pconnect($config['HOST'],$config['PORT'],$config['CONNECT_TIMEOUT']);
        }catch(Error $e){
            throw new RedisConnectFailedException();
        }
        // 密码认证
        if(isset($config['PASSWORD']) && !empty($config['PASSWORD'])){
            if($redis->auth($config['PASSWORD']) == false){
                throw new RedisAuthErrorException();
            }
        }
        $this->instance = $redis;       // 保存实例
        return $this;
    }


    /**
     * 调用 Redis 实例的方法(避免了使用继承)
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