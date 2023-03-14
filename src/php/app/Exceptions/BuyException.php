<?php

namespace App\Exceptions;

use Exception;

class BuyException extends Exception
{
    protected $message = 'BuyControllerで例外が発生しました';
}
