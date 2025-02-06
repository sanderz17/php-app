<?php
    include "connect.php";
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage | Search</title>
        <?php include 'front_include/css.php'; ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    </head>
    <body>

    <div class="header--mobile-search">
        <div class="ps-search--mobile">
             <form class="ps-form--search-mobile" method="GET">
                 <div class="form-group--nest">
                       <input type="text" aria-label="Search" id="search-mobile" name="q" class="form-control w-100" placeholder="I'm looking for" autocomplete="off">
                       <button><i class="fas fa-search"></i></button>
                       <span class="icon-close"><a href="javascript:void(0)" onclick="history.back()">Cancel</a></span>
                 </div>
             </form>
        </div>
    </div>
      
    </body>
</html>