<?php
// On charge l'enregistrement correspondant à l'ID passé en paramètre/on importe le contenu du fichier "db.php"
include "db.php";
// on exécute la méthode de connexion à notre BDD
$db = connexionBase();

// On récupère l'ID passé en paramètre :
$id = (isset($_GET['id']) && $_GET['id'] != "") ? $_GET['id'] : Null;



// On crée une requête préparée avec condition de recherche :
//$requete = $db->prepare("SELECT * FROM artist WHERE artist_id=?");
$requete = $db->prepare("SELECT * FROM disc JOIN artist ON disc.artist_id = artist.artist_id WHERE disc_id=?");
// on ajoute l'ID du disque passé dans l'URL en paramètre et on exécute :
//$requete->execute(array($_GET["id"]));
$requete->execute(array($id));
//on récupère le  (et seul) résultat :
$disc = $requete->fetch(PDO::FETCH_ASSOC);
// on clôt la requête en BDD
$requete->closeCursor();

$requete2 = $db->query("SELECT * FROM artist");
$requete2->execute();
// on récupère tous les résultats dans le tableau trouvés dans une variable   
$artists = $requete2->fetchAll(PDO::FETCH_ASSOC);
// on clôt la requête en BDD  
$requete2->closeCursor();

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Form Example</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
</head>

<body>
  <div class="container-fluid">

    <nav class="navbar navbar-expand-lg bg-info">
      <div class="container-fluid">
        <a class="navbar-brand">Modifier un vinyle</a>
    </nav>
    <form action="script_disc_modif.php" id="formulaire" method="post" enctype="multipart/form-data">

      <!-- Création d'un champ caché/La valeur du champ est récupérée à partir de la variable $id           -->
      <input type="hidden" name="id" value="<?= $id ?>">

      <div class="mb-3 row">
        <label class="col-sm-12 col-form-label">Title</label>
        <div class="col-sm-12">
          <input class="form-control" type="text" name="title" value="<?= $disc['disc_title'] ?>">
        </div>
      </div>
      <!--Liste déroulante / Sélection de l'artiste du disque-->
      <label class="col-sm-12 col-form-label">Artist</label>
      <select class="form-select" name="artist">
        <option>Choisir un artiste</option>
        <?php
        foreach ($artists as $unArtiste) { ?>
          <option <?php if ($unArtiste['artist_id'] == $disc['artist_id'])
            echo "selected" ?>
              value="<?= $unArtiste['artist_id'] ?>">
            <?= $unArtiste['artist_name'] ?>
          </option>
          <?php
        }
        ?>
      </select>
      <!--Input Année-->
      <div class="mb-3 row">
        <label class="col-sm-12 col-form-label">Year</label>
        <div class="col-sm-12">
          <input class="form-control" type="text" name="year" value="<?= $disc['disc_year'] ?>">
        </div>
      </div>
      <!--Input Genre-->
      <div class="mb-3 row">
        <label class="col-sm-12 col-form-label" for="genre">Genre</label>
        <div class="col-sm-12">
          <input class="form-control" type="text" name="genre" value="<?= $disc['disc_genre'] ?>">
        </div>
      </div>
      <!--Input Label-->
      <div class=" mb-3 row">
        <label class="col-sm-12 col-form-label" for="label">Label</label>
        <div class="col-sm-12">
          <input class="form-control" type="text" name="label" value="<?= $disc['disc_label'] ?>">
        </div>
      </div>
      <!--Input Prix-->
      <div class="form-group">
        <label for="price-input">Price</label>
        <div class="input-group">
          <div class="input-group-prepend">
          </div>
          <input type="number" class="form-control" name="price" value="<?= $disc['disc_price'] ?>" required>
        </div>
      </div>
      <label for="picture">Picture</label>
      <div>
        <input type="file" name="picture">
      </div>
      <div>
        <img class="img w-25" src="assets/img/<?php echo $disc['disc_picture'] ?>" alt="picture" title="Picture">
      </div>
      <div class="py-3">
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="index.php" class="btn btn-warning">Retour</a>
      </div>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>