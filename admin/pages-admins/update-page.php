<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php
    if(!isset($_SESSION['adminname'])) {
        header("location: ".ADMINURL."/admins/login.php");
    }

    // Validate and fetch page
    if(isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $page = null;

        if ($stmt = $conn->prepare("SELECT id, title, content_html, status, image FROM cms_pages WHERE id = ? LIMIT 1")) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $page = $result->fetch_object();
            }
            $stmt->close();
        }

        if(!$page) {
            header("location: ".ADMINURL."/pages-admins/show-pages.php");
        }
    } else {
        header("location: ".ADMINURL."/404.php");
    }

    if(isset($_POST['submit'])) {
        if(empty($_POST['title']) || empty($_POST['content_html'])) {
            echo "<script>alert('one or more inputs are empty');</script>";
        } else {
            $title = $_POST['title'];
            $content_html = $_POST['content_html'];
            $status = $_POST['status'];
            $image = $_FILES['image']['name'];

            $newImage = $page->image;
            if(!empty($image)) {
                $dir = "../../images/" . basename($image);
                if (!empty($page->image) && file_exists("../../images/" . $page->image)) {
                    @unlink("../../images/" . $page->image);
                }
                move_uploaded_file($_FILES['image']['tmp_name'], $dir);
                $newImage = $image;
            }

            if ($stmt = $conn->prepare("UPDATE cms_pages SET title = ?, content_html = ?, status = ?, image = ? WHERE id = ?")) {
                $stmt->bind_param("ssssi", $title, $content_html, $status, $newImage, $id);
                $stmt->execute();
                $stmt->close();
            }

            header("location: ".ADMINURL."/pages-admins/show-pages.php");
        }
    }
?>
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({selector:'textarea#content'});</script>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Update Page "<?php echo $page->title; ?>"</h5>
                <form method="POST" action="update-page.php?id=<?php echo $page->id; ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" value="<?php echo $page->title; ?>" class="form-control" id="title" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content_html" class="form-control" id="content" rows="10"><?php echo $page->content_html; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Current Image</label>
                        <br>
                        <img src="../../images/<?php echo $page->image; ?>" width="200px">
                    </div>
                     <div class="form-group">
                        <label for="image">New Image</label>
                        <input type="file" name="image" class="form-control-file" id="image">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="draft" <?php if($page->status == 'draft') { echo 'selected'; } ?>>Draft</option>
                            <option value="published" <?php if($page->status == 'published') { echo 'selected'; } ?>>Published</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "../layouts/footer.php"; ?>