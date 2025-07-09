<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Instructors | Learn & Help</title>
  <link rel="icon" href="images/icon_logo.png" type="image/png">

 
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;900&display=swap"  rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

  
  <link href="css/main.css" rel="stylesheet">

  <style>
    :root{ --accent:#99D930; --card-shadow:0 4px 6px rgba(0,0,0,.1); }
    body{font-family:'Roboto',sans-serif;background:#fafafa;margin:0;}

    
    .intro-banner{
      background:#1a1a1a;color:#fff;text-align:center;padding:60px 20px 50px;
    }
    .intro-banner h1{
      font-family:'Montserrat',sans-serif;font-size:3rem;font-weight:900;margin:0 0 22px;
    }
    .intro-banner h1 .accent-text{color:var(--accent);}
    .intro-banner p{max-width:820px;margin:0 auto;font-size:1.05rem;line-height:1.65;}

   
    #instructor-search{display:block;margin:35px auto 0;padding:.6rem 1rem;font-size:1rem;
                       max-width:420px;width:90%;border:1px solid #ccc;border-radius:6px;}

   
    .cards-wrapper{max-width:1000px;margin:1.5rem auto;padding:0 20px;display:flex;
                   flex-direction:column;gap:40px}
    .instructor-card{display:flex;flex-direction:row;background:#fff;border-radius:10px;
                     box-shadow:var(--card-shadow);overflow:hidden;transition:transform .25s;}
    .instructor-card:hover{transform:translateY(-5px);}
    .card-img{width:45%;flex-shrink:0;overflow:hidden;}
    .card-img img{width:100%;height:100%;object-fit:cover;display:block;}
    .card-body{width:55%;padding:24px 28px;display:flex;flex-direction:column;
               justify-content:space-between;}
    .card-body h3{font-family:'Montserrat',sans-serif;margin:0 0 12px;font-size:1.6rem;}

    
    .card-body .bio{
      font-size:.85em;         
      line-height:1.6;
      color:#333;
      font-family:'Montserrat',sans-serif;
      white-space:pre-wrap;
    }

    .admin-controls{margin-top:14px;}
    .admin-btn{background:#1976d2;color:#fff;border:none;padding:.25rem .9rem;font-size:.8rem;
               border-radius:20px;cursor:pointer;margin-right:4px;}
    .admin-btn:hover{background:#1259a3;}

    @media(max-width:768px){
      .instructor-card{flex-direction:column;}
      .card-img,.card-body{width:100%;}
      .card-img{height:250px;}
    }
  </style>
</head>
<body>

<?php include 'show-navbar.php'; show_navbar(); ?>

<section class="intro-banner">
  <h1><span class="accent-text">Meet&nbsp;our&nbsp;Team</span></h1>
  <p>
    Share and pass down our knowledge and skills to our students and help them professionally
    with love and compassion to become some genius in software development is the only thing
    that brings smile into our face every day. So, enroll your little ones and your youth in
    one of our schools and let us transform them joyfully into what you’ve never thought of them.
  </p>
</section>

<input id="instructor-search" type="text" placeholder="Search instructors…">

<div class="cards-wrapper" id="cards-wrapper">
<?php
require 'db_configuration.php';
$conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
if ($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }

$res = $conn->query("SELECT * FROM instructor ORDER BY instructor_ID ASC");
while($row = $res->fetch_assoc()):
  $id    = $row['instructor_ID'];
  $first = htmlspecialchars($row['First_name']);
  $last  = htmlspecialchars($row['Last_name']);
  $bio   = nl2br(htmlspecialchars($row['Bio_data']));
  $img   = htmlspecialchars(trim(explode(',', $row['Image'])[0]));
?>
  <article class="instructor-card" data-filter="<?= strtolower("$first $last ".$row['Bio_data']) ?>">
    <div class="card-img"><img src="<?= $img ?>" alt="<?= "$first $last" ?>"></div>
    <div class="card-body">
      <div>
        <h3><?= "$first $last" ?></h3>
        <div class="bio"><?= $bio ?></div>
      </div>
      <?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin'): ?>
      <div class="admin-controls">
        <form action="admin_edit_instructors.php" method="POST" style="display:inline;">
          <input type="hidden" name="instructor_ID" value="<?= $id ?>">
          <button type="submit" name="edit" class="admin-btn">Edit</button>
        </form>
        <form action="admin_delete_instructor.php" method="POST"
              onsubmit="return confirm('Delete this instructor?');" style="display:inline;">
          <input type="hidden" name="instructor_ID" value="<?= $id ?>">
          <button type="submit" name="delete" class="admin-btn">Delete</button>
        </form>
      </div>
      <?php endif; ?>
    </div>
  </article>
<?php endwhile; $conn->close(); ?>
</div>

<?php include 'footer.php'; ?>

<script>
  const qInput=document.getElementById('instructor-search');
  const cards=document.querySelectorAll('.instructor-card');
  qInput.addEventListener('input',e=>{
    const q=e.target.value.toLowerCase().trim();
    cards.forEach(c=>c.style.display=c.dataset.filter.includes(q)?'':'none');
  });
</script>
</body>
</html>
