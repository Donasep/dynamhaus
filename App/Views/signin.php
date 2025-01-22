<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynmahaus | Annonces</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
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
    <main class="userPage">
      <div class="alert" id="alertVer">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        E-mail non vérifié. Vérifiez votre boîte mail.
      </div>
      <section class="formSection">
        <form class="signupForm" id="signinForm">
          <h1>Se connecter</h1>
          <h2>Adresse email</h2>
          <input type="email" placeholder="Votre mot de passe" id="userEmail"/>
          <h2>Mot de passe</h2>
          <div class="passwordWrapper">
            <input placeholder="Votre mot de passe" id="userPassword" type="password" class="passwordInput"/>
            <a id="toggleButton" class="passwordToggleBtn" onclick="togglePasswordVisibility()">
              <img id="toggleBtnImg" src="/dynamHaus/public/icons/closedEye.svg"/>
            </a>
          </div>
          <p class="reinBtn">Mot de passe oublier ?<a href="/dynamHaus/resetPassword">Réinitialiser</a></p>
          <label id="errorMessage"></label>
          <button class="signinBtn" id="signinBtn" type="button">Se connecter</button>
          <div class="oucontent">
            <hr />
            <span className=" font-bold">Ou</span>
            <hr />
          </div>
          <a class="googleBtn" href="googleSignin">
            <span class="spanbtn">Se connecter avec</span>
            <img class="googleLogo" src="/dynamhaus/public/icons/7123025_logo_google_g_icon.svg"/>
          </a>
          <p class="signupBtnPara">Vous n'avez pas un compte ?<a href="/dynamHaus/signup">Inscrivez-vous</a></p>
        </form>
      </section>
      <section class="imgSection">
        <img src="/dynamhaus/public/images/Simple Shiny.svg"/>
      </section>
    </main>
    <script src="/dynamhaus/public/script/signin.js"></script>
    <script src="/dynamhaus/public/script/passwordVisibility.js"></script>
  </body>
</html>