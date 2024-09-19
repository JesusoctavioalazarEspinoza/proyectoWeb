<?php
// Configuración de la base de datos
$host = 'localhost';
$db   = 'logica_programacion';
$user = 'tu_usuario';
$pass = 'tu_contraseña';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Verificar si se ha proporcionado un nombre de archivo
if (isset($_GET['archivo'])) {
    $archivo = $_GET['archivo'];
    
    // Verificar si el archivo existe en la base de datos
    $stmt = $pdo->prepare("SELECT ruta FROM pdfs WHERE nombre = ?");
    $stmt->execute([$archivo]);
    $pdf = $stmt->fetch();
    
    if ($pdf) {
        $ruta_archivo = $pdf['ruta'];
        
        // Verificar si el archivo existe en el servidor
        if (file_exists($ruta_archivo)) {
            // Configurar cabeceras para la descarga
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $archivo . '"');
            header('Content-Length: ' . filesize($ruta_archivo));
            
            // Leer y enviar el archivo
            readfile($ruta_archivo);
            exit;
        } else {
            echo "El archivo no existe en el servidor.";
        }
    } else {
        echo "El archivo solicitado no existe en la base de datos.";
    }
} else {
    echo "No se ha especificado ningún archivo para descargar.";
}
?>