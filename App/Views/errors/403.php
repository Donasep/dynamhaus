<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynmahaus | Error 403</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/annonces.css" />
    <link rel="icon" href="/dynamHaus/public/icons/dynamhause_logo.svg" sizes="16x16" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/errorPage.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"/>
  </head>
  <body>
    <header class="layout_header">
        <?php require(dirname(__DIR__).'/nav.php'); ?>
    </header>
    <main class="userPage">
      <section class="errorMessageArea">
        <div class="errorMessageContent">
					<span class="errorNumber">Page 403</span>
          <h1>Accès refusé!</h1>
          <span>Désolé, vous n'êtes pas autorisé à accéder à cette page.</span>
          <a class="goBackBtn" href="/dynamhaus/" type="button">Retourner</a>
				</div>
      </section>
      <section class="imgSection">
				<label>
					<img src="/dynamhaus//public/icons/lock.svg"/>
				</label>
      </section>

    </main>
    <footer class="layout_footer">
      <?php require(dirname(__DIR__).'/footer.php'); ?>
    </footer>
  </body>
</html>
