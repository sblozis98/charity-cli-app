<?php

/**
 * Class Charity
 * Represents a charity with an ID, name, and representative email.
 */
class Charity
{
    public $id; // The unique ID of the charity
    public $name; // The name of the charity
    public $representativeEmail; // The representative's email address for the charity

    /**
     * Charity constructor.
     * @param int $id The ID of the charity.
     * @param string $name The name of the charity.
     * @param string $representativeEmail The representative's email address of the charity.
     */
    public function __construct($id, $name, $representativeEmail)
    {
        // Initialize the charity properties
        $this->id = $id;
        $this->name = $name;
        $this->representativeEmail = $representativeEmail;
    }

    /**
     * Validates the format of an email address.
     * @param string $email The email address to validate.
     * @return bool True if the email is valid, false otherwise.
     */
    public static function validateEmail($email)
    {
        // Use PHP's built-in filter to validate the email format
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
