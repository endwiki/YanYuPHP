<?php
/**
 * 文件类
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 10:14
 */
namespace src\framework;

use src\framework\exceptions\DirAlreadyExistException;
use src\framework\exceptions\DirNotMissException;

class File {

    /**
     * 创建文件夹
     * @param String $path 创建路径
     * @param bool $recursive 是否递归创建
     * @param String $mode 权限 default 777 在 Windows 环境下无效
     * @return bool
     * @throws DirAlreadyExistException [100010]文件夹已经存在异常
     * @throws DirNotMissException [100011]文件夹不存在异常
     */
    public static function makeDir(String $path,bool $recursive = false,String $mode = '777'){
        // 递归，直接判断路径是否存在
        if($recursive && is_dir($path)){
            throw new DirAlreadyExistException();
        }
        // 不递归，判断文件夹是否已经存在
        if(!$recursive && !self::isDirExistByRecursive($path,true)){
            throw new DirNotMissException();
        }
        $result = mkdir($path,$mode,$recursive);

        return $result;
    }

    /**
     * 递归判断文件夹是否存在
     * @param String $path 路径
     * @param bool $notFinal 不包含最后一层文件夹
     * @return bool
     */
    public static function isDirExistByRecursive(String $path,bool $notFinal = true){
        $dirs = explode('/',$path);
        // 是否包含最后一层目录
        if($notFinal){
            array_pop($dirs);
        }
        // 逐层判断路径是否存在
        while(count($dirs) != 0){
            $path = implode('/',$dirs);
            if(!is_dir($path)){
                return false;
            }
            array_pop($dirs);
        }
        return true;
    }

}