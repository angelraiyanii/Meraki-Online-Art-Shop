<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="styles.css">
  <script src="validation.js"></script>
  <style>
    .art-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }

    .art-item {
      border: 1px solid #ddd;
      padding: 20px;
      text-align: center;
    }
  </style>
  <?php
  include 'Header.php';
  if (isset($_SESSION['U_Admin']) || isset($_SESSION['U_User'])) {
    // header("Location: Login.php");
    // exit();
    $Email_Session = isset($_SESSION['U_User']) ? $_SESSION['U_User'] : $_SESSION['U_Admin'];
  }
  //$id = $_GET['Id'];
  ?>
</head>

<body class="bg-dark">
  <div class="container-fluid mt-5 mb-5 bgcolor" style="padding:20px;">
    <!-- Similar Products Section -->
    <div class="row mt-3 mb-3">
      <h2 class="col-md-3" style="color:white">Products</h2>
      <div class="col-md-5"></div>
      <div class="col-md-3" style="text-align:right;padding-right:25px;">
        <!-- form for search Start -->
        <form method="get"><input type="text" name="search" class="form-control" placeholder="Search here...">&nbsp;
      </div>
      <div class="col-md-1"><button class="btn btn-dark"><i class="fa fa-search "></i></button></div>
      </form>
      <!-- form for search End -->
    </div>
    <div class="row mt-5">
      <!-- Add more blocks as needed -->
      <div class="art-grid">
        <?php
        $sc_id = isset($_GET['Id']) ? $_GET['Id'] : '';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $search_query = '';
        if (!empty($search)) {
          $search_query = "AND ( P_Id LIKE '%$search%' OR P_Name LIKE '%$search%'OR P_Price LIKE '%$search%'OR P_Stock LIKE '%$search%' OR s.SC_Name LIKE '%$search%' OR c.C_Name LIKE '%$search%')";
        }

        $q = "SELECT p.*,s.SC_Name,c.C_Name FROM product_tbl p JOIN subcategory_tbl s ON p.P_SC_Id=s.SC_Id JOIN category_tbl c ON s.C_Id=c.C_Id where s.SC_Id=$sc_id AND p.P_Status='Active' $search_query";
        // $result = mysqli_query($con, $q);
        $total_records = mysqli_num_rows(mysqli_query($con, $q));

        // Set the number of records per page
        $records_per_page = 4;

        // Calculate the total number of pages
        $total_pages = ceil($total_records / $records_per_page);

        // Get the current page number
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Calculate the start record for the current page
        $start_from = ($page - 1) * $records_per_page;

        // Fetch the records for the current page
        $q = $q . "LIMIT $start_from, $records_per_page";
        $result = mysqli_query($con, $q);

        while ($r = mysqli_fetch_assoc($result)) {
          $discount = $r['P_Discount'];
          $original_price = $r['P_Price'];
          $discounted_price = $original_price - ($original_price * $discount / 100);
          ?>

          <div class="card <?php echo ($r['P_Stock'] == 0) ? 'out-of-stock' : ''; ?>">
            <?php if ($discount > 0 && $r['P_Stock'] > 0) { ?>
              <div class="ribbon"><?php echo $discount; ?>% off</div>
            <?php } ?>
            <img src="db_img/product_img/<?php echo $r['P_Img1'] ?>" class="card__image"
              alt="<?php echo $r['P_Name']; ?>" />
            <?php if ($r['P_Stock'] == 0) { ?>
              <!-- Always visible Out of Stock badge -->
              <div class="out-of-stock-badge">Out of Stock</div>
            <?php } ?>
            <div class="card__overlay">
              <div class="card__header">
                <div class="card__header-text">
                  <h3 class="card__title"><?php echo $r['P_Name'] ?></h3>
                  <?php if ($discount > 0 && $r['P_Stock'] > 0) { ?>
                    <span class="card__status">
                      <span style="text-decoration: line-through; color: #888;">Rs.
                        <del><?php echo number_format($original_price, 2); ?></del></span>
                      <span style="color: #f00;"> Rs. <?php echo number_format($discounted_price, 2); ?></span>
                    </span>
                  <?php } else { ?>
                    <span class="card__status">Rs. <?php echo number_format($original_price, 2); ?></span>
                  <?php } ?>
                  <p><?php echo $r['P_Company_Name'] ?></p>
                </div>
              </div>
              <?php if ($r['P_Stock'] > 0) { ?>
                <form method="post">
                  <p class="card__description">
                    <input type="hidden" name="p_id" value="<?php echo $r['P_Id']; ?>">
                    <a href="single_product.php?Id=<?php echo $r['P_Id'] ?>">
                      <button type="button" class="btn btn-dark">
                        <i class="fa fa-eye"></i>
                      </button>
                    </a>
                    <a href="cart.php">
                      <button type="submit" name="cart" class="btn btn-dark">
                        <i class="fa fa-shopping-cart"></i>
                      </button>
                    </a>
                    <a href="wishlist.php">
                      <button type="submit" name="wish" class="btn btn-dark">
                        <i class="fa fa-heart"></i>
                      </button>
                    </a>
                  </p>
                </form>
              <?php } ?>
            </div>
          </div>

          <?php
        }
        ?>
        <!-- Add more artworks as needed -->
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
  </div>
  <?php
  include "Footer.php";

  if (isset($_POST['cart'])) {
    $Ct_Quantity = 1;
    $Ct_P_Id = $_POST['p_id'];
    $Ct_U_Email = $Email_Session;

    $chechQuery = "select * from cart_tbl where Ct_P_Id=$Ct_P_Id And Ct_U_Email='$Ct_U_Email'";
    $CheckData = mysqli_num_rows(mysqli_query($con, $chechQuery));
    if ($CheckData == 0) {
      $sql = "INSERT INTO cart_tbl (Ct_Quantity, Ct_P_Id, Ct_U_Email) VALUES ('$Ct_Quantity', '$Ct_P_Id', '$Ct_U_Email')";
      $data = mysqli_query($con, $sql);

      if ($data) {
        echo "<script>window.location.href='cart.php';</script>";
      } else {
        echo "Error inserting data into cart";
      }
    } else {
      setcookie('success', "This product is already in cart!!!", time() + 5, "/");
      ?>
      <script>
        window.location.href = 'cart.php';
      </script>";
      <?php
    }
  }

  if (isset($_POST['wish'])) {
    $W_Quantity = 1;
    $W_P_Id = $_POST['p_id'];
    $W_U_Email = $Email_Session;

    $checkQuery = "select * from wishlist_tbl where W_P_Id=$W_P_Id And W_U_Email='$W_U_Email'";
    $CheckData = mysqli_num_rows(mysqli_query($con, $checkQuery));

    if ($CheckData == 0) {
      $sql = "INSERT INTO wishlist_tbl (W_U_Email,W_P_Id, W_Quantity) VALUES ('$W_U_Email', '$W_P_Id', '$W_Quantity')";
      $data = mysqli_query($con, $sql);

      if ($data) {
        echo "<script>location.replace('wishlist.php');</script>";
      } else {
        echo "Error inserting data into wishlist";
      }
    } else {
      setcookie('success', "This product is already in your Wishlist!!!", time() + 5, "/");
      ?>
      <script>
        window.location.href = 'wishlist.php';
      </script>";
      <?php
    }
  }
  ?>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>