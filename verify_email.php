<?php
include_once('header.php');

$email = $_GET['em'];
echo $email;

$q = "select * from user_tbl where U_Email='$email'";
$result = mysqli_query($con, $q);
$count = mysqli_num_rows($result);

if ($count == 1) {
    while ($r = mysqli_fetch_array($result)) {
        if ($r[9] == "Active") {
            setcookie('success', "Email is already verified", time() + 5, "/");
?>
            <script>
                window.location.href = "login.php";
            </script>
            <?php
        } else {
            $update = "update user_tbl set `U_Status`='Active' where `U_Email`='$email'";
            if (mysqli_query($con, $update)) {
                setcookie('success', "Email verified successfully", time() + 5, "/");
            ?>
                <script>
                    window.location.href = "login.php";
                </script>
    <?php
            }
        }
    }
} else {
    setcookie('error', "Email is not registered", time() + 5, "/");
    ?>
    <script>
        window.location.href = "register.php";
    </script>
<?php
}