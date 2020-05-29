<html>

<head>
  <title>Pagination</title>
  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
    #tintable {
      margin-top: 3rem;
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }



    #tintable td,
    tintable th {
      border: 1px solid #ddd;
      padding: 8px;
    }



    #tintable tr:nth-child(even) {
      background-color: #f2f2f2;
    }



    #tintable tr:hover {
      background-color: #ddd;
    }



    #tintable th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #4CAF50;
      color: white;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="col-md-offset-1 col-md-10">
      <table class="table" id="tintable">
        <thead>
          <tr>
            <th scope="col">Code</th>
            <th scope="col">Name</th>
            <th scope="col">Line</th>
            <th scope="col">Vendor</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
          </tr>
        </thead>
        <tbody>


          <?php
          require_once('data_access_helper.php');

          //Create an instance of data access helper
          $db = new DataAccessHelper();

          //Connect to database
          $db->connect();


          // Get page number from url
          if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
          } else {
            $pageno = 1;
          }
          // Số sản phẩm trên một trang
          $no_of_records_per_page = 12;
          // Bỏ qua các trang trước 
          $offset = ($pageno - 1) * $no_of_records_per_page;

          // Câu truy vấn đếm tất cả sản phẩm để xem có bao nhiêu trang
          $total_pages_sql = "SELECT COUNT(*) FROM products";

          // Run câu truy vấn
          $result = mysqli_query($conn, $total_pages_sql);
          $row = mysqli_fetch_row($result);
          $total_rows = (int) $row[0];

          // Đếm số trang
          $total_pages = ceil($total_rows / $no_of_records_per_page);


          //Query database
          $result = $db->executeQuery("SELECT * FROM products LIMIT $offset, $no_of_records_per_page;");




          //Display result out
          if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
              echo '<tr>';
              echo "<td>" . $row["productCode"] . "</td>";
              echo "<td>" . $row["productName"] . "</td>";
              echo "<td>" . $row["productLine"] . "</td>";
              echo "<td>" . $row["productVendor"] . "</td>";
              echo "<td>" . $row["quantityInStock"] . "</td>";
              echo "<td>" . $row["buyPrice"] . "</td>";
              echo '</tr>';
            }
          } else {
            echo "0 results";
          }

          //Close connection
          $db->close();
          ?>


        </tbody>
      </table>
    </div>
    <div class="col-md-offset-5 col-4">
      <ul class="pagination mt-5">
        <li><a href="?pageno=1">Page 1</a></li>
        <li class="<?php if ($pageno <= 1) {
                      echo 'disabled';
                    } ?>">
          <a href="<?php if ($pageno <= 1) {
                      echo '#';
                    } else {
                      echo "?pageno=" . ($pageno - 1);
                    } ?>">Prev</a>
        </li>
        <li class="<?php if ($pageno >= $total_pages) {
                      echo 'disabled';
                    } ?>">
          <a href="<?php if ($pageno >= $total_pages) {
                      echo '#';
                    } else {
                      echo "?pageno=" . ($pageno + 1);
                    } ?>">Next</a>
        </li>
        <li>
          <a href="?pageno=<?php echo $total_pages; ?>">
            <?php echo "Page" . $total_pages ?>
          </a>
        </li>
      </ul>
    </div>
  </div>


</body>

</html>
