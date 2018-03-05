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

//FILTRES & PAGINATION!
    //Récuperation des rangées de la table 'articles' dans un array.
    $articlesArray = $req->fetchAll();
    $articleNumberTotal = count($articlesArray);
   	$articleNumberByPage = 5;
 	//Système de tri par catégories.
 	$articlesArrayFilter = array();
 	//Variables qui serviront à garder les checkboxs séléctionnées lors du submit.
 	$cat1 = '';
 	$cat2 = '';
 	$cat3 = '';
 	$cat4 = '';
 	//Tester si des categories ont été séléctionnées. Pour des raisons de sécurité, on vérifie qu'il n'y en pas plus de 4 (les 4 présentes pour le moment).
 	if (isset($_GET['categorie1']) || isset($_GET['categorie2']) || isset($_GET['categorie3']) || isset($_GET['categorie4']))
 	{
 		$categorie1 = '';
 		$categorie2 = '';
 		$categorie3 = '';
 		$categorie4 = '';

 		$categories = array();
 		if (isset($_GET['categorie1']) && $_GET['categorie1'] == true)
 		{ 		
 			$categorie1 = $_GET['categorie1'];
	 		array_push($categories, 1);
 		}
 		if (isset($_GET['categorie2']) && $_GET['categorie2'] == true)
 		{
 			 $categorie2 = $_GET['categorie2'];
	 		array_push($categories, 2);
 		} 		
 		if (isset($_GET['categorie3']) && $_GET['categorie3'] == true)
 		{
 			$categorie3 = $_GET['categorie3'];
	 		array_push($categories, 3);
 		} 		
 		if (isset($_GET['categorie4']) && $_GET['categorie4'] == true)
 		{
 			$categorie4 = $_GET['categorie4'];
	 		array_push($categories, 4);
 		}
 		$categoriesLength = count($categories);
 		//Pour garder les champs checked dans formulaire après submit. Cet entête de boucle sera executé une seconde fois, quelques lignes plus loin pour filtrer les articles. Cependant vu la nature de cette boucle, elle s'arrête lorsqu'elle trouve la premiere catégorie correspondant à l'article. Même si cet article se situe dans plusieurs de celles-ci. Elle ne pourra donc pas être utilisée pour valider les checkboxs.
		for ($j = 0; $j < $categoriesLength; $j++)
		{
			switch ($categories[$j])
		   	{
		    case "1":
		        $cat1 = 'checked';
		        break;
		    case "2":
		        $cat2 = 'checked';
		        break;
		    case "3":
		        $cat3 = 'checked';
		        break;
		     case "4":
		        $cat4 = 'checked';
		        break;
			}
		}
 		//Boucle dans les articles...
	 	for ($i = 0; $i < $articleNumberTotal; $i++)
	 	{
	 		//Boucle dans les catégories séléctionnées...
	 		for ($j = 0; $j < $categoriesLength; $j++)
	 		{
	 			//Si l'article fait partie de la catégorie on l'ajoute dans l'array 'articlesArrayFilter' et on sort de la boucle 'catégories'. De plus, pour des raisons de sécurité on vérifie que l'élément de l'array 'catégories' est bien un nombre entier compris entre 1 et 4 (les 4 catégories).
	 			if ($articlesArray[$i]['categorie'.$categories[$j].''] == true && $categories[$j] >= 1 && $categories[$j] <= 4)
	 			{
	 				array_push($articlesArrayFilter, $articlesArray[$i]);
	 				break;
	 			}
	 		}
	 	}
	 	$articleNumberTotal = count($articlesArrayFilter);
	 	//Si le nombre total d'article sur une page est inférieur au nombre total d'articles alors on fixe le nombre d'articles par page à ce dernier.
	 	$articleNumberByPage = $articleNumberTotal < $articleNumberByPage ? $articleNumberTotal : $articleNumberByPage;
	 	//S'il n'y aucun articles suite au tri, c'est qu'il y'a eu erreur ou injection => reinitialisation des données pour afficher la page sans catégories filtrées.
		/*if ($articleNumberTotal == 0)
		{
			$articlesArrayFilter = $articlesArray;
			$articleNumberTotal = count($articlesArrayFilter);
		 	$articleNumberByPage = 5;
		}*/
	}
	else
	{
		$articlesArrayFilter = $articlesArray;
	}

 	$pageNumberMax = $articleNumberTotal / $articleNumberByPage;
 	$pageNumberMax = ceil($pageNumberMax);
 	$pageNumberRest = $pageNumberMax % $articleNumberByPage;
 	//Récuperer la valeur de la page transmise par l'url.
 	if (isset($_GET['page']))
 	{
 		$pageActuelle = $_GET['page'];
 		$pageActuelle = htmlspecialchars($pageActuelle);
 	}
 	else
 	{
 		$pageActuelle = 1;
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
		<form action="blog.php" method="get">
			<input type="checkbox" name="categorie1" <?php echo $cat1;?>>
			<input type="checkbox" name="categorie2" <?php echo $cat2;?>>
			<input type="checkbox" name="categorie3" <?php echo $cat3;?>>
			<input type="checkbox" name="categorie4" <?php echo $cat4;?>>
			<input type="submit" value="valider">
		</form>
		<div class='articles'>
		<?php
			$pagePrevious = $pageActuelle == 1 ? $pageNumberMax : $pageActuelle - 1;
		?>
			<a class="pagin_arrow" href="blog.php?page=<?=$pagePrevious?>&categorie1=<?=$categorie1?>&categorie2=<?=$categorie2?>&categorie3=<?=$categorie3?>&categorie4=<?=$categorie4?>">&#171;</a>
		<?php
			for ($i = 0; $i < $pageNumberMax; $i++)
			{
				$pageNumberList = $i+1;
		?>
				<a class="paginPages" href="blog.php?page=<?=$pageNumberList?>&categorie1=<?=$categorie1?>&categorie2=<?=$categorie2?>&categorie3=<?=$categorie3?>&categorie4=<?=$categorie4?>"><?=$pageNumberList?></a>
		<?php
			}
			$pageNext = $pageActuelle == $pageNumberMax ? 1 : $pageActuelle + 1;
		?>
			<a class="pagin_arrow" href="blog.php?page=<?=$pageNext?>&categorie1=<?=$categorie1?>&categorie2=<?=$categorie2?>&categorie3=<?=$categorie3?>&categorie4=<?=$categorie4?>">&#187;</a>
		<?php
			for ($i = 0, $j = $articlesOnThisPageFirstIndex; $i < $articleNumberByPage; $i++, $j++)
	        {
				if(isset($articlesArrayFilter[$j]))
				{
		?>
					<h2><?php echo $articlesArrayFilter[$j]['titre']; ?><span> | <?php echo $articlesArrayFilter[$j]['date']; ?></span></h2>
			       	<p><?php echo $articlesArrayFilter[$j]['contenu']; ?></p>
		<?php
		       }
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