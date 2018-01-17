<?php
/**
 * 验证码类
 * User: end_wiki
 * Date: 2017/12/9
 * Time: 14:09
 */
namespace yanyu\tools;

use yanyu\Config;
use yanyu\exceptions\GdExtensionNotInstallException;

class Captcha {

    protected $config = [];
    protected $chars = ['a','b','c','d','e','f','g','h','j','k','m','n','p','q','e','s','t',
        'u','v','w','x','y','z', 'A','B','C','D','E','F','G','H','J','K','M','N','O','P','Q',
        'R','S','T','U','V','W','X','Y','Z','2','3','4','5','6','7','8','9'];
    protected $image;

    public function __construct(array $config = []){
        // 检查 GD 库扩展是否安装
        if(!function_exists('gd_info')){
            throw new GdExtensionNotInstallException();
        }
        if(!empty($config)){
            $this->config = $config;
        }else{
            $this->config = Config::get('CAPTCHA');
        }
        list($width,$height) = explode(',',$this->config['IMAGE_SIZE']);
        $this->image = imagecreate($width,$height);       // 创建一张真彩色的图像
    }

    /**
     * 增加干扰字符
     */
    protected function drawPoint(){
        $chars = ['*','.','$','@','!','%','^'];
        list($width,$height) = explode(',',$this->config['IMAGE_SIZE']);
        $charCount = 50;
        for($i = 0;$i < $charCount;$i++){
            $red = mt_rand(0,128);
            $green = mt_rand(0,128);
            $blue = mt_rand(0,128);
            $x = mt_rand(1,$width);
            $y = mt_rand(1,$height);
            $charColor = imagecolorallocate($this->image,$red,$green,$blue);
            $char = $chars[mt_rand(0,count($chars) - 1)];
            imagechar($this->image,1,$x,$y,$char,$charColor);
        }
    }

    /**
     * 设置背景
     */
    protected function setBackground(){
        $red = mt_rand(0,128);
        $green  = mt_rand(0,128);
        $blue = mt_rand(0,128);
        imagecolorallocate($this->image,$red,$green,$blue);
    }

    /**
     * 写入文本
     */
    protected function writeText(){
        list($width,$height) = explode(',',$this->config['IMAGE_SIZE']);
        $chinese = $this->generateChinese(4);
        $fontFileFile = realpath($this->config['FONT_TTF_PATH']);
        $fontSize = 25;
        $fontCount = 4;
        for($i = 0; $i < $fontCount; $i++){
            $xMin = $i * ($width / $fontCount);
            $xMax = $width - ($width / $fontCount) * ($fontCount - $i);
            $x =  mt_rand($xMin,$xMax);
            $y = mt_rand(25,$height - $fontSize / 3);
            $red = mt_rand(129,255);
            $green = mt_rand(129,255);
            $blue = mt_rand(129,255);
            $charColor = imagecolorallocate($this->image,$red,$green,$blue);
            imagettftext($this->image,$fontSize,0,$x,$y,$charColor,$fontFileFile,$chinese[$i]);
        }
    }

    /**
     * 随机生成汉字
     * @param int $count 生成汉字数量
     * @return array
     */
    public function generateChinese(int $count){
        $str = [];
        for ($i = 0; $i < $count; $i++) {
            // 使用chr()函数拼接双字节汉字，前一个chr()为高位字节，后一个为低位字节
            $char = chr(mt_rand(0xB0,0xD0)).chr(mt_rand(0xA1, 0xF0));
            // 转码
            $str[] = iconv('GB2312', 'UTF-8', $char);
        }
        return $str;
    }

    /**
     * 渲染图片
     */
    public function reader(){
        $this->setBackground();
        $this->writeText();
        $this->drawPoint();
        header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
        header('Content-type: image/png');
        imagepng($this->image);
    }
}