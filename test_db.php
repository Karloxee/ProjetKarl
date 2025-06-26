<?php
$host = '192.168.1.178'; 
$db   = 'devopscar';
$user = 'devopscar';
$pass = 'devopscar';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "✅ Connexion réussie à la base de données.\n";

    $stmt = $pdo->query("SHOW TABLES");
    echo "📦 Tables disponibles :\n";
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo "- $row[0]\n";
    }

} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage() . "\n";
    http_response_code(500);
}
?>
