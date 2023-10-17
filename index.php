<?php

require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

if(!empty($_POST)) {
    $friends = $_POST;
    $friends = array_map('trim', $friends);
    $friends = array_map('htmlentities', $friends);

    $errors = [];

    if(empty($friends['firstname']) || !isset($friends['firstname'])) {
        $errors[] = 'le prénom est obligatoire';
    }
    if(empty($friends['lastname']) || !isset($friends['lastname'])) {
        $errors[] = 'le nom est obligatoire';
    }

    if(empty($errors)) {
        
        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $friends['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $friends['lastname'], \PDO::PARAM_STR);
        $statement->execute();

        header('Location: index.php');
    }
}

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friendsArray = $statement->fetchAll();


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
        <ul>
            <?php foreach($friendsArray as $friend): ?>
            <li><?=$friend['firstname'] . ' ' . $friend['lastname']?></li>
            <?php endforeach;?>
        </ul>
        <form method="post">
                <option value = "select">Sélectionner</option>
                <option value = "friend1">Monica</option>
                <option value = "friend2">Phoebe</option>
                <option value = "friend3">Joey</option>
                <option value = "friend4">Ross</option>
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
