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

    #filters-dropdown {
      display: none;
      position: relative;
      z-index: 10;
    }
  </style>
  <?php
  include 'Header.php';
  if (isset($_SESSION['U_Admin']) || isset($_SESSION['U_User'])) {
    $Email_Session = isset($_SESSION['U_User']) ? $_SESSION['U_User'] : $_SESSION['U_Admin'];
  }
  ?>
</head>

<body class="bg-dark">
  <div class="container-fluid mt-5 mb-5 bgcolor" style="padding:20px;">
    <!-- Similar Products Section -->
    <div class="row mt-3 mb-3">
      <h2 class="col-md-3" style="color:white">Products</h2>
      <div class="col-md-4"></div>
      <div class="col-md-3" style="text-align:right;padding-right:25px;">
        <form method="get">
          <!-- form for search Start -->
          <input type="text" name="search" class="form-control" placeholder="Search here...">&nbsp;
      </div>
      <div class="col-md-2"><button class="btn btn-dark"><i class="fa fa-search "></i></button>
        <button type="button" class="btn btn-dark ml-2" id="filters-toggle"><i class="fa fa-filter"></i></button>
      </div>
      </form>
      <!-- form for search End -->
    </div>

    <!-- Filters Dropdown -->
    <div id="filters-dropdown" class="bg-light p-3 mt-3"
      style="display: none; border: 1px solid #ddd; border-radius: 5px;">
      <form method="get" id="filter-form">
        <!-- Ratings Filter -->
        <div class="form-group">
          <label for="rating" style="color: black;">Ratings:</label>
          <select name="rating" id="rating" class="form-control">
            <option value="">All</option>
            <option value="1" <?php echo isset($_GET['rating']) && $_GET['rating'] == 1 ? 'selected' : ''; ?>>1 Star &
              Above</option>
            <option value="2" <?php echo isset($_GET['rating']) && $_GET['rating'] == 2 ? 'selected' : ''; ?>>2 Stars &
              Above</option>
            <option value="3" <?php echo isset($_GET['rating']) && $_GET['rating'] == 3 ? 'selected' : ''; ?>>3 Stars &
              Above</option>
            <option value="4" <?php echo isset($_GET['rating']) && $_GET['rating'] == 4 ? 'selected' : ''; ?>>4 Stars &
              Above</option>
            <option value="5" <?php echo isset($_GET['rating']) && $_GET['rating'] == 5 ? 'selected' : ''; ?>>5 Stars
            </option>
          </select>
        </div>

        <!-- Price Range Filter -->
        <div class="form-group">
          <label for="min_price" style="color: black;">Price:</label>
          <input type="number" name="min_price" id="min_price" class="form-control" placeholder="Min"
            value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : ''; ?>">
          <input type="number" name="max_price" id="max_price" class="form-control mt-2" placeholder="Max"
            value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : ''; ?>">
        </div>

        <!-- Discount Filter -->
        <div class="form-group">
          <label for="discount" style="color: black;">Discount:</label>
          <select name="discount" id="discount" class="form-control">
            <option value="">Any</option>
            <option value="10" <?php echo isset($_GET['discount']) && $_GET['discount'] == 10 ? 'selected' : ''; ?>>10%+
            </option>
            <option value="20" <?php echo isset($_GET['discount']) && $_GET['discount'] == 20 ? 'selected' : ''; ?>>20%+
            </option>
            <option value="50" <?php echo isset($_GET['discount']) && $_GET['discount'] == 50 ? 'selected' : ''; ?>>50%+
            </option>
          </select>
        </div>

        <!-- Apply Filters Button -->
        <button type="submit" class="btn btn-dark mt-2">Apply Filters</button>
      </form>
    </div>

    <div class="row mt-5">
      <div class="art-grid">
        <?php
        $sc_id = isset($_GET['Id']) ? $_GET['Id'] : '';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $rating = isset($_GET['rating']) ? $_GET['rating'] : '';
        $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
        $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
        $discount = isset($_GET['discount']) ? $_GET['discount'] : '';
        $search_query = '';

        // Build the search filter
        if (!empty($search)) {
          $search_query = "AND (P_Id LIKE '%$search%' OR P_Name LIKE '%$search%' OR P_Price LIKE '%$search%' OR P_Stock LIKE '%$search%' OR s.SC_Name LIKE '%$search%' OR c.C_Name LIKE '%$search%')";
        }

        // Build the rating filter
        $rating_query = '';
        if (!empty($rating)) {
          $rating_query = "AND (SELECT AVG(r.R_Rating) FROM review_tbl r WHERE r.R_P_Id = p.P_Id) >= $rating";
        }

        // Build the price filter
        $price_query = '';
        if (!empty($min_price) && !empty($max_price)) {
          $price_query = "AND p.P_Price BETWEEN $min_price AND $max_price";
        } elseif (!empty($min_price)) {
          $price_query = "AND p.P_Price >= $min_price";
        } elseif (!empty($max_price)) {
          $price_query = "AND p.P_Price <= $max_price";
        }

        // Build the discount filter
        $discount_query = '';
        if (!empty($discount)) {
          $discount_query = "AND p.P_Discount >= $discount";
        }

        $q = "SELECT p.*, s.SC_Name, c.C_Name, 
             ROUND(COALESCE(AVG(r.R_Rating), 0)) AS avg_rating
      FROM product_tbl p 
      JOIN subcategory_tbl s ON p.P_SC_Id = s.SC_Id 
      JOIN category_tbl c ON s.C_Id = c.C_Id 
      LEFT JOIN review_tbl r ON p.P_Id = r.R_P_Id
      WHERE s.SC_Id = '$sc_id' AND p.P_Status = 'Active'
      $search_query
      $rating_query
      $price_query
      $discount_query
      GROUP BY p.P_Id";

        // echo $q;
        
        $result = mysqli_query($con, $q);
        if (!$result) {
          die('Error in SQL query: ' . mysqli_error($con)); 
        }

        // Pagination
        $total_records = mysqli_num_rows($result);
        $records_per_page = 4;
        $total_pages = ceil($total_records / $records_per_page);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start_from = ($page - 1) * $records_per_page;
        $q .= " LIMIT $start_from, $records_per_page";

        // Fetch the records for the current page
        $result = mysqli_query($con, $q);

        // Check if no results are found
        if (mysqli_num_rows($result) == 0) {
          echo "<p>No products found with the applied filters.</p>";
        } else {
          while ($r = mysqli_fetch_assoc($result)) {
            // Fetch product details and render HTML as before
            $discount = $r['P_Discount'];
            $original_price = $r['P_Price'];
            $discounted_price = $original_price - ($original_price * $discount / 100);
            $avg_rating = $r['avg_rating'];  // Get the average rating
            ?>
            <div class="card <?php echo ($r['P_Stock'] == 0) ? 'out-of-stock' : ''; ?>">
              <?php if ($discount > 0 && $r['P_Stock'] > 0) { ?>
                <div class="ribbon"><?php echo $discount; ?>% off</div>
              <?php } ?>
              <img src="db_img/product_img/<?php echo $r['P_Img1'] ?>" class="card__image"
                alt="<?php echo $r['P_Name']; ?>" />
              <?php if ($r['P_Stock'] == 0) { ?>
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
        }
        ?>



      </div>

      <!-- Pagination Start -->
      <nav>
        <ul class="pagination">
          <?php
          if ($page > 1) {
            echo "<li class='page-item'><a class='page-link btn-dark' href='?page=" . ($page - 1) . "&search=" . $search . "&rating=" . $rating . "'><i class='fa fa-chevron-left'></i></a></li>";
          }
          for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='?page=" . $i . "&search=" . $search . "&rating=" . $rating . "'>" . $i . "</a></li>";
          }
          if ($page < $total_pages) {
            echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "&search=" . $search . "&rating=" . $rating . "'><i class='fa fa-chevron-right'></i></a></li>";
          }
          ?>
        </ul>
      </nav>
      <!-- Pagination End -->
    </div>
  </div>
  <script>
    document.getElementById('filters-toggle').addEventListener('click', function () {
      const filtersDropdown = document.getElementById('filters-dropdown');
      if (filtersDropdown.style.display === 'none' || filtersDropdown.style.display === '') {
        filtersDropdown.style.display = 'block';
      } else {
        filtersDropdown.style.display = 'none';
      }
    });
  </script>

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
        echo "<script>alert('Something went wrong');</script>";
      }
    } else {
      echo "<script>alert('Already in Cart');</script>";
    }
  }

  if (isset($_POST['wish'])) {
    $wish_Query = "INSERT INTO wishlist_tbl (W_P_Id, W_U_Email) VALUES ('$Ct_P_Id', '$Ct_U_Email')";
    $wish_Result = mysqli_query($con, $wish_Query);
    if ($wish_Result) {
      echo "<script>alert('Added to Wishlist');</script>";
    } else {
      echo "<script>alert('Error occurred');</script>";
    }
  }
  ?>
</body>

</html>