<?php
namespace App\Models\Manager;

use App\Lib\Manager\AbstractDataManager;
use App\Models\Entity\SensorData;
use App\Models\Entity\SensorParam;

class DataManager extends AbstractDataManager{
    public function findOne(int $id) {
        return $this->readOne(SensorData::class,['id'=>$id]);
    } 
    public function findLastTemperature() {
        return $this->readOneWithParam(SensorData::class,['sensorId'=>1],["timeRecorded"=>"DESC"],1);
    }
    public function findTemperatureHistory(int $limit) {
        return $this->readMany(sensorData::class,['sensorId'=>[1,"="]],['timeRecorded'=>'DESC'],$limit);
    }
    public function findLastAlert() {
        $query = "SELECT * FROM sensorData WHERE sensorId = 1 AND value NOT BETWEEN 10 AND 25 ORDER BY timeRecorded DESC LIMIT 1";
        $db=$this->connect();
        $stmt = $db->prepare($query);
        $stmt->execute();
		return $stmt->fetch();
    }
    public function getSensorParams() {
        return $this->readMany(SensorParam::class);
    }
    public function findLastValueFromSensor(int $sensorId) {
        return $this->readMany(sensorData::class,['sensorId'=>[$sensorId,"="]],['timeRecorded'=>'DESC'],1);
    }
    public function updateSensorSamplingPeriod(int $sensorId, int $newPeriod) {
        return $this->updateSensorParam(SensorParam::class,['samplingDelay'=>$newPeriod],$sensorId);
    }
    public function updateSensorStatus(int $sensorId, bool $isActive) {
        return $this->updateSensorParam(SensorParam::class,['active'=>$isActive],$sensorId);
    }
    public function getLightHistory(int $sensorId, string $startDate, string $endDate, int $intervalMinutes = 30) {
        if ($intervalMinutes <= 0) {
            // Un intervalle non positif n'a pas de sens pour l'agrégation.
            // Retourner les données brutes ou une erreur ? Pour l'instant, erreur.
            error_log("getLightHistory: L'intervalle en minutes doit être positif.");
            return false; 
        }

        $db = $this->connect(); // Méthode pour obtenir votre instance PDO

        // La requête SQL pour agréger les données par intervalle de temps.
        // Cette requête est spécifique à MySQL. D'autres SGBD pourraient nécessiter une syntaxe différente
        // pour grouper par intervalle de temps (ex: date_trunc sur PostgreSQL).
        // L'idée est de tronquer/arrondir `timeRecorded` à l'intervalle le plus proche
        // puis de faire la moyenne des `value` pour chaque groupe.

        // Solution pour MySQL:
        // On convertit timeRecorded en timestamp UNIX, on divise par les secondes de l'intervalle,
        // on prend la partie entière, puis on reconvertit en timestamp UNIX et en date.
        // Cela regroupe les enregistrements par "tranches" de $intervalMinutes.
        $sql = "
            SELECT 
                FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(timeRecorded) / (:interval_seconds)) * :interval_seconds) as interval_start_time,
                AVG(value) as average_value
            FROM 
                sensorData
            WHERE 
                sensorId = :sensor_id
                AND timeRecorded BETWEEN :start_date AND :end_date
            GROUP BY 
                interval_start_time
            ORDER BY 
                interval_start_time ASC
        ";
        
        // Alternative plus simple si l'agrégation exacte par intervalle n'est pas critique
        // et que vous voulez juste un nombre limité de points (échantillonnage).
        // Mais l'agrégation par moyenne est généralement meilleure pour les graphiques.
        // Si vous avez beaucoup de données, cette requête sera plus performante sans GROUP BY complexe
        // mais ne donnera pas une moyenne par intervalle.
        /*
        $sql_simple_sampling = "
            SELECT 
                timeRecorded, 
                value
            FROM 
                sensorData
            WHERE 
                sensorId = :sensor_id
                AND timeRecorded BETWEEN :start_date AND :end_date
            ORDER BY 
                timeRecorded ASC
            -- LIMIT X; // Pourrait être ajouté si vous voulez juste un sous-ensemble
        ";
        // Si vous utilisez cette version simple, le traitement pour agréger/échantillonner
        // devrait être fait en PHP après avoir récupéré toutes les données.
        */


        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':sensor_id', $sensorId, \PDO::PARAM_INT);
            $stmt->bindValue(':start_date', $startDate, \PDO::PARAM_STR);
            $stmt->bindValue(':end_date', $endDate, \PDO::PARAM_STR);
            $stmt->bindValue(':interval_seconds', $intervalMinutes * 60, \PDO::PARAM_INT);
            
            $stmt->execute();
            
            // On veut retourner un format cohérent avec ce que le contrôleur attend
            // (un tableau d'objets avec les propriétés 'timeRecorded' et 'value')
            $results = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $obj = new \stdClass();
                $obj->timeRecorded = $row['interval_start_time']; // C'est le début de l'intervalle
                $obj->value = (float)$row['average_value'];
                $results[] = $obj;
            }
            return $results;

        } catch (\PDOException $e) {
            // Loguer l'erreur est une bonne pratique
            error_log("Erreur PDO dans getLightHistory: " . $e->getMessage());
            return false;
        }
    }
    public function calculateLuxHours(int $sensorId, string $startDate, string $endDate) {
        $db = $this->connect();
        // Récupère toutes les données dans la période pour faire une approximation par la méthode des trapèzes
        $sql = "SELECT timeRecorded, value 
                FROM sensorData 
                WHERE sensorId = :sensor_id 
                  AND timeRecorded BETWEEN :start_date AND :end_date
                ORDER BY timeRecorded ASC";
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':sensor_id', $sensorId, \PDO::PARAM_INT);
            $stmt->bindParam(':start_date', $startDate, \PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $endDate, \PDO::PARAM_STR);
            $stmt->execute();
            $readings = $stmt->fetchAll(\PDO::FETCH_OBJ);

            if (count($readings) < 2) {
                // Pas assez de données pour calculer une intégrale significative
                // Si une seule lecture, on pourrait multiplier par la durée totale, mais ce serait imprécis.
                // Si la seule lecture est 0, alors 0 Lux-h.
                if (count($readings) == 1 && $readings[0]->value > 0) {
                     // Heures entre start et end (pour une approximation très grossière)
                    $startDt = new \DateTime($startDate);
                    $endDt = new \DateTime($endDate);
                    $durationHours = ($endDt->getTimestamp() - $startDt->getTimestamp()) / 3600;
                    return (float)$readings[0]->value * $durationHours;
                }
                return 0.0;
            }

            $totalLuxHours = 0;
            for ($i = 0; $i < count($readings) - 1; $i++) {
                $t1 = strtotime($readings[$i]->timeRecorded);
                $v1 = (float)$readings[$i]->value;
                $t2 = strtotime($readings[$i+1]->timeRecorded);
                $v2 = (float)$readings[$i+1]->value;

                $durationHours = ($t2 - $t1) / 3600; // Durée de l'intervalle en heures
                $averageLux = ($v1 + $v2) / 2;     // Moyenne de Lux sur l'intervalle
                
                $totalLuxHours += $averageLux * $durationHours;
            }
            return $totalLuxHours;

        } catch (\PDOException $e) {
            error_log("Erreur PDO dans calculateLuxHours: " . $e->getMessage());
            return false;
        }
    }
    public function findLightHistory(int $limit) {
        return $this->readMany(sensorData::class,['sensorId'=>[5,"="]],['timeRecorded'=>'DESC'],$limit);
    }
    public function getLightPeaksAboveThreshold(int $sensorId, string $startDate, string $endDate, float $thresholdLux = 3500, int $limit = 20) {
        $db = $this->connect();
        $sql = "
            SELECT 
                timeRecorded, 
                value
            FROM 
                sensorData
            WHERE 
                sensorId = :sensor_id
                AND value > :threshold
                AND timeRecorded BETWEEN :start_date AND :end_date
            ORDER BY 
                timeRecorded DESC
            LIMIT :limit_count 
        ";
        // On prend les plus récents d'abord

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':sensor_id', $sensorId, \PDO::PARAM_INT);
            $stmt->bindValue(':threshold', $thresholdLux, \PDO::PARAM_STR); // PDO traite float comme string
            $stmt->bindValue(':start_date', $startDate, \PDO::PARAM_STR);
            $stmt->bindValue(':end_date', $endDate, \PDO::PARAM_STR);
            $stmt->bindValue(':limit_count', $limit, \PDO::PARAM_INT);
            
            $stmt->execute();
            
            $results = $stmt->fetchAll(\PDO::FETCH_OBJ); // Récupère tous les résultats sous forme d'objets
            return $results ?: []; // Retourne un tableau vide si aucun résultat

        } catch (\PDOException $e) {
            error_log("Erreur PDO dans getLightPeaksAboveThreshold: " . $e->getMessage());
            return false;
        }
    }
}