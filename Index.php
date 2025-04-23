<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="validation.js"></script>
  <?php
  include 'Header.php';

  ?>
  <style>
    /* .container {
      background-color: rgba(165, 165, 165, 0.7);
      border-radius: 50px;
      padding: 50px;
    } */

    body {
      margin: 0;
      color: white;
      font-family: Arial, Helvetica, sans-serif;
    }

    a {
      color: #000000;
      text-decoration: none;
    }

    a:hover {
      color: #ffffff
    }

    .featured {
      padding: 50px 20px;
      text-align: center;
    }

    .featured h2 {
      margin-bottom: 30px;
    }

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
</head>

<body class="bg-dark">
  <!-- <body style="background-color:#48172d"> -->
  <div class="container-fluid bgcolor mt-5">
    <div class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $query = "select * from slider_tbl where Id=1";
        $result = mysqli_query($con, $query);
        $r = mysqli_fetch_assoc($result);
        ?>
        <div class="carousel-item active">
          <img src="db_img/slider_img/<?php echo $r['Img_1'] ?>" class="d-block w-100">
          <div class="carousel-caption d-none d-md-block">
            <!-- <h5>MERAKI</h5> -->
          </div>
        </div>
        <div class="carousel-item">
          <img src="db_img/slider_img/<?php echo $r['Img_2'] ?>" class="d-block w-100">
          <div class="carousel-caption d-none d-md-block">
            <!-- <h5>MERAKI</h5> -->
          </div>
        </div>
        <div class="carousel-item">
          <img src="db_img/slider_img/<?php echo $r['Img_3'] ?>" class="d-block w-100">
          <div class="carousel-caption d-none d-md-block">
            <!-- <h5>MERAKI</h5> -->
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Featured products -->
  <div class="container-fluid bgcolor mt-5 mb-5">
    <div class="row mt-1">
      <div class="col">
        <section class="featured" id="latest">
          <h2>Bestsellers</h2>
          <div class="art-grid">
            <?php
            $q = "SELECT o.O_P_Id,count(o.O_P_Id) as maxCount,p.* FROM order_tbl o JOIN product_tbl p ON o.O_P_Id=p.P_Id GROUP BY o.O_P_Id ORDER BY maxCount DESC LIMIT 3";
            $result = mysqli_query($con, $q);

            while ($r = mysqli_fetch_assoc($result)) {
              ?>
              <div class="card">
                <?php if ($r['P_Discount'] > 0) { ?>
                  <div class="ribbon"><?php echo $r['P_Discount']; ?>% off</div>
                <?php } ?>
                <a href="single_product.php?Id=<?php echo $r['P_Id'] ?>" class="card">
                  <img src="db_img/product_img/<?php echo $r['P_Img1'] ?>" class="card__image"
                    alt="<?php echo $r['P_Name']; ?>" />
                  <div class="card__overlay">
                    <div class="card__header">
                      <div class="card__header-text">
                        <h3 class="card__title"><?php echo $r['P_Name'] ?></h3>
                        <span class="card__status">Rs. <?php echo $r['P_Price'] ?></span>
                      </div>
                    </div>
                    <p class="card__description"><?php echo $r['P_Company_Name'] ?></p>
                  </div>
                </a>
              </div>
              <!-- <a href="single_product.php">
                <div class="art-item">
                  <img src="Img/categories.png" alt="Artwork 1" style="width:100%;">
                  <h3>Product Name</h3>
                  <p>Comapny Name</p>
                  <p>$200</p>
                </div>
              </a> -->
              <?php
            }
            ?>
          </div>
          <!-- Add more artworks as needed -->
        </section>
      </div>
    </div>
  </div>

  <!-- Offers Section -->
  <div class="container-fluid bgcolor mt-5 mb-5">
    <!-- <h2>Offers and Discounts</h2> -->
    <div id="offerCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $query = "SELECT Of_Banner, Of_Description FROM offers_tbl WHERE Of_Status = 'Active'";
        $result = mysqli_query($con, $query);
        $isFirst = true; // Track the first item for the active class
        
        while ($row = mysqli_fetch_assoc($result)) {
          $banner = $row['Of_Banner'];
          $description = $row['Of_Description'];
          ?>
          <div class="carousel-item <?php if ($isFirst)
            echo 'active'; ?>">
            <a href="cart.php"><img src="db_img/offer_img/<?php echo $banner; ?>" class="d-block w-100"
                alt="Offer Image"></a>
            <div class="carousel-caption d-none d-md-block">
              <h5><?php echo $description; ?></h5>
            </div>
          </div>
          <?php
          $isFirst = false; // Set to false after the first iteration
        }
        ?>
      </div>
      <!-- Optional: Add carousel controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#offerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#offerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>


  <!-- Newest products -->
  <div class="container-fluid bgcolor mt-5 mb-5">
    <div class="row mt-1">
      <div class="col">
        <section class="featured" id="latest">
          <h2>Newest Products</h2>
          <div class="art-grid">
            <!-- <a href="single_product.php">
              <div class="art-item">
                <img src="Img/categories.png" alt="Artwork 1" style="width:100%;">
                <h3>Product Name</h3>
                <p>Company Name</p>
                <p>Rs. 13,000</p>
              </div>
            </a> -->
            <?php
            $q = "SELECT * FROM product_tbl ORDER BY P_Id DESC LIMIT 3";
            $result = mysqli_query($con, $q);

            while ($r = mysqli_fetch_assoc($result)) {
              ?>
              <div class="card">
              <?php if ($r['P_Discount'] > 0) { ?>
                  <div class="ribbon"><?php echo $r['P_Discount']; ?>% off</div>
                <?php } ?>
                <a href="single_product.php?Id=<?php echo $r['P_Id'] ?>" class="card">
                  <img src="db_img/product_img/<?php echo $r['P_Img1'] ?>" class="card__image"
                    alt="<?php echo $r['P_Name']; ?>" />
                  <div class="card__overlay">
                    <div class="card__header">
                      <div class="card__header-text">
                        <h3 class="card__title"><?php echo $r['P_Name'] ?></h3>
                        <span class="card__status">Rs. <?php echo $r['P_Price'] ?></span>
                      </div>
                    </div>
                    <p class="card__description"><?php echo $r['P_Company_Name'] ?></p>
                  </div>
                </a>
              </div>
              <!-- <a href="single_product.php">
                <div class="art-item">
                  <img src="Img/categories.png" alt="Artwork 1" style="width:100%;">
                  <h3>Product Name</h3>
                  <p>Comapny Name</p>
                  <p>$200</p>
                </div>
              </a> -->
              <?php
            }
            ?>
            <!-- Add more artworks as needed -->
          </div>
        </section>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

  <?php
  include('Footer.php');
  ?>
</body>

</html>