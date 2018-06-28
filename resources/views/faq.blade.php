@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="titlePage">FAQ</h1>
	
    <?php



$dsn = 'mysql:dbname=laravelAuth;host=127.0.0.1';
$user = 'root';
$password = 'mysql';

try {
    $bdd = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
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

<div class="col-md-10">
<h3 class="subTitle"><?= $data[$i]["questions"]?></h3>
<p><?= $data[$i]["reponses"]?></p>
</div>
<?php 
} 
?> 
 </div> <!-- /container -->
@endsection