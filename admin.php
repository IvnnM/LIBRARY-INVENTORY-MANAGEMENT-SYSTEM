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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN PAGE</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
  <link rel="stylesheet" href="./css/admin.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./js/admin.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container-fluid" id="headerCont">

  <?php if (isset($_SESSION['user_id'])): ?>



  <div class="row">
    <div class="col">
      <h3><?= htmlspecialchars($user["fullname"]) ?></h3>
    </div>
    <div class="col-2 d-flex justify-content-end">
      <button id="logoutBtn" type="button" class="btn btn-danger" onclick="location.href='./php/logout.php'">
        <i class="fa fa-sign-out"></i> Log Out
      </button>
    </div>
  </div>





    <!--<a href="./php/logout.php">Logout</a>-->

</div>

<div class="container-fluid" id="navCont">
  <ul class="nav nav-pills">
    <li class="nav-item" >
      <a class="nav-link active" aria-current="page" id="ButtonHome" >Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" aria-current="page" id="ButtonOutStock">Out of Stocks</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" aria-current="page" id="ButtonTodayTransac">Today's Transaction</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" aria-current="page" id="ButtonLibrarianAcc">Librarian Accounts</a>
    </li>
  </ul>
</div>

<div class="container-fluid" id="Home">
  
  <div class="row align-items-start" id="colTbl">
    
    <div class="col" id="BooksListsTbl">
      <h4>Books Lists</h4>
      <div class="container-fluid overflow-y-scroll rounded bg-dark p-4" >
        <?php
          $sql = "SELECT * FROM books WHERE quantity >= 0";
          $result = $con->query($sql);
          if ($result->num_rows > 0) {
              echo '<table class="table table-dark table-hover">';
              echo "<tr><th>Book ID</th><th>Title</th><th>Description</th><th>Quantity</th></tr>";
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["bookID"] . "</td>";
                  echo "<td>" . $row["title"] . "</td>";
                  echo "<td>" . $row["description"] . "</td>";
                  $quantity = $row["quantity"];
                  echo "<td>" . ($quantity == 0 ? "Out of Stock" : $quantity) . "</td>";
              }
              echo "</table>";
          } else {
              echo "No records found";
          }
        ?>
      </div>      
    </div>
    <div class="col" id="AccountsTbl">
      <h4>Accounts</h4>
      <div class="container-fluid overflow-y-scroll rounded bg-dark p-4">
        <?php
          $sql = "SELECT * FROM users WHERE role != 'Admin'";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
              echo '<table class="table table-dark table-hover">';
              echo "<tr><th>User ID</th><th>Full Name</th><th>Email</th><th>Role</th><th>Change Role</th></tr>";
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["userID"] . "</td>";
                  echo "<td>" . $row["fullname"] . "</td>";
                  echo "<td>" . $row["email"] . "</td>";
                  echo "<td>" . $row["role"] . "</td>";
                  echo "<td><button class='btn btn-outline-danger' id='editRoleBtn' onclick='editRole(" . $row["userID"] . ", \"" . $row["email"] . "\")'>Edit</button></td>";
                  echo "</tr>";
              }
              echo "</table>";
          } else {  
              echo "No records found";
          }
        ?>
      </div>      
    </div>

  </div>

  <br>
  <h4>Transactions</h4>
  <div class="container-fluid overflow-y-scroll rounded bg-dark p-4" id="TransactionsTbl">
    <?php
      $sql = "SELECT * FROM book_transactions";
      $result = $con->query($sql);

      if ($result->num_rows > 0) {
          echo '<table class="table table-dark table-hover">';
          echo "<tr><th>Transaction ID</th><th>Librarian ID</th><th>Book ID</th><th>Transaction Type</th><th>Transaction Quantity</th><th> Timestamp</th></tr>";
          while ($row = $result->fetch_assoc()) {
            
              echo "<tr>";
              echo "<td>" . $row["transactionID"] . "</td>";
              echo "<td>" . $row["userID"] . "</td>";
              echo "<td>" . $row["bookID"] . "</td>";
              $transactionType = ($row["inQuantity"] > 0) ? "In" : "Out";
              echo "<td>" . $transactionType . "</td>";

              if ($transactionType === "In") {
                echo "<td>" . $row["inQuantity"] . "</td>";
              } else {
                echo "<td>" . $row["outQuantity"] . "</td>";
              }

              echo "<td>" . $row["date"] . "</td>";
          }
          echo "</table>";
      } else {
          echo "No records found";
      }
    ?>
  </div>

