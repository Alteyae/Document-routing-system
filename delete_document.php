<?php
// Include database connection
include("db_connection.php");

// Check if document_id is set
if (isset($_GET['document_id'])) {
    $documentID = $_GET['document_id'];

    // Fetch document details for confirmation alert
    $sqlDocument = "SELECT * FROM document WHERE DocumentID = $documentID";
    $resultDocument = $conn->query($sqlDocument);

    if ($resultDocument->num_rows > 0) {
        $documentDetails = $resultDocument->fetch_assoc();
        $trackingNumber = $documentDetails['TrackingNumber'];
    }

    // Check if form is submitted (after confirmation)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
        // Delete document from the document table
        $deleteDocumentSQL = "DELETE FROM document WHERE DocumentID = $documentID";
        $result = $conn->query($deleteDocumentSQL);

        if ($result === TRUE) {
            echo "<script>alert('Document deleted successfully!');</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "Error deleting document: " . $conn->error;
        }
    }
} else {
    // If document_id is not set, redirect to index.php
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Delete Document</h2>

        <!-- Display confirmation alert -->
        <div class="alert alert-danger" role="alert">
            Are you sure you want to delete the document with Tracking Number: <?php echo $trackingNumber; ?>?
        </div>

        <!-- Delete confirmation form -->
        <form action="delete_document.php?document_id=<?php echo $documentID; ?>" method="post">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
