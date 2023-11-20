<?php

session_start();
include './connection.php';


if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM books WHERE quantity >= 0 AND (bookID LIKE '%$search%' OR title LIKE '%$search%' OR ISBN LIKE '$search%')";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="table table-dark table-hover">';
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
            echo '</tbody>';
        }
    } else {
        echo "<tr><td colspan='4'>No records found</td></tr>";
    }
} else {
    echo "<tr><td colspan='4'>Enter a search term</td></tr>";
}
?>
