<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynmahaus | Contact Us</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="icon" href="/dynamHaus/public/icons/dynamhause_logo.svg" sizes="16x16" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/contactUs.css" />
  </head>
  <body>
    <div class="contactPage">
      <div class="alert" id="alertVer">
      
      </div>
      <section class="formArea">
        <form class="contactForm">
          <h1>Contactez notre équipe</h1>
          <div class="contactCred">
            <div class="inputArea">
              <h2>Nom</h2>
              <input type="text" placeholder="Votre nom" id="nom" required/>
            </div>
            <div class="inputArea">
              <h2>Prénom</h2>
              <input type="text" placeholder="Votre prénom" id="prénom" required/>
            </div>
          </div>
          <h2>Email</h2>
          <input type="email" placeholder="Votre adresse email" id="email" required/>
          <h2>Sujet</h2>
          <input type="text" placeholder="Votre sujet" id="sujet" required/>
          <h2>Message</h2>
          <textarea placeholder="Votre message" id="message" required></textarea>
          <button id="contactBtn">Envoyer le message</button>
        </form>
      </section>
      <section class="imageArea">
        <img src="/dynamhaus/public/images/patern.jpg"/>
      </section>
    </div>
  </body>
  <script src="/dynamhaus/public/script/contactUs.js"></script>
</html>