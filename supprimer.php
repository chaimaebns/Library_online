<?php
// Check if the 'delete' key exists in the $_POST array
if (isset($_POST['delete'])) {
    // Define your database connection parameters
    $servername = "localhost";
    $username = "your_actual_username"; // Replace with your actual username
    $password = "your_actual_password"; // Replace with your actual password
    $dbname = "database_name"; // Replace with your actual database name

    // Create a connection using mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Your code to delete a record goes here
    // Example: Deleting a record from the database
    $id = $_POST['delete']; // Replace with the actual ID to delete
    $sql = "DELETE FROM your_table WHERE id = $id"; // Replace 'your_table' with your actual table name

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "No delete key found in the request.";
}
?>
