<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Exception\AppErrorRequestException;
use App\Helpers\Code;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Model\Set;
use App\Helpers\Helper;

/**
 * @Controller()
 */
class UploadController
{

    /**
     * 是否出错
     * @param $file
     * @return bool
     */
    protected function getError($file)
    {
        if($file->getError()!=0){
            return false;
        }
        return true;
    }

    /**
     * 文件大小
     * @param $file
     * @param $set
     * @return bool
     */
    protected function getSize($file,$set)
    {
        $where[]=['key','=','upload_size'];
        $size = $set->oneInfo($where)->toArray();

        $imgSize = $file->getSize();

        if($imgSize>$size['value']){
            return false;
        }
        return true;
    }

    /**
     * 文件类型
     * @param $file
     * @param $set
     * @return bool
     */
    protected function getType($file,$set)
    {
        $where[]=['key','=','upload_type'];

        $type = $set->oneInfo($where)->toArray();

        $typeArr = explode(',',$type['value']);

        $mediaType = $file->getClientMediaType();

        $mediaArr = explode('/',$mediaType);

        if(!in_array($mediaArr['1'],$typeArr)){
            return false;
        }

        return true;
    }

    /**
     * 递归创建目录
     * @param $dir
     * @return bool
     */
    protected function createFolders($dir)
    {
        return is_dir($dir) or ($this->createFolders(dirname($dir)) and mkdir($dir,0777,true));
    }

    /**
     * 获取保存目录
     * @param $set
     * @return string
     */
    protected function getSavePath($set)
    {
        $where[]=['key','=','upload_dir'];

        $arr = $set->oneInfo($where)->toArray();

        $dir = '/'.trim($arr['value'],'/').'/';

        $name = date('Y-m-d',time());

        $savePath = BASE_PATH.'/public'.$dir.$name;

        return $savePath;

    }

    /**
     * 创建目录
     * @param $set
     * @return bool
     */
    protected function mkdir($set)
    {
        $savePath = $this->getSavePath($set);
        return $this->createFolders($savePath);
    }

    /**
     * @RequestMapping(path="/common/upload/image", methods="post")
     */
    public function image(RequestInterface $request,Set $set,Helper $helper,\League\Flysystem\Filesystem $filesystem)
    {

        $uploadFile = key($request->getUploadedFiles());

        if(!$uploadFile){
            throw new AppErrorRequestException('上传文件出错,请重试',Code::ERROR);
        }

        $fileIsValid = $request->file($uploadFile)->isValid();

        if(!$fileIsValid){
            throw new AppErrorRequestException('上传文件出错,请重试',Code::ERROR);
        }

        $file = $request->file($uploadFile);

        if(!$this->getError($file)){
            throw new AppErrorRequestException('上传文件出错,请重试',Code::ERROR);
        }

        if(!$this->getSize($file,$set)){
            throw new AppErrorRequestException('图片过大,请重试',Code::ERROR);
        }

        if(!$this->getType($file,$set)){
            throw new AppErrorRequestException('图片类型错误,请重试',Code::ERROR);
        }

        if(!$this->mkdir($set)){
            throw new AppErrorRequestException('上传文件出错,请重试',Code::ERROR);
        }

        $extension = $file->getExtension();

        $name = md5(uniqid(md5(microtime(true).random_int(1,100)),true)).'.'.$extension;

        $path = $this->getSavePath($set);

        $url = $path.'/'.$name;

        $file->moveTo($url);

        if (!$file->isMoved()) {
            throw new AppErrorRequestException('上传文件出错,请重试',Code::ERROR);
        }

        $len = strlen(BASE_PATH.'/public');

        $imgUrl = substr($url,$len);

        return $helper->mdresult(Code::SUCCESS,1,'success',$imgUrl);
    }
}