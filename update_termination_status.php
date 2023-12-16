<?php
// Include database connection
include("db_connection.php");

// Fetch termination data
if (isset($_GET['document_id'])) {
    $documentID = $_GET['document_id'];
    $sql = "SELECT * FROM termination WHERE DocumentID = $documentID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $terminationID = $row['TerminationID'];
        $terminationDate = $row['TerminationDate'];
        $terminationReason = ($terminationDate) ? $row['TerminationReason'] : "STATUS NOT YET UPDATED";
    } else {
        // Termination record not found, create a new termination record
        createTerminationRecord($conn, $documentID); // Pass the DocumentID
        $terminationReason = "STATUS NOT YET UPDATED";
    }
} else {
    echo "Document ID not provided";
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $newStatus = $_POST['new_status'];

    // Update termination status
    updateTerminationStatus($conn, $terminationID, $newStatus);

    // Redirect back to index.php
    header("Location: index.php");
    exit();
}

// Close database connection
$conn->close();

// Function to update termination status
function updateTerminationStatus($conn, $terminationID, $newStatus) {
    $sql = "UPDATE termination SET TerminationReason = '$newStatus' WHERE TerminationID = $terminationID";

    if ($conn->query($sql) !== TRUE) {
        echo "Error updating termination status: " . $conn->error;
    }
}

// Function to create a new termination record
function createTerminationRecord($conn, $documentID) {
    // You may need to adjust this query based on your specific requirements
    $sql = "INSERT INTO termination (DocumentID, TerminationDate, TerminationReason) VALUES ($documentID, NOW(), 'Pending')";
    
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating termination record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Termination Status</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Update Termination Status</h2>
        <form action="update_termination_status.php?document_id=<?php echo $documentID; ?>" method="post">
            <div class="mb-3">
                <label for="document_id" class="form-label">Document ID:</label>
                <input type="text" class="form-control" value="<?php echo $documentID; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="termination_date" class="form-label">Termination Date:</label>
                <input type="text" class="form-control" value="<?php echo isset($terminationDate) ? $terminationDate : ''; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="termination_reason" class="form-label">Current Termination Status:</label>
                <!-- Make the status field a dropdown -->
                <select class="form-select" name="new_status" required>
                    <option value="Received" <?php echo ($terminationReason == 'Received') ? 'selected' : ''; ?>>Received</option>
                    <option value="Decline" <?php echo ($terminationReason == 'Decline') ? 'selected' : ''; ?>>Decline</option>
                    <option value="Pending" <?php echo ($terminationReason == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Termination Status</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
