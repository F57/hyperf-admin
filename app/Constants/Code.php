<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class Code extends AbstractConstants
{
    /**
     * @Message("messages.request_error")
     */
    const ERROR = 0;

    /**
     * @Message("messages.request_success")
     */
    const SUCCESS = 200;

    /**
     * @Message("messages.login")
     */
    const LOGIN = 401;

    /**
     * @Message("messages.disallow")
     */
    const DISALLOW = 403;

    /**
     * @Message("messages.notfound")
     */
    const RECORD_NOT_FOUND = 404;

    /**
     * @Message("messages.timeout")
     */
    const TIMEOUT_ERROR = 408;

    /**
     * @Message("messages.csrf")
     */
    const CSRF_NOT_FOUND = 419;

    /**
     * @Message("messages.validata")
     */
    const VALIDATA_ERROR = 422;

    /**
     * @Message("messages.upload_error")
     */
    const UPLOAD_ERROR = 1000;
}