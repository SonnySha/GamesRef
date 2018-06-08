<?php
require_once('model/AccountManager.php');
require_once('model/GamesManager.php');
require_once('controller/controllerGames.php');
require_once('controller/elementsView.php');
    
    $elementConnection = '<a href="action/connection"><span class="glyphicon glyphicon-user"></span> Se connecter</a>';    
    $accountExist = false;
    $idUser = -1;
    if(isset($_SESSION['pseudo']) && isset($_SESSION['password'])) {
        $accountManager = new AccountManager;
        $accountExist  = $accountManager -> connexionAccount($_SESSION['pseudo'], $_SESSION['password']);


        if($accountExist) {
            $infoAccount = $accountManager -> infoAccount($_SESSION['pseudo']);
            $idUser = $infoAccount['id'];
            $arrayFavorites = getFavorites($idUser);
            $favorites = $arrayFavorites->fetchAll(PDO::FETCH_COLUMN, 0);
        } else {
            $idUser = -1;
        }

    }
    
     $gameManager = New GamesManager();
    $tabconsoles = viewConsoles();
    $tabGenres = viewGenres();


                        
                           
    
?>

    <!DOCTYPE html>
    <html>

    <head>
        <base href="/gamesRef/">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width" />
        <title>Games Ref</title>

        <!-- CDN Bootstrap -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- CDN Icone -->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- Css -->
        <link href="public/css/styleTemplate.css" rel="stylesheet">
        <link href="public/css/styleTest.css" rel="stylesheet">
        <!-- MediaQueries -->
        <link rel="stylesheet" media="all and (max-device-width: 480px)" href="public/css/styleMediaXs.css" />
        <link rel="stylesheet" media="all and (max-device-width: 990px)" href="public/css/styleMediaXs.css" />
        <!-- Police -->
        <link href="https://fonts.googleapis.com/css?family=Krona+One|Montserrat|PT+Sans|Raleway" rel="stylesheet">
    </head>


    <body class="background-color-custom">

        <div class="container-fluidd">

            <div id="background-header">
                <div id="btnConection" class="pull-left">
<?php
                    if($accountExist) {
                        $dashboard = "action/viewdashboard/" . $infoAccount['id'];
                        elementConnexionOn($infoAccount['avatar'], $infoAccount['pseudo']);
                    } else {
                        elementConnexionOff();
                    }
?>
                </div>
            </div>
                   
            <header>
               <nav id="nav-console" class="container text-center">
                    <form id="form-search-bar" action="action/s/1" method="post" class="col-md-12" >
                        <div class="input-group">
                            <input name="searchBar" type="text" class="form-control" placeholder="Rechercher">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                            </div>
                        </div>
                    </form>
                    <ul class="nav nav-pills list-nav-consoles col-md-12">
                       <li class="active"><a class="item-nav-console" href="#allGenres" data-toggle="tab">Tous</a></li> 
                        <?php
                        for($i = 0; $i < count($tabconsoles); $i++) {
?>
                       <li><a class="item-nav-console" href="#<?=$tabconsoles[$i]?>" data-toggle="tab"><?=$tabconsoles[$i]?></a></li>  
                       
                       
<?php
                        }


?>
                    </ul>

                   


                   <div class="tab-content col-md-12">
                   
                   <div class="tab-pane active" id="allGenres">
                            <ul class="list-label-genres">
                            <li class="li-genre"><a class="label-genres" href="">Home</a></li>
                            <li class="li-genre"><a class="label-genres" href="action/listGames/1">Tous les jeux</a></li>
<?php
                                foreach($tabGenres as $genre) {
?>
                                <li class="li-genre"><a class="label-genres" href="action/search/genres/<?= $genre ?>/1"><?= $genre ?></a></li>
<?php
                                }
?>
                            </ul>
                        </div>
                   
                   
                   
                   <div class="tab-pane <?= $classActive ?>" id="<?= $tabconsoles[$i] ?>">
                            <ul class="list-label-genres">
<?php
                           $tabGenres = $gameManager->searchGenresForConsole($tabconsoles[$i]);
                            
                            for($i2 = 0; $i2 < count($tabGenres); $i2++) {
                                
                                
                                if(isset($tabGenres[$i2])) {
 ?>                               
                                   <li class="li-genre"><a class="label-genres" href="action/search/genres/<?= $tabGenres[$i2] ?>/1"><?= $tabGenres[$i2] ?></a></li>
                                   
<?php
                                }

                            

                            }
?>
                            </ul>
                        </div>
                    
<?php

                       for($i = 0; $i < count($tabconsoles); $i++) {

?>
                        <div class="tab-pane" id="<?= $tabconsoles[$i] ?>">
                            <ul class="list-label-genres">
<?php
                           $tabGenres = $gameManager->searchGenresForConsole($tabconsoles[$i]);
                            
                            for($i2 = 0; $i2 < count($tabGenres); $i2++) {
                                
                                
                                if(isset($tabGenres[$i2])) {
 ?>                               
                                   <li class="li-genre"><a class="label-genres" href="action/search/genres/<?= $tabGenres[$i2] ?>/1"><?= $tabGenres[$i2] ?></a></li>
                                   
<?php
                                }

                            

                            }
?>
                            </ul>
                        </div>
                            
                            
                        
<?php
                       }
?>
                       
                    </div>
                    
               </nav>
                
            </header>

            <section class="container">


                <?= $content ?>


            </section>




            <footer>
                <p>Ceci est un projet personnel, réalisé pour mettre en pratique des techniques de développement appris en autodidacte. Toutes les informations telles que les commentaires/likes ou les fiches techniques des jeux ne sont pas exactes.</p>
                <p class="copyright pull-right">Réalisé par <a href="http://www.sonnyweb.fr/SonnyWebsite/">SonnyWeb</a></p>
            </footer>





        </div>







        <!-- CDN JQuery -->
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

    </html>
