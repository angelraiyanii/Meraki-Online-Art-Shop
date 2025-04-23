<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="validation.js"></script>
  <?php
  include 'Header.php';
  ?>
</head>


<!-- <body style="background-image: url(img/firstbigbox.png);background-size: cover;color:white;"> -->

<body class="bg-dark">
  <div class="container-fluid mt-5 bgcolor">
    <div class="row">
      <h2>Meraki</h2>
      <!-- Left Column -->
      <div class="col-md-4">
        <p class="price"></p>
        <div class="product-image">
          <?php
          $q = "select * from aboutus_tbl";
          $result = mysqli_query($con, $q);
          while ($r = mysqli_fetch_assoc($result)) { ?>
            <img src="db_img/about_img/<?php echo $r['a_Image'] ?>" alt="User Image" class="img-fluid rounded">
            <?php
          }
          ?>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-md-8">
        <!-- <h3 class="mb-5">Account Information</h3> -->
        <div class="product-image-large">
          <!-- user Information -->
          <div id="info">
            <div class="row">
              <div class="col-md-12 mb-6"><br>
                <label for="name" class="form-label" style="font-weight: bold;">Our History</label> <br><br>
                <?php
                $q = "select * from aboutus_tbl";
                $result = mysqli_query($con, $q);
                while ($r = mysqli_fetch_assoc($result)) {
                  echo $r['a_content'];
                }
                ?>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid mt-5 mb-5 bgcolor">
    <!-- Add a Review Section -->
    <div class="row mt-5">
      <h2>Contact Us</h2><br /><br />
      <div class="col">
        <form method="post" id="contactForm" onsubmit="return conForm()">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Name :</label>
              <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name">
              <span id="FnmError"></span>
            </div>
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Email :</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
              <span id="EmailError"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="name" class="form-label">Message :</label>
              <textarea name="msg" id="msg" class="form-control" placeholder="Enter your queries here..."></textarea>
              <span id="AddError"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-11 mb-3">
            </div>
            <div class="col-md-1 mb-3" style="align-content: end;">
              <button type="submit" name="contactSub" class="btn btn-dark"><i class="fa fa-arrow-right"></i></input>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script>
    function conForm() {
      event.preventDefault();
      validate = true;
      NameValidate(document.getElementById('fname'), document.getElementById('FnmError'));
      EmailValidate(document.getElementById('email'), document.getElementById('EmailError'));
      BigTextValidate(document.getElementById('msg'), document.getElementById('AddError'));

      if (validate) {
        return true;
      }
      return false;

    }
  </script>

  <?php
  include 'Footer.php';

  if (isset($_POST['contactSub'])) {
    $name = $_POST['fname'];
    $email = $_POST['email'];
    $msg = $_POST['msg'];

    $query = "insert into contact_tbl (Co_Name,Co_Email,Co_Msg,Co_Reply) values ('$name','$email','$msg','')";
    if (mysqli_query($con, $query)) {
      setcookie('success', 'Query sent successfully.', time() + 5, "/");
      ?>
      <script>
        window.location.href = 'about.php';
      </script>
      <?php
    } else {
      setcookie('error', 'Error in sending query.', time() + 5, "/");
    }

  }
  ?>
</body>

</html>