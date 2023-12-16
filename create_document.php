<?php
// Include database connection
include("db_connection.php");

// Fetch office names
$sqlOffices = "SELECT OfficeID, Name FROM office";
$resultOffices = $conn->query($sqlOffices);

// Fetch employee names
$sqlEmployees = "SELECT EmployeeID, Name FROM employee";
$resultEmployees = $conn->query($sqlEmployees);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $originatingOfficeID = $_POST['originating_office_id'];
    $destinationOfficeID = $_POST['destination_office_id'];
    $ownerEmployeeID = $_POST['owner_employee_id'];

    // Generate a unique tracking number
    $trackingNumber = "DOC" . uniqid();

    // Insert data into the document table
    $sql = "INSERT INTO document (TrackingNumber, Title, OriginatingOfficeID, DestinationOfficeID, OwnerEmployeeID) 
            VALUES ('$trackingNumber', '$title', $originatingOfficeID, $destinationOfficeID, $ownerEmployeeID)";

    if ($conn->query($sql) === TRUE) {
        echo "Document created successfully";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Create Document</h2>
        <form action="create_document.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="originating_office_id" class="form-label">Originating Office:</label>
                <select class="form-select" name="originating_office_id" required>
                    <?php
                    while ($row = $resultOffices->fetch_assoc()) {
                        echo "<option value='" . $row['OfficeID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="destination_office_id" class="form-label">Destination Office:</label>
                <select class="form-select" name="destination_office_id" required>
                    <?php
                    $resultOffices->data_seek(0); // Reset result pointer to the beginning
                    while ($row = $resultOffices->fetch_assoc()) {
                        echo "<option value='" . $row['OfficeID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="owner_employee_id" class="form-label">Owner Employee:</label>
                <select class="form-select" name="owner_employee_id" required>
                    <?php
                    while ($row = $resultEmployees->fetch_assoc()) {
                        echo "<option value='" . $row['EmployeeID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Document</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
