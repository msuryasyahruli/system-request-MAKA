<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Pickup Part Import</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 380px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 0 0 32px 0;
        }

        label {
            font-weight: bold;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin: 4px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .dimension {
            display: flex;
            gap: 8px;
        }
    </style>
</head>

<body>
    <?php require 'header.php' ?>
    <h1>Request Pickup Part Import</h1>
    <div>
        <form action="request_pickup.php" method="POST" enctype="multipart/form-data">
            <!-- <label for="po_number">PO Number:</label><br>
             <input type="text" id="po_number" name="po_number" required class="form-input"><br><br> -->

            <label for="part_name">Part name:</label>
            <input type="text" id="part_name" name="part_name" required class="form-input" placeholder="Enter a part name"><br>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required class="form-input" placeholder="Enter amount"><br>

            <label for="dimensi_part">Dimension (Length, Width, Height)</label>
            <div class="dimension">
                <input type="number" id="dimensi_part" name="length" required class="form-input" placeholder="Length">
                <p>/</p>
                <input type="number" id="dimensi_part" name="width" required class="form-input" placeholder="Width">
                <p>/</p>
                <input type="number" id="dimensi_part" name="height" required class="form-input" placeholder="Height">
            </div>

            <label for="weight">Weight:</label>
            <input type="number" id="weight" name="weight" required class="form-input" placeholder="Enter weight"><br>

            <label for="pickup_address">Pickup address:</label>
            <input type="text" id="pickup_address" name="pickup_address" required class="form-input" placeholder="Enter address"><br>

            <label for="destination_address">Destination address:</label>
            <select id="destination_address" name="destination_address" required class="form-input">
                <option value="">Choose</option>
                <option value="Jl. TB Simatupang Blok Delima No.10, RT.3/RW.8, Gedong, Pasar Rebo, East Jakarta City, Jakarta 13760">RnD</option>
                <option value="MAKA-MOTORS KITIC FACTORY( Kawasan Industri Terpadu Indonesia China - KITIC ), Jl. Kawasan Industri Terpadu Indonesia China Kav 19-1, Desa Nagasari, Kec Serang Baru, Kab. Bekasi West Java 17330">Warehouse Manufacture</option>
            </select><br>

            <label for="pickup_date">Pickup date:</label>
            <input type="date" id="pickup_date" name="pickup_date" required class="form-input"><br>

            <label for="supplier_name">Supplier name:</label>
            <input type="text" id="supplier_name" name="supplier_name" required class="form-input" placeholder="Enter supplier name"><br>

            <label for="requester_nasme">Requester name:</label>
            <input type="text" id="requester_name" name="requester_name" required class="form-input" placeholder="Enter requester name"><br>

            <label for="import_documents">Dokument import (Packing List, Comercial invoice):</label>
            <input type="file" id="import_documents" name="import_documents" accept="application/pdf" required class="form-input"><br>

            <label for="shipping_options">Options:</label>
            <select id="shipping_options" name="shipping_options" required class="form-input">
                <option value="">Choose</option>
                <option value="Ocean">Ocean</option>
                <option value="Air">Air</option>
            </select><br>

            <input type="submit" value="Submit Request">
        </form>
    </div>
</body>

</html>