@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="titlepage">FAQ</h1>
	
    <?php



$dsn = 'mysql:dbname=laravelauth;host=127.0.0.1';
$user = 'root';
$password = '';

/*
    L'utilisation des blocs try/catch autour du constructeur est toujours valide
    même si nous définissons le ERRMODE à WARNING sachant que PDO::__construct
    va toujours lancer une exception PDOException si la connexion échoue.
*/
try {
    $bdd = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (PDOException $e) {
    echo 'Échec de la connexion : ' . $e->getMessage();
    exit;
}



$sql = "SELECT * FROM `faq` WHERE 1";
$res=$bdd->prepare("SELECT * FROM `faq` WHERE 1");
$res->execute();
$data=$res->fetchAll();

// On affiche chaque entrée une à une

for($i = 0; $i < sizeof($data);$i++) {
?>

<div class="col"> 
<h3><?= $data[$i]["questions"]?></h3>
<p><?= $data[$i]["reponses"]?></p>
</div>
<?php 
} 
?> 
 </div> <!-- /container -->
@endsection