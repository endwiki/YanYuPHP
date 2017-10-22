<?php
/**
 * 应用类
 * User: end_wiki
 * Date: 2017/10/22
 * Time: 19:37
 */
namespace src\framework;

class App {

    // 执行应用
    public function start(){
        $clazz = substr(APP_PATH,2) . '\\'
            . Route::getModule() . '\\' . Config::get('CONTROLLER_DIR') . '\\' . Route::getController();
        // 反射控制器
        $controllerClazz = new \ReflectionClass($clazz);
        // 检查方法是否存在
        if($controllerClazz->hasMethod(Route::getAction())){
            // 反射方法
            $reflectionMethod  = $controllerClazz->getMethod(Route::getAction());
            // 检查是否带有参数
            $ReflectionParameter = $reflectionMethod->getParameters();
            if(!$ReflectionParameter){
                $reflectionMethod->invoke(new $clazz);
            }else{
                $reflectionMethod->invokeArgs(new $clazz,Route::getArgs());
            }
        }

    }
}