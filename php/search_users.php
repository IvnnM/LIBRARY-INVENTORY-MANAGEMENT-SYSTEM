<?php
session_start();
include './connection.php';

if (isset($_SESSION["user_id"])) {
  $user_id = $_SESSION["user_id"];

  if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Build the SQL query to search for users based on name or email
    $sql = "SELECT * FROM users WHERE role != 'Admin' AND (fullname LIKE '%$search%' OR email LIKE '%$search%' OR userID LIKE '%$search%')";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
      echo '<table class="table table-dark table-hover">';
      echo '
      <thead>
        <tr>
          <th scope="col">User ID</th>
          <th scope="col">Full Name</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
        </tr>
      </thead>';
      while ($row = $result->fetch_assoc()) {
        echo '<tbody class="table-group-divider">';
        echo "<tr>";
        echo "<td>" . $row["userID"] . "</td>";
        echo "<td>" . $row["fullname"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["role"] . "</td>";
        echo "<td><button class='btn' id='editRoleBtn' onclick='editRole(" . $row["userID"] . ", \"" . $row["email"] . "\")'><i class='fa fa-ellipsis-v' aria-hidden='true'></i></button></td>";
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