</div>

<!--OTHER TABS-->
<div class="container-fluid" id="Sort">

  <div class="my-table" id="OutStocks">
    <h4 >Out of Stocks</h4>
    <div class="container-fluid overflow-y-scroll rounded bg-dark p-4" style="border: solid black 2px; height: 50vh;">
      <?php
        $sql = "SELECT * FROM books WHERE quantity <= 0"; 
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-dark table-hover">';
            echo "<tr><th>Book ID</th><th>Title</th><th>Description</th><th>Quantity</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bookID"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                $quantity = $row["quantity"];
                echo "<td>" . ($quantity == 0 ? "Out of Stock" : $quantity) . "</td>";
            }
            echo "</table>";
        } else {
            echo "No records found";
        }
      ?>
    </div>
  </div>
  <div class="my-table" id="TodayTransactions">
    <h4 >Today's Transactions</h4>
    <div class="container-fluid overflow-y-scroll rounded bg-dark p-4" style="border: solid black 2px; height: 50vh;">
      <?php
        $today = date('Y-m-d');
        $sql = "SELECT * FROM book_transactions WHERE DATE(date) = '$today'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-dark table-hover">';
            echo "<tr><th>Transaction ID</th><th>Librarian ID</th><th>Book ID</th><th>Transaction Type</th><th>Transaction Quantity</th><th>Timestamp</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["transactionID"] . "</td>";
                echo "<td>" . $row["userID"] . "</td>";
                echo "<td>" . $row["bookID"] . "</td>";
                $transactionType = ($row["inQuantity"] > 0) ? "In" : "Out";
                echo "<td>" . $transactionType . "</td>";

                if ($transactionType === "In") {
                    echo "<td>" . $row["inQuantity"] . "</td>";
                } else {
                    echo "<td>" . $row["outQuantity"] . "</td>";
                }

                echo "<td>" . $row["date"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No records found";
        }
      ?>
    </div>
  </div>
  <div class="my-table" id="LibrarianAcc">
    <h4 >Librarian Accounts</h4>
    <div class="container-fluid overflow-y-scroll rounded bg-dark p-4" style="border: solid black 2px; height: 50vh;">
      <?php
        $sql = "SELECT * FROM users WHERE role = 'Librarian'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-dark table-hover">';
            echo "<tr><th>User ID</th><th>Full Name</th><th>Email</th><th>Role</th><th>Change Role</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["userID"] . "</td>";
                echo "<td>" . $row["fullname"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["role"] . "</td>";
                echo "<td><button class='btn btn-outline-danger' id='editRoleBtn' onclick='editRole(" . $row["userID"] . ", \"" . $row["email"] . "\")'>Edit</button></td>";
                echo "</tr>";
            }
            echo '</table>';
        } else {
            echo "No records found";
        }
      ?>
    </div>
  </div>

</div>
<?php else: ?>
  <button id="loginBtn" type="button" class="btn btn-danger" onclick="location.href='adminlogin.html'">
    <i class="fa fa-lock"></i> Login
  </button>
<?php endif; ?>

<script>
    function refreshPage() {
      location.reload();
    }

    $(document).ready(function () {
        $("#ButtonHome").click(function () {
          refreshPage();
          $(".nav-link").removeClass("active");
          $(this).addClass("active");
        });
        $("#ButtonOutStock").click(function () {
          $("#OutStocks").show();
          $("#Home").hide();
          $("#TodayTransactions").hide();
          $("#LibrarianAcc").hide();

          $(".nav-link").removeClass("active");
          $(this).addClass("active");
        });
        $("#ButtonTodayTransac").click(function () {
          $("#TodayTransactions").show();
          $("#Home").hide();
          $("#LibrarianAcc").hide();
          $("#OutStocks").hide();

          $(".nav-link").removeClass("active");
          $(this).addClass("active");
        });
        $("#ButtonLibrarianAcc").click(function () {
          $("#LibrarianAcc").show();
          $("#Home").hide();
          $("#TodayTransactions").hide();
          $("#OutStocks").hide();

          $(".nav-link").removeClass("active");
          $(this).addClass("active");
        });
    });
  </script>

</body>
</html>