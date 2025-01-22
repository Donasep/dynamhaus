<?php
// Exemple de données d'annonces de logement
$offers=$data['ads']
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="/dynamhaus/public/stylesheets/profil.css"></link>
</head>
<body>
    <div class="container">
        
        <div class="profile-header">
            <img src=<?php
            if (isset($_SESSION['url'])) {
                echo $_SESSION['url'];
            } else {
                echo "";
            }
            ?> alt="Photo de profil"/> 
            <h1>Mon compte</h1>
        </div>

        
        <form class="account-section" id="account-form">
            <h2>Informations personnelles</h2>
            <div class="form-group">
                <div>
                    <label for="nom">Nom</label>
                    <div class="Wrapper">
                        <input type="text" id="nom" placeholder="Votre nom" disabled="true" value=<?php echo $data['lastName'] ?>>
                        <a id="nomBtn" class="EnableBtn">
                            <img id="enableBtnImg" src="/dynamHaus/public/icons/pen.svg"/>
                        </a>
                    </div>
                </div>
                <div>
                    <label for="prenom">Prénom</label>
                    <div class="Wrapper">
                        <input type="text" id="prenom" placeholder="Votre prénom" disabled="true" value=<?php echo $data['firstName'] ?>>
                        <a id="prenomBtn" class="EnableBtn">
                            <img id="enableBtnImg" src="/dynamHaus/public/icons/pen.svg"/>
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <label for="email">Adresse email</label>
                    <div class="Wrapper">
                        <input type="email" id="email" placeholder="Votre adresse" disabled="true" value=<?php echo $data['email'] ?>>
                    </div>
                </div>
                <div>
                    <label for="password">Mot de passe</label>
                    <div class="Wrapper">
                        <input type="password" id="password" placeholder="********" disabled="true">
                        <a id="enableButton" class="EnableBtn" href=<?= $data['method']?"/dynamhaus/resetPassword":""?> >
                            <img id="enableBtnImg" src="/dynamHaus/public/icons/pen.svg"/>
                        </a>
                    </div>
                </div>
            </div>

            <div class="update_button-section">
                <button id="updateBtn" class="btn-update-profile" type='submit'><h3>Mettre à jour le profil</h3></button>
            </div>
        </form>

        <div class="ads-section">

            <h2>Mes annonces</h2>

            <div class="ads-flexbox">

            <?php $index = 0;
            foreach ($offers as $offer): ?>
                
                <div class="ad-card">
                    <img src="<?php echo $offer['urls'][0]??""; ?>" alt="Annonce 1">
                    <div class="ad-info">
                        <h3><?php echo $offer['address']; ?></h3>
                        <div class="price"><?php echo $offer['price']; ?></div>
                        <?php 
                        if (!$data['student']) {echo '
                        <div class="modify_and_delete">
                            <a href="#" class="btn-edit-nonstudent">Modifier</a>
                            <a href="#" class="btn-delete" onclick="confirm(\'Etes-vous sur de vouloir supprimer cette annonce ?\')">Supprimer</a>
                        </div>';}
                        else {echo '
                            <a href="#" class="btn-edit-student">
                            <img src="/dynamHaus/public/icons/brokenHeart.svg"/>
                            Retirer des favoris
                            </a>
                        ';}
                        ?>
                    </div>
                </div>
            
            <?php $index += 1;
            endforeach; ?>
            
            </div>
        </div>

        <div class="delete_button-section">
            <a href="#" class="btn-delete-profile" onclick="confirm('Etes-vous sur de vouloir supprimer ce profil ?')"><h3>Supprimer le profil</h3></a>
        </div>

    </div>
    <script src="/dynamhaus/public/script/profile.js"></script>
</body>
</html>