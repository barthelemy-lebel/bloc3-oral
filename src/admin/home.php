<?php
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit(); 
  }

  require('../config.php');

  // Récupération des annonces pour les afficher sur la page d'accueil
  $query = "SELECT * FROM submissions";
  $submissions = mysqli_query($conn, $query);

  if (!$submissions) {
    die("Erreur lors de la récupération des annonces: " . mysqli_error($conn));
  }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="/src/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
      <h1 class="text-2xl font-bold text-gray-700">Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
      <p class="mt-2 text-gray-600">C'est votre espace admin.</p>
      <div class="mt-4 flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">
        <a href="home.php" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition">Accueil</a>
        <a href="add_submissions.php" class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-700 transition">Ajouter une annonce</a>
        <a href="modify_submissions.php" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-700 transition">Modifier une annonce</a>
        <a href="delete_submissions.php" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition">Supprimer une annonce</a>
        <a href="../logout.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700 transition">Déconnexion</a>
      </div>
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
