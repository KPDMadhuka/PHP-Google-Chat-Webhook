<?php
// Initialize the message variable
$message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace 'YOUR_WEBHOOK_URL' with your actual Google Chat webhook URL
    $webhookUrl = 'YOUR_WEBHOOK_URL';

    // Get the form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $contactInfo = isset($_POST['contact_info']) ? trim($_POST['contact_info']) : '';
    $messageText = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Check if required fields are not empty
    if (!empty($name) && !empty($contactInfo) && !empty($messageText)) {
        // Message data to be sent to Google Chat
        $messageData = array(
            'text' => "New contact form submission:\nName: $name\nContact: $contactInfo\nMessage: $messageText",
        );

        // Convert the message data to JSON
        $jsonData = json_encode($messageData);

        // Set up cURL to make a POST request to the Google Chat webhook URL
        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        // Execute the cURL request and capture the response
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        // Set the success message
        $message = 'Form submitted successfully';
    } else {
        // Set an error message if any required field is empty
        $message = 'All fields are required';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Form</h1>
    
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="contact_info">Contact Number or Email:</label>
        <input type="text" name="contact_info" id="contact_info" required>

        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
