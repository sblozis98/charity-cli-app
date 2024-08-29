<?php

/**
 * Class Donation
 * Represents a donation with an ID, donor name, amount, charity ID, and date/time.
 */
class Donation
{
    public $id; // The unique ID of the donation
    public $donorName; // The name of the donor who made the donation
    public $amount; // The amount of money donated
    public $charityId; // The ID of the charity to which the donation is made
    public $dateTime; // The date and time when the donation was made

    /**
     * Donation constructor.
     * @param int $id The ID of the donation.
     * @param string $donorName The name of the donor.
     * @param float $amount The amount of the donation.
     * @param int $charityId The ID of the charity receiving the donation.
     * @param string $dateTime The date and time of the donation.
     */
    public function __construct($id, $donorName, $amount, $charityId, $dateTime)
    {
        // Initialize the donation properties
        $this->id = $id;
        $this->donorName = $donorName;
        $this->amount = $amount;
        $this->charityId = $charityId;
        $this->dateTime = $dateTime;
    }

    /**
     * Validates the donation amount to ensure it is a positive number.
     * @param float $amount The amount to validate.
     * @return bool True if the amount is valid, false otherwise.
     */
    public static function validateAmount($amount)
    {
        // Check that the amount is a numeric value greater than 0
        return is_numeric($amount) && $amount > 0;
    }
}
