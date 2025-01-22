<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynmahaus | Annonce</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/annonce.css" />
    <link
      rel="icon"
      href="/dynamHaus/public/icons/dynamhause_logo.svg"
      sizes="16x16"
    />
  </head>
  <body>
    <div class="page">
      <div class="annonce_part_1"></div>
      
      <div class="annonce_part_2">
        <div class="gallery">
          <div class="large">
            <img src="/dynamhaus/public/images/annonce_img_1.jpg" />
          </div>
          <div class="small">
            <div class="first_row">
              <img
                class="right_img"
                src="/dynamhaus/public/images/annonce_img_2.jpg"
              />
              <img
                class="left_img"
                src="/dynamhaus/public/images/annonce_img_3.jpg"
              />
            </div>
            <div class="second_row">
              <img
                class="right_img"
                src="/dynamhaus/public/images/annonce_img_4.jpg"
              />
              <img
                class="left_img"
                src="/dynamhaus/public/images/annonce_img_5.jpg"
              />
            </div>
          </div>
        </div>
        
        <?php $ad = $data['ad'];?>
        
        <div class="annonce_content">
          <div class="first_row">
            <div class="title">
              <h1><?php echo $ad['title']; ?> </h1>
              <button>
                <img class="img" src="/dynamhaus/public/icons/heart.svg" />
              </button>
            </div>
            <div>
              <div></div>
              <div></div>
            </div>
          </div>
          <div class="second_row">
            <div class="first_half">
              <img src="/dynamhaus/public/icons/bed.svg"/>
              <p><?php echo $ad['numberOfBedrooms']; ?> chambres</p>
              <img src="/dynamhaus/public/icons/bath.svg"/>
              <p><?php echo $ad['numberOfBathrooms']; ?> salle de bains</p>
              <img src="/dynamhaus/public/icons/size.svg"/>
              <p><?php echo $ad['surface']; ?> m2</p>
            </div>
            <div class="second_half">
              <p><?php echo $ad['address']; ?></p>
            </div>
          </div>
          
          <div class="third_row">
            <div class="first_col">
              <h2>Description</h2>
              <textarea readonly><?php echo $ad['description']; ?></textarea>
              <button>En savoir plus</button>
              <h2>Ce qu'offre ce lieu</h2>
              <div class="offre">
                <div class="first_col_offre">
                  <p><img src="/dynamhaus/public/icons/kitchen.svg"/> Cuisine partagée équipée</p>
                  <p><img src="/dynamhaus/public/icons/charges.svg"/>Charges incluses</p>
                  <p><img src="/dynamhaus/public/icons/furnished.svg"/>Chambres meublées</p>
                  <p><img src="/dynamhaus/public/icons/wifi.svg"/>Wi-Fi haut débit</p>
                  <p><img src="/dynamhaus/public/icons/laundry.svg"/>Service de blanchisserie ou machines à laver</p>
                </div>
                <div class="second_col_offre">
                  <p><img src="/dynamhaus/public/icons/workingspace.svg"/>Espaces de travail ou d’étude</p>
                  <p><img src="/dynamhaus/public/icons/commonarea.svg"/>Zones communes ou sociales</p>
                  <p><img src="/dynamhaus/public/icons/secure.svg"/>Accès sécurisé</p>
                  <p><img src="/dynamhaus/public/icons/maintenance.svg"/>Services de maintenance rapide</p>
                  <p><img src="/dynamhaus/public/icons/animals.svg"/>Animaux acceptés</p>
                </div>
              </div>
            </div>
            
            <div class="second_col">
              <div class="box">
                <div class="content"> 
                  <div class="price">
                    <p class="value">&euro;<?php echo $ad['price']; ?></p>
                    <p class="text">par mois</p>
                  </div>
                  <div class="checkin">
                    <input type="date" class="date_one"/>
                    <input type="date" class="date_two"/>
                  </div>
                  <button>Contacter</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="fourth_row">
        <h2>Autre offres</h2>
        <div class="adsArea">
          <?php 
            $offers = $data['otherAds']; 
            $imageSources = [
              "/dynamhaus/public/images/annonceImg13.jpeg",
              "/dynamhaus/public/images/annonceImg14.webp",
              "/dynamhaus/public/images/annonceImg15.jpg",
              "/dynamhaus/public/images/annonceImg16.jpg",
              "/dynamhaus/public/images/annonceImg17.webp",
              "/dynamhaus/public/images/annonceImg18.avif",
              "/dynamhaus/public/images/annonceImg19.jpeg",
              "/dynamhaus/public/images/annonceImg20.jpg",
              "/dynamhaus/public/images/annonceImg21.jpg",
              "/dynamhaus/public/images/annonceImg22.webp",
              "/dynamhaus/public/images/annonceImg23.jpeg",
              "/dynamhaus/public/images/annonceImg24.jpg",
            ];
            $index = 0;
            foreach ($offers as $offer): ?>
              <div class="autre_offre" id="autreOffres">
                <div class="autre_offre" id="autreOffreChild">
                  <img src="<?php echo $imageSources[$index % count($imageSources)]; ?>" class="annonce_cover_autre" id="adImg"/>
                  <p id="address"><?php echo $offer['address']; ?></p>
                  <div class="details_one">
                    <img src="/dynamhaus/public/icons/bed.svg"/>
                    <p id="bedrooms"><?php echo $offer['numberOfBedrooms']; ?> chambres</p>
                    <img src="/dynamhaus/public/icons/bath.svg"/>
                    <p id="bathrooms"><?php echo $offer['numberOfBathrooms']; ?> salle de bains</p>
                    <img src="/dynamhaus/public/icons/size.svg"/>
                    <p id="size"><?php echo $offer['surface']; ?>m2</p>
                  </div>
                  <div class="details_two">
                    <p id="price"><?php echo $offer['price']; ?>&euro;</p>
                    <span>Disponible maintenant</span>
                  </div>
                </div>
              </div>
            <?php $index += 1; endforeach; ?>
        </div>
      </div>
    </div>
  </body>
</html>
