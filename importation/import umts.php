<!DOCTYPE html>
<html>
<head>
<title>import csv</title>
</head>

<body>
<form  method="post" enctype="multipart/form-data">
    <label for="csv_file">Select CSV file to import:</label>
    <input type="file" id="csv_file" name="csv_file" accept=".csv">
    <br>
    <input type="submit" name="import_csv" value="Import CSV">
</form>

<?php
// Check if the form has been submitted
if (isset($_POST['import_csv'])) {
    
    // Get the file name and temporary file location
    $csv_file = $_FILES['csv_file']['name'];
    $tmp_file = $_FILES['csv_file']['tmp_name'];
    
    // Check if a file was selected
    if (empty($csv_file)) {
        die("Please select a CSV file to import.");
    }
    
    // Open the CSV file for reading
    $handle = fopen($tmp_file, "r");
    
    // Check if the CSV file could be opened
    if (!$handle) {
        die("Could not open the CSV file.");
    }
    
    // Connect to the MySQL database
    $conn = mysqli_connect("localhost","root","","pfe");
    if (!$conn) {
        die("Could not connect to the MySQL database: " . mysqli_connect_error());
    }
    
    // Loop through the CSV file line by line
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        
        // Escape special characters in the data
        $data = array_map(function($value) use ($conn) {
            return mysqli_real_escape_string($conn, $value);
        }, $data);
        
        // Build the SQL query to insert the data into the table
        $query = "INSERT INTO 3g_u2020 (NE_Name, NodeB_ID, NodeB_Name, Cell_ID, Cell_Name, RNC_Connection_Status, Activity_Status, BLK_Status, LAC, SAC, RAC, Ul_Freq, Dl_Freq, Max_Power, CELLCBSSTATE, CELLMBMSSTATE, HSDPA_OpState, HSUPA_OpState)
         VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]','$data[9]', '$data[10]', '$data[11]', '$data[12]', '$data[13]', '$data[14]', '$data[15]', '$data[16]', '$data[17]')";
        
        // Execute the query
        $result = mysqli_query($conn, $query);
        
        // Check if the query was executed successfully
        if (!$result) {
            die("Error executing the query: " . mysqli_error($conn));
        }
    }
    
    // Close the CSV file and the MySQL connection
    fclose($handle);
    mysqli_close($conn);
    
    // Display a success message
    echo "CSV file has been imported successfully.";
}
?>
</body>
</html>
