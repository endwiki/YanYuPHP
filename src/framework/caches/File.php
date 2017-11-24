<?php
/**
 * 文件缓存实现类
 * User: end_wiki
 * Date: 2017/11/24
 * Time: 11:28
 */
namespace src\framework\caches;

use src\framework\Config;
use src\framework\File as FileClass;

class File {

    protected $fileExtension = '.txt';      // 文件扩展名

    /**
     * 判断缓存是否存在以及是否超时
     * @param String $fileName 文件名
     * @return bool
     */
    public function isExist(String $fileName){
        $cacheFile = Config::get('SYSTEM_RUNTIME_PATH') . 'caches/' . $fileName . $this->fileExtension;
        // 检查文件是否存在
        if(!is_file($cacheFile)){
            return false;
        }
        // 检查文件是否超时
        $createTime = (FileClass::textRead($cacheFile))[1];
        if($this->isTimeOut($cacheFile,$createTime)){
            return false;
        }
        return true;
    }

    /**
     * 读取缓存
     * @param String $fileName 文件名
     * @return mixed
     */
    public function read(String $fileName){
        $cacheFile = Config::get('SYSTEM_RUNTIME_PATH') . 'caches/' . $fileName . $this->fileExtension;
        // 没有超时，返回缓存内容
        $cacheContent = (FileClass::textRead($cacheFile));
        return unserialize($cacheContent[0]);
    }

    /**
     * 保存缓存
     * @param String $fileName 文件名
     * @param String|array $content 缓存内容
     * @return void
     */
    public function save(String $fileName,$content){
        $cacheDir = Config::get('SYSTEM_RUNTIME_PATH') . 'caches/';
        $dataList[] = $content;
        // 因为 Windows10 下相同文件名的创建时间在删除后仍然相同，所以写入创建时间
        $dataList[] = time();
        FileClass::textWrite($dataList,$cacheDir . $fileName . $this->fileExtension);
    }

    /**
     * 检查缓存是否超时
     * @param String $fileName 文件名
     * @param int $createTime 创建时间
     * @return bool 如果超时返回 true,否则返回 false
     */
    public function isTimeOut(String $fileName,int $createTime){
        $timeOut = Config::get('CACHE.EXPIRATION');
        // 如果没有超时返回 false
        if((time() - $createTime) <= $timeOut){
            return false;
        }
        // 如果超时，是删除文件并返回 true
        $this->clear($fileName);
        return true;
    }

    /**
     * 删除文件缓存
     * @param String $fileName 文件名
     * @return void
     */
    public function clear(String $fileName){
        FileClass::delete($fileName);
    }

}