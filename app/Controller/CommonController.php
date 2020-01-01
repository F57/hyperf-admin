<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\AppBadRequestException;
use App\Model\Set;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use App\Helpers\Helper;
use Hyperf\Contract\SessionInterface;
use App\Helpers\Code;

class CommonController
{

    protected function getError($file)
    {
        if($file->getError()!=0){
            return false;
        }
        return true;
    }

    protected function getImgSize($file,$set)
    {
        $where[]=['key','=','img_upload_size'];
        $size = $set->oneInfo($where)->toArray();

        $imgSize = $file->getSize();

        if($imgSize>$size['value']){
            return false;
        }
        return true;
    }

    protected function getImgType($file,$set)
    {
        $where[]=['key','=','img_upload_type'];

        $type = $set->oneInfo($where)->toArray();

        $typeArr = explode(',',$type['value']);

        $mediaType = $file->getClientMediaType();

        $mediaArr = explode('/',$mediaType);

        if(!in_array($mediaArr['1'],$typeArr)){
            return false;
        }

        return true;
    }

    protected function isLogin($session)
    {
        $id = $session->get('id');
        if(!$id){
            return false;
        }
        return true;
    }

    public function img(RequestInterface $request, ResponseInterface $response,Set $set,Helper $helper,SessionInterface $session)
    {
        if(!$this->isLogin($session)){
            throw new AppBadRequestException('请登录',Code::UNAUTHENTICATED);
        }

        $hasFile = $request->hasFile('file');
        $fileIsValid = $request->file('file')->isValid();
        if ($hasFile && $fileIsValid) {
            $file = $request->file('file');

            if(!$this->getError($file)){
                throw new AppBadRequestException('上传文件出错,请重试');
            }

            if(!$this->getImgSize($file,$set)){
                throw new AppBadRequestException('图片过大,请重试');
            }

            if(!$this->getImgType($file,$set)){
                throw new AppBadRequestException('图片类型错误,请重试');
            }

            $dir = date('Y-m-d',time());

            $savePath = 'public/upload/img/'.$dir;

            if(!is_dir($savePath)){
                mkdir($savePath, 0700);
            }

            $extension = $file->getExtension();
            $name = md5(uniqid(md5(microtime(true).random_int(1,100)),true)).'.'.$extension;

            $url = $savePath.'/'.$name;

            $file->moveTo($url);

            if ($file->isMoved()) {

                $imgUrl = '/upload/img/' . $dir . '/' . $name;

                $arr= array('path' => $imgUrl,'csrf'=>$helper->getCsrf());

                return $helper->success($arr);
            }

        }

        throw new AppBadRequestException('上传文件出错,请重试');
    }

}