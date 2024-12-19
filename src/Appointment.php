<?php
class Appointment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Book an appointment
    public function bookAppointment($patientId, $doctorId, $appointmentDate)
    {
        $stmt = $this->pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) VALUES (?, ?, ?, 'scheduled')");
        return $stmt->execute([$patientId, $doctorId, $appointmentDate]);
    }

    // Create a new appointment
    public function createAppointment($patientId, $doctorId, $appointmentDate)
    {
        $stmt = $this->pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) VALUES (?, ?, ?, 'pending')");
        return $stmt->execute([$patientId, $doctorId, $appointmentDate]);
    }

    // Get appointments for a patient
    public function getAppointmentsForPatient($patientId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE patient_id = ? Order BY id DESC");
        $stmt->execute([$patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get appointments for a doctor
    public function getAppointmentsForDoctor($doctorId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE doctor_id = ?");
        $stmt->execute([$doctorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all appointments for admin
    public function getAllAppointmentsForAdmin()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Approve appointment
    public function approveAppointment($appointmentId)
    {
        $stmt = $this->pdo->prepare("UPDATE appointments SET status = 'approved' WHERE id = ?");
        return $stmt->execute([$appointmentId]);
    }

    // Reject appointment
    public function rejectAppointment($appointmentId)
    {
        $stmt = $this->pdo->prepare("UPDATE appointments SET status = 'rejected' WHERE id = ?");
        return $stmt->execute([$appointmentId]);
    }


    public function getAllReportsWithAppointments()
    {
        $stmt = $this->pdo->prepare("
        SELECT a.id AS appointment_id, a.patient_id, a.doctor_id, a.appointment_date, a.status, 
               r.report_type, r.created_at AS report_created_at
        FROM appointments a
        INNER JOIN reports r ON a.id = r.appointment_id
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>

