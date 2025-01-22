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
  <link rel="stylesheet" href="/dynamhaus/public/stylesheets/signup.css" />
  <link rel="stylesheet" href="/dynamhaus/public/stylesheets/phoneVer.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<?php
$recaptcha_site_key = $_ENV['RECAPTCHA_SITE_KEY'];
?>
<main class="userPage">
  <section class="formSection">
    <form class="signupForm" id="signupForm" action="">
      <h1>S'inscrire</h1>
      <div class="usernameParent">
        <div class="usernameChild">
          <h2>Nom</h2>
          <input placeholder="Votre nom" id="userLastName" type="text"/>
        </div>
        <div class="usernameChild">
          <h2>Prénom</h2>
          <input placeholder="Votre prénom" id="userFirstName"/>
        </div>
      </div>
      <h2>Adresse email</h2>
      <input type="email" placeholder="Votre adresse email" id="userEmail"/>
      <h2>Mot de passe</h2>
      <input placeholder="Votre mot de passe" id="userPassword"/>
      <div class="regexArea">
        <p class="regexVer" id="upperCaseRegex"><img src="/dynamhaus/public/icons/RedX.svg"/>Au moins une lettre majuscule</p>
        <p class="regexVer" id="lowerCaseRegex"><img src="/dynamhaus/public/icons/RedX.svg"/>Au moins une lettre minuscule</p>
        <p class="regexVer" id="numberRegex"><img src="/dynamhaus/public/icons/RedX.svg"/>Au moins un chiffre</p>
        <p class="regexVer" id="specialCharaceterRegex"><img src="/dynamhaus/public/icons/RedX.svg"/>Au moins un caractère spécial</p>
        <p class="regexVer" id="lengthRegex"><img src="/dynamhaus/public/icons/RedX.svg"/>Au moins 8 caractères</p>
      </div>
      <h2>Confirmer votre mot de passe</h2>
      <input placeholder="Votre mot de passe" id="userConfirmPassword"/>
      <label id="errorMessageOne"></label>
      <label id="errorMessageTwo"></label>
      <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
      <button class="signinBtn" id="signinBtn" type="button">S'inscrire</button>
      <div class="oucontent">
        <hr />
        <span class="font-bold">Ou</span>
        <hr />
      </div>
      <a class="googleBtn" href="googleSignup">
        <span class="spanbtn">S'inscrire avec</span>
        <img class="googleLogo" src="/dynamhaus/public/icons/7123025_logo_google_g_icon.svg"/>
      </a>
      <p class="signinBtnPara">Vous avez un compte ?<a href="signin">Connectez-vous</a></p>
    </form>
  </section>
  <section class="imgSection">
    <img src="/dynamhaus/public/images/Simple Shiny.svg"/>
  </section>
</main>
<script src="/dynamhaus/public/script/signup.js"></script>
<script src="/dynamhaus/public/script/regexCheck.js"></script>
<script src="/dynamhaus/public/script/countryCode.js"></script>
</body>
</html>
