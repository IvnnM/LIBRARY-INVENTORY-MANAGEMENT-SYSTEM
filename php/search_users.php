<?php
session_start();
include './connection.php';

if (isset($_SESSION["user_id"])) {
  $user_id = $_SESSION["user_id"];

  if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Build the SQL query to search for users based on name or email
    $sql = "SELECT * FROM tbempinfo WHERE (lastname LIKE '%$search%' OR firstname LIKE '%$search%' OR department LIKE '%$search%' OR empid LIKE '%$search%')";


    $result = $con->query($sql);

    if ($result->num_rows > 0) {
      echo '<table class="table table-dark table-hover">';
      echo '
      <thead>
        <tr>
          <th scope="col">Employee ID</th>
          <th scope="col">Lastname</th>
          <th scope="col">Firstname</th>
          <th scope="col">Department</th>
        </tr>
      </thead>';
      while ($row = $result->fetch_assoc()) {
        echo '<tbody class="table-group-divider">';
        echo "<tr>";
        echo "<td>" . $row["empid"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["department"] . "</td>";
        echo "</tr>";
        echo '</tbody>';
      }
    } else {
      echo "<tr><td colspan='4'>No records found</td></tr>";
    }
  } else {
    // Handle the case where no search term is provided
    echo "<tr><td colspan='4'>Enter a search term</td></tr>";
  }
}
?>
