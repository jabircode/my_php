<?php
session_start();

if (isset($_POST['Submit'])) {
    try {
        // Database initialization code
        $db = new PDO('mysql:host=localhost;dbname=DATABASE_NAME', 'USERNAME', 'PASSWORD');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL query with placeholders to prevent SQL injection
        $sql = "SELECT btrain_id, from_to, pax, utilization FROM train_usage WHERE pax >= :min_pax AND utilization > :min_utilization";
        $stmt = $db->prepare($sql);
        
        // Bind the parameters
        $min_pax = 1200;
        $min_utilization = 90;
        $stmt->bindParam(':min_pax', $min_pax, PDO::PARAM_INT);
        $stmt->bindParam(':min_utilization', $min_utilization, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Display the results
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Bullet train ID = " . $row['btrain_id'] . "<br>";
            echo "From/To = " . $row['from_to'] . "<br>";
            echo "Max passengers (pax) = " . $row['pax'] . "<br>";
            echo "Utilization = " . $row['utilization'] . "<br><br>";
        }

        $db = null;

        echo('<a href="index.php">Go back to search page</a>');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
?>
<!-- Your search form here -->
<form method="POST" action="#">
  20035729 Jabir Jamil
  <br><br>
  Search trains:
  <br><br>
  Max passengers (pax) greater than or equals: <input type="text" name="max_pax">
  <br><br>
  Utilization more than: <input type="text" name="utilization"> %
  <br><br>
  <input type="submit" name="Submit" value="Submit">
</form>
<?php
}
?>
