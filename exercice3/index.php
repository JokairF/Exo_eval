<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avion</title>
</head>

<body>
    <form action="managerAvion.class.php" method="post">
        <label for="nom">Modèle:</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="pays">Pays:</label>
        <input type="text" id="pays" name="pays" required><br><br>

        <label for="annee">Année:</label>
        <input type="date" id="annee" name="annee" required><br><br>

        <label for="constructeur">Fabricant:</label>
        <input type="text" id="constructeur" name="constructeur" required><br><br>

        <input type="submit" value="Ajouter Avion">
    </form>
</body>

</html>