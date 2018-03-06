<?php

//DIVERS CHARGEMENTS!

    //Importer les données pour la connexion serveur.
    include 'humhum.php';
    //Importer le test de session.
    include 'session.php';
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
//OPTIONS ADMIN!
    if ($sessionOk)
    {
    }
//TRIAGE
    //Variables qui serviront à garder les checkboxs séléctionnées lors du submit.
 	$catCheck1 = '';
 	$catCheck2 = '';
 	$catCheck3 = '';
 	$catCheck4 = '';
 	$catbyand = '';
 	$catbyor = '';
 	//Récupérer les categories séléctionnées.
 	$categorie1 = htmlspecialchars(isset($_GET['categorie1'])) && htmlspecialchars($_GET['categorie1']) == true ? htmlspecialchars($_GET['categorie1']) : '';

	$categorie2 = htmlspecialchars(isset($_GET['categorie2'])) && htmlspecialchars($_GET['categorie2']) == true ? htmlspecialchars($_GET['categorie2']) : '';

	$categorie3 = htmlspecialchars(isset($_GET['categorie3'])) && htmlspecialchars($_GET['categorie3']) == true ? htmlspecialchars($_GET['categorie3']) : '';

	$categorie4 = htmlspecialchars(isset($_GET['categorie4'])) && htmlspecialchars($_GET['categorie4']) == true ? htmlspecialchars($_GET['categorie4']) : '';

	$categorie5 = htmlspecialchars(isset($_GET['catandor'])) && htmlspecialchars($_GET['catandor']) == 'catbyand' ? true : '';

	$categorie6 = htmlspecialchars(isset($_GET['catandor'])) && htmlspecialchars($_GET['catandor']) == 'catbyor' ? true : '';
	//Tester s'il existe au moins une categorie séléctionnée.
 	if ($categorie1 != '' || $categorie2 != '' || $categorie3 != '' || $categorie4 != '')
 	{
 		$categories = array();
 		if ($categorie1 == true)
 		{ 		
	 		array_push($categories, 1);
 		}
 		if ($categorie2 == true)
 		{ 		
	 		array_push($categories, 2);
 		} 		
 		if ($categorie3 == true)
 		{ 		
	 		array_push($categories, 3);
 		} 		
 		if ($categorie4 == true)
 		{ 		
	 		array_push($categories, 4);
 		}
 		if ($categorie5 == true)
 		{ 		
	 		array_push($categories, 5);
 		}
 		if ($categorie6 == true)
 		{ 		
	 		array_push($categories, 6);
 		}
 		$categoriesLength = count($categories);
	 	//Garder les champs checked dans formulaire après submit.
		for ($j = 0; $j < $categoriesLength; $j++)
		{
			switch ($categories[$j])
		   	{
		    case "1":
		        $catCheck1 = 'checked';
		        break;
		    case "2":
		        $catCheck2 = 'checked';
		        break;
		    case "3":
		        $catCheck3 = 'checked';
		        break;
		     case "4":
		        $catCheck4 = 'checked';
		        break;
		    case "5":
		        $catbyand = 'checked';
		        $catandor = 'catbyand';
		        break;
		     case "6":
		        $catbyor = 'checked';
		        $catandor = 'catbyor';
		        break;
			}
		}
		//Requête préparée.
		if ($catbyor == 'checked')
		{
		    $req = $bdd->prepare('
		    	SELECT * 
		    	FROM articles
		    	INNER JOIN relations
		    	ON relations.id_articles = articles.id_articles
		    	WHERE
				 	relations.categorie1 = :cat1 AND relations.categorie1 = 1
				OR
					relations.categorie2 = :cat2 AND relations.categorie2 = 1
				OR
					relations.categorie3 = :cat3 AND relations.categorie3 = 1
				OR
					relations.categorie4 = :cat4 AND relations.categorie4 = 1
		    	ORDER BY articles.id_articles DESC');
		}
		else
		{
			$req = $bdd->prepare('
		    	SELECT * 
		    	FROM articles
		    	INNER JOIN relations
		    	ON relations.id_articles = articles.id_articles
		    	WHERE
				 	relations.categorie1 = :cat1
				AND
					relations.categorie2 = :cat2
				AND
					relations.categorie3 = :cat3
				AND
					relations.categorie4 = :cat4
		    	ORDER BY articles.id_articles DESC');
		    	$catbyand = 'checked';	
		}
	    $req->bindParam(':cat1', $categorie1, PDO::PARAM_BOOL);
	   	$req->bindParam(':cat2', $categorie2, PDO::PARAM_BOOL);
	   	$req->bindParam(':cat3', $categorie3, PDO::PARAM_BOOL);
	    $req->bindParam(':cat4', $categorie4, PDO::PARAM_BOOL);
	    $req->execute();
	   	$articlesArray = $req->fetchAll();
	   	$req->closeCursor();
        $req = NULL;
       	//Récuperation des rangées de la table 'articles' dans un array.
	 	//$articlesArray = $req->fetchAll();
	}
	//Sinon, on charge tous les articles.
	else
	{
		$req = $bdd->prepare('
	    SELECT * 
	    FROM articles
	   	ORDER BY id_articles DESC');
	   	$req->execute();
	   	$articlesArray = $req->fetchAll();
	   	$req->closeCursor();
        $req = NULL;
	}
 	$articleNumberTotal = count($articlesArray);
 	$articleNumberByPage = 5;
 	//Si le nombre total d'article sur une page est inférieur au nombre total d'articles alors on fixe le nombre d'articles par page à ce dernier.
 	$articleNumberByPage = $articleNumberTotal < $articleNumberByPage ? $articleNumberTotal : $articleNumberByPage;
 	//S'il n'y aucun articles suite au tri, c'est qu'il y'a eu erreur ou injection => reinitialisation des données pour afficher la page sans catégories filtrées.
	/*if ($articleNumberTotal == 0)
	{
		$articlesArrayFilter = $articlesArray;
		$articleNumberTotal = count($articlesArrayFilter);
	 	$articleNumberByPage = 5;
	}*/
 	$pageNumberMax = $articleNumberByPage > 0 && $articleNumberTotal > 0 ? $articleNumberTotal / $articleNumberByPage : 1;
 	$pageNumberMax = ceil($pageNumberMax);
 	//Récuperer la valeur de la page transmise par l'url.
 	if (htmlspecialchars(isset($_GET['page'])))
 	{
 		$pageActuelle = htmlspecialchars($_GET['page']);
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
 	/*$articleNumberByPage = $pageActuelle == $pageNumberMax ? ($articleNumberByPage - $pageNumberRest) : $articleNumberByPage;*/
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
			<label for="categorie1">categorie1</label>
			<input type="checkbox" name="categorie1" <?php echo $catCheck1;?>>
			<label for="categorie2"> | categorie2</label>
			<input type="checkbox" name="categorie2" <?php echo $catCheck2;?>>
			<label for="categorie3"> | categorie3</label>
			<input type="checkbox" name="categorie3" <?php echo $catCheck3;?>>
			<label for="categorie4"> | categorie4</label>
			<input type="checkbox" name="categorie4" <?php echo $catCheck4;?>>
			<label for="catbyand"> | AND</label>
			<input type="radio" name="catandor" value="catbyand" <?php echo $catbyand;?>>
			<label for="catbyor"> | OR</label>
			<input type="radio" name="catandor" value="catbyor" <?php echo $catbyor;?>>
			<input type="submit" value="valider">
		</form>
		<div class='articles'>
		<?php
			$pagePrevious = $pageActuelle == 1 ? $pageNumberMax : $pageActuelle - 1;
		?>
			<a class="pagin_arrow" href="blog.php?page=<?=$pagePrevious?>&categorie1=<?=$categorie1?>&categorie2=<?=$categorie2?>&categorie3=<?=$categorie3?>&categorie4=<?=$categorie4?>&catandor=<?=$catandor?>">&#171;</a>
		<?php
			for ($i = 0; $i < $pageNumberMax; $i++)
			{
				$pageNumberList = $i+1;
		?>
				<a class="paginPages" href="blog.php?page=<?=$pageNumberList?>&categorie1=<?=$categorie1?>&categorie2=<?=$categorie2?>&categorie3=<?=$categorie3?>&categorie4=<?=$categorie4?>&catandor=<?=$catandor?>"><?=$pageNumberList?></a>
		<?php
			}
			$pageNext = $pageActuelle == $pageNumberMax ? 1 : $pageActuelle + 1;
		?>
			<a class="pagin_arrow" href="blog.php?page=<?=$pageNext?>&categorie1=<?=$categorie1?>&categorie2=<?=$categorie2?>&categorie3=<?=$categorie3?>&categorie4=<?=$categorie4?>&catandor=<?=$catandor?>">&#187;</a>
		<?php
			for ($i = 0, $j = $articlesOnThisPageFirstIndex; $i < $articleNumberByPage; $i++, $j++)
	        {
				if(isset($articlesArray[$j]))
				{
		?>
					<h2><?php echo $articlesArray[$j]['titre']; ?><span> | <?php echo $articlesArray[$j]['date']; ?></span></h2>
			       	<p><?php echo $articlesArray[$j]['contenu']; ?></p>
		<?php
		       }
			}
		?>
		</div>
	</div>
</body>
</html>