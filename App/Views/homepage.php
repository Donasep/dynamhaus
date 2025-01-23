<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dynmahaus</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <link rel="stylesheet" href="/public/stylesheets/homepage.css" />
  <link rel="stylesheet" href="/public/stylesheets/annonces.css" />
  <link rel="icon" href="/public/icons/dynamhause_logo.svg" sizes="16x16" />
</head>

<body>
  <main>
    <section class="sectionSearch">
      <img src="/public/images/homepagedude.png" alt="Homme sortant d'un immeuble avec une plante à coté de lui">
      <h1>Trouver le bon toit, pour vivre avec joie.</h1>
      <div class="searchEngine"><?php include("search.php");?></div>
    </section>
    <section class="section_guide">
      <h1>Comment s’en servir <em>Facilement ?</em></h1>
      <p>Parcourez nos annonces pour découvrir une variété de propriétés adaptées à vos besoins et préférences.</p>
      <div class="etapes">
        <div class="step step1">
          <div class="picto">
            <img src="/public/icons/loupe.svg" alt="pictogramme loupe">
          </div>
          <h2>Étape n°1</h2>
          <p>Trouvez le logement qui vous correspond parfaitement et confirmez votre intérêt en quelques clics.</p>
        </div>
        <div class="step step2">
          <div class="picto">
            <img src="/public/icons/check.svg" alt="pictogramme check">
          </div>
          <h2>Étape n°2</h2>
          <p>Trouvez le logement qui vous correspond parfaitement et confirmez votre intérêt en quelques clics.</p>
        </div>
        <div class="step step3">
          <div class="picto">
            <img src="/public/icons/addFriend.svg" alt="pictogramme d'ajout d'ami">
          </div>
          <h2>Étape n°3</h2>
          <p>Ajoutez le bien à vos favoris ou contactez le propriétaire pour organiser une visite.</p>
        </div>
      </div>
    </section>
    <section class="section_annonces">
      <div class="section_annonces_content">
        <h1>Trouvez votre prochain logement à <em>Paris</em></h1>
        <div class="vignettes_annonces">
        <?php 
              $offers = $data['ads']; 
              $imageSources = [
                "/public/images/annonceImg2.jpg",
                "/public/images/annonceImg3.jpeg",
                "/public/images/annonceImg4.png",
                "/public/images/annonceImg5.jpg",
              ];
            ?>
            <?php $index = 0;
            foreach ($offers as $offer): ?>
              <div class="autre_offre" id="autreOffres">
                <div class="autre_offre" id="autreOffreChild">
                  <img src="<?php echo $imageSources[$index % count($imageSources)]; ?>"  class="annonce_cover_autre" id="adImg"/>
                  <p class="addressAutreOffre" id="address"><?php echo $offer['address']; ?></p>
                  <div class="details_one">
                    <img src="/public/icons/bed.svg"/>
                    <p id="bedrooms"><?php echo $offer['numberOfBedrooms']; ?> chambres</p>
                    <img src="/public/icons/bath.svg"/>
                    <p id="bathrooms"><?php echo $offer['numberOfBathrooms']; ?> salle de bains</p>
                    <img src="/public/icons/size.svg"/>
                    <p id="size"><?php echo $offer['surface']; ?>m2</p>
                  </div>
                  <div class="details_two">
                    <p id="price"><?php echo $offer['price']; ?>€</p>
                    <span>Disponible maintenant</span>
                  </div>
                </div>
                </div>
            <?php $index += 1;
          endforeach; ?>
        </div>
        <a href="search" class="bouton_esp">En savoir plus</a>
      </div>
    </section>
    <section class="section_questions">
      <h1>Question les plus <em>Fréquentes</em></h1>
      <div class="questions">
        <h2>Qu’est-ce que le dépôt de garantie ?</h2>
        <p>Le dépôt de garantie est une somme versée par le locataire à DYNAMHAUS pour assurer le respect de ses obligations locatives.</p>
        <h2>Quelles sont les conditions d’admission ?</h2>
        <p>DYNAMHAUS accueille étudiants, jeunes actifs, stagiaires, et salariés sous certaines conditions, notamment un plafond de ressources pour les jeunes actifs.</p>
        <h2>Qu’est-ce qu’un garant ?</h2>
        <p>Un garant s'engage à payer en cas de défaillance du locataire. Cela peut être une personne physique, un organisme comme VISALE ou Garantme, ou une entreprise.</p>
        <h2>Comment réserver un appartement ?</h2>
        <p>Sélectionnez votre résidence et type de logement sur le site, déposez une demande et créez un compte. Vous serez informé de l’avancée de votre dossier par mail.</p>      
      </div>
    </section>
  </main>
  <script src="/public/script/searchSubmit.js"></script>
</body>

</html>