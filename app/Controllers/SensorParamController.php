<?php
namespace App\Controllers;

use App\Lib\Controller\AbstractController;
use App\Models\Manager\DataManager;
use DateTime;
class SensorParamController extends AbstractController {
    public function gestion() {
        $SENSORNAME = [1=>['Thermomètre','capteur'],2=>['Bouton','capteur'],3=>['Capteur Distance','capteur'],4=>['Buzzer','actionneur'],5=>['Capteur Lumière','capteur'],6=>['Capteur Humidité','capteur']];

        $dataManager = new DataManager();
        $appareilsFromDb = $dataManager->getSensorParams();
        foreach ($appareilsFromDb as $appareil) {
            $appareil = (array) $appareil;
            $complement = $dataManager->findLastValueFromSensor($appareil['sensorId'])[0]??null;
            if ($complement)  {$appareil['lastTimeRecorded'] = $complement->timeRecorded;} else {
                $appareil['lastTimeRecorded']="";
            }
           
            $appareil['nom'] = $SENSORNAME[$appareil['sensorId']][0]??"appareil inconnu";
            $appareil['type']=$SENSORNAME[$appareil['sensorId']][1]?? "inconnu";
            $appareilsForDisplay[] = [
                "id" => $appareil['sensorId'],
                "nom" => $appareil['nom'],
                "type" => $appareil['type'],
                "periode_echantillonnage" => $appareil['samplingDelay'],
                "derniere_communication" => $this->formatTimeAgo($appareil['lastTimeRecorded']), // On utilise la valeur traitée
                "actif" => $appareil['active']
            ];
        }
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            return $this->renderView("gestion.php",['appareils'=>$appareilsForDisplay]);
        
        } else {
            header('Content-Type: application/json');
            echo json_encode($appareilsForDisplay);
            return null;
        }   
    }
    

    function formatTimeAgo(string $datetime_str): string {
        if (empty($datetime_str)) return "Jamais";
        
        $now = new DateTime();
        $ago = new DateTime($datetime_str);
        $diff = $now->diff($ago);

        if ($diff->y > 0) return 'Il y a ' . $diff->y . ' an(s)';
        if ($diff->m > 0) return 'Il y a ' . $diff->m . ' mois';
        if ($diff->d > 0) return 'Il y a ' . $diff->d . ' jour(s)';
        if ($diff->h > 0) return 'Il y a ' . $diff->h . ' heure(s)';
        if ($diff->i > 0) return 'Il y a ' . $diff->i . ' minute(s)';
        return 'À l\'instant';
    }

    public function updateSamplingPeriod() {
        if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $input = json_decode(file_get_contents('php://input'), true);

            $sensorId = filter_var($input['sensorId'] ?? null, FILTER_VALIDATE_INT);
            $newPeriod = filter_var($input['period'] ?? null, FILTER_VALIDATE_INT);

            if ($sensorId && $newPeriod !== null && $newPeriod >= 0) { // Validez la période (ex: >= 0 ou dans une liste d'options)
                $dataManager = new DataManager();
                // Assurez-vous d'avoir une méthode comme updateSensorSamplingPeriod dans votre DataManager
                $success = $dataManager->updateSensorSamplingPeriod($sensorId, $newPeriod); 

                if ($success) {
                    echo json_encode(['status' => 'success', 'message' => 'Période mise à jour.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour de la période.']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Données invalides.']);
            }
            return null;
        }
        http_response_code(403); // Interdit si pas AJAX POST
        return null;
    }

    public function toggleDeviceStatus() {
        if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $input = json_decode(file_get_contents('php://input'), true);

            $sensorId = filter_var($input['sensorId'] ?? null, FILTER_VALIDATE_INT);
            $isActive = filter_var($input['isActive'] ?? null, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);


            if ($sensorId && $isActive !== null) {
                $dataManager = new DataManager();
                // Assurez-vous d'avoir une méthode comme updateSensorStatus dans votre DataManager
                $success = $dataManager->updateSensorStatus($sensorId, (bool)$isActive); 

                if ($success) {
                    echo json_encode(['status' => 'success', 'message' => 'Statut mis à jour.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour du statut.']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Données invalides.']);
            }
            return null;
        }
        http_response_code(403);
        return null;
    }

}