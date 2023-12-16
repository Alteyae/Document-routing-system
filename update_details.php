    <?php
// Include database connection
include("db_connection.php");

// Fetch employee names
$sqlEmployees = "SELECT EmployeeID, Name FROM employee";
$resultEmployees = $conn->query($sqlEmployees);

// Fetch office names
$sqlOffices = "SELECT OfficeID, Name FROM office";
$resultOffices = $conn->query($sqlOffices);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employeeID = $_POST['employee_id'];
    $employeeName = $_POST['employee_name'];
    $employeeEmail = $_POST['employee_email'];
    $employeeRole = $_POST['employee_role'];
    $officeID = $_POST['office_id'];

    // Update employee details
    $updateEmployeeSQL = "UPDATE employee SET Name='$employeeName', Email='$employeeEmail', Role='$employeeRole', OfficeID=$officeID WHERE EmployeeID=$employeeID";
    $conn->query($updateEmployeeSQL);

    // Redirect to index.php after successful update
    header("Location: index.php");
    exit();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Update Employee and Office Details</h2>
        <form action="update_details.php" method="post">
            <div class="mb-3">
                <label for="employee_id" class="form-label">Select Employee:</label>
                <select class="form-select" name="employee_id" required>
                    <?php
                    while ($row = $resultEmployees->fetch_assoc()) {
                        echo "<option value='" . $row['EmployeeID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="employee_name" class="form-label">Employee Name:</label>
                <input type="text" class="form-control" name="employee_name" required>
            </div>
            <div class="mb-3">
                <label for="employee_email" class="form-label">Employee Email:</label>
                <input type="email" class="form-control" name="employee_email" required>
            </div>
            <div class="mb-3">
                <label for="employee_role" class="form-label">Employee Role:</label>
                <input type="text" class="form-control" name="employee_role" required>
            </div>
            <div class="mb-3">
                <label for="office_id" class="form-label">Select Office:</label>
                <select class="form-select" name="office_id" required>
                    <?php
                    $resultOffices->data_seek(0); // Reset result pointer to the beginning
                    while ($row = $resultOffices->fetch_assoc()) {
                        echo "<option value='" . $row['OfficeID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Details</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
