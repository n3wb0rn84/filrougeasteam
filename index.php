<?php

//DIVERS CHARGEMENTS!

    //Importer les variables pour la connexion serveur
    include 'humhum.php';
	//Chargement de la session.
    session_start();
    //Chargement de la base de données.
    try
    {
      	// version Mysql
      	$bdd = new PDO('mysql:host=localhost;dbname=filrougeteam;charset=utf8', 'root', '');
      	//version PostgreSql
      	//$bdd = new PDO('pgsql:host='.$GLOBALS['host'].';port='.$GLOBALS['port'].';dbname='.$GLOBALS['dbname'].';user='.$GLOBALS['user'].';password='.$GLOBALS['pass'].'');
    }
    catch (Exception $e)
    {
      	die('Erreur : ' . $e->getMessage());
    }
    //Récupération des messages d'erreur.
    $sms = $_GET['sms'] ?? '';
	$sms = htmlspecialchars($sms);
	//Logout.
    if ($sms == 'logout')
    {
     	$_SESSION = array();
     	$sms = 'Déconnection réussie';
    }

//VERIFICATION DE l'IP DE SESSION!

    //Si la variable 'ip' de session n'existe pas, on la crée.
    if(!isset($_SESSION['ip']))
    {
      	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    }
    //Si la variable 'ip' de session a changé (il s'agit peut être d'une usurpation d'identité) => déconnection, retour à la page d'authentification.
    if($_SESSION['ip']!=$_SERVER['REMOTE_ADDR'])
    {
      	header('Location: index.php?sms=vous avez été déconnecté!');
      	$_SESSION = array();
      	exit;
    }
//VERIFICATION DES DONNEES DE SESSION!

    //Verifier s'il existe des données 'login' et 'pwd' dans la session.
    if(isset($_SESSION['login']) && isset($_SESSION['pwd']))
    {
        $login = htmlspecialchars($_SESSION['login']);
        $pwd = htmlspecialchars($_SESSION['pwd']);
        $stayOnPage = false;

        //Chargement de la requête préparée.
        $req = $bdd->prepare('SELECT nick, password FROM membres');
        $req->execute();
        //Pour chaque rangée...
        while ($compare = $req->fetch())
        {
        	//Si les données de session correspondent à un membre => chargement de la page Blog avec les droits administrateurs.
          	if ($login == $compare['nick'] && $pwd == $compare['password'])
          	{
          		$req->closeCursor();
          		$req = NULL;
          		header("Location: blog.php");
          	}
        }
        $_SESSION = array();
    }

//VERIFICATION DU LOGIN ET DU PASSWORD!

 	//Verification de l'existance des inputs.
  	if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pwd']) && !empty($_POST['pwd']))
  	{
  		//Récuperation des inputs.
  		$login = htmlspecialchars($_POST['login']);
		$pwd = htmlspecialchars($_POST['pwd']);
		$pwd = hash('sha256', $pwd);
  		//Chargement de la requête préparée.
	  	$req = $bdd->prepare('SELECT nick, password, activate FROM membres');
    	$req->execute();
    	//Pour chaque rangée...
		while ($compare = $req->fetch())
		{
			//Verifier si le login et le mot de passe sont corrects...
			if ($login == $compare['nick'] && $pwd == $compare['password'])
			{
				//Verifier si le compte a été activé par mail.
				if ($compare['activate'] == '')
				{
					//Insérer le login et le mot de passe dans la session.
					$_SESSION['login'] = $login;
					$_SESSION['pwd'] = $pwd;
					header("Location: blog.php");
				}
				else
				{
					$GLOBALS['sms'] = "Veuillez vérifier votre boîte mail. Un lien d'activation vous y a été envoyé lors de votre inscription!";
					return;
				}
			}
		}
		$req->closeCursor();
		$req = NULL;
		$GLOBALS['sms'] = "login ou mot de passe incorrect!";
  	}
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog - Authentification</title>
    <!--<link rel="stylesheet" href="assets/css/style.css">-->
</head>
<body>
	<div id="main">
		<form action="index.php" method="post">
	      	<legend><h1 class="legend">Authentification</h1></legend>
	  		<label for="login">Login</label>
	         	<input type="text" name="login" id="login" autofocus required>
	  		<label for="pwd">Password</label>
	         	<input type="password" name="pwd" id="pwd" autocomplete="off" required>
	  		<input class="submit" type="submit" value="Connexion">
		</form>
		<p class="sms">
	        <?php echo $sms; ?>
	    </p>
	</div>
</body>
</html>