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
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 100vw;
            flex: 1;
        }

        .filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
        }

        .search-form {
            display: flex;
            align-items: center;
        }

        .search-input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 8px;
            font-size: 14px;
        }

        .search-button {
            background-color: #007BFF;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-button:hover {
            background-color: #0056b3;
        }

        .table-container {
            width: 100%;
            margin-bottom: 32px;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            max-width: 1200px;
            background-color: white;
        }

        th,
        td {
            padding: 12px 16px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        td.clamp {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        th {
            background-color: #21D1FA;
            font-weight: bold;
            text-align: center;
        }

        .download-button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .download-button:hover {
            background-color: #45a049;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #f1f1f1;
            color: #333;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .active {
            background-color: #007bff;
            color: white;
        }

        .pagination .disabled {
            background-color: #ddd;
            color: #666;
        }

        .pagination .prev,
        .pagination .next {
            font-weight: bold;
        }

        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            th,
            td {
                font-size: 12px;
                padding: 8px;
            }

            .download-button {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
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