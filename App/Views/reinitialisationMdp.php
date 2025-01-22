
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du Mot de Passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .container h1 {
            color: #0056b3; 
            font-size: 24px;
            margin-bottom: 20px;
        }

        .container p {
            color: #555555;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .container input[type="email"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .container button {
            background-color: #0056b3; 
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .container button:hover {
            background-color: #004099; 
        }

        .container .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Réinitialisation mot de passe</h1>
        <p>Veuillez entrer votre adresse email pour recevoir un lien de réinitialisation</p>
        <form action="reset_password_request.php" method="POST">
            <input type="email" name="email" placeholder="Votre email" required>
            <button type="submit">Envoyer</button>
        </form>
        
    </div>
</body>
</html>
