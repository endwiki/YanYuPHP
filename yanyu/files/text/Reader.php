<?php
/**
 * 文本文件迭代器
 * User: end_wiki
 * Date: 2017/11/21
 * Time: 15:06
 */
namespace yanyu\files\text;

class Reader {

    /**
     * 文本文件迭代器
     * @param String $path 文件名
     * @return \Generator
     */
    public static function iterator(String $path){
        $fileHandler = fopen($path,'r');
        while(!feof($fileHandler)){
            yield rtrim(fgets($fileHandler));
        }
    }
}