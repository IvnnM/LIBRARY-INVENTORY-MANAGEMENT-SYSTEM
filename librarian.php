<?php
session_start();
include './php/connection.php';

if (isset($_SESSION["user_id"])) {
  $sql = "SELECT e.lastname, e.firstname FROM tb_librarian l
          INNER JOIN tbempinfo e ON l.empid = e.empid
          WHERE l.librarianID = {$_SESSION["user_id"]}";

  $result = $con->query($sql);

  if ($result) {
      $user = $result->fetch_assoc();

      // Now $user["lastname"] and $user["firstname"] contain the librarian's name.
  }
}

$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LIBRARIAN PAGE</title>
  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <!--Sweetalert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!--Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
  <link rel="stylesheet" href="./css/librarian.css">
  <script src="./js/librarian.js"></script>


</head>
<body>

  <div class="container-fluid">
      <div class="row" >
        <div class="col-md-1 col-lg-1 d-md-block d-flex align-items-center" style="padding: 10px;">
          <h1 class="text-center"><span class="fa fa-id-card fa-2x"></span></h1>
        </div>
        <div class="col-md-11 col-lg-11 d-md-block rounded-top" style="background-color: #eff2e3;">
          <h5 style="margin:0;">Inventory</h5>
          <div class="Login">
              <?php if (isset($_SESSION['user_id'])): ?>
          </div>
          <span style="font-size: small;">Today is <?php echo $today; ?></span>  
          <div>
            <h2>Hi, <span><?= htmlspecialchars($user["firstname"] . " " . $user["lastname"]) ?></span></h2>

            <p>Welcome to the Librarian Page! Manage book inventory, track ins and outs, and view current stocks.</p>
          </div>
          
        </div>
      </div>
  </div>
  <div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-1 col-lg-1 d-md-block sidebar" style="background-color: white; padding:0;">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item1 text-center">
                        <a class="nav-link sidebar active" id="ButtonHome" data-bs-toggle="tooltip" data-bs-placement="right" title="Books">
                          <i class="fa fa-th-large icon-size"></i>
                        </a>
                    </li>
                    <li class="nav-item1 text-center">
                        <a class="nav-link sidebar" id="ButtonTodayTransac" data-bs-toggle="tooltip" data-bs-placement="right" title="Today's Transaction">
                          <i class="fa fa-history icon-size"></i>
                        </a>
                    </li>
                    <li class="nav-item1 text-center">
                        <a class="nav-link sidebar" href="./php/logout.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Log out">
                          <i class="fa fa-sign-out icon-size"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-11 ms-sm-auto  col-lg-11 overflow-y-scroll p-4">
            
            <div class="container-fluid table" id="Inventory" style="padding: 0;">
              <h5>Books</h5>
                <div class="d-flex justify-content-between">
                    <form class="d-flex" role="bookSearch">
                        <input class="form-control search" type="text" id="bookSearchInput" placeholder="Search by id, title or ISBN" aria-label="Search" style="margin-bottom: 10px; width:600px;">
                    </form>

                    <div class="d-flex" >
                    <select class="form-select author" id="authorDropdown" aria-label="Sort by Author">
                     <option value="All Authors">All Authors</option>
                      <?php
                        $sql = "SELECT DISTINCT author FROM books";
                        $result = $con->query($sql);

                        while ($row = $result->fetch_assoc()) {
                          echo "<option value='" . $row['author'] . "'>" . $row['author'] . "</option>";
                        }
                      ?>
                    </select>
                    <select class="form-select genre" id="genreDropdown" aria-label="Sort by Genre">
                      <option value="All Genres">All Genres</option>
                      <?php
                        $sql = "SELECT DISTINCT genre FROM books";
                        $result = $con->query($sql);

                        while ($row = $result->fetch_assoc()) {
                          echo "<option value='" . $row['genre'] . "'>" . $row['genre'] . "</option>";
                        }
                      ?>
                    </select>
                    <select class="form-select" id="sortSelect" aria-label="Sort by Transaction Type" style="margin-bottom: 10px; width:250px;">
                        <option value="all" selected>All Books</option>
                        <option value="Out of Stock">Out of Stock</option>
                        <option value="Today's New Release">New Release Books</option>
                    </select> 
                  </div>
                </div>

                <div class="container-fluid overflow-y-scroll rounded bg-dark p-4">
                    <?php
                    $sql = "SELECT * FROM books";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='table table-dark table-hover' id='bookTable'>";
                        echo '
                        <thead>
                            <tr>
                                <th scope="col">Book ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Genre</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Description</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Publication Date</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<tbody class="table-group-divider">';
                            echo "<tr>";
                            echo "<td>" . $row["bookID"] . "</td>";
                            echo "<td>" . $row["title"] . "</td>";
                            echo "<td>" . $row["author"] . "</td>";
                            echo "<td>" . $row["genre"] . "</td>";
                            echo "<td>" . $row["ISBN"] . "</td>";
                            echo "<td><div class='overflow-auto description' style='max-height: 100px;'>" . $row["description"] . "</div></td>";
                            $quantity = $row["quantity"];
                            echo "<td>" . ($quantity == 0 ? "Out of Stock" : $quantity) . "</td>";
                            echo "<td>" . $row["publication_date"]. "</td>";
                            echo "<td><button class='btn btn-outline-success' id='addBtn' onclick='handleInventory(\"IN\", {$row["bookID"]})'>IN</button></td>";
                        
                            if ($quantity == 0) {
                                echo "<td><button class='btn btn-outline-danger' onclick='handleInventory(\"OUT\", {$row["bookID"]})' disabled>OUT</button></td>";
                            } else {
                                echo "<td><button class='btn btn-outline-danger' id='subtractBtn' onclick='handleInventory(\"OUT\", {$row["bookID"]})'>OUT</button></td>";
                            }
                            echo "</tr>";
                            echo '</tbody>';
                        }
                        echo "</table>";
                    } else {
                        echo "No records found";
                        
                    }
                    ?>
                </div>
            </div>
            <div class="container-fluid table" id="TodayTransactions" style="padding: 0; display: none;">
                <h5>Today's Transaction History</h5>
                <div class="container-fluid overflow-y-scroll rounded bg-dark p-4" style="height: 300px;">
                    <?php
                    $today = date('Y-m-d');
                    $sql = "SELECT * FROM book_transactions WHERE DATE(date) = '$today'";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<table class="table table-dark table-hover">';
                        echo '
                        <thead>
                        <tr>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Librarian ID</th>
                            <th scope="col">Book ID</th>
                            <th scope="col">Transaction Type</th>
                            <th scope="col">Transaction Quantity</th>
                            <th scope="col">Timestamp</th>
                        </tr>
                        </thead>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<tbody class="table-group-divider">';
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
                            echo '</tbody>';
                        }
                        echo "</table>";
                    } else {
                        echo "No records found";
                    }
                    ?>
                </div>
            </div>

        </main>
    </div>  
  </div>
