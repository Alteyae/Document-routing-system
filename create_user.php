<?php
// Include database connection
include("db_connection.php");

// Fetch office names
$sqlOffices = "SELECT OfficeID, Name FROM office";
$resultOffices = $conn->query($sqlOffices);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $officeID = $_POST['office_id'];

    // Insert data into the employee table
    $sql = "INSERT INTO employee (Name, Email, Role, OfficeID) 
            VALUES ('$name', '$email', '$role', $officeID)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User created successfully!');</script>";
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
    <title>Create User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Create User</h2>
        <form action="create_user.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <input type="text" class="form-control" name="role" required>
            </div>
            <div class="mb-3">
                <label for="office_id" class="form-label">Office:</label>
                <select class="form-select" name="office_id" required>
                    <?php
                    while ($row = $resultOffices->fetch_assoc()) {
                        echo "<option value='" . $row['OfficeID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
