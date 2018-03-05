<?php

//DIVERS CHARGEMENTS!

    //Importer les données pour la connexion serveur.
    include 'humhum.php';
    //Importer le test de session.
    include 'session.php';
//OPTIONS ADMIN!
    if ($sessionOk)
    {
    }
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
    //Requête préparée.
    $req = $bdd->prepare('SELECT * FROM articles ORDER BY id_articles DESC');
    $req->execute();
//SYSTEME DE PAGINATION
    $articleNumberByPage = 5;
    $articlesArray = $req->fetchAll();
    $articleNumberTotal = count($articlesArray);
 	$pageNumberMax = $articleNumberTotal / $articleNumberByPage;
 	$pageNumberMax = ceil($pageNumberMax);
 	$pageNumberRest = $pageNumberMax % $articleNumberByPage;
 	$pageActuelle = $_GET['page'] ?? 1;

 	//système de tri par catégories.
 	$articlesArrayFilter = array();
 	if (isset($_POST['categories']))
 	{
 		$categories = $_POST['categories'];
 		var_dump($categories);
	 	/*for ($i = 0; $i < $articleNumberTotal; $i++)
	 	{
	 		for ($j = 0; $j < count($categories); $j)
	 		{ 				echo $categories[$j];

	 			if ($articlesArray[$i] == $categories[$j])
	 			{
	 				array_push($articlesArrayFilter, $articlesArray[$i]);
	 			}
	 		}
	 	}*/
	 }




	//Si le numero de la page actuelle est plus grand que le nombre de pages ou qu'il ne s'agit pas d'un chiffre...
 	if (!isset($pageActuelle) || $pageActuelle > $pageNumberMax || filter_var($pageActuelle, FILTER_VALIDATE_INT) == false)
 	{
 		//...chargement page 1.
 		$pageActuelle = 1;
 	}
 	else
 	{
 		//Si déplacement vers la page précédente => chargement dernière page.
 		$pageActuelle = $pageActuelle < 0 ? $pageNumberMax : $pageActuelle;
 	}
 	//Changement d'index pour parcourir l'array 'articlesArray' en fonction de la page affichée.
 	$articlesOnThisPageFirstIndex = $articleNumberByPage * ($pageActuelle - 1);
 	//Changement du nombre d'articles à afficher si on se trouve sur la dernière page.
 	$articleNumberByPage = $pageActuelle == $pageNumberMax ? ($articleNumberByPage - $pageNumberRest) : $articleNumberByPage;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <!--<link rel="stylesheet" href="assets/css/style.css">-->
</head>
<body>
	<div id="main">
		<a href="index.php?sms=logout">|lougout|</a>
		<h1>Blog</h1>
		<form action="blog.php" method="post">
			<input type="checkbox" name="categories[]" value="cat1">
			<input type="checkbox" name="categories[]" value="cat2">
			<input type="checkbox" name="categories[]" value="cat3">
			<input type="checkbox" name="categories[]" value="cat4">
			<input type="checkbox" name="categories[]" value="cat5">
			<input type="submit" value="valdier">
		</form>
		<div class='articles'>
		<?php
			$pagePrevious = $pageActuelle == 1 ? $pageNumberMax : $pageActuelle - 1;
		?>
			<a class="pagin_arrow" href="blog.php?page=<?=$pagePrevious?>">&#171;</a>
		<?php
			for ($i = 0; $i < $pageNumberMax; $i++)
			{
				$pageNumberList = $i+1;
		?>
				<a class="paginPages" href="blog.php?page=<?=$pageNumberList?>"><?=$pageNumberList?></a>
		<?php
			}
			$pageNext = $pageActuelle == $pageNumberMax ? 1 : $pageActuelle + 1;
		?>
			<a class="pagin_arrow" href="blog.php?page=<?=$pageNext?>">&#187;</a>
		<?php
			for ($i = 0, $j = $articlesOnThisPageFirstIndex; $i < $articleNumberByPage; $i++, $j++)
	        {
		?>
				<h2><?php echo $articlesArray[$j]['titre']; ?><span> | <?php echo $articlesArray[$j]['date']; ?></span></h2>
		       	<p><?php echo $articlesArray[$j]['contenu']; ?></p>
		<?php
			}
		?>
		</div>
	</div>
	<?php
	    $req->closeCursor();
        $req = NULL;
	?>
</body>
</html>