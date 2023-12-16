<?php
// Include database connection
include("db_connection.php");

// Fetch document data
if (isset($_GET['document_id'])) {
    $documentID = $_GET['document_id'];
    $sql = "SELECT * FROM document WHERE DocumentID = $documentID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $trackingNumber = $row['TrackingNumber'];
        $title = $row['Title'];
        $originatingOfficeID = $row['OriginatingOfficeID'];
        $destinationOfficeID = $row['DestinationOfficeID'];
        $ownerEmployeeID = $row['OwnerEmployeeID'];
    } else {
        echo "Document record not found";
    }
} else {
    echo "Document ID not provided";
}

// Fetch office names
$sqlOffices = "SELECT OfficeID, Name FROM office";
$resultOffices = $conn->query($sqlOffices);

// Fetch employee names
$sqlEmployees = "SELECT EmployeeID, Name FROM employee";
$resultEmployees = $conn->query($sqlEmployees);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $newTrackingNumber = $_POST['tracking_number'];
    $newTitle = $_POST['title'];
    $newOriginatingOfficeID = $_POST['originating_office_id'];
    $newDestinationOfficeID = $_POST['destination_office_id'];
    $newOwnerEmployeeID = $_POST['owner_employee_id'];

    // Update document data
    $sql = "UPDATE document SET TrackingNumber = '$newTrackingNumber', Title = '$newTitle', 
            OriginatingOfficeID = $newOriginatingOfficeID, DestinationOfficeID = $newDestinationOfficeID, 
            OwnerEmployeeID = $newOwnerEmployeeID WHERE DocumentID = $documentID";

    if ($conn->query($sql) === TRUE) {
        echo "Document updated successfully";
         header("Location: index.php");
    exit();
    } else {
        echo "Error updating document: " . $conn->error;
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
    <title>Update Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Update Document</h2>
        <form action="update_document.php?document_id=<?php echo $documentID; ?>" method="post">
            <div class="mb-3">
                <label for="tracking_number" class="form-label">Tracking Number:</label>
                <input type="text" class="form-control" name="tracking_number" value="<?php echo $trackingNumber; ?>" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="mb-3">
                <label for="originating_office_id" class="form-label">Originating Office:</label>
                <select class="form-select" name="originating_office_id" required>
                    <?php
                    while ($rowOffice = $resultOffices->fetch_assoc()) {
                        $selected = ($rowOffice['OfficeID'] == $originatingOfficeID) ? "selected" : "";
                        echo "<option value='" . $rowOffice['OfficeID'] . "' $selected>" . $rowOffice['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="destination_office_id" class="form-label">Destination Office:</label>
                <select class="form-select" name="destination_office_id" required>
                    <?php
                    $resultOffices->data_seek(0); // Reset result pointer to the beginning
                    while ($rowOffice = $resultOffices->fetch_assoc()) {
                        $selected = ($rowOffice['OfficeID'] == $destinationOfficeID) ? "selected" : "";
                        echo "<option value='" . $rowOffice['OfficeID'] . "' $selected>" . $rowOffice['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="owner_employee_id" class="form-label">Owner Employee:</label>
                <select class="form-select" name="owner_employee_id" required>
                    <?php
                    while ($rowEmployee = $resultEmployees->fetch_assoc()) {
                        $selected = ($rowEmployee['EmployeeID'] == $ownerEmployeeID) ? "selected" : "";
                        echo "<option value='" . $rowEmployee['EmployeeID'] . "' $selected>" . $rowEmployee['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Document</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
