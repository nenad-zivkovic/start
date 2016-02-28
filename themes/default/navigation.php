<?php require_once __DIR__.'/../../loader.php' ?>

        <!-- Static navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand text-uppercase" href="#"><?= APP_NAME ?></a>
                </div>

                <div id="navbar" class="navbar-collapse collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="backend/home.php">Home</a></li>
                        <li><a href="backend/users.php">Users</a></li>
                        <li><a href="backend/logout.php">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>