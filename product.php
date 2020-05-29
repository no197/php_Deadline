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
    echo "code: " . $row["productCode"] . " - Name: " . $row["productName"] . "<br>";
  }
} else {
  echo "0 results";
}

//Close connection
$db->close();
