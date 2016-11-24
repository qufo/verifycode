### Simple VerifyCode for PHP

## Install
add 
```
    "qufo/verifycdoe":"dev-master"
```
to your composer.json, and composer update.

## Build a verifycode

```
$code = new Qufo\VerifyCode\VerifyCode();
$code->showImage();
```

## Get verifycode

```
 echo $code->getCheckCode();
```