<?php else: ?>
  <button id="loginBtn" type="button" class="btn btn-danger" onclick="location.href='librarianlogin.html'">
    <i class="fa fa-lock"></i> Login
  </button>
<?php endif; ?>  

<script>
  $(document).ready(function() {
    $('#sortSelect').change(function() {
      var selectedOption = $(this).val();
      var table = $('#bookTable');

      if (selectedOption === "Out of Stock") {
        table.find('tbody tr:not(:has(td:contains("Out of Stock")))').hide();
        table.find('tbody tr:has(td:contains("Out of Stock"))').show();
      } else if (selectedOption === "Today's New Release") {
        // Hide rows where the publication date is not today
        table.find('tbody tr:not(:contains("' + '<?php echo $today; ?>' + '"))').hide();
        // Show rows where the publication date is today
        table.find('tbody tr:contains("' + '<?php echo $today; ?>' + '")').show();
      } else {
        table.find('tbody tr').show();
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    var originalAuthorOptions = $('#authorDropdown option').clone();

    var defaultGenreValue = $('#genreDropdown').val();

    $('#authorDropdown').change(function() {
        var selectedAuthor = $(this).val();
        var table = $('#bookTable');

        // Reset the genre dropdown to its default value
        $('#genreDropdown').val(defaultGenreValue);

        if (selectedAuthor !== "All Authors") {
            table.find('tbody tr:not(:contains("' + selectedAuthor + '"))').hide();
            table.find('tbody tr:contains("' + selectedAuthor + '")').show();
        } else {
            table.find('tbody tr').show();
        }
    });

    $('#genreDropdown').change(function() {
        var selectedGenre = $(this).val();
        var table = $('#bookTable');

        // Reset the author dropdown to its default value
        $('#authorDropdown').empty().append(originalAuthorOptions);

        if (selectedGenre !== "All Genres") {
            table.find('tbody tr:not(:contains("' + selectedGenre + '"))').hide();
            table.find('tbody tr:contains("' + selectedGenre + '")').show();
        } else {
            table.find('tbody tr').show();
        }
    });
  });
</script>

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
      $("#ButtonTodayTransac").click(function () {
        $("#TodayTransactions").show();
        $("#Inventory").hide();

        $(".nav-link").removeClass("active");
        $(this).addClass("active");
      });
  });
</script>
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
</body>
</html>