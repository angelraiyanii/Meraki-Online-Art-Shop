<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Category</title>
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js"></script>
    <?php
    include 'Header.php';
    if (!isset($_SESSION['U_Admin'])) {
        header("Location: index.php");
        exit();
    }
    ?>
    <style>
        tr {
            border: 1px black solid;
            text-align: center;
        }

        table {
            width: 100%;
        }

        th,
        td {
            width: 100%;
            border: 1px black solid;
            padding: 10px;
        }

        th:nth-child(1),
        td:nth-child(1) {
            width: 10%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 40%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 40%;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="container-fluid bgcolor mt-5">
        <div class="row mt-3 mb-3">
            <h2 class="col-md-4" style="color:white">Main Category</h2>
            <div class="col-md-3" style="text-align:right">
                <!-- form for search Start -->
                <form method="get"><input type="text" name="search" class="form-control"
                        placeholder="Search here...">&nbsp;
            </div>
            <div class="col-md-1"><button class="btn btn-dark"><i class="fa fa-search "></i></button></div>
            </form>
            <!-- form for search End -->
            <div class="col-md-3"></div>
            <div class="col-md-1" style="text-align:right"><button class="btn btn-dark" onclick="addForm(1)"><i
                        class="fa fa-plus"></i></button></div>
        </div>

        <!-- add category -->
        <div class="container-fluid bgcolor mt-5 mb-5" id="add_form" style="display:none !important">
            <div class="row">
                <div class="col col-md-12">
                    <h2>Add New Category</h2>
                    <!-- <form onsubmit="return addCat()" > -->
                    <form method="post" enctype="multipart/form-data" onsubmit="return  mainCat()">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name :</label>
                                <input type="text" class="form-control" name="cnm" id="catNm"
                                    placeholder="Enter Category Name">
                                <span id="catNm_er"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Image :</label>
                                <input type="file" class="form-control" name="cimg" id="catImg">
                                 Upload Images with Dimentions of 1024*1024
                                <span id="catImg_er"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mb-3"></div>
                            <div class="col-md-2 mb-3" style="align-content: end;">
                                <button type="submit" name="csubmit" class="btn btn-dark"><i
                                        class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- table -->
        <div class="row" id="product">
            <table>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>View</th>
                    <th>Status</th>
                </tr>
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $search_query = '';
                if (!empty($search)) {
                    $search_query = "WHERE C_Id LIKE '%$search%' OR C_Name LIKE '%$search%' OR C_Status LIKE '$search'";
                }
                $q = "SELECT * FROM category_tbl $search_query";
                $result = mysqli_query($con, $q);
                $total_records = mysqli_num_rows($result);

                $records_per_page = 2;

                $total_pages = ceil($total_records / $records_per_page);

                $page = isset($_GET['page']) ? $_GET['page'] : 1;

                $start_from = ($page - 1) * $records_per_page;

                $q = "SELECT * FROM category_tbl $search_query LIMIT $start_from, $records_per_page";
                $result = mysqli_query($con, $q);


                while ($r = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $r['C_Id'] ?></td>
                        <td><?php echo $r['C_Name'] ?></td>
                        <td><img src="db_img/cat_img/<?php echo $r['C_Img'] ?>" height="100px" width="100px"></td>
                        <td>
                            <form method="post" action="AdCategory.php#update_form">
                                <a href="#update_form">
                                    <button type="submit" class="btn btn-dark" value="<?php echo $r['C_Id'] ?>"
                                        name="showCat" onclick="update(1)"><i class="fa fa-eye"></i></button>
                                </a>
                            </form>
                        </td>

                        <td>
                            <form method="post" action="AdCategory.php">
                                <input type="hidden" name="categoryId" value="<?php echo $r['C_Id']; ?>">
                                <input type="hidden" name="currentStatus" value="<?php echo $r['C_Status']; ?>">
                                <button type="submit" name="changeStatus" class="btn btn-dark">
                                    <?php echo $r['C_Status'] == 'Active' ? 'Hide' : 'Show'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
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

    <!-- update cat form -->
    <?php
    if (isset($_POST['showCat'])) {
        //echo $_POST['showUsr'];
        $id = $_POST['showCat'];

        $query = "select * from category_tbl where C_Id=$id";
        $result = mysqli_query($con, $query);
        $r = mysqli_fetch_assoc($result);
        $p_status = $r['C_Status'];
        ?>
        <div class="container-fluid bgcolor mt-5" id="update_form">
            <div class="row">
                <!-- Images Column -->
                <div class="col-md-4">
                    <div class="product-image">
                        <img src="db_img/cat_img/<?php echo $r['C_Img'] ?>" height="100px" width="100px" alt="Product Image"
                            class="img-fluid rounded">
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-8">
                    <div class="product-image-large">
                        <!-- update information -->
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <input type="hidden" name="cid" value="<?php echo $r['C_Id'] ?>">
                                <input type="hidden" name="oldimg" value="<?php echo $r['C_Img'] ?>">
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Category Name:</label>
                                    <input type="text" class="form-control" name="cnm" id="anm"
                                        value="<?php echo $r['C_Name'] ?>">
                                    <span id="unm_er" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Category Image:</label>
                                    <input type="file" class="form-control" name="cimg" id="anm">
                                    Upload Images with Dimentions of 1024*1024
                                    <span id="unm_er" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="anm" class="form-label">Category Status:</label>
                                    <select class="form-control" name="status">
                                        <option <?php if ($p_status == 'Active')
                                            echo 'selected'; ?> value="Active">Active
                                        </option>
                                        <option <?php if ($p_status == 'Deactivate')
                                            echo 'selected'; ?> value="Deactivate">
                                            Deactivate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 mb-3">
                                </div>
                                <div class="col-md-3 mb-3" style="align-content: end;">
                                    <button class="btn btn-dark" onclick="update(2)"><i class="fa fa-times"></i></button>
                                    <button type="submit" class="btn btn-dark" name="updateCat"><i
                                            class="fa fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!-- update product form -->

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function update(a) {
            if (a == 1) {
                $('#update_form').show();
            }
        }
        function addForm(a) {
            if (a == 1)
                $('#add_form').show();
            else
                $('#add_form').hide();
        }
    </script>
    <script>
        function mainCat() {
            validate = true;

            NameValidate(document.getElementById('catNm'), document.getElementById('catNm_er'));
            ImgValidate(document.getElementById('catImg'), document.getElementById('catImg_er'));
            if (validate) {
                return true;
            }
            return false;
        }
    </script>
    <?php
    include 'Footer.php';

    // Add cat
    if (isset($_POST['csubmit'])) {
        $cnm = $_POST['cnm'];
        $cimg = uniqid() . $_FILES['cimg']['name'];

        $query = "INSERT INTO `category_tbl`(`C_Name`, `C_Img`,`C_Status`) VALUES ('$cnm','$cimg','Active')";
        if (mysqli_query($con, $query)) {
            if (!is_dir('db_img/cat_img')) {
                mkdir('db_img/cat_img');
            }
            if (move_uploaded_file($_FILES['cimg']['tmp_name'], 'db_img/cat_img/' . $cimg)) {
                setcookie('success', 'Category Added', time() + 5, "/");
                ?>
                <script>
                    window.location.href = "AdCategory.php";
                </script>
                <?php
            } else {
                echo "File upload error: ". $_FILES['cimg']['error'];
            }
        } else {
            setcookie('error', 'Error in adding Category', time() + 5, "/");
            ?>
            <script>
                window.location.href = "AdCategory.php";
            </script>
            <?php
        }
    }
    // Update cat
    if (isset($_POST['updateCat'])) {
        $id = $_POST['cid'];
        $cnm = $_POST['cnm'];
        $stat = $_POST['status'];
        $oimg = $_POST['oldimg'];

        if ($_FILES['cimg']['name'] != "") {
            $img = uniqid() . $_FILES['cimg']['name'];
            move_uploaded_file($_FILES['cimg']['tmp_name'], "db_img/cat_img/" . $img);
        } else {
            $img = $oimg;
        }

        $query = "UPDATE `category_tbl` SET `C_Name`='$cnm',`C_Img`='$img',`C_Status`='$stat' WHERE `C_Id`=$id";
        echo $query;

        if (mysqli_query($con, $query)) {
            if ($_FILES['cimg']['name'] != "") {
                $old_image = $oimg;
                if (file_exists("db_img/cat_img/" . $old_image)) {
                    unlink("db_img/cat_img/" . $old_image);
                }
            }
            setcookie('success', "Category updated successfully", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'AdCategory.php';
            </script>
            <?php
        } else {
            setcookie('error', "Error in updating category", time() + 5, "/");
            ?>
            <script>
                window.location.href = 'AdCategory.php';
            </script>
            <?php
        }
    }
    // status update from table
    if (isset($_POST['changeStatus'])) {
        $id = $_POST['categoryId'];
        $currentStatus = $_POST['currentStatus'];

        // Determine the new status
        $newStatus = ($currentStatus == 'Active') ? 'Deactivate' : 'Active';

        // Update the status in the database
        $query = "UPDATE `category_tbl` SET `C_Status`='$newStatus' WHERE `C_Id`=$id";

        if (mysqli_query($con, $query)) {
            setcookie('success', "Status updated successfully", time() + 5, "/");
        } else {
            setcookie('error', "Error in updating status", time() + 5, "/");
        }
        ?>
        <script>
            window.location.href = 'AdCategory.php';
        </script>
        <?php
    }
    ?>
</body>

</html>