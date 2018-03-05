<?php
//VERIFICATION DES DONNEES DE SESSION!
    session_start();
    //Si la variable 'ip' de session n'existe pas, on la crée.
    if(!isset($_SESSION['ip']))
    {
      $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    }
    //Si la variable 'ip' de session a changé (il s'agit peut être d'une usurpation d'identité) => déconnection, retour à la page d'authentification.
    if($_SESSION['ip']!=$_SERVER['REMOTE_ADDR'])
    {
      header('Location: index.php?smsError=vous avez été déconnecté!');
      $_SESSION = array();
      exit;
    }
    //Verifier si l'utilisateur est déjà log.
    if(isset($_SESSION['login']) && isset($_SESSION['pwd']))
    {
      //Connexion à la base de donnée.
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
        $login = htmlspecialchars($_SESSION['login']);
        $pwd = htmlspecialchars($_SESSION['pwd']);
        $sessionOk = false;

        //Chargement de la requête préparée.
        $req = $bdd->prepare('SELECT nick, password FROM membres');
        $req->execute();
        //Pour chaque rangée...
        while ($compare = $req->fetch())
        {
          if ($login == $compare['nick'] && $pwd == $compare['password'])
          {
            $sessionOk = true;
          }
        }
        //Si la varible 'sessionOk' n'est pas passée à 'true' lors de la vérifiaction précédente, la session est vidée et retour à la page d'authentification.
        if ($sessionOk == false)
        {
          $req->closeCursor();
          $req = NULL;
          $_SESSION = array();
          header("Location: index.php");
        }
        $req->closeCursor();
        $req = NULL;
      }
    else
    {
        header("Location: index.php");
    }
    //basename(__FILE__);
?>