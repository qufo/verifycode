<?php
namespace Qufo\VerifyCode;

class VerifyCode{
    private $width;
    private $height;
    private $codeNum;//验证码数
    private $image;
    private $pionNum;//干扰点数
    private $checkCode;
    private $isNum=true;
    private $fontFace;
    function __construct($width=80,$height=25,$codeNum=4,$isNum=true){//------构造方法
        $this->width=$width;
        $this->height=$height;
        $this->codeNum=$codeNum;
        $this->isNum=$isNum;
        $this->checkCode=$this->createChekCode();
        $pnum=floor($width*$height/25);
        if($pnum>240-$codeNum){
            $this->pionNum=200-$codeNum;
        }else{
            $this->pionNum=$pnum;
        }

    }
    public function showImage($fontFace=""){//获得图片
        $this->fontFace = ($fontFace=="")?dirname(__FILE__).'/verifycode.ttf':$fontFace;
        $this->createImage();
        //$this->setDisturbcolor();//创建干扰素
        $this->outputText($this->fontFace);
        $this->outputImage();//输出图片

    }
    public function getCheckCode(){//获得验证码
        return $this->checkCode;
    }

    private function createImage(){//创建图像
        $this->image=imagecreatetruecolor($this->width,$this->height);//创建一个画布(推荐)
        $bgcolor=imagecolorallocate($this->image,rand(225,255),rand(225,255),rand(225,255));
        imagefill($this->image,0,0,$bgcolor);
        //$boderc=imagecolorallocate($this->image,0,0,0);
        //imagerectangle($this->image,0,0,$this->width-2,$this->height-2,$boderc);//画边框
    }
    private function setDisturbcolor(){//创建干扰素
        for($i=0;$i<$this->pionNum;$i++){
            $pcolor=imagecolorallocate($this->image,rand(0,255),rand(0,255),rand(0,255));
            imagesetpixel($this->image,rand(1,$this->width-2),rand(1,$this->height-2),$pcolor);
        }
        for($i=0;$i<5;$i++){
            $lcolor=imagecolorallocate($this->image,rand(0,255),rand(0,255),rand(0,255));
            imageline($this->image,rand(1,$this->width-2),rand(1,$this->height-2),rand(1,$this->width-2),rand(1,$this->height-2),$lcolor);
        }
    }
    private function createChekCode(){//生成验证码
        if($this->isNum){
            $code="0123456789";
        }else{
            $code="23456789abcdefghijkmnpqrsztuvwABCDEFGHJKLMNPQRSZTUVW";
        }


        $string="";
        for($i=0;$i<$this->codeNum;$i++){
            $string.=$code[rand(0,strlen($code)-1)];//去随机数
        }
        return $string;
    }
    private function outputText($fontFace){//输出文本
        if($fontFace==""){//字体为空
            for($i=0;$i<$this->codeNum;$i++){
                $fontcolor=imagecolorallocate($this->image,rand(0,128),rand(0,128),rand(0,128));
                $fontSize=rand(10,20);
                $x=floor($this->width/$this->codeNum)*$i+3;
                $y=rand(1,$this->height-15);
                imagechar($this->image,$fontSize,$x,$y,$this->checkCode[$i],$fontcolor);
            }
        }else{
            for($i=0;$i<$this->codeNum;$i++){
                $fontcolor=imagecolorallocate($this->image,rand(0,128),rand(0,128),rand(0,128));
                $fontSize=rand(20,25);
                $x=floor(($this->width-5)/$this->codeNum)*$i+5;
                $y=rand($fontSize,$this->height-5);
                imagettftext($this->image,$fontSize,rand(-30,30),$x,$y,$fontcolor,$fontFace,$this->checkCode{$i});
            }
        }
    }
    private function outputImage(){//输出图像
        if(imagetypes() & IMG_GIF){
            header("Content-Type:image/gif");
            imagegif($this->image);
        }else if(imagetypes() &IMG_JPG){
            header("Content-Type:image/jpeg");
            imagegif($this->image);
        }else if(imagetypes() &IMG_PNG){
            header("Content-Type:image/png");
            imagegif($this->image);
        }else if(imagetypes() &IMG_WBMP){
            header("Content-Type:image/und.wap.wbmp");
            imagegif($this->image);
        }else{
            die("服务器太旧，不支持！");
        }
    }
    function __destruct(){
        imagedestroy($this->image);//释放图片资源
    }//-------析构方法
};
?>