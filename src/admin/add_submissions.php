<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/src/output.css" />
</head>
<body class="min-h-screen">
<?php
require('../config.php');

if (isset($_POST['title'], $_POST['price'], $_POST['localisation'])){
  // récupérer le titre de l'annonce 
  $title = stripslashes($_POST['title']);
  $title = mysqli_real_escape_string($conn, $title); 
  // récupérer le prix
  $price = stripslashes($_POST['price']);
  $price = mysqli_real_escape_string($conn, $price);
  // récupérer la localisation
  $localisation = stripslashes($_POST['localisation']);
  $localisation = mysqli_real_escape_string($conn, $localisation);
  
  // Utilisation de requêtes préparées pour éviter les injections SQL
  $query = $conn->prepare("INSERT INTO `submissions` (title, price, localisation) VALUES (?, ?, ?)");
  $query->bind_param("sss", $title, $price, $localisation);
  $res = $query->execute();

  if($res){
     echo "<div class='success'>
           <h3>L'annonce a été créée avec succès.</h3>
           <p>Cliquez <a href='home.php'>ici</a> pour retourner à la page d'accueil</p>
     </div>";
  } else {
     echo "<div class='error'>
           <h3>Une erreur s'est produite. Veuillez réessayer.</h3>
     </div>";
  }
} else {
?>
<form class="box bg-white shadow-md rounded-lg px-8 pt-6 pb-8 shadow-purple-500 flex flex-col gap-4 max-w-96 mx-auto my-8" action="" method="post">
  <h1 class="box-title font-bold text-2xl">Ajouter une annonce</h1>
  <input type="text" class="box-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="title" 
  placeholder="Titre de l'annonce" required />
  
  <input type="text" class="box-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="price" 
  placeholder="Prix" required />
  
  <input type="text" class="box-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="localisation" 
  placeholder="Localisation" required />
  
  <input type="submit" name="submit" value="Ajouter" class="box-button px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-700 w-32 transition" />
</form>
<?php } ?>
</body>
</html>
