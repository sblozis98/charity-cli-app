<?php

require_once 'Charity.php'; // Include the Charity class definition
require_once 'Donation.php'; // Include the Donation class definition

/**
 * Class CharityManager
 * Manages charities and donations, including CRUD operations, validation, and CSV import.
 */
class CharityManager
{
    private $charities = []; // Array to store Charity objects, indexed by charity ID
    private $donations = []; // Array to store Donation objects, indexed by donation ID

    /**
     * Displays all the charities stored in the application.
     * If a charity has received donations, they are displayed along with the charity details.
     */
    public function viewCharities()
    {
        if (empty($this->charities)) {
            // No charities are available to display
            echo "No charities available.\n";
            return;
        }

        // Loop through each charity and display its details
        foreach ($this->charities as $charity) {
            echo "ID: {$charity->id}, Name: {$charity->name}, Email: {$charity->representativeEmail}\n";

            // Check if there are any donations associated with this charity
            $hasDonations = false;
            foreach ($this->donations as $donation) {
                if ($donation->charityId == $charity->id) {
                    // Display donation details associated with this charity
                    echo "  - Donation ID: {$donation->id}, Donor: {$donation->donorName}, Amount: \${$donation->amount}, Date: {$donation->dateTime}\n";
                    $hasDonations = true;
                }
            }

            if (!$hasDonations) {
                echo "  No donations for this charity.\n"; // Inform the user if no donations were found
            }
        }
    }

    /**
     * Adds a new charity to the application.
     * @param string $id The ID of the charity.
     * @param string $name The name of the charity.
     * @param string $email The representative's email address of the charity.
     */
    public function addCharity($id, $name, $email)
    {
        // Validate the email format using the Charity class's static method
        if (!Charity::validateEmail($email)) {
            echo "Invalid email address.\n";
            return;
        }

        // Check if a charity with the same ID already exists
        if (isset($this->charities[$id])) {
            echo "Charity ID already exists.\n";
            return;
        }

        // Create a new Charity object and add it to the list
        $charity = new Charity($id, $name, $email);
        $this->charities[$id] = $charity;
        echo "Charity added successfully.\n";
    }

    /**
     * Edits an existing charity's details.
     * @param string $id The ID of the charity to edit.
     * @param string $name The new name of the charity.
     * @param string $email The new representative's email address of the charity.
     */
    public function editCharity($id, $name, $email)
    {
        // Check if the charity exists in the list
        if (!isset($this->charities[$id])) {
            echo "Charity not found.\n";
            return;
        }

        // Validate the new email format
        if (!Charity::validateEmail($email)) {
            echo "Invalid email address.\n";
            return;
        }

        // Update the charity's details
        $this->charities[$id]->name = $name;
        $this->charities[$id]->representativeEmail = $email;
        echo "Charity updated successfully.\n";
    }

    /**
     * Deletes a charity from the application.
     * @param string $id The ID of the charity to delete.
     */
    public function deleteCharity($id)
    {
        // Check if the charity exists in the list
        if (!isset($this->charities[$id])) {
            echo "Charity not found.\n";
            return;
        }

        // Remove the charity from the list
        unset($this->charities[$id]);
        echo "Charity deleted successfully.\n";
    }

    /**
     * Adds a new donation to the application.
     * @param string $id The ID of the donation.
     * @param string $donorName The name of the donor.
     * @param float $amount The amount of the donation.
     * @param string $charityId The ID of the charity receiving the donation.
     */
    public function addDonation($id, $donorName, $amount, $charityId)
    {
        // Check if the charity ID exists in the list
        if (!isset($this->charities[$charityId])) {
            echo "Charity not found.\n";
            return;
        }

        // Validate the donation amount
        if (!Donation::validateAmount($amount)) {
            echo "Invalid donation amount.\n";
            return;
        }

        // Create a new Donation object with the provided details
        $dateTime = date('Y-m-d H:i:s'); // Current date and time
        $donation = new Donation($id, $donorName, $amount, $charityId, $dateTime);
        $this->donations[$id] = $donation; // Add the donation to the list
        echo "Donation added successfully.\n";
    }

    /**
     * Imports charities from a CSV file.
     * @param string $filename The path to the CSV file.
     */
    public function importCharitiesFromCSV($filename)
    {
        // Check if the file exists and is readable
        if (!file_exists($filename) || !is_readable($filename)) {
            echo "CSV file does not exist or is not readable.\n";
            return;
        }

        $header = null; // To store the header row
        $data = array(); // To store the CSV data
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                if (!$header) {
                    // The first row is the header
                    $header = $row;
                } else {
                    // Combine header and row to create associative array
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);

            // Add each charity from the CSV data
            foreach ($data as $row) {
                $id = $row['id'];
                $name = $row['name'];
                $email = $row['email'];
                $this->addCharity($id, $name, $email);
            }
        }
    }
}
