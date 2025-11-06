<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 
    if(!isset($_SESSION['adminname'])) {
        header("location: ".ADMINURL."/admins/login.php");
    }

    // Ensure table exists; if not, show empty list with a hint
    $all_pages = [];
    $tableExists = false;
    if ($conn) {
        $check = mysqli_query($conn, "SHOW TABLES LIKE 'cms_pages'");
        if ($check && mysqli_num_rows($check) > 0) {
            $tableExists = true;
        }
    }

    if ($tableExists) {
        if ($res = $conn->query("SELECT * FROM cms_pages ORDER BY updated_at DESC")) {
            while ($row = $res->fetch_assoc()) {
                $all_pages[] = $row;
            }
        }
    }
?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Manage Pages</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Last Updated</th>
                            <th scope="col">Status</th>
                            <th scope="col">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($all_pages)) : ?>
                        <tr>
                            <td colspan="5">No pages found. If you just updated the code, please import the SQL files in the <code>db/</code> folder to enable CMS editing.</td>
                        </tr>
                        <?php endif; ?>
                        <?php foreach($all_pages as $page) : ?>
                        <tr>
                            <th scope="row"><?php echo $page['id']; ?></th>
                            <td><?php echo $page['title']; ?></td>
                            <td><?php echo date('M d, Y h:i A', strtotime($page['updated_at'])); ?></td>
                            <td>
                                <?php if($page['status'] == 'published'): ?>
                                    <span class="badge badge-success">Published</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td><a href="update-page.php?id=<?php echo $page['id']; ?>" class="btn btn-warning text-white text-center">Update</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require "../layouts/footer.php"; ?>