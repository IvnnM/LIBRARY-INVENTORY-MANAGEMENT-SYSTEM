<?php
  session_start();
  include './php/connection.php';
  if (isset($_SESSION["user_id"])){

    $sql = "SELECT * FROM users
    WHERE userID = {$_SESSION["user_id"]}";

    $result = $con->query($sql);
    $user = $result->fetch_assoc();
  }

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CLIENT PAGE</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <!--<link rel="stylesheet" href="">-->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./js/client.js"></script>
</head>
<body>

  <div class="containerfluid">
  <h1>CLIENT FORM</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
      <p> Welcome <?= htmlspecialchars($user["fullname"]) ?></p>
      <a href="./php/logout.php">Logout</a>

      <div class="containerfluid" id="AllBooks">
        <h1 style="text-align: right;">Available Books</h1>
        <?php
          $sql = "SELECT * FROM books WHERE quantity > 0";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
              echo "<table>";
              echo "<tr><th>Book ID</th><th>Title</th><th>Description</th><th>Quantity</th></tr>";
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["bookID"] . "</td>";
                  echo "<td>" . $row["title"] . "</td>";
                  echo "<td>" . $row["description"] . "</td>";
                  echo "<td>" . $row["quantity"] . "</td>";
              }
              echo "</table>";
          } else {
              echo "No records found";
          }
        ?>
      </div>

    <?php else: ?>
      <a href="clientlogin.html">Log In Account</a>
    <?php endif; ?>

  </div>
  


</body>
</html>