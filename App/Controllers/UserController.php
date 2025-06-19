<?php
namespace App\Controllers;

use App\Lib\Controller\AbstractController;
use App\Models\Manager\UserManager;

class UserController extends AbstractController {

    /**
     * Affiche la page de profil de l'utilisateur connecté.
     */
    public function showProfile()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            $this->redirectToRoute('/login');
            return;
        }

        return $this->renderView("profil.php", ['user' => $user]);
    }

    /**
     * Affiche le formulaire de modification de profil.
     */
    public function editProfile()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            $this->redirectToRoute('/login');
            return;
        }

        return $this->renderView("editionprofil.php", ['user' => $user]);
    }

    /**
     * Traite la soumission du formulaire de modification de profil.
     */
    public function updateProfile()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            $this->redirectToRoute('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToRoute('/profil/edit');
            return;
        }

        $userManager = new UserManager();
        $error = null;

        // Récupérer les données du formulaire
        $lastName = trim($_POST['lastName'] ?? '');
        $firstName = trim($_POST['firstName'] ?? '');
        
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Créer un nouvel objet User pour ne pas modifier l'objet en session directement
        $userToUpdate = $userManager->find($user->id);
        $userToUpdate->lastName = $lastName;
        $userToUpdate->firstName = $firstName;
        
        if (!empty($newPassword)) {
            if (empty($oldPassword) || empty($confirmPassword)) {
                $error = "Pour changer de mot de passe, vous devez remplir les trois champs.";
            } 
            elseif (!$this->verifyPassword($user, $oldPassword)) {
                $error = "L'ancien mot de passe est incorrect.";
            }
            elseif ($newPassword !== $confirmPassword) {
                $error = "Les nouveaux mots de passe ne correspondent pas.";
            }
            elseif (strlen($newPassword) < 8) {
                $error = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
            }
            else {
                $userToUpdate->password = hash('sha512', $newPassword);
            }
        }
        
        if ($error) {
            // On repasse l'objet user original à la vue d'édition, pas celui modifié
            return $this->renderView('editionprofil.php', ['user' => $user, 'error' => $error]);
        }
        
        // Sauvegarde des modifications
        $userManager->save($userToUpdate);

        $this->redirectToRoute('/profil');
    }
}