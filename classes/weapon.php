<?php

class Weapon {
    private $db; 

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function getAllWeapons() {
        $sql = "SELECT w.*, u.username AS created_by_username 
                FROM weapons w 
                LEFT JOIN users u ON w.created_by = u.id 
                ORDER BY w.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWeaponById($id) {
        $sql = "SELECT w.*, u.username AS created_by_username 
                FROM weapons w 
                LEFT JOIN users u ON w.created_by = u.id 
                WHERE w.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function searchWeapons($searchTerm) {
        $sql = "SELECT w.*, u.username AS created_by_username 
                FROM weapons w 
                LEFT JOIN users u ON w.created_by = u.id 
                WHERE w.name LIKE :term1 OR w.type LIKE :term2 OR w.description LIKE :term3
                ORDER BY w.created_at DESC";
        
        $searchTermWithWildcards = "%{$searchTerm}%"; 
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':term1', $searchTermWithWildcards);
        $stmt->bindParam(':term2', $searchTermWithWildcards);
        $stmt->bindParam(':term3', $searchTermWithWildcards);
        
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function addWeapon($data) {
        $sql = "INSERT INTO weapons (
                    name, type, origin_country, manufacture_year, historical_period, 
                    material, length_cm, weight_kg, condition_status, description, 
                    acquisition_date, estimated_value, image_url, created_by
                ) VALUES (
                    :name, :type, :origin_country, :manufacture_year, :historical_period, 
                    :material, :length_cm, :weight_kg, :condition_status, :description, 
                    :acquisition_date, :estimated_value, :image_url, :created_by
                )";
        
        $params = [
            ':name' => $data['name'],
            ':type' => $data['type'],
            ':origin_country' => $data['origin_country'],
            ':manufacture_year' => $data['manufacture_year'],
            ':historical_period' => $data['historical_period'],
            ':material' => $data['material'],
            ':length_cm' => $data['length_cm'],
            ':weight_kg' => $data['weight_kg'],
            ':condition_status' => $data['condition_status'],
            ':description' => $data['description'],
            ':acquisition_date' => $data['acquisition_date'],
            ':estimated_value' => $data['estimated_value'],
            ':image_url' => $data['image_url'],
            ':created_by' => $data['created_by']
        ];

        try {
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute($params)) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Silah Ekleme Hatası: " . $e->getMessage());
            return false;
        }
    }

    public function updateWeapon($id, $data) {
        $sql = "UPDATE weapons SET 
                    name = :name, 
                    type = :type, 
                    origin_country = :origin_country, 
                    manufacture_year = :manufacture_year, 
                    historical_period = :historical_period, 
                    material = :material, 
                    length_cm = :length_cm, 
                    weight_kg = :weight_kg, 
                    condition_status = :condition_status, 
                    description = :description, 
                    acquisition_date = :acquisition_date, 
                    estimated_value = :estimated_value, 
                    image_url = :image_url
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':origin_country', $data['origin_country']);
        $stmt->bindParam(':manufacture_year', $data['manufacture_year']);
        $stmt->bindParam(':historical_period', $data['historical_period']);
        $stmt->bindParam(':material', $data['material']);
        $stmt->bindParam(':length_cm', $data['length_cm']);
        $stmt->bindParam(':weight_kg', $data['weight_kg']);
        $stmt->bindParam(':condition_status', $data['condition_status']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':acquisition_date', $data['acquisition_date']);
        $stmt->bindParam(':estimated_value', $data['estimated_value']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteWeapon($id) {
        $sql = "DELETE FROM weapons WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>