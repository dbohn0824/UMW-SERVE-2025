<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");

    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('universal.inc'); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="footer.css">

        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            body {
                display: flex;
                flex-direction: column;
            }

            .content-wrapper {
                flex: 1;
            }

            footer {
                width: 100%;
            }

            /* Promo Cards Section */
            #promotions-1567 {
                padding: 2rem 1rem;
                background-color: #f8f9fa;
            }

            .cs-container {
                max-width: 1200px;
                margin: 0 auto;
            }

            .cs-card-group {
                list-style: none;
                padding: 0;
                margin: 0;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 2rem;
            }

            .cs-item {
                position: relative;
                overflow: hidden;
                border-radius: 1rem;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }

            .cs-background img {
                display: block;
                width: 100%;
                height: auto;
                border-radius: 1rem 1rem 0 0;
            }

            .cs-content {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                background: rgba(0, 0, 0, 0.6);
                color: #fff;
                padding: 1rem;
                text-align: center;
            }

            .cs-tag {
                font-size: 0.9rem;
                text-transform: uppercase;
                color: #ffc107;
                display: block;
                margin-bottom: 0.5rem;
                font-weight: bold;
            }

            .cs-h2 {
                font-size: 1.5rem;
                margin: 0 0 0.75rem;
            }

            .cs-button-solid {
                display: inline-block;
                padding: 1.0rem 1.75rem; /* increased padding */
                font-size: 1.5rem;        /* increased font size */
                font-weight: 900;
                background-color: #CFA118;
                color: #000;
                text-decoration: none;
                border-radius: 1.0rem;   /* slightly rounder corners */
                transition: background-color 0.3s ease, transform 0.3s ease;
            }


            .cs-button-solid:hover {
                background-color: #CFA118;
                transform: scale(1.1);
            }

            .cs-h2 {
                font-size: 1.5rem;
                margin: 0 0 0.75rem;
                font-weight: 900; /* <- Add this */
            }


            @media (max-width: 600px) {
                .cs-h2 {
                    font-size: 1.25rem;
                }
                .cs-button-solid {
                    font-size: 0.9rem;
                }
            }
        </style>

        <title>SERVE</title>
    </head>
    <body>
        <?php require('welcomeHeader.php'); ?>

        <div class="content-wrapper">
            <section id="promotions-1567">
                <div class="cs-container">
                    <ul class="cs-card-group">
                        <li class="cs-item">
                            <picture class="cs-background">
                                <source media="(max-width: 600px)" srcset="images/serve-backgroundimage-3.jpeg">
                                <source media="(min-width: 601px)" srcset="images/serve-backgroundimage-3.jpeg">
                                <img loading="lazy" decoding="async" src="images/serve-backgroundimage-3.jpeg" width="630" height="354" alt="Volunteer">
                            </picture>
                            <div class="cs-content">
                                <h2 class="cs-h2">Click Here if You're A Volunteer</h2>
                                <a href="volunteerSearch.php" class="cs-button-solid">Volunteer</a>
                            </div>
                        </li>
                        <li class="cs-item">
                            <picture class="cs-background">
                                <source media="(max-width: 600px)" srcset="images/serve-backgroundimage-2.jpeg">
                                <source media="(min-width: 601px)" srcset="images/serve-backgroundimage-2.jpeg">
                                <img loading="lazy" decoding="async" src="images/serve-backgroundimage-2.jpeg" width="630" height="354" alt="Staff">
                            </picture>
                            <div class="cs-content">
                                <h2 class="cs-h2">Click Here to Login to Portal</h2>
                                <a href="login.php" class="cs-button-solid">Staff</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="text-center text-lg-start text-white py-3" style="background-color: #7E0B07; width: 100%;">
            <div class="container p-2 pb-0">
                <section>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto">
                            <h6 class="text-uppercase mb-2" style="font-size: 1rem;">SERVE</h6>
                            <p class="mb-1" style="font-size: 0.9rem;">
                                Stafford Emergency Relief through Volunteer Efforts
                            </p>
                        </div>

                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                            <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Hours</h6>
                            <p class="mb-1" style="font-size: 0.9rem;"><span>Monday – Thursday:</span>
                            <span>11:00am–4:00pm</span></p>
                            <p class="mb-1" style="font-size: 0.9rem;">2nd Wed: until 6:30pm</p>
                            <p class="mb-1" style="font-size: 0.9rem;">Closed on Federal Holidays</p>
                        </div>

                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                            <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Donations</h6>
                            <p class="mb-1" style="font-size: 0.9rem;">Food donations accepted:</p>
                            <p class="mb-1" style="font-size: 0.9rem;">Mon–Thurs: 11am–4pm</p>
                            <p class="mb-1" style="font-size: 0.9rem;">Every 2nd Wed</p>
                            <p class="mb-1" style="font-size: 0.9rem;">Call: (540)288-9603</p>
                        </div>

                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto">
                            <h6 class="text-uppercase mb-2" style="font-size: 1rem;">Contact</h6>
                            <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-home mr-2"></i> 15 Upton Ln, Stafford, VA</p>
                            <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-home mr-2"></i> P.O. Box 1357</p>
                            <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-envelope mr-2"></i> SERVE@SERVE-helps.org</p>
                            <p class="mb-1" style="font-size: 0.9rem;"><i class="fas fa-phone mr-2"></i> 540-288-9603</p>
                        </div>
                    </div>
                </section>

                <hr class="my-2">

                <section class="pt-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-12 text-center">
                            <div style="font-size: 0.85rem;">
                                © 2020 Copyright:
                                <a class="text-white">MDBootstrap.com</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </footer>
        <!-- End Footer -->
    </body>
</html>
