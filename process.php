
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
        // TODO: Add your PHP processing code here starting in Step 3

        // Initialize variables for validation
        $errors = [];
        $name = $email = $club = "";
        $is_valid = true;

        // Check if the request method is POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Validate Name field
            if (empty($_POST['name'])) {
                $is_valid = false;
                $errors[] = "Name is a required field.";
            } else {
                // Sanitize name input
                $name = htmlspecialchars(trim($_POST['name']));
            }

            // Validate Email field
            if (empty($_POST['email'])) {
                $is_valid = false;
                $errors[] = "Email is a required field.";
            } else {
                // Sanitize email input
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

            // If all fields are valid, display the success message
            if ($is_valid) {
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





