<?php require_once 'init.php'; ?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="../Boutique60/style.css">

    <title>Boutique60</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <a class="navbar-brand" href="../Boutique60/index.php" >LesHabitsDeWF3</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor03">
        <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?= URL?>./index.php">Accueil
            </a>
            </li>

            <?php if (userIsAdmin()) : ?>
              <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>admin/dashboard.php">Dashboard</a>
              </li>
            <?php endif ?>

            <?php if (userConnected()) : ?>
              <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>boutique.php">Boutique</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>panier.php">Panier</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>profil.php">Profil</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>connexion.php?action=deconnexion">Déconnexion</a>
              </li>
            <?php else : ?>
              <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>inscription.php">Inscription</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>connexion.php">Connexion</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>boutique.php">Boutique</a>
              </li>

            <?php endif ?>

        </ul>

    </div>
    </div>
</nav>