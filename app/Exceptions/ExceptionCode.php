<?php

namespace App\Exceptions;


/**
 * Global exception code definitions
 */
final class ExceptionCode
{
    /**
     * Code for general exception
     */
    const GENERAL = 10000;
    const FORM_VALIDATION = 10001;
    const AUTHENTICATION = 10002;

    //**********************
    //      User
    //**********************
    const CLIENT_NOT_EXISTS = 10101;
}
