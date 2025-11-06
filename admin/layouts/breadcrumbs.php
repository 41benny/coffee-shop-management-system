<?php
function generate_breadcrumbs() {
    echo '<nav aria-label="breadcrumb">';
    echo '<ol class="breadcrumb">';

    // Home breadcrumb
    echo '<li class="breadcrumb-item"><a href="' . ADMINURL . '">Home</a></li>';

    // Get the current script name and remove the extension
    $current_page = basename($_SERVER['SCRIPT_NAME'], '.php');

    // Capitalize the first letter and display it
    echo '<li class="breadcrumb-item active" aria-current="page">' . ucfirst($current_page) . '</li>';

    echo '</ol>';
    echo '</nav>';
}
?>