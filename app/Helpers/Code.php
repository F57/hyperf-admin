<?php
declare(strict_types = 1);

namespace App\Helpers;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class Code extends AbstractConstants {

    /**
     * @Message("Request Error！")
     */
    const ERROR = 0;

    /**
     * @Message("Success")
     */
    const SUCCESS = 200;

    /**
     * @Message("请先登录")
     */
    const UNAUTHENTICATED = 401;

    /**
     * @Message("无权访问该资源")
     */
    const DISALLOW = 403;

    /**
     * @Message("请求资源不存在")
     */
    const RECORD_NOT_FOUND = 404;

    /**
     * @Message("超时")
     */
    const TIMEOUT_ERROR = 408;

    /**
     * @Message("未认证")
     */
    const CSRF_NOT_FOUND = 419;

    /**
     * @Message("验证错误")
     */
    const VALIDATE_ERROR = 422;

    /**
     * @Message("上传错误")
     */
    const UPLOAD_ERROR = 1000;

    /**
     * @Message("操作失败")
     */
    const OPERATE_ERROR = 1001;

}