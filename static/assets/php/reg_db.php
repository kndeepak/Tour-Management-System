<?php
    

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "contactdb";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }


    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST["password"]);
        // $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($password) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        // $recipient = "deepak_kasi_nathan@yahoo.com";

        //$recipient=  'deepak_kasi_nathan@yahoo.com';

        // Set the email subject.
        // $subject = "New contact from $name";

        // // Build the email content.
        // $email_content = "Name: $name\n";
        // $email_content .= "Email: $email\n\n";
        // $email_content .= "Subject: $subject\n\n";
        // $email_content .= "Message:\n$message\n";

        // Build the email headers.
        //$email_headers = "From: $name <$email>";

        $sql = "INSERT INTO reg (name,password, email ) VALUES ('".$name."','".$password."','".$email."')";


        // Send the email.
        if (mysqli_query($conn, $sql)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You Your message has been sent. we will contact you soon ";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
