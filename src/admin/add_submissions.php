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

  if ($res) {
    echo "<div class='success'>
            <h3>L'annonce a été ajouté avec succès.</h3>
            <p>Redirection automatique vers <a href='home.php' class='text-purple-500'>l'accueil</a>...</p>
          </div>";
    // Redirection vers la page d'accueil après 2 secondes
    header("refresh:2;url=home.php");
  } else {
      echo "<div class='error'>
              <h3>Une erreur s'est produite. Veuillez réessayer.</h3>
            </div>";
  }
} else {
?>

<div class="container mx-auto p-4">
  <div class="bg-white rounded-lg shadow-md p-6 text-center">
    <h1 class="text-2xl font-bold text-gray-700">Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
    <p class="mt-2 text-gray-600">C'est votre espace admin.</p>
    <div class="mt-4 flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">
      <a href="home.php" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-purple-700 transition">Accueil</a>
      <a href="add_submissions.php" class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-700 transition">Ajouter une annonce</a>
      <a href="modify_submissions" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-700 transition">Modifier une annonce</a>
      <a href="#" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition">Supprimer une annonce</a>
      <a href="../logout.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700 transition">Déconnexion</a>
    </div>
  </div>
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
</div>
<?php } ?>
</body>
</html>
