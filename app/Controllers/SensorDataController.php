<?php
namespace App\Controllers;

use App\Lib\Controller\AbstractController;
use App\Models\Manager\DataManager;
use DateInterval;
use DateTime;
class SensorDataController extends AbstractController {
    public function temperature() {
        if (!(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')) {
            $dataManager = new DataManager();
            $sensorData = $dataManager->findLastTemperature();
            $formattedData = $this->temperatureHistory();
            $alert = $dataManager->findLastAlert();
            $motorState = $dataManager->findLastValueFromSensor(2)[0]??null;
            if ($motorState) {
                $motorState=$motorState->value;
            } else {
                $motorState=0;
            }
            return $this->renderView("temperature.php",['currentTemp'=>$sensorData->value,'initialChartData'=>json_encode($formattedData),'alert'=>$alert,'motorState'=>$motorState]);
        } else {
        $dataManager = new DataManager();
        $sensorData = $dataManager->findLastTemperature();
        if (!$sensorData) {
            echo json_encode(["state" => "Server error"]);
            return null;
        }
        $currentTemp = $sensorData->value;
        $formattedData = $this->temperatureHistory();
        $alert = $dataManager->findLastAlert();
        $motorState = $dataManager->findLastValueFromSensor(2)[0]??null;
            if ($motorState) {
                $motorState=$motorState->value;
            } else {
                $motorState=0;
            }
        echo json_encode(["currentTemp" => $currentTemp,'initialChartData'=>json_encode($formattedData),'alert'=>json_encode($alert),'motorState'=>$motorState]);
        return null;
            
        }
    }
    private function temperatureHistory() {
    $dataManager = new DataManager();
    $historyData = $dataManager->findTemperatureHistory(100);

    // Initialise une structure de données vide
    $formattedData = [
        'labels' => [],
        'values' => [],
    ];

    // Si des données sont trouvées, on les formate
    if ($historyData) {
        foreach (array_reverse($historyData) as $dataPoint) {
            $formattedData['labels'][] = date('H:i', strtotime($dataPoint->timeRecorded));
            $formattedData['values'][] = $dataPoint->value;
        }
    }
    return $formattedData;

    }

    public function lumiere() {
        $dataManager = new DataManager();
        $lastReading = $dataManager->findLastValueFromSensor(5)[0];
        $currentLightValue = 'N/A';
        $currentLightStatus = 'DONNÉES INDISPONIBLES';
        $statusClass = 'unknown';

        if ($lastReading && property_exists($lastReading, 'value')) {
            $currentLightValue = (float)$lastReading->value;
            if ($currentLightValue <= 800) { // Seuil pour "obscurité complète"
                $currentLightStatus = 'OBSCURITÉ COMPLÈTE';
                $statusClass = 'dark';
            } elseif ($currentLightValue <= 1500) { // Seuil pour "lumière faible détectée"
                $currentLightStatus = 'LUMIÈRE FAIBLE DÉTECTÉE';
                $statusClass = 'low-light';
            } else {
                $currentLightStatus = 'LUMIÈRE FORTE DÉTECTÉE !';
                $statusClass = 'light-detected critical'; // Classe pour alerte visuelle
            }
        }

        // Données initiales pour le graphique (dernières 24h, un point toutes les 30 mins par exemple)
        $initialChartData = $this->getFormattedLightHistoryForChart(
            (new DateTime())->sub(new DateInterval('P1D'))->format('Y-m-d H:i:s'), // Start: il y a 24h
            (new DateTime())->format('Y-m-d H:i:s'), // End: maintenant
            30 // Intervalle en minutes
        );

        $viewData = [
            'currentLightValue' => $currentLightValue,
            'currentLightStatus' => $currentLightStatus,
            'statusClass' => $statusClass,
            'lastUpdateTimestamp' => ($lastReading && property_exists($lastReading, 'timeRecorded')) ? $lastReading->timeRecorded : null,
            'initialLightChartData' => json_encode($initialChartData)
        ];

        return $this->renderView(
            'lumiere.php', // Votre fichier de vue
            $viewData
        );
    }
    private function getFormattedLightHistoryForChart(string $startDate, string $endDate, int $intervalMinutes = 30) {
        $dataManager = new DataManager();
        // Vous devez implémenter getLightHistory dans DataManager pour qu'il accepte ces paramètres
        // et retourne des données agrégées ou échantillonnées par intervalle.
        // Pour cet exemple, je simule une structure de retour.
        $historyData = $dataManager->findLightHistory(100);
        $formattedData = ['labels' => [], 'values' => []];
        if ($historyData && is_array($historyData)) {
            foreach ($historyData as $dataPoint) {
                if (is_object($dataPoint) && property_exists($dataPoint, 'timeRecorded') && property_exists($dataPoint, 'value')) {
                    $formattedData['labels'][] = (new DateTime($dataPoint->timeRecorded))->format('H:i'); // Heure:Minute
                    $formattedData['values'][] = (float)$dataPoint->value;
                }
            }
        }
        return $formattedData;
    }
    private function isAjaxRequest() {
        return (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest');
    }
    public function getCurrentLightDataAjax() {
        if (!$this->isAjaxRequest()) return $this->forbiddenAccess();
        header('Content-Type: application/json');

        $dataManager = new DataManager();
        $lastReading = $dataManager->findLastValueFromSensor(5)[0];

        $currentLightValue = null;
        $currentLightStatus = 'DONNÉES INDISPONIBLES';
        $statusClass = 'unknown';
        $timestamp = null;

        if ($lastReading && property_exists($lastReading, 'value')) {
            $currentLightValue = (float)$lastReading->value;
            $timestamp = $lastReading->timeRecorded;
            if ($currentLightValue <= 800) {
                $currentLightStatus = 'OBSCURITÉ COMPLÈTE';
                $statusClass = 'dark';
            } elseif ($currentLightValue <= 1500) {
                $currentLightStatus = 'LUMIÈRE FAIBLE DÉTECTÉE';
                $statusClass = 'low-light';
            } else {
                $currentLightStatus = 'LUMIÈRE FORTE DÉTECTÉE !';
                $statusClass = 'light-detected critical';
            }
        }
        
        echo json_encode([
            'currentLightValue' => $currentLightValue,
            'currentLightStatus' => $currentLightStatus,
            'statusClass' => $statusClass,
            'lastUpdateTimestamp' => $timestamp,
            'formattedLastUpdate' => $timestamp ? $this->formatTimeAgo($timestamp) : 'Jamais'
        ]);
        return null;
    }
    public function getLightHistoryAjax() {
        if (!$this->isAjaxRequest()) return $this->forbiddenAccess();
        header('Content-Type: application/json');

        // Récupérer les paramètres de date du GET, avec des valeurs par défaut
        $defaultEndDate = new DateTime();
        $defaultStartDate = (new DateTime())->sub(new DateInterval('P1D')); // Par défaut 24h

        $startDate = $_GET['start'] ?? $defaultStartDate->format('Y-m-d H:i:s');
        $endDate = $_GET['end'] ?? $defaultEndDate->format('Y-m-d H:i:s');
        $interval = isset($_GET['interval']) ? (int)$_GET['interval'] : 30; // Intervalle en minutes

        $chartData = $this->getFormattedLightHistoryForChart($startDate, $endDate, $interval);
        
        echo json_encode($chartData);
        return null;
    }
    private function forbiddenAccess(){
        http_response_code(403);
        echo json_encode(['error' => 'Accès interdit']);
        return null;
    }
    private function formatTimeAgo(string $datetime_str = null): string {
        if (empty($datetime_str)) return "Jamais";
        try {
            $now = new DateTime();
            $ago = new DateTime($datetime_str);
            $diff = $now->diff($ago);

            if ($diff->y > 0) return ($diff->y == 1) ? 'Il y a 1 an' : ('Il y a ' . $diff->y . ' ans');
            if ($diff->m > 0) return ($diff->m == 1) ? 'Il y a 1 mois' : ('Il y a ' . $diff->m . ' mois');
            if ($diff->d > 0) return ($diff->d == 1) ? 'Il y a 1 jour' : ('Il y a ' . $diff->d . ' jours');
            if ($diff->h > 0) return ($diff->h == 1) ? 'Il y a 1 heure' : ('Il y a ' . $diff->h . ' heures');
            if ($diff->i > 0) return ($diff->i == 1) ? 'Il y a 1 minute' : ('Il y a ' . $diff->i . ' minutes');
            if ($diff->s < 30) return 'À l\'instant'; // Plus précis pour "À l'instant"
            return 'Il y a quelques instants';
        } catch (\Exception $e) {
            return "Date invalide";
        }
    }
    public function getLuxHoursAjax() {
        if (!$this->isAjaxRequest()) return $this->forbiddenAccess();
        header('Content-Type: application/json');
        
        $dataManager = new DataManager();
        $now = new DateTime();
        $todayStart = (new DateTime())->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $nowFormatted = $now->format('Y-m-d H:i:s');
        $thisWeekStart = (new DateTime())->modify('monday this week')->setTime(0,0,0)->format('Y-m-d H:i:s');

        $luxHoursToday = $dataManager->calculateLuxHours(5, $todayStart, $nowFormatted);
        $luxHoursThisWeek = $dataManager->calculateLuxHours(5, $thisWeekStart, $nowFormatted);

        echo json_encode([
            'luxHoursToday' => ($luxHoursToday !== false) ? number_format($luxHoursToday, 2) : 'Erreur',
            'luxHoursThisWeek' => ($luxHoursThisWeek !== false) ? number_format($luxHoursThisWeek, 2) : 'Erreur'
        ]);
        return null;
    }
    public function getLightEventsAjax() {
        if (!$this->isAjaxRequest()) return $this->forbiddenAccess();
        header('Content-Type: application/json');
        
        $dataManager = new DataManager();
        $now = new DateTime();
        
        // Paramètres optionnels via GET pour la période et le seuil
        $defaultStartDate = (new DateTime())->sub(new DateInterval('P7D'))->format('Y-m-d H:i:s'); // Par défaut 7 jours
        $defaultThreshold = 3500;
        $defaultLimit = 5;

        $startDate = $_GET['start'] ?? $defaultStartDate;
        $endDate = $_GET['end'] ?? $now->format('Y-m-d H:i:s');
        $threshold = isset($_GET['threshold']) ? (float)$_GET['threshold'] : $defaultThreshold;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : $defaultLimit;

        $lightEvents = $dataManager->getLightPeaksAboveThreshold(
            5,
            $startDate,
            $endDate,
            $threshold,
            10
        );

        // Formater les dates pour un affichage plus convivial si besoin ici, ou en JS
        $formattedEvents = [];
        if ($lightEvents && is_array($lightEvents)) {
            foreach ($lightEvents as $event) {
                $formattedEvents[] = [
                    'timeRecorded' => (new DateTime($event->timeRecorded))->format('d/m/Y H:i:s'), // Formatage
                    'value' => (float)$event->value
                ];
            }
        }
        
        echo json_encode($formattedEvents ?: []); // Renvoyer un tableau vide si pas d'événements
        return null;
    }
}