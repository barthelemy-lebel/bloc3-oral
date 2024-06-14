<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <?php
  require('config.php');

  if (isset($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'])){
    // récupérer le nom d'utilisateur 
    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($conn, $username); 
    // récupérer l'email 
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    // récupérer le mot de passe 
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "INSERT into `users` (username, email, type, password)
              VALUES ('$username', '$email', 'user', '".hash('sha256', $password)."')";
    $res = mysqli_query($conn, $query);

    if($res){
      echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative' role='alert'>
              <strong class='font-bold'>Succès!</strong>
              <span class='block sm:inline'> Vous êtes inscrit avec succès.</span>
              <span class='absolute top-0 bottom-0 right-0 px-4 py-3'>
                <svg class='fill-current h-6 w-6 text-green-500' role='button' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M14.59 6.41L10 11l-4.59-4.59L4 7l6 6 6-6z'/></svg>
              </span>
              <p>Cliquez ici pour vous <a href='login.php' class='underline text-purple-500'>connecter</a></p>
            </div>";
    }
  } else {
  ?>
  <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">S'inscrire</h2>
    <form action="" method="post">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Nom d'utilisateur</label>
        <input type="text" name="username" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Nom d'utilisateur" required />
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
        <input type="email" name="email" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Email" required />
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mot de passe</label>
        <input type="password" name="password" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Mot de passe" required />
      </div>
      <div class="flex items-center justify-between">
        <button type="submit" name="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          S'inscrire
        </button>
      </div>
      <p class="text-gray-600 text-sm mt-6">Déjà inscrit? <a href="login.php" class="text-purple-500 hover:text-purple-800">Connectez-vous ici</a></p>
    </form>
  </div>
  <?php } ?>
</body>
</html>
