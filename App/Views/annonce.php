<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynamhaus | Annonce</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/annonce.css" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/imagesPreview.css" />
    <link
      rel="icon"
      href="/dynamHaus/public/icons/dynamhause_logo.svg"
      sizes="16x16"
    />
  </head>
  <body>
    <?php $ad = $data['ad'];?>
    <div class="page">
      <div class="annonce_part_1"></div>
      <div class="annonce_part_2">
        <div class="imgSection">
          <div class="slider-container">
            <div class="slider">
              <?php 
              foreach($ad['urls'] as $url) { echo "<div class='slide'><img src='".$url."' /></div>";}
              ?>
            </div>
            <div id="myModal" class="modal">
              <span class="close">&times;</span>
              <img class="modal-content" id="img01">
            </div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
          </div>
          <div class="dots-container">
            <?php 
            $index=0;
            foreach($ad['urls'] as $url) {
                  echo "<span class='dot' data-index=$index></span>";
                  $index+=1;
                }
              ?>
          </div>
        </div>
        <input type="file" accept="image/png, image/jpeg, image/jpg" multiple="true" id="imgInput"/>
        <div class="annonce_content">
          <div class="first_row">
            <div class="title">
              <h1><?php echo $ad['title']; ?> </h1>
              <div style="display: flex; gap: 5px;"> 
                <button id="notifBtn" class=<?php echo $ad['favorite']? 'notifBtnActive' : 'notifBtn';?>>
                  <img class="img" id="notifImg" src="<?php echo ($ad['favorite']) ? '/dynamhaus/public/icons/notifActive.svg' : '/dynamhaus/public/icons/notifInactive.svg'; ?>" />
                </button>
                <button id="favBtn" class=<?php echo $ad['favorite']? 'favBtnActive' : 'favBtn';?>>
                  <img class="img" id="favImg" src="<?php echo ($ad['favorite']) ? '/dynamhaus/public/icons/heartWhite.svg' : '/dynamhaus/public/icons/heart.svg'; ?>" />
                </button>
              </div>
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
              <a target="_blank" href="http://maps.google.com/?q=<?php echo $ad['address']; ?>"><?php echo $ad['address']; ?></a>
            </div>
          </div>
          <div class="third_row">
            <div class="first_col">
              <h2>Description</h2>
              <textarea readonly><?php echo $ad['description']; ?></textarea>
              <button>En savoir plus</button>
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
          <div class="fourth_row">
            <h2>Ce qu'offre ce lieu</h2>
              <div class="offre">
                <div class="first_col_offre">
                  <p><img src="/dynamhaus/public/icons/kitchen.svg"/>Chauffage <?php echo str_contains($ad['gear'], '1')? 'inclue' : 'non inclue';?></p>
                  <p><img src="/dynamhaus/public/icons/fridge.svg"/>Réfrigérateur <?php echo str_contains($ad['gear'], '2')? 'inclue' : 'non inclue';?></p>
                  <p><img src="/dynamhaus/public/icons/tv.svg"/>TV <?php echo str_contains($ad['gear'], '3')? 'inclue' : 'non inclue';?></p>
                  <p><img src="/dynamhaus/public/icons/stove.svg"/>Plaques de cuisson <?php echo str_contains($ad['gear'], '5')? 'inclue' : 'non inclue';?></p>
                  <p><img src="/dynamhaus/public/icons/laundry.svg"/>Lave-linge <?php echo str_contains($ad['gear'], '6')? 'inclue' : 'non inclue';?></p>
                </div>
                <div class="second_col_offre">
                  <p><img src="/dynamhaus/public/icons/smoke.svg"/>Détecteur de fumée <?php echo str_contains($ad['gear'], '7')? 'inclue' : 'non inclue';?></p>
                  <p><img src="/dynamhaus/public/icons/kitchenUt.svg"/>Ustensiles de cuisine <?php echo str_contains($ad['gear'], '8')? 'inclue' : 'non inclue';?></p>
                  <p><img src="/dynamhaus/public/icons/furnished.svg"/>Apartement <?php echo $ad['furnished']? 'meublé' : 'non meublé';?></p>
                  <p><img src="/dynamhaus/public/icons/wifi.svg"/>Wi-Fi haut débit <?php echo str_contains($ad['gear'], '9')? 'inclue' : 'non inclue';?></p>
                  <p><img src="/dynamhaus/public/icons/animals.svg"/>Animaux <?php echo $ad['animals']?  'acceptés' : 'interdits' ;?></p>
                </div>
              </div>
          </div>
          <div class="fifth_row">
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
      </div>
    </div>
  </body>
  <script src="/dynamhaus/public/script/ad.js"></script>
  <script src="/dynamhaus/public/script/imgsPreview.js"></script>
  </html>
