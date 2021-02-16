<?php
// define how many results you want per page
$results_per_page = 3;
// determine which page number visitor is currently on
if (!isset($_GET['page']) && !isset($_GET['category'])) {
    $currentpage = 1;
    $page = 1;
    $category = "hot";
  } else {
    $currentpage =  $_GET['page'];
    $page = $_GET['page'];
    $category = $_GET['category'];
}
// find out the number of results stored in database
$sql="SELECT * FROM blogs where category='$category'";
$result = $conn->query( $sql);
$number_of_results =$result->num_rows;

// determine number of total pages available
$number_of_pages = ceil($number_of_results/$results_per_page);


// determine the sql LIMIT starting number for the results on the displaying page
$this_page_first_result = ($page-1)*$results_per_page;

// retrieve selected results from database and display them on page
$query="SELECT * FROM blogs where category='$category' LIMIT  $this_page_first_result,$results_per_page";
$result = $conn->query($query);

// while($row = $result->fetch_assoc()) {
//   echo $row['id'] . ' ' . $row['blogs']. '<br>';
// }

// // display the links to the pages
// for ($page=1;$page<=$number_of_pages;$page++) {
//   echo '<a href="index.php?page=' . $page . '">' . $page . '</a> ';
// }

?>