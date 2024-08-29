<?php

require_once 'CharityManager.php'; // Include the CharityManager class

// Create an instance of the CharityManager
$manager = new CharityManager();

// Main loop for the CLI application
while (true) {
    // Display the available actions to the user
    echo "\nChoose an action: view, add, edit, delete, donate, import, exit: ";
    $action = trim(fgets(STDIN)); // Get the user's input

    switch ($action) {
        case 'view':
            $manager->viewCharities(); // Display the list of charities and their donations
            break;
        case 'add':
            echo "Enter Charity ID: ";
            $id = trim(fgets(STDIN)); // Get charity ID from user
            echo "Enter Charity Name: ";
            $name = trim(fgets(STDIN)); // Get charity name from user
            echo "Enter Representative Email: ";
            $email = trim(fgets(STDIN)); // Get representative's email from user
            $manager->addCharity($id, $name, $email); // Add the charity
            break;
        case 'edit':
            echo "Enter Charity ID to edit: ";
            $id = trim(fgets(STDIN)); // Get charity ID to edit
            echo "Enter new Charity Name: ";
            $name = trim(fgets(STDIN)); // Get new name for the charity
            echo "Enter new Representative Email: ";
            $email = trim(fgets(STDIN)); // Get new email for the charity
            $manager->editCharity($id, $name, $email); // Edit the charity
            break;
        case 'delete':
            echo "Enter Charity ID to delete: ";
            $id = trim(fgets(STDIN)); // Get charity ID to delete
            $manager->deleteCharity($id); // Delete the charity
            break;
        case 'donate':
            echo "Enter Donation ID: ";
            $id = trim(fgets(STDIN)); // Get donation ID
            echo "Enter Donor Name: ";
            $donorName = trim(fgets(STDIN)); // Get donor's name
            echo "Enter Donation Amount: ";
            $amount = trim(fgets(STDIN)); // Get donation amount
            echo "Enter Charity ID: ";
            $charityId = trim(fgets(STDIN)); // Get charity ID for the donation
            $manager->addDonation($id, $donorName, $amount, $charityId); // Add the donation
            break;
        case 'import':
            echo "Enter CSV filename: ";
            $filename = trim(fgets(STDIN)); // Get the CSV filename from the user
            $manager->importCharitiesFromCSV($filename); // Import charities from the CSV file
            break;
        case 'exit':
            exit("Exiting...\n"); // Exit the application
        default:
            echo "Invalid action. Please choose again.\n"; // Handle invalid input
    }
}
