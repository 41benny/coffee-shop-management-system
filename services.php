<?php
require_once "includes/header.php";

// Default original services content (static)
$default_services_html = '<div class="container">
    <div class="row">
      <div class="col-md-4 ftco-animate">
        <div class="media d-block text-center block-6 services">
          <div class="icon d-flex justify-content-center align-items-center mb-5">
            <span class="flaticon-choices"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Easy to Order</h3>
            <p>
              Even the all-powerful Pointing has no control about the blind
              texts it is an almost unorthographic.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 ftco-animate">
        <div class="media d-block text-center block-6 services">
          <div class="icon d-flex justify-content-center align-items-center mb-5">
            <span class="flaticon-delivery-truck"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Fastest Delivery</h3>
            <p>
              Even the all-powerful Pointing has no control about the blind
              texts it is an almost unorthographic.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 ftco-animate">
        <div class="media d-block text-center block-6 services">
          <div class="icon d-flex justify-content-center align-items-center mb-5">
            <span class="flaticon-coffee-bean"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Quality Coffee</h3>
            <p>
              Even the all-powerful Pointing has no control about the blind
              texts it is an almost unorthographic.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>';

$page_content = $default_services_html;

// Try CMS content if table exists
$tableExists = false;
if ($conn) {
  $check = mysqli_query($conn, "SHOW TABLES LIKE 'cms_pages'");
  if ($check && mysqli_num_rows($check) > 0) {
    $tableExists = true;
  }
}

if ($tableExists) {
  if ($stmt = $conn->prepare("SELECT slug, title, content_html, image FROM cms_pages WHERE slug = ? AND status = 'published' LIMIT 1")) {
    $slug = 'services';
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && ($row = $result->fetch_assoc())) {
      if (!empty($row['content_html'])) {
        $page_content = $row['content_html'];
      }
    }
    $stmt->close();
  }
}
?>

<section class="home-slider owl-carousel">
  <div class="slider-item" style="background-image: url(images/bg_3.jpg)" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">
        <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Services</h1>
          <p class="breadcrumbs">
            <span class="mr-2"><a href="index.php">Home</a></span>
            <span>Services</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section ftco-services">
  <?php echo $page_content; ?>
</section>

<?php require_once "includes/footer.php"; ?>