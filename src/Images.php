<?php
class ImageManager
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Fetch all images for a given patient ID
    public function getImagesByPatientId($patientId)
    {
        $stmt = $this->db->prepare("SELECT * FROM images_new WHERE patient_id = ? order by id desc ");
        $stmt->execute([$patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get image by ID (Patient view)
    public function getImageById($imageId)
    {
        $stmt = $this->db->prepare("SELECT * FROM images_new WHERE id = ? order by id desc");
        $stmt->bindParam(1, $imageId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function getPatientImages($limit, $offset)
    {
        $stmt = $this->db->prepare("
            SELECT 
                i.id AS image_id, 
                i.patient_id, 
                i.s3_key, 
                i.type AS image_type, 
                i.uploaded_at, 
                u.name AS patient_name
            FROM 
                images_new i
            JOIN 
                users u ON i.patient_id = u.id
            ORDER BY 
                u.name, i.uploaded_at
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>