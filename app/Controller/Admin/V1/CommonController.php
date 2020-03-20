<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1;

use App\Constants\Code;
use App\Controller\Admin\BaseController;
use App\Exception\AppRequestException;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 */
class CommonController extends BaseController
{

    protected function isLogin()
    {
        $id = $this->session->get('id');
        if(!$id){
            return false;
        }
        return true;
    }

    /**
     * @RequestMapping(path="/v1/common/image", methods="post")
     */
    public function image()
    {   
	    $uploadFile = key($this->request->getUploadedFiles());

        if(!$uploadFile){
            throw new AppRequestException('',Code::UPLOAD_ERROR);
        }


        if(!$this->isLogin()){
            throw new AppRequestException('',Code::LOGIN);
        }


        $fileIsValid = $this->request->file($uploadFile)->isValid();

        if ($fileIsValid) {
            $file = $this->request->file($uploadFile);

            $dir = date('Y-m-d',time());

            $savePath = BASE_PATH.'/public/upload/image/'.$dir;

            if(!is_dir($savePath)){
                mkdir($savePath, 0700);
            }

            $extension = $file->getExtension();

            $name = md5(uniqid(md5(microtime(true).random_int(1,100)),true)).'.'.$extension;

            $url = $savePath.'/'.$name;

            $file->moveTo($url);

            if ($file->isMoved()) {

                $imgUrl = '/upload/image/' . $dir . '/' . $name;

                $arr= array('path' => $imgUrl,'csrf'=>$this->helper->getCsrf());

                return $this->helper->success($arr);
            }

        }

        throw new AppRequestException('',Code::UPLOAD_ERROR);
    }

}
