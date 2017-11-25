<?php
/**
 * 文件类
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 10:14
 */
namespace src\framework;


use src\framework\exceptions\DirNotMissException;

class File {

    /**
     * 创建文件夹
     * @param String $path 创建路径
     * @param bool $recursive 是否递归创建
     * @param String $mode 权限 default 777 在 Windows 环境下无效
     * @return bool
     */
    public static function makeDir(String $path,bool $recursive = false,String $mode = '777'){
        // 递归，直接判断路径是否存在
        if($recursive && is_dir($path)){
            return false;
        }
        // 不递归，判断文件夹是否已经存在
        if(!$recursive && !self::isDirExist($path,true)){
            return false;
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
    public static function isDirExist(String $path,bool $notFinal = true){
        $dirs = explode('/',$path);
        // 是否包含最后一层目录
        if($notFinal){
            array_pop($dirs);
        }
        // 逐层判断路径是否存在
        $path = implode('/',$dirs);
        if(!is_dir($path)){
            return false;
        }

        return true;
    }

    /**
     * 写入文件
     * @param String|array $dataList 写入数据
     * @param String $path 文件路径
     * @param String $mode 写入模式 default 'w+' option [r|r+|w|w+|a|a+|x|x+]
     */
    public static function textWrite($dataList,String $path,String $mode = 'w+'){
        $fileHandler = fopen($path,$mode);
        $content = '';
        if(is_array($dataList)){
            foreach($dataList as $item => $value){
                $content .= $value . PHP_EOL;
            }
        }
        if(is_string($dataList)){
            $content = $dataList;
        }
        fwrite($fileHandler,$content);
        fclose($fileHandler);
    }

    /**
     * 读取文本文件
     * @param String $path 文件路径
     * @param int $limit 行数
     * @return array
     */
    public static function textRead(String $path,int $limit = -1){
        $fileHandler = file($path);
        $dataList = [];
        foreach($fileHandler as $item => $value){
            if($item === $limit){
                break;
            }
            $dataList[] = rtrim($value);
        }
        return $dataList;
    }

    /**
     * 在文本文件中查询字符串
     * @param String $path 文件路径
     * @param String $queryStr 查询字符串
     * @return array
     */
    public static function textFind(String $path,String $queryStr){
        $fileHandler = file($path);
        $dataList = [];         // 用来匹配适应的行
        $index = 0;
        foreach($fileHandler as $item => $value){
            $position = mb_strpos($value,$queryStr,0,'UTF-8');
            if(false !== $position){
                $dataList[$index]['no'] = $item;
                $dataList[$index]['position'] = $position;
                $dataList[$index]['value'] = rtrim($value);
                $index++;
            }
        }
        return $dataList;
    }

    /**
     * 获取文件信息
     * @param String $path 文件路径
     * @return array
     */
    public static function getFileInfo(String $path){
        $fileHandler = fopen($path,'r');
        $fileInfo = fstat($fileHandler);
        fclose($fileHandler);
        return $fileInfo;
    }

    /**
     * 删除文件
     * @param String $path 文件路径
     * @return bool
     */
    public static function delete(String $path){
        return unlink($path);
    }

    /**
     * 遍历目录文件
     * @param String $path 目录路径
     * @param array $filterExtensionName 过滤扩展名
     * @throws DirNotMissException [100011]目录不存在异常
     * @return array
     */
    public static function eachDir(String $path,array $filterExtensionName = []){
        // 检查目录是否存在
        if(!is_dir($path)){
            throw new DirNotMissException();
        }
        // 遍历文件并过滤
        $files = scandir($path);
        $fileList = [];
        foreach($files as $index => $file){
            // 排除当前目录和上一级目录
            if($file != '.' && $file != '..'){
                $extensionName = pathinfo($file,PATHINFO_EXTENSION);
                if(!in_array($extensionName,$filterExtensionName)){
                    $fileList[] = $file;
                }
            }
        }
        return $fileList;
    }
}