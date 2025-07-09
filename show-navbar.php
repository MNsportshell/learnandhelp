<?php
include 'show-button.php';

function show_navbar() {
    echo '
    <div class="navbar">
      <div class="navbar-center">
        <a href="home.php" id="nav-logo">
            <img id="logo" src="images/icon_logo.png" alt="Learn N Help Logo">
        </a>
        <div class="dropdown">
          <a href="learn.php" class="dropbtn">Learn</a>
          <div class="dropdown-content">
            <a href="classes.php">Classes</a>
            <a href="instructors.php">Instructors</a>
            <a href="students.php">Students</a>
          </div>
        </div>
        <div class="dropdown">
          <a href="help.php" class="dropbtn">Help</a>
          <div class="dropdown-content">
            <a href="schools.php">Schools</a>
            <a href="books.php">Books</a>
            <a href="suggest_cause.php">Suggest a Cause</a>
          </div>
        </div>
        <a href="blog.php">Blog</a>
       
        <a href="enroll.php" id="register">Enroll Now</a>
      
        <a href="contact_us.php">Contact</a>
        <a href="faq.php">FAQs</a>
        ';
        if (isset($_SESSION['email']) && $_SESSION['role'] == 'admin') {
            echo '<a href="administration.php">Administration</a>';
        }
    echo '
      </div>
      
      <div class="navbar-right">';
        getButton();
    echo '
      </div>
    </div>
    ';
}
?>
