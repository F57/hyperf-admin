<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\UploadException;
use App\Helpers\Code;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Di\Annotation\Inject;

class Upload
{
    protected $config;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    public function __construct(array $config=array(),RequestInterface $request)
    {
        $this->config=$config;
        $this->request=$request;
    }

    public function imgUpload($name)
    {
        $obj = $this->request->file($name);
        $this->getError($obj);
    }
//$d = $this->request->file('image')->getError();//int(0)
//$e = $this->request->file('image')->getClientMediaType();//string(10) "image/jpeg"
//$f = $this->request->file('image')->getType();//string(4) "file"
//$k = $this->request->file('image')->getExtension();//string(3) "jpg"
//$l = $this->request->file('image')->getMimeType();//string(10) "image/jpeg"
//$a = $this->request->file('image')->getSize();
    protected function getError($obj)
    {
        $type = $obj->getError();
        switch ($type)
        {
            case 1:
                throw new UploadException(trans(),Code::UPLOAD_ERROR);
            break;

            case 2:
//                expression = label2 时执行的代码 ;
            break;

            default:
//                表达式的值不等于 label1 及 label2 时执行的代码;
        }
    }


}