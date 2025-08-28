<?php
// Start the session to maintain registration data across requests
session_start();

// Define a constant for the file path to prevent typos
define("REGISTRATIONS_FILE", "registrations.json");

// Custom function to save data to a file
function saveRegistrationToFile($registration) {
    $registrations = getRegistrationsFromFile();
    $registrations[] = $registration;
    // Use JSON to easily store structured data in a text file
    file_put_contents(REGISTRATIONS_FILE, json_encode($registrations, JSON_PRETTY_PRINT));
}

// Custom function to retrieve data from a file
function getRegistrationsFromFile() {
    if (file_exists(REGISTRATIONS_FILE)) {
        $json_data = file_get_contents(REGISTRATIONS_FILE);
        // Decode the JSON data and return as an array
        return json_decode($json_data, true);
    }
    return []; // Return an empty array if the file doesn't exist
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Student Club Registration</h1>
        <p>Your registration status and a list of all members.</p>
    </header>

    <main>
        <?php
        // Initialize variables for validation
        $errors = [];
        $is_valid = true;

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect and validate all form data
            $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
            $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
            $club = isset($_POST['club']) ? htmlspecialchars(trim($_POST['club'])) : '';
            $membership = isset($_POST['membership']) ? htmlspecialchars($_POST['membership']) : 'standard';
            $interests = isset($_POST['interests']) ? $_POST['interests'] : [];
            $comments = isset($_POST['comments']) ? htmlspecialchars(trim($_POST['comments'])) : '';
        
            // Validate Name field
            if (empty($name)) {
                $is_valid = false;
                $errors[] = "Name is a required field.";
            }
        
            // Validate Email field
            if (empty($email)) {
                $is_valid = false;
                $errors[] = "Email is a required field.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $is_valid = false;
                $errors[] = "The email address is not in a valid format.";
            }
            
            // Validate Club field
            if (empty($club)) {
                $is_valid = false;
                $errors[] = "Please select a club.";
            }
        
            // If validation passes, save the new registration
            if ($is_valid) {
                $new_registration = [
                    'name' => $name,
                    'email' => $email,
                    'club' => $club,
                    'membership' => $membership,
                    'interests' => $interests,
                    'comments' => $comments,
                    'registration_date' => date('Y-m-d H:i:s')
                ];
        
                saveRegistrationToFile($new_registration);
        
                echo "<h2>Registration Successful!</h2>";
                echo "<p>Thank you for registering. Here is your information:</p>";
                echo "<ul>";
                echo "<li><strong>Name:</strong> $name</li>";
                echo "<li><strong>Email:</strong> $email</li>";
                echo "<li><strong>Club:</strong> $club</li>";
                echo "<li><strong>Membership:</strong> $membership</li>";
                echo "<li><strong>Interests:</strong> " . implode(", ", $interests) . "</li>";
                echo "<li><strong>Comments:</strong> $comments</li>";
                echo "</ul>";
            } else {
                // Display validation errors
                echo "<h2>Error!</h2>";
                echo "<p>Please fix the following issues:</p>";
                echo "<ul>";
                foreach ($errors as $error) {
                    echo "<li>&bull; $error</li>";
                }
                echo "</ul>";
            }
        
        } else {
            // Display a message if the form was not submitted via POST
            echo "<h2>Invalid Request</h2>";
            echo "<p>This page should be accessed via a form submission.</p>";
        }
        ?>

        <hr>

        <h2>All Registered Students</h2>

        <form method="get" action="process.php" class="search-form">
            <input type="text" name="search" placeholder="Search by name or club..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">Search</button>
        </form>

        <?php
        $all_registrations = getRegistrationsFromFile();
        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $search_query = strtolower(trim($_GET['search']));
            $filtered_registrations = array_filter($all_registrations, function($reg) use ($search_query) {
                return str_contains(strtolower($reg['name']), $search_query) || str_contains(strtolower($reg['club']), $search_query);
            });
            $display_registrations = $filtered_registrations;
        } else {
            $display_registrations = $all_registrations;
        }

        if (!empty($display_registrations)): ?>
            <ul class="registration-list">
                <?php foreach ($display_registrations as $registration): ?>
                    <li>
                        <strong>Name:</strong> <?= htmlspecialchars($registration['name']) ?><br>
                        <strong>Email:</strong> <?= htmlspecialchars($registration['email']) ?><br>
                        <strong>Club:</strong> <?= htmlspecialchars($registration['club']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No students have registered yet or no results found.</p>
        <?php endif; ?>

        <a href="index.html" class="button">Go Back</a>
    </main>

    <footer>
        <p>&copy; 2024 Student Club Registration System</p>
    </footer>
</body>
</html>

<?php
        /* 
        Step 3 Requirements:
        - Process form data using $_POST
        - Display submitted information back to user
        - Handle name, email, and club fields
       
          Step 4 Requirements:
        - Add validation for all fields
        - Check for empty fields
        - Validate email format
        - Display appropriate error messages

          Step 5 Requirements:
          - Store registration data in arrays
          - Display list of all registrations
          - Use loops to process array data

          Step 6 Requirements:
          - Add enhanced features like:
            - File storage for persistence
            - Additional form fields
            - Better error handling
            - Search functionality
        */

        ?>
