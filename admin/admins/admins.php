<?php require_once __DIR__ . "/../layouts/header.php"; ?>
<?php require_once __DIR__ . "/../layouts/breadcrumbs.php"; ?>

<?php

// fetching desserts
$query = "SELECT * FROM admins";
$result = mysqli_query($conn, $query) or die("Query Unsuccessful");

?>

<div class="container-fluid">

  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-4 d-inline">Admins</h5>
            <a href="create-admins" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
          </div>
          <?php generate_breadcrumbs(); ?>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <tr>
                    <th scope="row"><?php echo $row['id']; ?></th>
                    <td><?php echo $row['admin_name']; ?></td>
                    <td class="admin-email"><?php echo $row['email']; ?></td>
                  </tr>
              <?php }
              } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

</html>