<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="styles.css">
    <script src="validation.js"></script>
    <?php
    include 'Header.php';
    if (!isset($_SESSION['U_Admin'])) {
        header("Location: index.php");
        exit();
    }
    ?>

<body class="bg-dark">
    <form action="AdAboutUs.php" method="post">
        <div class="container-fluid mt-5 bgcolor">
            <div class="row mt-3 mb-3">
                <h2 class="col-md-4" style="color:white">About As</h2>
                <!-- Editor container -->
                <?php
                $query = "SELECT * FROM aboutus_tbl";
                $result = mysqli_query($con, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        echo "<p>" . $row['a_content'] . "</p>";
                    }
                } else {
                    echo "<p>No content available.</p>";
                }

                ?>
            </div>

            <!-- Form for Editing Content -->
            <h2 class="col-md-4" style="color:white">Change Content</h2>
            <form action="about_us.php" method="post" enctype="multipart/form-data">
                <div id="toolbar-container"></div>
                <div id="editor">
                    <?php
                    // Load the current content into the editor
                    $query = "SELECT * FROM aboutus_tbl LIMIT 1";
                    $result = mysqli_query($con, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo $row['a_content'];
                    } else {
                        echo "<p>No content available.</p>";
                    }
                    ?>
                </div>
                <!-- Hidden textarea to store the HTML content -->
                <textarea id="editor-content" name="editor_content" style="display:none;"></textarea>

                <br>
                <div class="col-12 text-center">
                    <input type="submit" value="Update Content" class="btn btn-dark" name="updt_about">
                </div>
            </form>
            <!-- CKEditor setup -->
            <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/decoupled-document/ckeditor.js"></script>
            <script>
                DecoupledEditor.create(document.querySelector("#editor"), {
                    toolbar: [
                        "heading",
                        "bold",
                        "italic",
                        "link",
                        "bulletedList",
                        "numberedList",
                        "blockQuote",
                        "fontColor",
                        "fontBackgroundColor",
                        "undo",
                        "redo",
                    ],
                    heading: {
                        options: [{
                            model: "paragraph",
                            title: "Paragraph",
                            class: "ck-heading_paragraph",
                        },
                        {
                            model: "heading1",
                            view: "h1",
                            title: "Heading 1",
                            class: "ck-heading_heading1",
                        },
                        {
                            model: "heading2",
                            view: "h2",
                            title: "Heading 2",
                            class: "ck-heading_heading2",
                        },
                        {
                            model: "heading3",
                            view: "h3",
                            title: "Heading 3",
                            class: "ck-heading_heading3",
                        },
                        {
                            model: "heading4",
                            view: "h4",
                            title: "Heading 4",
                            class: "ck-heading_heading4",
                        },
                        {
                            model: "heading5",
                            view: "h5",
                            title: "Heading 5",
                            class: "ck-heading_heading5",
                        },
                        {
                            model: "heading6",
                            view: "h6",
                            title: "Heading 6",
                            class: "ck-heading_heading6",
                        },
                        ],
                    },
                    fontColor: {
                        colors: [{
                            color: "hsl(0, 0%, 0%)",
                            label: "white",
                        },
                        {
                            color: "hsl(0, 75%, 60%)",
                            label: "Red",
                        },
                        {
                            color: "hsl(30, 75%, 60%)",
                            label: "Orange",
                        },
                        {
                            color: "hsl(60, 75%, 60%)",
                            label: "Yellow",
                        },
                        {
                            color: "hsl(120, 75%, 60%)",
                            label: "Green",
                        },
                        {
                            color: "hsl(180, 75%, 60%)",
                            label: "Cyan",
                        },
                        {
                            color: "hsl(240, 75%, 60%)",
                            label: "Blue",
                        },
                        {
                            color: "hsl(300, 75%, 60%)",
                            label: "Magenta",
                        },
                        ],
                    },
                    fontBackgroundColor: {
                        colors: [{
                            color: "hsl(0, 0%, 100%)",
                            label: "white",
                        },
                        {
                            color: "hsl(0, 75%, 60%)",
                            label: "Red",
                        },
                        {
                            color: "hsl(30, 75%, 60%)",
                            label: "Orange",
                        },
                        {
                            color: "hsl(60, 75%, 60%)",
                            label: "Yellow",
                        },
                        {
                            color: "hsl(120, 75%, 60%)",
                            label: "Green",
                        },
                        {
                            color: "hsl(180, 75%, 60%)",
                            label: "Cyan",
                        },
                        {
                            color: "hsl(240, 75%, 60%)",
                            label: "Blue",
                        },
                        {
                            color: "hsl(300, 75%, 60%)",
                            label: "Magenta",
                        },
                        ],
                    },
                })
                    .then((editor) => {
                        const toolbarContainer = document.querySelector("#toolbar-container");
                        toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                        // Get the HTML content from the editor and update the textarea
                        document.querySelector("#editor-content").value = editor.getData();

                        editor.model.document.on("change:data", () => {
                            document.querySelector("#editor-content").value = editor.getData();
                        });
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            </script>
            <br><br>
            <h2 class="col-12  text-center" style="color:white">Update Image</h2>
            <!-- Image Upload Section -->
            <div class="col-12 text-center">
                <form action="AdAboutUs.php" method="post" enctype="multipart/form-data">
                    <?php
                    // Display the current image preview if it exists
                    $query = "SELECT a_Image FROM aboutus_tbl LIMIT 1";
                    $result = mysqli_query($con, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        if (!empty($row['a_Image'])) {
                            echo "<img src='db_img/about_img/" . $row['a_Image'] . "' alt='Current Image' style='max-width:300px; height:auto;'>";
                            echo "<br><br>";
                        }
                    }
                    ?>

                    <?php
                    // Display the current image preview if it exists
                    $query = "SELECT a_Image FROM aboutus_tbl LIMIT 1";
                    $result = mysqli_query($con, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        if (!empty($row['image'])) {
                            echo "<img src='db_img/about_img/" . $row['a_Image'] . "' alt='Current Image' style='max-width:300px; height:auto;'>";
                            echo "<br><br>";
                        }
                    }
                    ?>
                    <label for="about_image" class="form-label">Upload New Image:</label>
                    <input type="file" name="about_image" accept="image/*" class="form-control "
                        style="width: 30%; margin: 0 auto;">
                    <br>

                    <input type="submit" value="Update Image" class="btn btn-dark" name="updt_image">
            </div>
    </form>


    </div>
</body>

<?php
include 'Footer.php';
if (isset($_POST['updt_about'])) {
    $about_content = $_POST['editor_content'];
    $q1 = "select * from aboutus_tbl";
    $res1 = mysqli_query($con, $q1);
    $count = mysqli_num_rows($res1);
    if ($count == 0) {
        $q2 = "INSERT INTO aboutus_tbl (a_content) VALUES ('$about_content')";
        if (mysqli_query($con, $q2)) {
            setcookie("success", 'Page Content Updated', time() + 5, "/");
        } else {
            setcookie("error", 'Failed to update page content', time() + 5, "/");
        }
    } else {
        $q = "UPDATE aboutus_tbl SET a_content='$about_content'";
        if (mysqli_query($con, $q)) {
            setcookie("success", 'Page Content Updated', time() + 5, "/");
        } else {
            setcookie("error", 'Failed to update page content', time() + 5, "/");
        }
    }
    ?>
    <script>
        window.location.href = "AdAboutUs.php";
    </script>
    <?php
}
?>


<!-- Handle form submission for image update -->
<?php
if (isset($_POST['updt_image'])) {
    $image = $_FILES['about_image']['name'];
    $target_dir = "db_img/about_img/";
    $target_file = $target_dir . basename($image);
    $uploadError = $_FILES['about_image']['error'];

    // Debugging: Check upload directory
    if (!is_writable($target_dir)) {
        echo "<script>alert('Upload directory is not writable: " . $target_dir . "');</script>";
    } else {
        if ($uploadError === UPLOAD_ERR_OK) {
            // Check if the file type is allowed
            $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileType, $allowedTypes)) {
                echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            } else {
                // Try to move the file
                if (move_uploaded_file($_FILES['about_image']['tmp_name'], $target_file)) {
                    $stmt = $con->prepare("UPDATE aboutus_tbl SET a_Image=?");
                    $stmt->bind_param("s", $image);
                    if ($stmt->execute()) {
                        setcookie("success", 'Image Updated', time() + 5, "/");
                        ?>
                            <script>
                                window.location.href = "AdAboutUs.php";
                            </script>
                        <?php
                    } else {
                        setcookie("error", 'Failed to update image in database', time() + 5, "/");
                    }
                } else {
                    echo "<script>alert('Failed to move uploaded file to: " . $target_file . "');</script>";
                }
            }
        } else {
            echo "<script>alert('Error uploading file: " . $uploadError . "');</script>";
        }
    }
}
?>