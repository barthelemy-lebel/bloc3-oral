<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier une annonce</title>
  <link rel="stylesheet" href="/src/output.css" />
</head>
<body class="min-h-screen bg-gray-100">
  <div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
      <h1 class="text-2xl font-bold text-gray-700">Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
      <p class="mt-2 text-gray-600">C'est votre espace admin.</p>
      <div class="mt-4 flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4">
        <a href="home.php" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition">Accueil</a>
        <a href="add_submissions.php" class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-700 transition">Ajouter une annonce</a>
        <a href="modify_submissions.php" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-700 transition">Modifier une annonce</a>
        <a href="#" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 transition">Supprimer une annonce</a>
        <a href="../logout.php" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700 transition">Déconnexion</a>
      </div>
    </div>
    <?php
    require('../config.php');

    if (isset($_POST['submit'])) {
      // Récupérer les données du formulaire
      $id = $_POST['id'];
      $title = stripslashes($_POST['title']);
      $title = mysqli_real_escape_string($conn, $title); 
      $price = stripslashes($_POST['price']);
      $price = mysqli_real_escape_string($conn, $price);
      $localisation = stripslashes($_POST['localisation']);
      $localisation = mysqli_real_escape_string($conn, $localisation);
      
      // Préparer et exécuter la requête SQL pour mettre à jour l'annonce
      $query = $conn->prepare("UPDATE `submissions` SET title = ?, price = ?, localisation = ? WHERE id = ?");
      $query->bind_param("sssi", $title, $price, $localisation, $id);
      $res = $query->execute();

      if ($res) {
        echo "<div class='success'>
                <h3>L'annonce a été mise à jour avec succès.</h3>
                <p>Redirection automatique vers <a href='home.php' class='text-purple-500'>l'accueil</a>...</p>
              </div>";
        // Redirection vers la page d'accueil après 2 secondes
        header("refresh:2;url=home.php");
      } else {
          echo "<div class='error'>
                  <h3>Une erreur s'est produite. Veuillez réessayer.</h3>
                </div>";
      }
    }
    ?>
    
    <div class="container mx-auto p-4">
      <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Modifier une annonce</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6">
          <form class="space-y-4" action="" method="post">
            <input type="number" name="id" class="box-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
            placeholder="ID de l'annonce" required />

            <input type="text" name="title" class="box-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
            placeholder="Titre de l'annonce" required />

            <input type="text" name="price" class="box-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
            placeholder="Prix" required />

            <input type="text" name="localisation" class="box-input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
            placeholder="Localisation" required />

            <input type="submit" name="submit" value="Enregistrer les modifications" 
            class="box-button px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-700 w-full transition" />
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
