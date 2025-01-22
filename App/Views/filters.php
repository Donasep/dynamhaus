<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dynmahaus | Annonces</title>
  <link rel="stylesheet" href="/dynamHaus/public/stylesheets/filters.css" />
  <link rel="icon" href="/dynamHaus/public/icons/dynamhause_logo.svg" sizes="16x16" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <div class="filters_container">

    <div class="filter">
      <div class="filter_title">
        <h1>Type de logement</h1>
        <button><img src="/dynamhaus/public/icons/Down Arrow Icon.svg" /></button>
      </div>
      <div class="filter_content">
        <label class="choice">T1<input type="checkbox" value="T1" /><span class="checkmark"></span></label>
        <label class="choice">T2<input type="checkbox" value="T2" /><span class="checkmark"></span></label>
        <label class="choice">T3<input type="checkbox" value="T3" /><span class="checkmark"></span></label>
        <label class="choice">T4<input type="checkbox" value="T4" /><span class="checkmark"></span></label>
        <label class="choice">T5<input type="checkbox" value="5" /><span class="checkmark"></span></label>
      </div>
    </div>

    <div class="filter">
      <div class="filter_title">
        <h1>Surfaces et pièces</h1>
        <button><img src="/dynamhaus/public/icons/Down Arrow Icon.svg" /></button>
      </div>
      <div class="filter_content">
        <div class="slider">
          <div class="whynotworking">
            <p class="filter_header_title">Minimum</p>
            <p class="filter_header_value" id="minSurfaceValue">0m²</p>
          </div>
          <div class="filter_slider">
            <div class="line_min_surface" id="minSurfaceLine"></div>
            <input type="range" class="input_surface_min_range" min="0" max="200" step="1" value="0" id="minSurfaceInput"/>
          </div>
        </div>
        <div class="slider">
          <div class="whynotworking">
            <p class="filter_header_title">Maximum</p>
            <p class="filter_header_value" id="maxSurfaceValue">0m²</p>
          </div>
          <div class="filter_slider">
            <div class="line_max_surface" id="maxSurfaceLine"></div>
            <input type="range" class="input_surface_max_range" min="0" max="200" step="1" value="0" id="maxSurfaceInput"/>
          </div>
        </div>
        <div class="slider">
          <div class="whynotworking">
            <p class="filter_header_title">Nombre de chambres</p>
            <p class="filter_header_value" id="nbRoomsValue">0</p>
          </div>
          <div class="filter_slider">
            <div class="line_chambres" id="nbRoomsLine"></div>
            <input type="range" class="input_chambres_range" min="0" max="10" step="1" value="0" id="nbRoomsInput"/>
          </div>
        </div>
      </div>
    </div>

    <div class="filter">
      <div class="filter_title">
        <h1>Durée</h1>
        <button><img src="/dynamhaus/public/icons/Down Arrow Icon.svg" /></button>
      </div>
      <div class="filter_content">
        <div class="whynotworking">
          <p id="durationValue">0 mois</p>
        </div>
        <div class="filter_slider">
          <div class="line_durée" id="durationLine"></div>
          <input type="range" class="input_durée_range" min="0" max="36" step="1" value="0" id="durationInput"/>
        </div>
      </div>
    </div>

    <div class="filter">
      <div class="filter_title">
        <h1>Autres critères</h1>
        <button><img src="/dynamhaus/public/icons/Down Arrow Icon.svg" /></button>
      </div>
      <div class="filter_content">
        <label class="choice">Meublé<input type="checkbox" checked value="furnished" /><span class="checkmark"></span></label>
        <label class="choice">Animaux autorisés<input type="checkbox" value="animals" /><span class="checkmark"></span></label>
        <label class="choice">Charges<input type="checkbox" value="charges" /><span class="checkmark"></span></label>
      </div>
    </div>

    <div class="filter">
      <div class="filter_title">
        <h1>Proposé par</h1>
        <button><img src="/dynamhaus/public/icons/Down Arrow Icon.svg" /></button>
      </div>
      <div class="filter_content">
        <label class="choice">Agence immobilière<input type="checkbox" checked value="1" /><span class="checkmark"></span></label>
        <label class="choice">Résidence étudiante<input type="checkbox" value="2" /><span class="checkmark"></span></label>
        <label class="choice">Particulier<input type="checkbox" value="0" /><span class="checkmark"></span></label>
      </div>
    </div>

  </div>
  <script src="/dynamhaus/public/script/searchSliders.js"></script>
</body>
</html>
