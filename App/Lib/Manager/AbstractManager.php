<?php 
namespace App\Lib\Manager;

use Exception;
use PDOException;

abstract class AbstractManager {

    private ?\PDO $db=null;
    public function connect(): \PDO {
        if ($this->db===null) {
            try {
            $this->db = new \PDO("mysql:host=".$_ENV['PDO_HOST'].";dbname=".$_ENV['DBNAME'].";charset=utf8",$_ENV["DB_USERNAME"],$_ENV["DB_PASSWORD"]);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->db->exec("SET NAMES utf8");
            } catch (Exception $e) {
                echo json_encode(["state"=>"Problem with Database"]);
            }
        }

        return $this->db;
    }

    private function executeQuery(string $query, array $params = []): \PDOStatement {
        $db=$this->connect();
        $stmt = $db->prepare($query);
        foreach ($params as $key => $param) $stmt->bindValue($key,$param);
        $stmt->execute();
        return $stmt;
    }

    private function getTableName(string $class): string {
        if (defined($class.'::TABLE_NAME')) {
            $table = $class::TABLE_NAME;
        } else {
            $tmp = explode('\\',$class);
            $table = strtolower(end($tmp));
        }
        return $table;

    }

    protected function readManyRandom(string $class, $filter=null, int $limit=null,int $id=null) {
        $query = 'SELECT * FROM ' . $this->getTableName($class);
        
        if (!empty($filter)) {
            $query .=" WHERE ". $filter[0]." ".$filter[1][1]." '".$filter[1][0]."'";
        }
        if (!empty($id)) {
            $query.=' AND id <> '.$id;
        } 
        $query.=' ORDER BY RAND()';
        if (isset($limit)) {
			$query .= ' LIMIT ' . $limit;
		}
        $db=$this->connect();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $class);
		return $stmt->fetchAll();
    }
    protected function readOne(string $class, array $filters) {
        $query = 'SELECT * FROM ' . $this->getTableName($class) . ' WHERE ';
        foreach (array_keys($filters) as $filter) {
            $query .= $filter . " = :" . $filter;
            if ($filter != array_key_last($filters)) $query .= ' AND ';
        }
        $stmt = $this->executeQuery($query, $filters);
        $stmt->setFetchMode(\PDO::FETCH_CLASS,$class);
        return $stmt->fetch();
    }
    protected function readManyQuery (string $class, array $filters = [], array $order = [], int $limit = null, int $offset = null) {
        $query = 'SELECT * FROM '.$this->getTableName($class);
		if (!empty($filters)) {
			$query .= ' WHERE ';
			foreach (array_keys($filters) as $filter) {
                if (is_array($filters[$filter][0])) {
                    if (count($filters[$filter])==1) {
                    $values=$filters[$filter][0];
                    $query .= $filter.' IN (';
                    foreach($values as $key => $value) {
                        $query .= (is_string($value) ? "'".$value."'": $value);
                        if ($key != array_key_last($values)) $query .= ', ';
                        else $query .= ')';
                    }
                    } else {
                        sort($filters[$filter][0]);
                        $orderedValues=$filters[$filter][0];
                        $query .= '('.$filter .' BETWEEN '.$orderedValues[0].' AND '.$orderedValues[1].')';
                            }
                    
                } else {
                    $query .= $filter . " ".$filters[$filter][1]." " . (is_string($filters[$filter][0])? "'".$filters[$filter][0]."'":$filters[$filter][0]); #filters = ["surface"=>[value,"type of comp (for exemple =>,=,<=,!=)"],"price"=>.....]
                    
                }
                if ($filter != array_key_last($filters)) $query .= ' AND ';
				
			}
		}
		if (!empty($order)) {
			$query .= ' ORDER BY ';
			foreach ($order as $key => $val) {
				$query .= $key . ' ' . $val;
				if ($key != array_key_last($order)) $query .= ', ';
			}
		}
		if (isset($limit)) {
			$query .= ' LIMIT ' . $limit;
			if (isset($offset)) {
				$query .= ' OFFSET ' . $offset;
			}
		}
        
        return $query;
    }
    protected function readMany(string $class, array $filters = [], array $order = [], int $limit = null, int $offset = null): mixed {
        $query = 'SELECT * FROM '.$this->getTableName($class);
		if (!empty($filters)) {
			$query .= ' WHERE ';
			foreach (array_keys($filters) as $filter) {
                if (is_array($filters[$filter][0]??null)) {
                    if (count($filters[$filter])==1) {
                    $values=$filters[$filter][0];
                    $query .= $filter.' IN (';
                    foreach($values as $key => $value) {
                        $query .= (is_string($value) ? "'".$value."'": $value);
                        if ($key != array_key_last($values)) $query .= ', ';
                        else $query .= ')';
                    }
                    } else {
                        sort($filters[$filter][0]);
                        $orderedValues=$filters[$filter][0];
                        $query .= '('.$filter .' BETWEEN '.$orderedValues[0].' AND '.$orderedValues[1].')';
                            }
                    
                } else {
                    $query .= $filter . " ".$filters[$filter][1]." " . (is_string($filters[$filter][0])? "'".$filters[$filter][0]."'":$filters[$filter][0]); #filters = ["surface"=>[value,"type of comp (for exemple =>,=,<=,!=)"],"price"=>.....]
                    
                }
                if ($filter != array_key_last($filters)) $query .= ' AND ';
				
			}
		}
		if (!empty($order)) {
			$query .= ' ORDER BY ';
			foreach ($order as $key => $val) {
				$query .= $key . ' ' . $val;
				if ($key != array_key_last($order)) $query .= ', ';
			}
		}
		if (isset($limit)) {
			$query .= ' LIMIT ' . $limit;
			if (isset($offset)) {
				$query .= ' OFFSET ' . $offset;
			}
		}
		$db=$this->connect();
        $stmt = $db->prepare($query);
        $stmt->execute();
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $class);
		return $stmt->fetchAll();
	}

    protected function executeSimpleQuery (string $query, string $class) {
        $db=$this->connect();
        $stmt = $db->prepare($query);
        $stmt->execute();
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $class);
		return $stmt->fetchAll();
    }

    protected function create(string $class, array $fields): int {
		$query = "INSERT INTO " . $this->getTableName($class) . " (";
		foreach (array_keys($fields) as $field) {
			$query .= $field;
			if ($field != array_key_last($fields)) $query .= ', ';
		}
		$query .= ') VALUES (';
		foreach (array_keys($fields) as $field) {
			$query .= ':' . $field;
			if ($field != array_key_last($fields)) $query .= ', ';
		}
		$query .= ')';
		$this->executeQuery($query, $fields);
        return $this->connect()->lastInsertId();
	}

    private function getLastInsertedRowId() {
        $db=$this->connect();
        return $db->lastInsertId();
    }
    protected function update(string $class, array $fields, int $id): \PDOStatement {
		$query = "UPDATE " . $this->getTableName($class) . " SET ";
		foreach (array_keys($fields) as $field) {
			$query .= $field . " = :" . $field;
			if ($field != array_key_last($fields)) $query .= ', ';
		}
		$query .= ' WHERE id = :id';
		$fields['id'] = $id;
		return $this->executeQuery($query, $fields);
	}

    protected function remove(string $class, int $id): \PDOStatement {
		$query = "DELETE FROM " . $this->getTableName($class) . " WHERE id = :id";
		return $this->executeQuery($query, [ 'id' => $id ]);
	}

}