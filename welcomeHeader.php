<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHP-Homebase, which is free software. It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/> for more information).
 */
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">

    <!-- Set serif font for entire page -->
    <style>
        body {
            font-family: 'Lora', serif;
        }
        .custom-navbar {
            background-color: #fff;
            padding-top: 15px;
            padding-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
        }

        .logo-img {
            width: 100px;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        #vms-logo {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            font-family: 'Lora', serif;
        }

        body {
            font-family: 'Lora', serif;
            padding-top: 130px; /* Adjust to match header height */
        }

    </style>
    <title>SERVE</title> <!-- Added a title for the page -->
</head>

<header>
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="images/SERVE_logo.png" alt="SERVE Logo" class="logo-img mr-3">
                <span id="vms-logo" style="font-weight: bold;"></span>
            </a>
        </div>
    </nav>
</header>
