<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sub Categories</title>
  <link rel="stylesheet" href="styles.css">
  <script src="validation.js"></script>
  <?php
  include 'Header.php';
  ?>
</head>

<body class="bg-dark">
  <div class="container-fluid bgcolor mt-5 mb-5" style="padding:20px;">
    <div class="row mt-3 mb-3">
      <h2 class="col-md-3" style="color:white">Sub Categories</h2>
      <div class="col-md-5"></div>
      <div class="col-md-3" style="text-align:right;padding-right:25px;"> <!-- form for search Start -->
        <form method="get"><input type="text" name="search" class="form-control" placeholder="Search here...">&nbsp;
      </div>
      <div class="col-md-1"><button class="btn btn-dark"><i class="fa fa-search "></i></button></div>
      </form>
      <!-- form for search End -->
    </div>
    <div class="row mt-5">
      <?php
      $c_id = isset($_GET['Id']) ? $_GET['Id'] : '';

      $search = isset($_GET['search']) ? $_GET['search'] : '';
      $search_query = '';
      if (!empty($search)) {
        $search_query = "AND (s.SC_Id LIKE '%$search%' OR s.SC_Name LIKE '%$search%' OR c.C_Name LIKE '%$search%')";
      }

      // Determine the total number of records
      $q = "SELECT s.*,c.C_Name FROM subcategory_tbl s JOIN category_tbl c ON s.C_Id=c.C_Id  where s.C_Id=$c_id AND s.SC_Status='Active' $search_query";
      $result = mysqli_query($con, $q);
      $total_records = mysqli_num_rows($result);

      $records_per_page = 2;
      $total_pages = ceil($total_records / $records_per_page);

      // Get the current page number
      $page = isset($_GET['page']) ? $_GET['page'] : 1;

      $start_from = ($page - 1) * $records_per_page;

      $q = $q . " LIMIT $start_from, $records_per_page";
      $result = mysqli_query($con, $q);

      while ($r = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 cat-block">
          <div class="card">
            <a href="Products.php?Id=<?php echo $r['SC_Id'] ?>" class="card">
              <img src="db_img/subCat_img/<?php echo $r['SC_Img'] ?>" class="card__image"
                alt="<?php echo $r['SC_Name']; ?>" />
              <div class="card__overlay">
                <!-- <div class="card__header">
                  <div class="card__header-text">
                    <h3 class="card__title"><?php echo $r['SC_Name'] ?></h3>
                    <span class="card__status">Rs. <?php echo $r['P_Price'] ?></span>
                  </div>
                </div> -->
                <p class="card__description"><?php echo $r['SC_Name'] ?></p>
              </div>
            </a>
          </div>
        </div>
        <!-- <div class="col-lg-3 col-md-4 col-sm-6 mb-4 cat-block">
          <a href="Products.php?Id=<?php echo $r['SC_Id'] ?>"><img src="db_img/subCat_img/<?php echo $r['SC_Img']; ?>"
              alt="Product Image" class="cat-image">
            <div class="overlay">
              <div class="text"><?php echo $r['SC_Name'] ?></div>
            </div>
          </a>
        </div> -->
        <?php
      }
      ?>
    </div>
    <!--pagination Start  -->
    <nav>
      <ul class="pagination">
        <?php
        if ($page > 1) {
          echo "<li class='page-item'><a class='page-link btn-dark' href='?page=" . ($page - 1) . "&search=" . $search . "'><i class='fa fa-chevron-left'></i></a></li>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
          echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='?page=" . $i . "&search=" . $search . "'>" . $i . "</a></li>";
        }
        if ($page < $total_pages) {
          echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "&search=" . $search . "'><i class='fa fa-chevron-right'></i></a></li>";
        }
        ?>
      </ul>
    </nav>
    <!--pagination End  -->
  </div>
  <?php
  include "Footer.php";
  ?>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>