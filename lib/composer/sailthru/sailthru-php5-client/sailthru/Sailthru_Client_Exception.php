<?php

/**
 * Handles Sailthru Client Exceptions
 */
class Sailthru_Client_Exception extends Exception {
    /**
     * Sailthru internal error codes.
     */
    const ERROR_CODE_INTERNAL_EXCEPTION = 9;
    const ERROR_CODE_INVALID_EMAIL = 11;

    /**
     * Standardized exception codes.
     */
    const CODE_GENERAL = 1000;
    const CODE_RESPONSE_EMPTY = 1001;
    const CODE_RESPONSE_INVALID = 1002;
}
