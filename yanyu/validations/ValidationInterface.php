<?php
/**
 * 验证类接口
 * User: end_wiki
 * Date: 2017/11/7
 * Time: 20:28
 */
namespace yanyu\validations;

interface ValidationInterface{
    public function verify($params);
}