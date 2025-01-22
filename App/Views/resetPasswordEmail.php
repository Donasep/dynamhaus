<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynmahaus | Annonces</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/annonces.css" />
    <link rel="icon" href="/dynamHaus/public/icons/dynamhause_logo.svg" sizes="16x16" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/signup.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <main class="resetPassPage">
      <section class="resetPassSection">
        <form class="signupForm" id="signinForm">
          <h1>Réinitialiser le mot de passe</h1>
          <h2>Nouveau mot de passe</h2>
          <div class="passwordWrapper">
            <input placeholder="Votre mot de passe" id="userPassword" type="password" class="passwordInput"/>
            <a id="toggleButton" class="passwordToggleBtn" onclick="togglePasswordVisibility()">
              <img id="toggleBtnImg" src="/dynamHaus/public/icons/closedEye.svg"/>
            </a>
          </div>
          <h2>Confirmer le nouveau mot de passe</h2>
          <div class="passwordWrapper">
            <input placeholder="Votre mot de passe" id="confirmUserPassword" type="password" class="passwordInput"/>
            <a id="toggleButton" class="passwordToggleBtn" onclick="toggleConfirmPasswordVisibility()">
              <img id="toggleConfirmButton" src="/dynamHaus/public/icons/closedEye.svg"/>
            </a>
          </div>
          <label id="errorMessage"></label>
          <button class="signinBtn" id="resetPasswordBtn" type="button">Réinitialiser mon mot de passe</button>
        </form>
      </section>
    </main>
    <script src="/dynamhaus/public/script/resetPassword.js"></script>
    <script src="/dynamhaus/public/script/resetPasswordEmail.js"></script>
    <script src="/dynamhaus/public/script/passwordVisibility.js"></script>
  </body>
</html>