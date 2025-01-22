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
		$uri =  $_ENV['DYNAMHAUS_URL']."/" . $path;

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

	protected function checkUserRole(array $requiredRoles)
	{
		$user = $this->getCurrentUser();
		if (!$user || !in_array($user->role, $requiredRoles) || $user->role == "ADMIN") {
			if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
				require_once dirname(__DIR__, 2) . '/Views/errors/403.php';
				exit;
			} else {
				http_response_code(403);
				echo json_encode(['error' => '403 Forbidden']);
				exit;
			}
		}
		return $user??null;
	}
	protected function checkSessionState()
	{
		$user = $this->getCurrentUser();
		if (!$user) {
			if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
				$this->renderView("signin.php", ['state' => "Vous devez vous connecter pour accéder à cette page"]);
				exit;
			} else {
				http_response_code(401);
				echo json_encode(['error' => '401 Unauthorized']);
				exit;
			}
		}
		return $user;
	}
	protected function setError404() {
		if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
			require_once dirname(__DIR__,2).'/Views/errors/404.php';
			exit; 
        } else {
			http_response_code(404);
			echo json_encode(['error' => '404 Not Found']);
		}
        
    }
	protected function verifyPassword(User $user, string $password)
    {
        $hashedPassword = hash('sha512', $password);
        return hash_equals($user->password, $hashedPassword);
    }
}