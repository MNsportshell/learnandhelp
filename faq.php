
 <?php
include 'show-navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Frequently Asked Questions | Learn and Help</title>
    <meta charset="UTF-8">
    <link rel="icon" href="images/icon_logo.png" type="image/icon type">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Roboto:wght@300;900&display=swap" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', 'Roboto', sans-serif;
            background: #f8f8f8;
            margin: 0;
            color: #252525;
        }
        .container {
            max-width: 1400px;
            width: 98vw;
            margin: 60px auto 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,.09);
            padding: 44px 1vw 32px 1vw;
        }
        .faq-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5em;
            color: #252525;
            font-weight: 900;
            text-align: center;
            margin-bottom: 36px;
            letter-spacing: 0.01em;
        }
        .faq-list {
            width: 100%;
            margin: 0 auto;
        }
        .accordion {
            background: #fff;
            color: #252525;
            cursor: pointer;
            padding: 24px 40px;
            width: 100%;
            border: none;
            border-radius: 8px;
            text-align: left;
            outline: none;
            font-size: 1.22em;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            margin-bottom: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.18s, color 0.18s;
        }
        .accordion .arrow {
            font-size: 1.4em;
            color: #000;
            margin-left: 18px;
            transition: transform 0.22s cubic-bezier(.4,2,.6,1), color 0.18s;
        }
        .accordion:hover, .accordion:focus {
            background: #99d930;
            color: #252525;
        }
        .accordion:hover .arrow, .accordion:focus .arrow {
            color: #000;
        }
        .accordion.active {
            background: #fff;
            color: #252525;
        }
        .accordion.active .arrow {
            transform: rotate(180deg);
            color: #000;
        }
        .panel {
            padding: 0 40px 20px 40px;
            background: #fff;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.22s cubic-bezier(.4,2,.6,1);
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            margin-bottom: 10px;
            font-size: 1.08em;
            color: #444;
        }
        .panel p {
            margin: 0;
            line-height: 1.7;
        }
        @media (max-width: 1200px) {
            .container { max-width: 99vw; }
            .accordion, .panel { padding-left: 18px; padding-right: 18px; }
        }
        @media (max-width: 900px) {
            .container { padding: 10px 2vw; }
            .faq-title { font-size: 1.6em; }
            .accordion { font-size: 1em; padding: 14px 8px; }
            .panel { padding: 0 8px 12px 8px; }
        }
    </style>
</head>
<body>
<?php show_navbar(); ?>

<div class="container">
    <div class="faq-title">Frequently Asked Questions</div>
    <div class="faq-list">
        <button class="accordion">
            What is Learn and Help?
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>Learn and Help is a beginner-friendly coding course that teaches kids how to program using Python while supporting charitable causes with each enrollment.</p>
        </div>

        <button class="accordion">
            Who is this course for? 
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>Our course is designed for students aged 10–16 with little to no coding experience. No prior knowledge is needed — just curiosity and a willingness to learn!</p>
        </div>

        <button class="accordion">
            What programming language will I learn?
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>We focus on Python, one of the most popular and beginner-friendly programming languages used in web development, game design, automation, and more.</p>
        </div>

        <button class="accordion">
            What is included in the course?
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>You’ll get live sessions, hands-on projects, coding challenges, mentorship, and access to extra learning materials between sessions.</p>
        </div>

        <button class="accordion">
            Are the classes live or recorded?
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>All classes are conducted live over Zoom for real-time interaction. Recordings are available afterward for review.</p>
        </div>

        <button class="accordion">
            What is the “Help” part of Learn and Help?
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>A portion of every enrollment is donated to charitable causes that support education and underprivileged youth around the world.</p>
        </div>

        <button class="accordion">
            How are students supported if they fall behind?
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>We offer one-on-one catch-up sessions and open office hours during the week to help students stay on track.</p>
        </div>

        <button class="accordion">
             Will I get a certificate after completing the course?
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>Yes! Every student receives a personalized certificate of completion at the end of the course.</p>
        </div>

        <button class="accordion">
             How do I sign up? 
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>You can register directly on our website by filling out the enrollment form and selecting your session time.</p>
        </div>
        
        <button class="accordion">
             Who teaches the classes? 
            <span class="arrow">&#9660;</span>
        </button>
        <div class="panel">
            <p>All classes are led by experienced instructors who are passionate about teaching and make coding fun and engaging for kids.</p>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var acc = document.getElementsByClassName("accordion");
    for (var i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight && panel.style.maxHeight !== "0px") {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
});
</script>
<?php include 'footer.php'; ?>
</body>
</html>
