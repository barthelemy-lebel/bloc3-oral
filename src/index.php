<?php
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit(); 
  }

  require('./config.php');

  // Récupération des annonces pour les afficher sur la page d'accueil
  $query = "SELECT * FROM submissions";
  $submissions = mysqli_query($conn, $query);

  if (!$submissions) {
    die("Erreur lors de la récupération des annonces: " . mysqli_error($conn));
  }
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="/src/output.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div class="sucess">
      <div class="flex flex-row align-bottom justify-start flex-wrap gap-4">
        <h1 class="text-3xl" >Bienvenue <span class="text-purple-500"><?php echo $_SESSION['username']; ?></span>!</h1>
        <a href="logout.php" class=" px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700 transition">Déconnexion</a>
      </div>
      <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Toutes les annonces</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php while($row = mysqli_fetch_assoc($submissions)): ?>
            <div class="bg-white rounded-lg shadow-md p-4">
              <div class="flex flex-row justify-between align-center">
                <h3 class="text-lg font-bold text-gray-700"><?php echo htmlspecialchars($row['title']); ?></h3>
                <div class="circle rounded-full w-8 h-8 p-0 text-lg flex flex-row align-center justify-center bg-purple-500 text-white"><?php echo htmlspecialchars($row['id']); ?></div>
              </div>
              
              <p class="mt-2 text-gray-600">Prix: <span class="text-purple-600 font-bold"><?php echo htmlspecialchars($row['price']); ?></span>€</p>
              <p class="mt-2 text-gray-600">Localisation: <span class=" border-b border-b-2 border-purple-600 font-bold"><?php echo htmlspecialchars($row['localisation']); ?></p>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </body>
</html>