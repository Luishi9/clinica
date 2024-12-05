<?php
require_once('../../backend/bd/Conexion.php');

$showPopup = false; // Controla si se muestra el pop-up

if (isset($_POST['add_doctor'])) {
    $ceddoc = trim($_POST['cem']);
    $nodoc = trim($_POST['named']);
    $apdoc = trim($_POST['apeme']);
    $nomesp = trim($_POST['espm']);
    $direcd = trim($_POST['dime']);
    $sexd = trim($_POST['geme']);
    $phd = trim($_POST['telme']);
    $nacd = trim($_POST['cumme']);

    try {
        $sql = "SELECT COUNT(*) FROM doctor WHERE ceddoc = :ceddoc";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':ceddoc', $ceddoc);
        $stmt->execute();
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            $errMSG = "La cédula ya está registrada.";
            $showPopup = true; // Activa el pop-up
        } else {
            $sql = "INSERT INTO doctor (ceddoc, nodoc, apdoc, nomesp, direcd, sexd, phd, nacd, state) 
                    VALUES (:ceddoc, :nodoc, :apdoc, :nomesp, :direcd, :sexd, :phd, :nacd, '1')";
            $stmt = $connect->prepare($sql);

            $stmt->bindParam(':ceddoc', $ceddoc);
            $stmt->bindParam(':nodoc', $nodoc);
            $stmt->bindParam(':apdoc', $apdoc);
            $stmt->bindParam(':nomesp', $nomesp);
            $stmt->bindParam(':direcd', $direcd);
            $stmt->bindParam(':sexd', $sexd);
            $stmt->bindParam(':phd', $phd);
            $stmt->bindParam(':nacd', $nacd);

            if ($stmt->execute()) {
                $errMSG = "Doctor agregado correctamente.";
            } else {
                $errMSG = "Error al agregar el Doctor.";
            }
        }
    } catch (PDOException $e) {
        $errMSG = "Error de base de datos: " . $e->getMessage();
    }
}
?>
