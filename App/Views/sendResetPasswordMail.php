
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Confirmation de l'Adresse Email</title>
	<link rel="stylesheet" href="/dynamhaus/public/stylesheets/sendResetPasswordMail.css" />
	<link rel="stylesheet" href="/dynamhaus/public/stylesheets/signup.css" />
</head>
<body>
<div class="mainAreaDona"> 
	<main class="userPage">
		<section class="formSection">
			<form class="signupForm" id="signinForm">
				<h1>Confirmer votre Email</h1>
				<h2>Veuillez entrer votre email pour recevoir un lien de confirmation.</h2>
				<input type="email" placeholder="Votre adresse email" id="userEmail"/>
				<label id="errorMessage"></label>
				<button class="signinBtn" id="resetEmailPassLink" type="button">Envoyer le Lien</button>
			</form>
		</section>
		<section class="imgSection">
			<img src="/dynamhaus/public/images/Simple Shiny.svg"/>
		</section>
	</main>
</div>
<script src="/dynamhaus/public/script/resetPasswordEmail.js"></script>
</body>
</html>
