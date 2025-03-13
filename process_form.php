<?php

function enregistrerContact($nom, $prenom, $adresse, $telephone, $email) {
    try {
        // Utilisez l'adresse IP du conteneur MariaDB
        $dsn = 'mysql:host=192.168.27.189;dbname=devopscar;charset=utf8';
        $pdo = new PDO($dsn, 'devopscar', 'devopscar');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête d'insertion
        $sql = "INSERT INTO contacts (nom, prenom, adresse, telephone, email) 
                VALUES (:nom, :prenom, :adresse, :telephone, :email)";
        $stmt = $pdo->prepare($sql);
        
        // Exécuter la requête avec les paramètres
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':adresse' => $adresse,
            ':telephone' => $telephone,
            ':email' => $email
        ]);
        
        // Retourner un message de succès
        return "Message envoyé avec succès !";
        
    } catch (PDOException $e) {
        // Gérer les erreurs de connexion ou d'exécution
        return "Erreur : " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];

    // Appel de la fonction pour enregistrer le contact
    $message = enregistrerContact($nom, $prenom, $adresse, $telephone, $email);

    // Afficher le message retourné par la fonction
    echo $message;
}

?>






