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
     * @Message("Request Error")
     */
    const ERROR = 1000;

    /**
     * @Message("Success")
     */
    const SUCCESS = 200;

    /**
     * @Message("Validation Error")
     */
    const VALIDATE_ERROR = 1001;

    /**
     * @Message("Api Not Found")
     */
    const NOT_FOUND = 1002;

    /**
     * @Message("Auth Fail")
     */
    const Auth_Fail = 1003;

}