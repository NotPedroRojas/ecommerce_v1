<?php

require_once __DIR__ . "/../../config/database.php";

function registrarUsuario($nombre, $email, $contrasena) {
    global $conexion;
    $consulta = $conexion->prepare(
        "INSERT INTO usuarios (nombre, email, contrasena, tipoUsuario)
         VALUES (:nombre, :email, :contrasena, 'cliente')"
    );
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":email", $email);
    $consulta->bindParam(":contrasena", $contrasena);
    $consulta->execute();
}

function obtenerUsuarioPorEmail($email) {
    global $conexion;
    $consulta = $conexion->prepare(
        "SELECT * FROM usuarios WHERE email = :email"
    );
    $consulta->bindParam(":email", $email);
    $consulta->execute();
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
    return $usuario;
}

function obtenerUsuarioPorId($idUsuario) {
    global $conexion;

    $consulta = $conexion->prepare(
        "SELECT * FROM usuarios WHERE idUsuario = ?"
    );
    $consulta->execute([$idUsuario]);

    return $consulta->fetch(PDO::FETCH_ASSOC);
}


function actualizarDatosUsuario($idUsuario, $nombre, $email, $contrasena) {
    global $conexion;

    if ($contrasena != "") {

        $consulta = $conexion->prepare(
            "UPDATE usuarios
             SET nombre = ?, email = ?, contrasena = ?
             WHERE idUsuario = ?"
        );

        $consulta->execute([
            $nombre,
            $email,
            $contrasena,
            $idUsuario
        ]);

    } else {

        $consulta = $conexion->prepare(
            "UPDATE usuarios
             SET nombre = ?, email = ?
             WHERE idUsuario = ?"
        );

        $consulta->execute([
            $nombre,
            $email,
            $idUsuario
        ]);
    }
}


function actualizarMetodoPago($idUsuario, $metodoPago) {
    global $conexion;

    $consulta = $conexion->prepare(
        "UPDATE usuarios SET metodoPago = ? WHERE idUsuario = ?"
    );

    $consulta->execute([$metodoPago, $idUsuario]);
}


function listarDireccionesUsuario($idUsuario) {
    global $conexion;

    $consulta = $conexion->prepare(
        "SELECT * FROM direcciones
         WHERE idUsuario = ?
         ORDER BY idDireccion DESC"
    );

    $consulta->execute([$idUsuario]);

    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


function guardarDireccion($idUsuario, $idDireccion, $calle, $numero, $pisoDepto, $localidad, $provincia, $codigoPostal) {
    global $conexion;

    if ($idDireccion > 0) {

        $consulta = $conexion->prepare(
            "UPDATE direcciones
             SET calle = ?, numero = ?, pisoDepto = ?,
                 localidad = ?, provincia = ?, codigoPostal = ?
             WHERE idDireccion = ? AND idUsuario = ?"
        );

        $consulta->execute([
            $calle,
            $numero,
            $pisoDepto,
            $localidad,
            $provincia,
            $codigoPostal,
            $idDireccion,
            $idUsuario
        ]);

    } else {

        $consulta = $conexion->prepare(
            "INSERT INTO direcciones
             (idUsuario, calle, numero, pisoDepto, localidad, provincia, codigoPostal)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $consulta->execute([
            $idUsuario,
            $calle,
            $numero,
            $pisoDepto,
            $localidad,
            $provincia,
            $codigoPostal
        ]);
    }
}


function eliminarDireccion($idDireccion, $idUsuario) {
    global $conexion;

    $consulta = $conexion->prepare(
        "DELETE FROM direcciones
         WHERE idDireccion = ? AND idUsuario = ?"
    );

    $consulta->execute([$idDireccion, $idUsuario]);
}

function listarUsuarios() {
    global $conexion;

    $consulta = $conexion->query(
        "SELECT idUsuario, nombre, email, tipoUsuario
         FROM usuarios
         ORDER BY idUsuario DESC"
    );

    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

?>
