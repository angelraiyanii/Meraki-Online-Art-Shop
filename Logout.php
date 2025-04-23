<?php
session_start();
// session_destroy();
unset($_SESSION['U_Admin']);
unset($_SESSION['U_User']);
setcookie('success', "User Logged out", time() + 5, "/");
?>
<script>
    window.location.href = "Login.php";
</script>