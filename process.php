<?php
// Start the session to maintain registration data across requests
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>
    <!-- Use Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100 p-4">
    <main class="card p-5 shadow-lg rounded-3 text-center" style="max-width: 500px; width: 100%;">
        <?php
        // Club Registration Form Processing
        
        // Initialize variables for validation
        $errors = [];
        $name = $email = $club = "";
        $is_valid = true;

        // Initialize the registrations array in the session if it doesn't exist
        if (!isset($_SESSION['registrations'])) {
            $_SESSION['registrations'] = [];
        }

        // Check if the request method is POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Validate Name field
            if (empty($_POST['name'])) {
                $is_valid = false;
                $errors[] = "Name is a required field.";
            } else {
                // Sanitize and trim name input
                $name = htmlspecialchars(trim($_POST['name']));
            }

            // Validate Email field
            if (empty($_POST['email'])) {
                $is_valid = false;
                $errors[] = "Email is a required field.";
            } else {
                // Sanitize and trim email input
                $email = htmlspecialchars(trim($_POST['email']));
                // Validate email format using filter_var()
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $is_valid = false;
                    $errors[] = "The email address is not in a valid format.";
                }
            }
            
            // Validate Club field
            if (empty($_POST['club'])) {
                $is_valid = false;
                $errors[] = "Please select a club.";
            } else {
                // Sanitize club input
                $club = htmlspecialchars(trim($_POST['club']));
            }

            // If all fields are valid, display the success message and store the data
            if ($is_valid) {
                // Create an associative array for the new registration
                $new_registration = [
                    'name' => $name,
                    'email' => $email,
                    'club' => $club
                ];
                // Push the new registration to the session array
                $_SESSION['registrations'][] = $new_registration;

                // Display a confirmation message to the user
                echo "<h1 class='h3 fw-bold text-dark mb-4'>Registration Successful!</h1>";
                echo "<p class='lead text-secondary mb-4'>Thank you for registering. Here is your information:</p>";
                echo "<div class='text-start space-y-2'>";
                echo "<p class='text-muted'><span class='fw-semibold text-dark'>Name:</span> $name</p>";
                echo "<p class='text-muted'><span class='fw-semibold text-dark'>Email:</span> $email</p>";
                echo "<p class='text-muted'><span class='fw-semibold text-dark'>Club:</span> $club</p>";
                echo "</div>";
            } else {
                // Display error messages
                echo "<h1 class='h3 fw-bold text-danger mb-4'>Error!</h1>";
                echo "<p class='text-secondary'>Please fix the following issues:</p>";
                echo "<ul class='list-unstyled text-start text-danger'>";
                foreach ($errors as $error) {
                    echo "<li>&bull; $error</li>";
                }
                echo "</ul>";
            }

        } else {
            // Display a message if the form was not submitted via POST
            echo "<h1 class='h3 fw-bold text-danger mb-4'>Invalid Request</h1>";
            echo "<p class='text-secondary'>This page should be accessed via a form submission.</p>";
        }
        ?>

        <hr class="my-4">

        <h2 class="h4 fw-bold text-dark mb-3">All Registered Students</h2>
        <?php if (!empty($_SESSION['registrations'])): ?>
            <ul class="list-group list-group-flush text-start">
                <?php foreach ($_SESSION['registrations'] as $index => $registration): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 fw-bold"><?= htmlspecialchars($registration['name']) ?></p>
                            <small class="text-muted"><?= htmlspecialchars($registration['email']) ?></small>
                        </div>
                        <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($registration['club']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">No students have registered yet.</p>
        <?php endif; ?>
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
        <a href="index.html" class="btn btn-primary mt-4">
            Go Back
        </a>
    </main>
</body>
</html>





