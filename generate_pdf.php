<?php
// Include the FPDF library
require('fpdf/fpdf.php');

// Function to log download events
function logDownload($userName) {
    $logFile = 'download_log.txt'; // Path to the log file
    
    // Prepare log message
    $logMessage = date('Y-m-d H:i:s') . " - User: $userName downloaded the PDF\n";
    
    // Append log message to the log file
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user's name from the POST request
    $userName = isset($_POST['userName']) ? $_POST['userName'] : '';

    // Check if the user's name is not empty
    if (!empty($userName)) {
        // Create a new PDF instance
        $pdf = new FPDF();
        $pdf->AddPage();

        // Draw other content on top of the background
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect(0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight(), 'F'); // Fill the page with white

        // Draw a red border around the content area
        $pdf->SetDrawColor(255, 0, 0); // Red
        $pdf->SetLineWidth(1); // Border width
        $pdf->Rect(5, 5, $pdf->GetPageWidth() - 10, $pdf->GetPageHeight() - 10); // Border around content

        // Include your Ganesh Ji logo (adjust path as needed)
        $logoPath = 'ganeshji.png';
        $pdf->Image($logoPath, 80, 10, 50); // Position logo at (80, 10) with width 50

        // Set font for title
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(36, 64, 97); // Dark blue color
        $pdf->SetXY(10, 80); // Set position for title text
        $pdf->Cell(0, 10, 'Wedding Invitation', 0, 1, 'C');
        
        // Set font for invitation text
        $pdf->SetFont('Arial', '', 14);
        $pdf->SetTextColor(64, 64, 64); // Dark gray color
        $invitationText = "Dear $userName,\n\nYou are invited to our wedding ceremony on July 9, 2024.\n\nPlease join us for this special occasion.\n\nBest regards,\nJyoti & Vishal";
        $pdf->SetXY(10, 120); // Set position for invitation text
        $pdf->MultiCell(0, 10, $invitationText);

        // Clear the output buffer to avoid any extra content being added
        ob_end_clean();
        
        // Set the headers to force download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Wedding_Invitation.pdf"');
        header('Content-Length: ' . strlen($pdf->Output('S')));

        // Output the PDF as a download
        $pdf->Output('D', 'Wedding_Invitation.pdf'); // 'D' for download

        // Log the download event
        logDownload($userName);

        exit;
    }
}
?>
