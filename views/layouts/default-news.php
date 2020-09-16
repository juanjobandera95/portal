<!DOCTYPE html>
<html lang="es">

<link>
<head>
    <meta charset="utf-8">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="/locales/css/menu.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Xabia que bonica eres</title>
    <style>


        @media all and (min-width: 992px) {
            .navbar .nav-item .dropdown-menu{ display: none; }
            .navbar .nav-item:hover .nav-link{ color: #3db6c6;  }
            .navbar .nav-item:hover .dropdown-menu{ display: block; }
            .navbar .nav-item .dropdown-menu{ margin-top:0; }
        }
    </style>
</head>
<body>

<?php
require_once("../partials/header.partial.php");
?>

<section class="container-fluid ">
    <img src="../montgo.jpg">
    <?php
    require_once("../partials/sub-header.php");
    ?>
    <br>

    <?= $mainContent; ?>

    <br>
</section>

</body>

</html>


