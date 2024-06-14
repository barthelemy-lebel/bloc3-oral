<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire de Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
  <style>
    /* Ajoutez ici des styles spécifiques si nécessaire */
    body {
      background-color: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .box {
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 300px;
    }
    .errorMessage {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <?php
  require('config.php');
  session_start();

  $message = '';

  if (isset($_POST['username'])) {
    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($conn, $username);
    $_SESSION['username'] = $username;
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    $query = "SELECT * FROM `users` WHERE username='$username' and password='" . hash('sha256', $password) . "'";

    $result = mysqli_query($conn, $query) or die(mysql_error());

    if (mysqli_num_rows($result) == 1) {
      $user = mysqli_fetch_assoc($result);
      // Vérifie si l'utilisateur est administrateur ou non
      if ($user['type'] == 'admin') {
        header('location: admin/home.php');
        exit;
      } else {
        header('location: index.php');
        exit;
      }
    } else {
      $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
  }
  ?>
  
  <div class="max-w-sm mx-auto mt-10">
    <form class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 shadow-purple-500" method="post" name="login">
    <h1 class="box-title font-bold my-4 text-2xl">Se Connectez</h1>  
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Nom d'utilisateur</label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Nom d'utilisateur" required>
      </div>
      <div>
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mot de passe</label>
        <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="*********" required>
      </div>
      <div class="flex flex-col items-center justify-between">
        <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit" name="submit">
          Connexion
        </button>
        <a class="inline-block align-baseline font-bold text-sm text-purple-500 hover:text-purple-800" href="register.php">
          Vous êtes nouveau ici? S'inscrire
        </a>
      </div>
      <?php if (!empty($message)) { ?>
        <p class="text-red-500 text-xs italic mt-2"><?php echo $message; ?></p>
      <?php } ?>
    </form>
  </div>
</body>
</html>
