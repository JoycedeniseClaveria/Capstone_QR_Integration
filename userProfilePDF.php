<?php
  require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'User Details', 0, 1, 'C');
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Instantiation of inherited class
$pdf = new FPDF();
$pdf->AddPage();

// Set margins: left, top, and right
$pdf->SetMargins(20, 20, 20);  // Margins set to 20mm each

// Optionally set auto page break
$pdf->SetAutoPageBreak(true, 25);

// Add a logo to the PDF
// Parameters: Image(file, x, y, width, height)
$pdf->Image('logo.png', 20, 5, 20); // Adjust x, y, width, and height as needed

// Set font for the title
$pdf->SetFont('Helvetica', 'B', 13); // Adjust font size as needed
$pdf->SetY(5); // Set the Y position of the title
$pdf->SetX(50); // Set the X position of the title to align it next to the logo
// Title
$pdf->Cell(140, 20, 'Second Chance Aspin Shelter Inc.', 0, 1, 'C'); // No border, align center

// Add text below the title
$pdf->SetFont('Helvetica', 'I', 11);
$pdf->SetY(17); // Position below the line
$pdf->SetX(50); // Respect left margin
$pdf->Cell(0, 10, '#428 Purok 7, Tibagan Road Majada, Calamba, Laguna', 0, 1, 'C');

// Draw a line below the header
$pdf->SetY(40); // Adjust the Y position where the line should start
$pdf->SetDrawColor(0, 0, 0); // Set color of the line (black)
$pdf->SetLineWidth(0.2); // Set width of the line
$pdf->Line(20, 27, 190, 27); // Draw the line from x1,y1 to x2,y2

// Adjust the line break and continue with your PDF content
$pdf->Ln(10);

// Add other elements like text, tables etc.
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Welcome to the Second Chance Aspin Shelter Inc. documentation.", 0, 1);



if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);
    include 'connection.php';

    $query = "SELECT firstName, lastName, location, emailAddress, contactNo, gender, birthday, maritalStatus, citizenship FROM users WHERE userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $location, $emailAddress, $contactNo, $gender, $birthday, $maritalStatus, $citizenship);
    $stmt->fetch();
    $stmt->close();

    // Map gender and marital status
    $genderText = $gender == 0 ? "Male" : "Female";
    $maritalStatusText = $maritalStatus == 0 ? "Single" : ($maritalStatus == 1 ? "Married" : "Widowed");

    // Write details to the PDF
    $pdf->Cell(0, 10, "First Name: " . $firstName, 0, 1);
    $pdf->Cell(0, 10, "Last Name: " . $lastName, 0, 1);
    $pdf->Cell(0, 10, "Location: " . $location, 0, 1);
    $pdf->Cell(0, 10, "Email Address: " . $emailAddress, 0, 1);
    $pdf->Cell(0, 10, "Contact No: " . $contactNo, 0, 1);
    $pdf->Cell(0, 10, "Gender: " . $genderText, 0, 1);
    $pdf->Cell(0, 10, "Birthday: " . $birthday, 0, 1);
    $pdf->Cell(0, 10, "Marital Status: " . $maritalStatusText, 0, 1);
    $pdf->Cell(0, 10, "Citizenship: " . $citizenship, 0, 1);
} else {
    $pdf->Cell(0, 10, 'No user specified', 0, 1);
}

$pdf->Output();
?>
