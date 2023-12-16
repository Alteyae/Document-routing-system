<?php
// Include database connection
include("db_connection.php");

// Initialize variables
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // SQL query to retrieve documents based on the tracking number
    $sql = "SELECT document.*, termination.TerminationReason 
            FROM document 
            LEFT JOIN termination ON document.DocumentID = termination.DocumentID
            WHERE document.TrackingNumber LIKE '%$search%'";
} else {
    // Default query to retrieve all documents
    $sql = "SELECT document.*, termination.TerminationReason 
            FROM document 
            LEFT JOIN termination ON document.DocumentID = termination.DocumentID";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Routing System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    <div class="container mt-4">
      
        <a href="create_user.php" class="btn btn-outline-dark">Create User</a>
        <a href="create_office.php" class="btn btn-outline-dark">Create Office</a>
        <a href="update_details.php" class="btn btn-outline-info">Update User Info</a>
        <h2>Document List</h2>
        
        <!-- Search form -->
        <form action="index.php" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Tracking Number" value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <!-- Create document link -->
        <a href="create_document.php" class="btn btn-success mb-3">Create Document</a>
        
        <!-- Create user link -->
       
        <!-- Display documents -->
     <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card mb-3'>";
        echo "<div class='card-body'>";
        
        // Display additional information
        echo "<strong>Title:</strong> " . $row['Title'] . "<br>";
        echo "<strong>Document ID:</strong> " . $row['DocumentID'] . "<br>";
        echo "<strong>Tracking Number:</strong> " . $row['TrackingNumber'] . "<br>";
        
        // Display termination status
        echo "<strong>Status:</strong> " . ($row['TerminationReason'] ? $row['TerminationReason'] : "No Status Found") . "<br>";
        
        // Add link to update termination status
        echo "<a href='update_termination_status.php?document_id=" . $row['DocumentID'] . "' class='btn btn-info me-2'>Update Status</a>";
        
        // Add some space between buttons
        echo "&nbsp;";
        
        // Add link to edit document
        echo "<a href='update_document.php?document_id=" . $row['DocumentID'] . "' class='btn btn-warning me-2'>Edit</a>";
        
        // Add link to delete document
        echo "<a href='delete_document.php?document_id=" . $row['DocumentID'] . "' class='btn btn-danger'>Delete</a>";
        
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No documents found";
}
?>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
