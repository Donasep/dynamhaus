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
    <div class="create">
      <div class="imgSection">
          <div class="slider-container">
            <div class="slider"></div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
          </div>
          <div class="dots-container"></div>
      </div>
      <div class="content">
        <form class="createForm" id="create">
          <h1>Création d'une annonce</h1>
          <div class="createCol">
            <h2>Images</h2>
            <input type="file" accept="image/png, image/jpeg, image/jpg" class="inputfile" multiple="true" id="imgInput"/>
            <label for="imgInput">Upload file(s) [5Mo par fichier]</label>
          </div>
          <div class="createCol">
            <h2>Title</h2>
            <input placeholder="Titre" id="title" class="inputTitle"/>
          </div>
          <div class="createCol">
            <h2>Adresse</h2>
            <input placeholder="Adresse" id="adresse" class="inputTitle"/>
            <div class="suggestedAd" id="suggestedAddresses" style="display: none;">
            </div>
          </div>
          <div class="createCol">
            <h2>Description</h2>
            <textarea placeholder="Description de l'annonce" id="description" class="inputDesc"></textarea>
          </div>
          <div class="createCol">
            <div class="createRow">
              <div class="typeDappart">
                <h2>Type d'appartement</h2>
                  <select id="appartmentType" class="selectAppartment">
                    <option value="">Quelle type?</option>
                    <option value="1">T1</option>
                    <option value="2">T2</option>
                    <option value="3">T3</option>
                    <option value="4">T4</option>
                  </select>
              </div>
              <div class="intInputDiv">
                <h2>Surface</h2>
                <div class="intInput">
                  <input type="number" id="area"/>
                  <p>m2</p>
                </div>
              </div>
              <div class="intInputDiv">
                <h2>Étage</h2>
                <div class="intInput">
                  <input type="number" id="floorNumber"/>
                </div>
              </div>
              <div class="intInputDiv">
                <h2>Chambre(s)</h2>
                <div class="intInput">
                  <input type="number" id="numberOfRooms"/>
                </div>
              </div>
              <div class="intInputDiv">
                <h2>Salle de bain(s)</h2>
                <div class="intInput">
                  <input type="number" id="salleDeBains"/>
                </div>
              </div>
              <div class="intInputDiv">
                <h2>Date de disponibilité</h2>
                <div class="intInput">
                  <input type="date" id="availabilityDate"/>
                </div>
              </div>
            </div>
          </div>
          <h2>Les équipements</h2>
          <div class="createCol">
            <div class="createRow">
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="heater" />
                  <span class="checkmark"></span>
                </label>
                <p>Chauffage</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="refrigerator" />
                  <span class="checkmark"></span>
                </label>
                <p>Réfrigérateur</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="tv" />
                  <span class="checkmark"></span>
                </label>
                <p>TV</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="microwave" />
                  <span class="checkmark"></span>
                </label>
                <p>Micro-ondes</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="stove" />
                  <span class="checkmark"></span>
                </label>
                <p>Plaques de cuisson</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="washingMachine" />
                  <span class="checkmark"></span>
                </label>
                <p>Lave-linge</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="smokeDetector" />
                  <span class="checkmark"></span>
                </label>
                <p>Détecteur de fumée</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="cookingUtensils" />
                  <span class="checkmark"></span>
                </label>
                <p>Ustensiles de cuisine</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="furnished" />
                  <span class="checkmark"></span>
                </label>
                <p>Chambres meublées</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="wifi" />
                  <span class="checkmark"></span>
                </label>
                <p>Wi-Fi haut débit</p>
              </div>
              <div class="checkbtn">
                <label class="choice">
                  <input type="checkbox" value="animals" />
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
                <input type="number" id="rent"/>
                <p>€</p>
              </div>
            </div>
            <div class="intInputDiv">
              <h2>Frais d'admission</h2>
              <div class="intInput">
                <input type="number" id="admissionFees"/>
                <p>€</p>
              </div>
            </div>
            <div class="intInputDiv">
              <h2>Charges</h2>
              <div class="intInput">
                <input type="number" id="charges"/>
                <p>€</p>
              </div>
            </div>
            <div class="intInputDiv">
              <h2>Garantie</h2>
              <div class="intInput">
                <input type="number" id="guarantee"/>
                <p>€</p>
              </div>
            </div>
          </div>
          <button class="createBtn" id="create_submit" type="submit">Ajouter</button>
        </form>
      </div>
    </div>
  </body>
  <script src="/dynamhaus/public/script/create.js"></script>
  <script src="/dynamhaus/public/script/imgsPreview.js"></script>
</html>