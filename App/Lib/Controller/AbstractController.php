<?php
namespace App\Lib\Controller;

use App\Lib\Authentification\Authentification;
use App\Models\Entity\User;
use App\Models\Manager\UserManager;

abstract class AbstractController
{
	protected function renderView(string $template, array $data = [])
	{
		$templatePath = dirname(__DIR__, 2) . '/Views/' . $template;
		return require_once dirname(__DIR__, 2) . '/Views/layout.php';
	}
	protected function redirectToRoute(string $path, array $params = []): void
	{
		$uri =  $path;

		if (!empty($params)) {
			$strParams = [];
			foreach ($params as $key => $val) {
				array_push($strParams, urlencode((string) $key) . '=' . urlencode((string) $val));
			}
			$uri .= '&' . implode('&', $strParams);
		}

		header("Location: " . $uri);
		die;
	}
	protected function verifyPassword(User $user, string $password)
    {
        $hashedPassword = hash('sha512', $password);
        return hash_equals($user->password, $hashedPassword);
    }
	protected function getCurrentUser()
	{
		if (isset($_SESSION['token'])) {
			$auth = new Authentification();
			$userId = $auth->Validate_jwt($_SESSION['token'])['Jwt']['dcpl']['userId']??null;
			if (isset($userId)) {
			$userManager = new UserManager();
			$user = $userManager->find($userId);
			}
			
		}
		return $user??null;
	}
}