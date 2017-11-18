<?php
/**
 * 用户在表单中输入了非数值字符异常
 * User: jinzhi<admin@end.wiki>
 * Date: 2017/11/02
 * Time: 18:47
 */
namespace exception;

class InputValueMustBeNumeric extends \Exception {
    protected $code = 406;
    protected $message = '您输入的内容必须为数值类型!';
}