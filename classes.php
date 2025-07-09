<?php

if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/db_configuration.php';   // provides $db
session_write_close();


$perPage = 10;
$page = (isset($_GET['page']) && ctype_digit($_GET['page']) && $_GET['page'] > 0)
        ? (int)$_GET['page'] : 1;

$totalRows  = $db->query("SELECT COUNT(*) AS cnt FROM classes")
                 ->fetch_assoc()['cnt'];
$totalPages = max(1, (int)ceil($totalRows / $perPage));
$page       = min($page, $totalPages);
$offset     = ($page - 1) * $perPage;


$sql = "
  SELECT Class_Id, Class_Name, Description, Image_URL
    FROM classes
ORDER BY Class_Name
   LIMIT $perPage OFFSET $offset";
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Classes | Learn and Help</title>


  <link rel="icon" href="images/icon_logo.png" type="image/icon type">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;900&family=Montserrat:wght@300;700;900&display=swap" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">

  <style>
    body{margin:0;font-family:'Montserrat',sans-serif;background:#f8f8f8;color:#252525;}

    
    .banner-wrapper{position:relative;width:100vw;left:50%;margin-left:-50vw;height:200px;background:#fff;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);}
    .banner-wrapper img{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;}
    @media(max-width:700px){.banner-wrapper{height:207px;}}

    
    .page-title{
      font-family:'Montserrat',sans-serif;
      font-size:3em;          
      font-weight:700;        
      text-align:center;
      margin:60px 0 30px;
      color:#252525;
    }

    
    .classes-grid{
      display:grid;
      grid-template-columns:repeat(2,1fr);
      gap:30px;
      max-width:1100px;
      margin:60px auto;
      padding:0 20px;
    }
    @media(max-width:700px){.classes-grid{grid-template-columns:1fr;}}

    .class-card{
      background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,.08);
      overflow:hidden;transition:transform .2s;display:flex;flex-direction:column;
    }
    .class-card:hover{transform:translateY(-6px);}
    .class-image{width:100%;height:200px;object-fit:cover;}
    .class-info{padding:22px;text-align:center;flex-grow:1;display:flex;flex-direction:column;}
    .class-info h3{margin:0 0 12px;font-size:1.35em;font-weight:900;color:#252525;}
    .class-desc{font-size:0.95em;color:#444;flex-grow:1;}

    /* pager links */
    .pager{text-align:center;font-weight:bold;margin:40px 0;}
    .pager a{margin:0 18px;color:#252525;text-decoration:none;}
    .pager a:hover{color:#99d930;}
  </style>
</head>
<body>

<?php include 'show-navbar.php'; show_navbar(); ?>

<div class="banner-wrapper">
  <img src="images/banner_images/classes/classroom3.jpg" alt="Classroom banner">
</div>

<h1 class="page-title">Classes</h1>

<div class="classes-grid">
<?php
if ($result && $result->num_rows){
  while($row=$result->fetch_assoc()){
    $name = htmlspecialchars($row['Class_Name']);
    $desc = htmlspecialchars($row['Description']);
    $img  = htmlspecialchars($row['Image_URL']);
    ?>
    <div class="class-card">
      <img class="class-image"
           src="<?= $img ?>"
           alt="<?= $name ?>"
           onerror="if(!this.dataset.fallback){this.dataset.fallback='y';this.src='images/class_pics/default.jpg';}">
      <div class="class-info">
        <h3><?= $name ?></h3>
        <p class="class-desc"><?= nl2br($desc) ?></p>
      </div>
    </div>
    <?php
  }
}else{
  echo '<p style="width:100%;text-align:center;font-size:1.2em;color:#777;">No classes found.</p>';
}
$result?->free();
?>
</div>

<?php if ($totalPages > 1): ?>
  <div class="pager">
    <?php if ($page > 1): ?>
      <a href="?page=<?= $page-1 ?>">&laquo; Previous</a>
    <?php endif; ?>
    Page <?= $page ?> of <?= $totalPages ?>
    <?php if ($page < $totalPages): ?>
      <a href="?page=<?= $page+1 ?>">Next &raquo;</a>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php $db->close(); include 'footer.php'; ?>
</body>
</html>
