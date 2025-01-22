<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynmahaus | Annonces</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/annonces.css" />
    <link rel="icon" href="/dynamHaus/public/icons/dynamhause_logo.svg" sizes="16x16" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/annonce.css" />
  </head>
  <body>
    <main class="page">
      <section class="searchArea">
        <img src="/dynamhaus/public/images/annonces_input_bg.svg"/>
        <div class="searchEngine"><?php include("search.php");?></div>
      </section>
      <section class="mainArea">
        <section class="filtersArea">
          <?php include("filters.php");?>
        </section>
        <div class="adsContentArea">
          <section class="adsArea" id="adsArea">
          </section>
          <div class="pagination" id="pagination"></div>
        </div>
      </section>
    </main>
    <script src="/dynamhaus/public/script/searchSubmit.js"></script>
    <script src="/dynamhaus/public/script/adsPagination.js"></script>
    <script>var adsData = <?php echo json_encode($data['ads']); ?>;</script>
  </body>
</html>