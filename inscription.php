<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "salle";

// Connexion MySQL
$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifie la présence des champs
if (!isset($_POST['nom'], $_POST['naissance'], $_POST['email'], $_POST['telephone'], $_POST['seances'])) {
    die("Formulaire incomplet.");
}

// Nettoyage et assignation
$nom = trim($_POST['nom']);
$naissance = trim($_POST['naissance']);
$email = trim($_POST['email']);
$telephone = trim($_POST['telephone']);
$seances = (int) $_POST['seances'];

$types = isset($_POST['type']) ? $_POST['type'] : [];
$type1 = $types[0] ?? NULL;
$type2 = $types[1] ?? NULL;
$type3 = $types[2] ?? NULL;

// Prépare la requête d'insertion
$sql = "INSERT INTO inscription (nom, naissance, email, telephone, seances, type1, type2, type3)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisss", $nom, $naissance, $email, $telephone, $seances, $type1, $type2, $type3);

// Exécute et redirige ou affiche erreur
if ($stmt->execute()) {
    header("Location: verification.html");
    exit();
} else {
    echo "Erreur lors de l'insertion : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
