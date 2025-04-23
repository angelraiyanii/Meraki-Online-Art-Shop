<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
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
            width: 30%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 20%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 20%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 30%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 30%;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="container-fluid bgcolor mt-5">
        <div class="row mt-3 mb-3">
            <h2 class="col-md-4" style="color:white">Reviews</h2>
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

        <!-- table -->
        <div class="row" id="product">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            // SQL query to include the search condition
            $search_query = '';
            if (!empty($search)) {
                $search_query = "WHERE P_Id LIKE '%$search%' OR P_Name LIKE '%$search%'OR P_Price LIKE '%$search%'OR P_Stock LIKE '%$search%' OR P_Status LIKE '%$search%'";
            }
            // Determine the total number of records
            $q = "
            SELECT 
                r.R_Id, r.R_U_Email, r.R_U_Name, r.R_Order_Id, r.R_P_Id, r.R_Rating, r.R_Review, r.R_Date, 
                p.P_Name, p.P_Img1
            FROM 
                review_tbl r 
            LEFT JOIN 
                product_tbl p ON r.R_P_Id = p.P_Id 
            $search_query ";

            $result = mysqli_query($con, $q);
            $total_records = mysqli_num_rows($result);

            // Set the number of records per page
            $records_per_page = 2;

            // Calculate the total number of pages
            $total_pages = ceil($total_records / $records_per_page);

            // Get the current page number
            $page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Calculate the start record for the current page
            $start_from = ($page - 1) * $records_per_page;

            // Fetch the records for the current page
            $q = $q . " LIMIT $start_from, $records_per_page";
            $result = mysqli_query($con, $q);

            ?>

            <table>
                <tr>
                    <th>Id</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                <?php while ($r = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $r['R_Id']; ?></td>
                        <td><?php echo $r['R_U_Name']; ?></td>
                        <td><?php echo $r['R_U_Email']; ?></td>
                        <td><?php echo $r['P_Name']; ?></td>
                        <td><img src="db_img/product_img/<?php echo $r['P_Img1'] ?>" alt="" height="100px" width="100px">
                        </td>
                        <td><?php echo $r['R_Rating']; ?></td>
                        <td><?php echo $r['R_Review']; ?></td>
                        <td><?php echo $r['R_Date']; ?></td>
                        <td>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $r['R_Id']; ?>">
                                <button class="btn btn-danger" type="submit" name="del">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
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
                $('#discount').show();
            else
                $('#discount').hide();
        }
    </script>
    <script>
        function discount() {
            validate = true;

            CommanValidate(document.getElementById('onm'), document.getElementById('onm_er'));
            BigTextValidate(document.getElementById('odes'), document.getElementById('odes_er'));
            RateValidate(document.getElementById('rate'), document.getElementById('rate_er'));
            RateValidate(document.getElementById('mda'), document.getElementById('mda_er'));
            RateValidate(document.getElementById('odt'), document.getElementById('odt_er'));
            CommanValidate(document.getElementById('sdt'), document.getElementById('sdt_er'));
            CommanValidate(document.getElementById('edt'), document.getElementById('edt_er'));
            ImgValidate(document.getElementById('bnr'), document.getElementById('bnr_er'));

            if (validate) {
                return true;
            }
            return false;
        }
    </script>
    <?php
    include 'Footer.php';

    if (isset($_POST['del'])) {
        $id = $_POST['delete_id'];
        // Update the status in the database
        $query = "delete from `review_tbl` where `R_Id`=$id";

        if (mysqli_query($con, $query)) {
            setcookie('success', "Review Deleted", time() + 5, "/");
        } else {
            setcookie('error', "Error in deleteing review", time() + 5, "/");
        }
        ?>
        <script>
            window.location.href = 'AdReview.php';
        </script>
        <?php
    }
    ?>
</body>

</html>