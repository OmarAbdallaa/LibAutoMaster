@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
            <h2 class="titlePage">{{ __('MES FAVORIS') }}</h2>
            </div>

        @if(session('message'))
            <div class='alert alert-success'>
                {{ session('message') }}
            </div>
        @endif
	
        <?php



$dsn = 'mysql:dbname=laravelauth;host=127.0.0.1';
$user = 'root';
$password = '';

try {
    $bdd = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (PDOException $e) {
    echo 'Échec de la connexion : ' . $e->getMessage();
    exit;
}



$sql = "SELECT * FROM `favoris` WHERE 1";
$res=$bdd->prepare("SELECT * FROM `favoris` WHERE 1");
$res->execute();
$data=$res->fetchAll();

// On affiche chaque entrée une à une

for($i = 0; $i < sizeof($data);$i++) {
?>

<div class="col"> 


</div>

            <div class="col-md-10">
                <h3 class="subTitle">Itinéraires</h3>
                <div class="card col-md-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $data[$i]["nomfavoris"]?></h5>
                        <p class="card-text"><span class="fromTo">DE:<?= $data[$i]["adressedepart"]?> </span></p>
                        <p class="card-text"><span class="fromTo">A: <?= $data[$i]["adressearriver"]?> </span></p>
                        <a href="#" class="btn btn-primary">Y ALLER</a>
                    </div>
                </div>
            </div>
            <?php 
} 
?> 
            <div class="col-md-10">
                <h3 class="subTitle">Stations</h3>
                <div class="card col-md-3">
                    <div class="card-body">
                        <h5 class="card-title">Nom favori</h5>
                        <p class="card-text"><span class="fromTo">A: </span></p>
                        <a href="#" class="btn btn-primary">Y ALLER</a>
                    </div>
                </div>
            </div>

        </div>
    </div> <!-- /container -->
@endsection