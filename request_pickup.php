<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pickup_system";

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$strPool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$po_number = "MKL" . substr(str_shuffle(str_repeat($strPool, ceil(10 / strlen($strPool)))), 1, 8);
$part_name = $_POST['part_name'];
$quantity = $_POST['quantity'];
$dimensi_part = $_POST['length'] . '/' . $_POST['width'] . '/' . $_POST['height'];
$weight = $_POST['weight'];
$pickup_address = $_POST['pickup_address'];
$destination_address = $_POST['destination_address'];
$pickup_date = $_POST['pickup_date'];
$supplier_name = $_POST['supplier_name'];
$requester_name = $_POST['requester_name'];

$docName = $_FILES['import_documents']['name'];
$fileTmp = $_FILES['import_documents']['tmp_name'];
$dirUpload = 'document/';
$import_documents = $dirUpload . $docName;
$uploaded = move_uploaded_file($fileTmp, $import_documents);

$shipping_options = $_POST['shipping_options'];

// Check if file was uploaded successfully
if (!$uploaded) {
    die("Error uploading file.");
}

// Insert form data into database
$sql = "INSERT INTO pickup_requests (po_number, part_name, quantity, dimensi_part, weight, pickup_address, destination_address, pickup_date, supplier_name, requester_name, import_documents, shipping_options)
VALUES ('$po_number', '$part_name', '$quantity', '$dimensi_part', '$weight', '$pickup_address', '$destination_address', '$pickup_date', '$supplier_name', '$requester_name', '$import_documents', '$shipping_options')";

if ($conn->query($sql) === TRUE) {
    // $mail = new PHPMailer(true);

    // try {
    //     // Pengaturan server SMTP
    //     $mail->isSMTP();                                     
    //     $mail->Host       = 'smtp.gmail.com';
    //     $mail->SMTPAuth   = true;
    //     $mail->Username   = 'yonathan.santo@maka-motors.com';
    //     $mail->Password   = 'vyrs tlwe uenm vvae';
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    
    //     $mail->Port       = 587;                              

    //     // Penerima
    //     $mail->setFrom('yonathan.santo@maka-motors.com');
    //     $mail->addAddress('yonathan.santo@maka-motors.com');

    //     // Konten email
    //     $mail->isHTML(false);  // Email dalam format teks biasa
    //     $mail->Subject = "New Pickup Request - PO: $po_number";
    //     $mail->Body    = "A new pickup request has been submitted. 
    //                     PO Number: $po_number, 
    //                     Part Name: $part_name, 
    //                     Quantity: $quantity, 
    //                     Dimensi: $dimensi_part, 
    //                     Weight: $weight, 
    //                     Pickup Address: $pickup_address, 
    //                     Destination Address: $destination_address, 
    //                     Pickup Date: $pickup_date, 
    //                     Supplier Name: $supplier_name, 
    //                     Requester Name: $requester_name, 
    //                     Import Documents: $import_documents, 
    //                     Shipping Options: $shipping_options";

    //     // Kirim email
    //     $mail->send();
    //     echo 'Message has been sent';
    // } catch (Exception $e) {
    //     echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
    // }
    require 'header.php';
    echo "<div class='success-message' style='text-align: center;'>Request Pickup Part submitted successfully!</div>";
} else {
    echo "<div class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</div>";
}

// Close connection
$conn->close();
