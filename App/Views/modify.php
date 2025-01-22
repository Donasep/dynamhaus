<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dynmahaus | Annonce</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/create.css" />
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/imagesPreview.css" />
    <link rel="icon" href="/dynamHaus/public/icons/dynamhause_logo.svg" sizes="16x16" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  </head>
  <body>
    <?php 
    $ad=$data['ad'];
    $gearIntList=explode('|',$ad['gear']);
    $equipments = ['','heater','refrigerator','tv','microwave','stove','washingMachine','smokeDetector','cookingUtensils','wifi'];
    foreach ($equipments as $gearName) {
      $gear[$gearName]=false;
    }
    foreach ($gearIntList as $gearInt) {
      $gear[$equipments[$gearInt]]=true;
    }
    ?>

    <div class="create">
      <div class="imgSection">
          <div class="slider-container">
            <div class="slider">
              <?php 
              foreach($ad['urls'] as $url) {
                echo "<div class='slide'><img src='".$url."' /></div>";
              }
              ?>
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
      <div class="content">
        <form class="createForm" id="create">
          <h1>Modification d'une annonce</h1>
          <div class="createCol">
            <h2>Images</h2>
            <input type="file" accept="image/png, image/jpeg, image/jpg" class="inputfile" multiple="true" id="imgInput"/>
            <label for="imgInput">Upload file(s)</label>
          </div>
          <div class="createCol">
            <h2>Title</h2>
            <input placeholder="Titre" id="title" class="inputTitle" value=<?= "'".$ad['title']."'"?>/>
          </div>
          <div class="createCol">
            <h2>Adresse</h2>
            <input placeholder="Adresse" id="adresse" class="inputTitle" readonly value=<?= "'".$ad['address']."'"?>/>
          </div>
          <div class="createCol">
            <h2>Description</h2>
            <textarea placeholder="Description de l'annonce" id="description" class="inputDesc" ><?= $ad['description']?></textarea>
          </div>
          <div class="createCol">
            <div class="createRow">
              <div class="typeDappart">
                <h2>Type d'appartement</h2>
                  <select id="appartmentType" class="selectAppartment">
                    <option value="">Quelle type?</option>
                    <option value="1" <?= $ad['apartmentType']==1?'selected':''?>>T1</option>
                    <option value="2" <?= $ad['apartmentType']==2?'selected':''?>>T2</option>
                    <option value="3" <?= $ad['apartmentType']==3?'selected':''?>>T3</option>
                    <option value="4" <?= $ad['apartmentType']==4?'selected':''?>>T4</option>
                  </select>
              </div>
              <div class="intInputDiv">
                <h2>Surface</h2>
                <div class="intInput">
                  <input type="number" id="area" value=<?= "'".$ad['surface']."'"?>/>
                  <p>m2</p>
                </div>
              </div>
              <div class="intInputDiv">
                <h2>Étage</h2>
                <div class="intInput">
                  <input type="number" id="floorNumber" value=<?= "'".$ad['floor']."'"?>/>
                </div>
              </div>
              <div class="intInputDiv">
                <h2>Chambre(s)</h2>
                <div class="intInput">
                  <input type="number" id="numberOfRooms" value=<?= "'".$ad['numberOfBedrooms']."'"?>/>
                </div>
              </div>
              <div class="intInputDiv">
                <h2>Salle de bain(s)</h2>
                <div class="intInput">
                  <input type="number" id="salleDeBains" value=<?= "'".$ad['numberOfBathrooms']."'"?>/>
                </div>
              </div>
              <div class="intInputDiv">
                <h2>Date de disponibilité</h2>
                <div class="intInput">
                  <input type="date" id="availabilityDate" value=<?= "'".$ad['availabilityDate']."'"?>/>
                </div>
              </div>
            </div>
          </div>
          <h2>Les équipements</h2>
          <div class="createCol">
            <div class="createRow">
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="heater" <?php echo $gear['heater']?"checked":""?> />
                  <span class="checkmark"></span>
                </label>
                <p>Chauffage</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="refrigerator" <?php echo $gear['refrigerator']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Réfrigérateur</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="tv" <?php echo $gear['tv']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>TV</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="microwave" <?php echo $gear['microwave']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Micro-ondes</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="stove" <?php echo $gear['stove']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Plaques de cuisson</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="washingMachine" <?php echo $gear['washingMachine']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Lave-linge</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="smokeDetector" <?php echo $gear['smokeDetector']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Détecteur de fumée</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="cookingUtensils" <?php echo $gear['cookingUtensils']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Ustensiles de cuisine</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="furnished" <?php echo $ad['furnished']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Chambres meublées</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="wifi" <?php echo $gear['wifi']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Wi-Fi haut débit</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="animals" <?php echo $ad['animals']?"checked":""?>/>
                  <span class="checkmark"></span>
                </label>
                <p>Animaux acceptés</p>
              </div>
            </div>
          </div>
          <div class="createRow">
            <div class="intInputDiv">
              <h2>Loyer par mois</h2>
              <div class="intInput">
                <input type="number" id="rent" value=<?= "'".$ad['price']."'"?>/>
                <p>€</p>
              </div>
            </div>
            <div class="intInputDiv">
              <h2>Frais d'admission</h2>
              <div class="intInput">
                <input type="number" id="admissionFees" value=<?= "'".$ad['applicationFee']."'"?>/>
                <p>€</p>
              </div>
            </div>
            <div class="intInputDiv">
              <h2>Charges</h2>
              <div class="intInput">
                <input type="number" id="charges" value=<?= "'".$ad['charges']."'"?>/>
                <p>€</p>
              </div>
            </div>
            <div class="intInputDiv">
              <h2>Garantie</h2>
              <div class="intInput">
                <input type="number" id="guarantee" value=<?= "'".$ad['warranty']."'"?>/>
                <p>€</p>
              </div>
            </div>
          </div>
          <button class="createBtn" id="create_submit" type="submit">Ajouter</button>
        </form>
      </div>
    </div>
  </body>
  <script src="/dynamhaus/public/script/update.js"></script>
  <script src="/dynamhaus/public/script/imgsPreview.js"></script>
</html>