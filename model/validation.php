<?php
/**
 * Validation Class
 */
class Validation {

    /**
     * Function to validate first name
     * @param $name
     * @return boolean
     */
    function validFName($name): bool
    {
        return strlen($name) < 2;
    }

}
