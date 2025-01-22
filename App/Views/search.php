<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynmahaus | Moteur de recherche</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/search.css" />
    <link
      rel="icon"
      href="/dynamhaus/public/icons/dynamhause_logo.svg"
      sizes="16x16"
    />
  </head>
  <body>
    <form class="searchForm"  id="searchForm">
      <input class="villeInput" placeholder="Ville" id="ville"/>
      <input class="addressInput" placeholder="Où souhaitez-vous habiter ?" id="address"/>
      <input class="dateInput" placeholder="Date d'emménagement" type="date" id="moveInDate"/>
      <div class="budgetInput">
        <input type="number" id="minBudget" placeholder="Min budget"/>
      </div>
      <div class="budgetInput">
        <input class="budgetInput" type="number" id="maxBudget" placeholder="Max budget"/>
      </div>
      <button class="search_btn" type="submit" id="submit">
        <img src="/dynamhaus/public/icons/Search Vector Icon.svg" />
        <p>Chercher</p>
      </button>
    </form>
  </body>
  <script src="/dynamhaus/public/script/searchSubmit.js"></script>
</html>
