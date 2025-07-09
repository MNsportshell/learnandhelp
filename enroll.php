<?php

if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/db_configuration.php'; 


$enrollMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['offering_id'])) {
    $offering_id = intval($_POST['offering_id']);
    $user_id = $_SESSION['user_id'] ?? null; 

    if ($user_id) {
       
        $check = $db->prepare("SELECT 1 FROM enrollments WHERE user_id=? AND offering_id=?");
        $check->bind_param('ii', $user_id, $offering_id);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $enrollMsg = '<div class="enroll-msg error">You are already enrolled in this offering.</div>';
        } else {
            $stmt = $db->prepare("INSERT INTO enrollments (user_id, offering_id) VALUES (?, ?)");
            $stmt->bind_param('ii', $user_id, $offering_id);
            if ($stmt->execute()) {
                $enrollMsg = '<div class="enroll-msg success">Enrollment successful!</div>';
            } else {
                $enrollMsg = '<div class="enroll-msg error">Enrollment failed. Please try again.</div>';
            }
            $stmt->close();
        }
        $check->close();
    } else {
        $enrollMsg = '<div class="enroll-msg error">You must be logged in to enroll.</div>';
    }
}

$sql = "
    SELECT o.offering_id, o.Batch_Name, o.day_of_week, o.start_time, o.end_time, o.instructor,
           c.Class_Name, c.Description, c.Image_URL
      FROM offerings o
      JOIN classes c ON o.Class_Id = c.Class_Id
     WHERE c.Status = 'Approved'
  ORDER BY c.Class_Name, o.day_of_week, o.start_time
";
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enroll | Learn and Help</title>
    <link rel="icon" href="images/icon_logo.png" type="image/icon type">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;900&family=Montserrat:wght@300;700;900&display=swap" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body{margin:0;font-family:'Montserrat',sans-serif;background:#f8f8f8;color:#252525;}
        .banner-wrapper{position:relative;width:100vw;left:50%;margin-left:-50vw;height:200px;background:#fff;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);}
        .banner-wrapper img{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;}
        @media(max-width:700px){.banner-wrapper{height:207px;}}
        .page-title{font-size:3em;font-weight:700;text-align:center;margin:60px 0 30px;}
        .classes-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:30px;max-width:1100px;margin:60px auto;padding:0 20px;}
        @media(max-width:700px){.classes-grid{grid-template-columns:1fr;}}
        .class-card{background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;transition:transform .2s;display:flex;flex-direction:column;}
        .class-card:hover{transform:translateY(-6px);}
        .class-image{width:100%;height:200px;object-fit:cover;}
        .class-info{padding:22px;text-align:center;flex-grow:1;display:flex;flex-direction:column;}
        .class-info h3{margin:0 0 12px;font-size:1.35em;font-weight:900;color:#252525;}
        .class-desc{font-size:0.95em;color:#444;flex-grow:1;}
        .offering-details{font-size:0.95em;color:#555;margin:10px 0 15px;}
        .enroll-btn{background:#99d930;color:#252525;font-weight:bold;padding:10px 24px;border:none;border-radius:8px;cursor:pointer;font-size:1em;transition:background .2s;}
        .enroll-btn:hover{background:#7fc41c;}
        .enroll-msg{max-width:600px;margin:30px auto;padding:16px 24px;border-radius:8px;text-align:center;font-size:1.1em;}
        .enroll-msg.success{background:#e6ffd8;color:#256b00;}
        .enroll-msg.error{background:#ffe6e6;color:#b30000;}
    </style>
</head>
<body>
<?php include 'show-navbar.php'; show_navbar(); ?>
<div class="banner-wrapper">
    <img src="images/banner_images/classes/classroom3.jpg" alt="Classroom banner">
</div>
<h1 class="page-title">Enroll</h1>
<?= $enrollMsg ?>
<div class="classes-grid">
<?php
if ($result && $result->num_rows) {
    while($row = $result->fetch_assoc()) {
        $name = htmlspecialchars($row['Class_Name']);
        $desc = htmlspecialchars($row['Description']);
        $img  = htmlspecialchars($row['Image_URL']);
        $batch = htmlspecialchars($row['Batch_Name']);
        $day = htmlspecialchars($row['day_of_week']);
        $start = htmlspecialchars($row['start_time']);
        $end = htmlspecialchars($row['end_time']);
        $instructor = htmlspecialchars($row['instructor']);
        $offering_id = (int)$row['offering_id'];
        ?>
        <div class="class-card">
            <img class="class-image"
                 src="<?= $img ?>"
                 alt="<?= $name ?>"
                 onerror="if(!this.dataset.fallback){this.dataset.fallback='y';this.src='images/class_pics/default.jpg';}">
            <div class="class-info">
                <h3><?= $name ?></h3>
                <p class="class-desc"><?= nl2br($desc) ?></p>
                <div class="offering-details">
                    <strong>Batch:</strong> <?= $batch ?><br>
                    <strong>Day:</strong> <?= $day ?><br>
                    <strong>Time:</strong> <?= $start ?> - <?= $end ?><br>
                    <strong>Instructor:</strong> <?= $instructor ?>
                </div>
                <form method="post" action="enroll.php">
                    <input type="hidden" name="offering_id" value="<?= $offering_id ?>">
                    <button type="submit" class="enroll-btn">Enroll</button>
                </form>
            </div>
        </div>
        <?php
    }
} else {
    echo '<p style="width:100%;text-align:center;font-size:1.2em;color:#777;">No available classes to enroll.</p>';
}
$result?->free();
?>
</div>
<?php $db->close(); include 'footer.php'; ?>
</body>
</html>
