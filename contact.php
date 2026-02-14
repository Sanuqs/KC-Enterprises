<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $name = strip_tags(trim($_POST["name"]));
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
    
    $message = strip_tags(trim($_POST["message"]));
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

    // Check required fields
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Error</title><link rel='stylesheet' href='css/style.css'></head><body style='display: flex; justify-content: center; align-items: center; height: 100vh;'><div style='text-align: center; padding: 30px; background: #f8d7da; border-radius: 10px;'><h2>❌ Invalid input</h2><p>Please fill all fields correctly.</p><a href='index.html#contact' class='btn btn-primary'>Go Back</a></div></body></html>";
        exit;
    }

    // Recipient email (CHANGE THIS TO YOUR ACTUAL EMAIL)
    $to = "your-email@example.com"; 
    
    // Subject
    $subject = "New Contact Message from $name";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
        // Success response
        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Thank You</title><link rel='stylesheet' href='css/style.css'></head><body style='display: flex; justify-content: center; align-items: center; height: 100vh;'><div style='text-align: center; padding: 30px; background: #d4edda; border-radius: 10px;'><h2>✅ Message Sent!</h2><p>Thank you for contacting KC Enterprises. We'll get back to you soon.</p><a href='index.html' class='btn btn-primary'>Return Home</a></div></body></html>";
    } else {
        // Failure response
        http_response_code(500);
        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Error</title><link rel='stylesheet' href='css/style.css'></head><body style='display: flex; justify-content: center; align-items: center; height: 100vh;'><div style='text-align: center; padding: 30px; background: #f8d7da; border-radius: 10px;'><h2>❌ Server Error</h2><p>Something went wrong. Please try again later.</p><a href='index.html#contact' class='btn btn-primary'>Go Back</a></div></body></html>";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Forbidden</title></head><body><h2>403 Forbidden</h2></body></html>";
}
?>