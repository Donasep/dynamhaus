<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet"
  />
  <link
    rel="icon"
    href="/public/icons/dynamhause_logo.svg"
    sizes="16x16"
  />
  <link rel="stylesheet" href="/public/stylesheets/navbar.css" />
</head>
<body>
  <nav class="navbar">
    <div class="content">
      <div class="start">
        <ul class="links">
          <li class="logo">
            <img
              rel="icon"
              src="/public/icons/dynamhause_logo.svg"
              href="/"
            />
            <a href="/">Dynamhaus</a>
          </li>
        </ul>
      </div>
      <div class="mid">
        <ul class="links">
          <li><a href="/search">Annonces</a></li>
          <li><a href="/blogs">Blogs</a></li>
        </ul>
        <div class="dropdown">
          <button class="dropbtn">Déposer une annonce</button>
          <div class="dropdown-content">
            <a href="/addAd">Vous êtes un particulier</a>
            <a href="/addAd">Vous êtes une agence immobilière</a>
            <a href="/addAd">Vous êtes une résidence étudiante</a>
          </div>
        </div>
      </div>
      <div class="end">
        <a 
          href="/<?php echo isset($_SESSION['token'])? 'signout' : 'signin'; ?>" 
          class="registration_btn">
          <?php echo isset($_SESSION['token'])? 'Se déconnecter' : "S'inscrire / Se connecter"; ?>
        </a>
        <?php if (isset($_SESSION['token'])): ?>
          <a href="/profile" class="profile-icon">
            <img src=<?= !empty($_SESSION['url'])?$_SESSION['url']:"/public/images/annonce_img_5.jpg"?> alt="Profile Icon" />
          </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <script></script>
</body>
</html>
