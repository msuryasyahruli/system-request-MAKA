<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pickup_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM pickup_requests WHERE part_name LIKE '%" . $conn->real_escape_string($search) . "%' LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$totalResult = $conn->query("SELECT COUNT(*) as count FROM pickup_requests WHERE part_name LIKE '%" . $conn->real_escape_string($search) . "%'");
$totalRows = $totalResult->fetch_assoc()['count'];
$totalPages = ceil($totalRows / $limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pickup Requests</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php require 'header.php'; ?>

    <h1>Dashboard Pickup Requests</h1>

    <div class="container">
        <div class="filter">
            <form action="dashboard.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button">Search</button>
            </form>

            <form action="exportToExcel.php" method="POST">
                <button type="submit" class="download-button">Export to Excel</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">PO Number</th>
                        <th scope="col">Part Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Dimensions</th>
                        <th scope="col">Weight</th>
                        <th scope="col">Pickup Address</th>
                        <th scope="col">Destination Address</th>
                        <th scope="col">Supplier Name</th>
                        <th scope="col">Requester Name</th>
                        <th scope="col">Shipping Options</th>
                        <th scope="col">Request Date</th>
                        <th scope="col">Pickup Date</th>
                        <th scope="col">Documents PDF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $i++ . "</td>
                                <td>" . htmlspecialchars($row["po_number"]) . "</td>
                                <td>" . htmlspecialchars($row["part_name"]) . "</td>
                                <td>" . htmlspecialchars($row["quantity"]) . "</td>
                                <td>" . htmlspecialchars($row["dimensi_part"]) . "</td>
                                <td>" . htmlspecialchars($row["weight"]) . " kg</td>
                                <td>" . htmlspecialchars($row["pickup_address"]) . "</td>
                                <td class='clamp'>" . htmlspecialchars($row["destination_address"]) . "</td>
                                <td>" . htmlspecialchars($row["supplier_name"]) . "</td>
                                <td>" . htmlspecialchars($row["requester_name"]) . "</td>
                                <td>" . htmlspecialchars($row["shipping_options"]) . "</td>
                                <td>" . htmlspecialchars($row["request_date"]) . "</td>
                                <td>" . htmlspecialchars($row["pickup_date"]) . "</td>
                                <td>
                                    <a class='download-button' href='downloadFile.php?url=" . urlencode($row["import_documents"]) . "' aria-label='Download PDF'>
                                        Download
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No results found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php
                if ($page > 1) {
                    echo "<a href='dashboard.php?page=" . ($page - 1) . "&search=" . urlencode($search) . "' class='prev'>&laquo; Prev</a>";
                } else {
                    echo "<span class='prev disabled'>&laquo; Prev</span>";
                }

                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $page) {
                        echo "<span class='active'>$i</span>";
                    } else {
                        echo "<a href='dashboard.php?page=$i&search=" . urlencode($search) . "'>$i</a> ";
                    }
                }

                if ($page < $totalPages) {
                    echo "<a href='dashboard.php?page=" . ($page + 1) . "&search=" . urlencode($search) . "' class='next'>Next &raquo;</a>";
                } else {
                    echo "<span class='next disabled'>Next &raquo;</span>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php require 'footer.php'; ?>
</body>

</html>