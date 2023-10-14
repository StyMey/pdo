<?php

require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

if(!empty($_POST)) {
    $friend = $_POST;
    $friend = array_map('trim', $friend);
    $friend = array_map('htmlentities', $friend);

    $errors = [];

    if(empty($friend['firstname']) || !isset($friend['firstname'])) {
        $errors[] = 'le prénom est obligatoire';
    }
    if(empty($friend['lastname']) || !isset($friend['lastname'])) {
        $errors[] = 'le nom est obligatoire';
    }

    if(empty($errors)) {
        header('Location: success.php');
    }
}

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friend = $statement->fetchAll();

$query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
$statement = $pdo->prepare($query);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        <form>
            <select>
                <option value = "select">Sélectionner</option>
                <option value = "friend1">Monica</option>
                <option value = "friend2">Phoebe</option>
                <option value = "friend3">Joey</option>
                <option value = "friend4">Ross</option>
            </select>
            <div>
                <label for="firstname">Prénom</label>
                <input type="text" id="firstname" name="firstname">
            </div>
            <div>
                <label for="lastname">Nom</label>
                <input type="text" id="lastname" name="lastname">
            </div>
            <div class="button">
                <button type="submit">Créer le nouvel ami</button>
            </div>
        </form>
    </main>
</body>
</html>