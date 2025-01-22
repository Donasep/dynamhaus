<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Dynmahaus | Annonces</title>
      <meta name="description" content="" />
      <meta name="keywords" content="" />
      <link
         rel="icon"
         href="/dynamHaus/public/icons/dynamhause_logo.svg"
         sizes="16x16"
      />
   </head>
   <body>
      <div class="layout_header" id="layoutHeader">
         <div id="desktopNav" style="display: none;">
         <?php require('nav.php'); ?>
      </div>
      <div id="mobileNav" style="display: none;">
         <?php require('navMobile.php'); ?>
      </div>
      </div>
      <div class="layout_main">
         <?php require $templatePath ?>
      </div>
      <div class="layout_footer">
         <?php require('footer.php');?>
      </div>
   </body>
   <script>
    let mobileWidth = window.innerWidth < 600;
   let desktopNav = document.getElementById('desktopNav');
   let mobileNav = document.getElementById('mobileNav');

   if (mobileWidth) {
      mobileNav.style.display = 'block';
   } else {
      desktopNav.style.display = 'block';
   }
   </script>
</html>
