<?php
require_once '../config/DB.php';

class Airline extends DB {
    
    public function getAllAirlines() {
        try {
            $stmt = $this->getPDO()->prepare("SELECT id, airline_name, logo FROM airline ORDER BY airline_name");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve airlines: " . $e->getMessage());
        }
    }
    
    public function getAirlineById($id) {
        try {
            $stmt = $this->getPDO()->prepare("SELECT id, airline_name, logo FROM airline WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch();
            return $result ? $result : null;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve airline: " . $e->getMessage());
        }
    }
    
    public function createAirline($airlineName, $logo = null) {
        try {
            $stmt = $this->getPDO()->prepare("INSERT INTO airline (airline_name, logo) VALUES (?, ?)");
            $result = $stmt->execute([$airlineName, $logo]);
            return [
                'success' => $result,
                'affected_rows' => $stmt->rowCount()
            ];
        } catch (Exception $e) {
            throw new Exception("Failed to create airline: " . $e->getMessage());
        }
    }
    
    public function updateAirline($id, $airlineName, $logo = null) {
        try {
            $stmt = $this->getPDO()->prepare("UPDATE airline SET airline_name = ?, logo = ? WHERE id = ?");
            $result = $stmt->execute([$airlineName, $logo, $id]);
            return [
                'success' => $result,
                'affected_rows' => $stmt->rowCount()
            ];
        } catch (Exception $e) {
            throw new Exception("Failed to update airline: " . $e->getMessage());
        }
    }
    
    public function deleteAirline($id) {
        try {
            $stmt = $this->getPDO()->prepare("DELETE FROM airline WHERE id = ?");
            $result = $stmt->execute([$id]);
            return [
                'success' => $result,
                'affected_rows' => $stmt->rowCount()
            ];
        } catch (Exception $e) {
            throw new Exception("Failed to delete airline: " . $e->getMessage());
        }
    }
}
?>
