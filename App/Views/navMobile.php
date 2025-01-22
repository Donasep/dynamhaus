<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" /> 
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="/dynamhaus/public/icons/dynamhause_logo.svg" sizes="16x16"/>
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/navMobile.css" />
  </head>
  <body>
		<div class="nav-bar">
			<a href="/dynamHaus/" class="logo"><img src="/dynamhaus/public/icons/dynamhause_logo.svg"/>Dynamhaus</a>
			<input id="menu-toggler" type="checkbox" class="menu-toggler">
			<label for="menu-toggler" class="show-menu">
			<span></span>
			</label>
			<nav class="nav">
				<ul class="nav__menu">
					<li class="nav__item">
						<img src="/dynamhaus/public/icons/homeIcon.svg"/>
						<a href="search" class="nav__link">Annonces</a>
					</li>
					<li class="nav__item">
						<img src="/dynamhaus/public/icons/blog.svg"/>
						<a href="blogs" class="nav__link">Blogs</a>
					</li>
					<button class="dropdown-btn">
						<img src="/dynamhaus/public/icons/rightArrow.svg"/>
						Déposer une annonce</button>
					<div class="dropdown-container">
						<a href="#">Link 1</a>
						<a href="#">Link 2</a>
						<a href="#">Link 3</a>
					</div>
				</ul>
			</nav>
		</div>
  </body>
	<script>
		function myFunction() {
			var x = document.getElementById("myLinks");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
			}
		}
		var dropdown = document.getElementsByClassName("dropdown-btn");
		var i;
		for (i = 0; i < dropdown.length; i++) {
			dropdown[i].addEventListener("click", function() {
				this.classList.toggle("active");
				var dropdownContent = this.nextElementSibling;
				if (dropdownContent.style.display === "block") {
					dropdownContent.style.display = "none";
				} else {
					dropdownContent.style.display = "flex";
				}
			});
		}
	</script>
</html>
