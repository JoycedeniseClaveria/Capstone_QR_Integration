<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    // function Header()
    // {
    //     $this->SetFont('Arial', 'B', 12);
    //     $this->Cell(0, 10, 'User Details', 0, 1, 'C');
    // }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Instantiation of inherited class
$pdf = new PDF();
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
$pdf->SetFont('Helvetica', 'B', 13);
$pdf->SetY(35);
$pdf->Cell(0, 10, "ADOPTION APPLICATION FORM", 0, 1, 'C');

if (isset($_GET['adoptionId'])) {
    $adoptionId = intval($_GET['adoptionId']);
    include 'connection.php';

    $query = "SELECT adoption.applicationDate, adoption.animalName, animal.image, adoption.name, adoption.age, adoption.emailAddress, adoption.location, adoption.contactNo, adoption.profession, adoption.fbName, adoption.fbLink, adoption.data1, adoption.data2, adoption.data3, adoption.data4, adoption.data5, adoption.data6, adoption.data7, adoption.data8, adoption.data9, adoption.data10, adoption.data11, adoption.data12, adoption.data13, adoption.data14, adoption.data15, adoption.data16, adoption.data17, adoption.data18, adoption.data19, adoption.data20, adoption.data21, adoption.data22, adoption.data23, adoption.data24, adoption.data25, adoption.data26, adoption.data27, adoption.data28, adoption.data29, adoption.data30
              FROM adoption 
              INNER JOIN animal ON adoption.animalName = animal.animalName
              WHERE adoption.adoptionId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $adoptionId);
    $stmt->execute();
    $stmt->bind_result($applicationDate, $animalName, $image, $name, $age, $emailAddress, $location, $contactNo, $profession, $fbName, $fbLink, $data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9, $data10, $data11, $data12, $data13, $data14, $data15, $data16, $data17, $data18, $data19, $data20, $data21, $data22, $data23, $data24, $data25, $data26, $data27, $data28, $data29, $data30);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    $pdf->SetFont('Helvetica', '', 11);

    // Set Y positions for each cell
    $currentY = 53; 
    $cellHeight = 10;

    // Display animal image
    if ($image) {
        $pdf->Ln(10);
        $imageX = $pdf->GetPageWidth() - 70; // X position of the image
        $imageY = $pdf->GetY(); // Y position of the image
        $imageWidth = 50; // Fixed width
        $imageHeight = 65; // Fixed height
        $pdf->Image($image, $imageX, $imageY, $imageWidth, $imageHeight); // Adjust size and position as needed
    }

    $labelX = 20; 
    $ansY = 160;
    $dataX = 60;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "Application Date: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($applicationDate), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "Animal Name: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($animalName), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "Adopter's Name: ", 0, 0,);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($name), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "Adopter's Age: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($age), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "Email Address: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($emailAddress), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "Address: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($location), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "Contact No: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($contactNo), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "Profession: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($profession), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "FB Name: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($fbName), 0, 1, 'L');
    $currentY += $cellHeight;

    $pdf->SetY($currentY);
    $pdf->SetX($labelX); // Set X position to align to the right
    $pdf->Cell(40, $cellHeight, "FB Link: ", 0, 0);
    $pdf->SetX($dataX);
    $pdf->Cell(50, $cellHeight, htmlspecialchars($fbLink), 0, 1, 'L');
    $currentY += $cellHeight;

    // Set the initial position for the label
    $pdf->SetY($ansY);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "1. Why did you decide to adopt an animal? ", 0, 1);
    $content = (empty($data1) ? "N/A" : htmlspecialchars($data1));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(185);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "2. Have you adopted from us before? ", 0, 1);
    $content = (empty($data2) ? "N/A" : htmlspecialchars($data2));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(210);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "3. If YES, when? (put N/A if otherwise) ", 0, 1);
    $content = (empty($data3) ? "N/A" : htmlspecialchars($data3));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(235);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "4. What type of residence do you live in? ", 0, 1);
    $content = (empty($data4) ? "N/A" : htmlspecialchars($data4));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(260);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "5. Is the residence for RENT? If YES, please secure a written letter from your landlord that pets are allowed. (put N/A if otherwise) ", 0, 1);
    $content = (empty($data5) ? "N/A" : htmlspecialchars($data5));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(35);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "6. Who do you live with? Please be specific. ", 0, 1);
    $content = (empty($data6) ? "N/A" : htmlspecialchars($data6));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(60);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "7. How long have you lived in the address registered here? ", 0, 1);
    $content = (empty($data7) ? "N/A" : htmlspecialchars($data7));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(85);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "8. Are you planning to move in the next six (6) months? ", 0, 1);
    $content = (empty($data8) ? "N/A" : htmlspecialchars($data8));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2;
    
    $pdf->SetY(110);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "9. If YES, where? Please leave a specific address. (put N/A if otherwise) ", 0, 1);
    $content = (empty($data9) ? "N/A" : htmlspecialchars($data9));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(135);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "10. Will the whole family be involved in the care of the animal? ", 0, 1);
    $content = (empty($data10) ? "N/A" : htmlspecialchars($data10));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(160);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "11. If NO, please explain. (put N/A if otherwise) ", 0, 1);
    $content = (empty($data11) ? "N/A" : htmlspecialchars($data11));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(185);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "12. Is there anyone in your household who has objection(s) to the arrangement? ", 0, 1);
    $content = (empty($data12) ? "N/A" : htmlspecialchars($data12));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(210);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "13. If YES, please explain. (put N/A if otherwise) ", 0, 1);
    $content = (empty($data13) ? "N/A" : htmlspecialchars($data13));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(235);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "14. Are there any children who visit your home frequently? ", 0, 1);
    $content = (empty($data14) ? "N/A" : htmlspecialchars($data14));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(260);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "15. Are there any other regular visitors on your home which your new companion must get along? ", 0, 1);
    $content = (empty($data15) ? "N/A" : htmlspecialchars($data15));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(35);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "16. Are there any member of your household who has an allergy to cats and dogs? ", 0, 1);
    $content = (empty($data16) ? "N/A" : htmlspecialchars($data16));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(60);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "17. If YES, who? (put N/A if otherwise) ", 0, 1);
    $content = (empty($data17) ? "N/A" : htmlspecialchars($data17));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(85);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "18. What will happen to this animal if you have to move unexpectedly? ", 0, 1);
    $content = (empty($data18) ? "N/A" : htmlspecialchars($data18));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(110);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "19. What kind of behavior(s) of the dog do you feel you will be unable to accept? ", 0, 1);
    $content = (empty($data19) ? "N/A" : htmlspecialchars($data19));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(135);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "20. How many hours in an average work day will your companion animal spend without a human? ", 0, 1);
    $content = (empty($data20) ? "N/A" : htmlspecialchars($data20));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(160);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "21. What will happen to your companion animal when you go on vacation or in case of emergency? ", 0, 1);
    $content = (empty($data21) ? "N/A" : htmlspecialchars($data21));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(185);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "22. Do you have a regular veterinarian? ", 0, 1);
    $content = (empty($data22) ? "N/A" : htmlspecialchars($data22));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(210);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "23. If YES, please provide these information: Name, Address and Contact Number (put N/A if otherwise) ", 0, 1);
    $content = (empty($data23) ? "N/A" : htmlspecialchars($data23));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(235);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "24. Do you have other companion animals? ", 0, 1);
    $content = (empty($data24) ? "N/A" : htmlspecialchars($data24));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(260);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "25. If YES, please specify what type and the total number. (put N/A if otherwise) ", 0, 1);
    $content = (empty($data25) ? "N/A" : htmlspecialchars($data25));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(35);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "26. In which part of the house will the animal stay? ", 0, 1);
    $content = (empty($data26) ? "N/A" : htmlspecialchars($data26));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(60);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "27. Where will this animal be kept during the day and during night? Please specify. ", 0, 1);
    $content = (empty($data27) ? "N/A" : htmlspecialchars($data27));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(85);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "28. Do you have a fenced yard? If YES, please specify the height and type. (put N/A if otherwise) ", 0, 1);
    $content = (empty($data28) ? "N/A" : htmlspecialchars($data28));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(110);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "29. If NO fence, how will you handle the dog's exercise and toilet duties? (put N/A if otherwise) ", 0, 1);
    $content = (empty($data29) ? "N/A" : htmlspecialchars($data29));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 

    $pdf->SetY(135);
    $pdf->SetX($labelX);
    $pdf->Cell(40, $cellHeight, "30. If adopting a cat, where will be the litter box be kept? (put N/A if otherwise) ", 0, 1);
    $content = (empty($data30) ? "N/A" : htmlspecialchars($data30));
    $pdf->SetX(25);
    $pdf->MultiCell(160, $cellHeight, $content, 0, 'L');
    $endY = $pdf->GetY();
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Line(25, $endY, 185, $endY); 
    $currentY = $endY + 2; 




// $pdf->SetY($currentY);
// $pdf->SetX(25);
// $pdf->MultiCell(160, $cellHeight, "Additional content can go here.", 0, 'L');

    


    // Write details to the PDF
    // $pdf->Cell(0, 10, "Application Date: " . htmlspecialchars($applicationDate), 0, 1);
    // $pdf->Cell(0, 10, "Animal Name: " . htmlspecialchars($animalName), 0, 1);
    // $pdf->Cell(0, 10, "Adopter's Name: " . htmlspecialchars($name), 0, 1);
    

    

} else {
    $pdf->Cell(0, 10, 'No adoption ID specified', 0, 1);
}

//  // Footer
//  $pdf->SetY(-25);  // Position at 15 mm from bottom
//  $pdf->SetX(0);    // Reset X to left margin
//  $pdf->SetFont('Arial', 'I', 8);
//  $pdf->Cell(0, 10, 'Thank you for your application.', 0, 0, 'C');  // Centered footer text

 // Close the document and output the PDF
 $pdf->Output('I', 'AdoptionApplication.pdf');  // Send to browser (inline display)


// $pdf->Output();
?>
