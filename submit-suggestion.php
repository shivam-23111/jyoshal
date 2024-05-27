<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $message = $_POST["message"];
    
    // Open the file in append mode
    $file = fopen("suggestions.txt", "a");
    
    if ($file) {
        // Format the message with username and timestamp
        $formattedMessage = "[$username] - $message\n";
        
        // Write the message to the file
        fwrite($file, $formattedMessage);
        
        // Close the file
        fclose($file);
        
        // Redirect back to the main page after submission
        header("Location: index.html");
        exit;
    } else {
        echo "Failed to save suggestion. Please try again.";
    }
}

?>
