<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pickup_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all data from pickup_request table
$sql = "SELECT * FROM pickup_requests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Tentukan nama file dan header untuk download
    $filename = "pickup_requests_" . date('Ymd') . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    // Buat pointer file untuk output CSV
    $output = fopen('php://output', 'w');

    // Tulis header kolom ke file CSV
    fputcsv($output, array('PO Number', 'Part Name', 'Quantity', 'Dimensions', 'Weight Per Unit', 'Pickup Address', 'Destination Address', 'Supplier Name', 'Requester Name', 'Shipping Options', 'Request Date', 'Pickup Date'));

    // Tulis data baris dari database ke file CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array(
            $row["po_number"],
            $row["part_name"],
            $row["quantity"],
            $row["dimensi_part"],
            $row["weight"] . ' kg',
            $row["pickup_address"],
            $row["destination_address"],
            $row["supplier_name"],
            $row["requester_name"],
            $row["shipping_options"],
            $row["request_date"],
            $row["pickup_date"],
        ));
    }

    fclose($output); // Tutup file pointer
} else {
    echo "No data available";
}

$conn->close();
?>
