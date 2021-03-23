<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions

session_start();

@$email= '';
@$street= '';
@$streetNumber= '';
@$city= '';
@$zipcode= '';

@$erreurEmail='';
@$erreurStreet='';
@$erreurStreetNumber='';
@$erreurZipcode='';


$totalValue = 0;

//print_r($_POST);//test

function valid_data($data) {
    $data = trim($data); // trim () pour supprimer les espaces inutiles
    $data = stripslashes($data);// stripslashes() pour supprimer les antislashes que certains hackers pourraient utiliser pour échapper des caractères spéciaux
    $data = htmlspecialchars($data);
    // htmlspecialchars () pour permettre d’échapper certains caractères spéciaux comme les chevrons « < » et « > » en les transformant en entités HTML.
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST["email"])) {
        $email = valid_data($_POST["email"]);
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurEmail = '<div class="alert alert-danger" role="alert">Invalid Email !</div>';
    }

    if(!empty($_POST["street"])){
        $street= $_POST["street"];//pour conserver la valeur valide entrée par l'utilisateur dans le form
    }
    if(empty($_POST["street"]) || is_numeric($_POST["street"])){
        
        $erreurStreet = '<div class="alert alert-danger" role="alert">Empty street !</div>';
    }

    if(!empty($_POST["streetnumber"])){
        $streetNumber=$_POST["streetnumber"];
    }
    if(empty($_POST["streetnumber"]) || !is_numeric($_POST["streetnumber"])){

        $erreurStreetNumber ='<div class="alert alert-danger" role="alert">Invalid street Number !</div>';
    }

    if(!empty($_POST["city"])){
        $city=$_POST["city"];
    }
    if(empty($_POST["city"]) || is_numeric($_POST["city"])){

        $erreurCity = '<div class="alert alert-danger" role="alert">Empty city !</div>';
    }

    if(!empty($_POST["zipcode"])){
        $zipcode=$_POST["zipcode"];
    }
    if(empty($_POST["zipcode"]) || !is_numeric($_POST["zipcode"])){

        $erreurZipcode = '<div class="alert alert-danger" role="alert">Invalid zipcode !</div>';
    }

} 

if(empty($erreurEmail) && empty($erreurStreet) && empty($erreurStreetNumber) && empty($erreurZipcode)){

    if(isset($_POST['order'])){ //click sur le bouton order

    
        $time =''; //temps de livraison

        $localtime = localtime();
        $minute = $localtime[1];
        $heure = $localtime[2] + 1;
        if($minute < 10){
            $minute = 0 .$minute;
        }
        

        if(isset($_POST['express_delivery'])){
            $minute = $minute + 30;
            

            if($minute >= 60){
                $heure = $heure + 1;
                $minute = $minute - 60;
            }
            $time = $heure.'h'.$minute; //heure de livraison +30min
            $totalValue = 5;//On ajoute 5euros aux prix total
        
        }
        else{ 
            $time = $heure + 1 .'h'.$minute;  //heure de livraison +1h
            
        }
        
    }
}

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}



//your products with their price.
$pizzas = [
    ['name' => 'Margherita', 'price' => 8],
    ['name' => 'Hawaï', 'price' => 8.5],
    ['name' => 'Salami pepper', 'price' => 10],
    ['name' => 'Prosciutto', 'price' => 9],
    ['name' => 'Parmiggiana', 'price' => 9],
    ['name' => 'Vegetarian', 'price' => 8.5],
    ['name' => 'Four cheeses', 'price' => 10],
    ['name' => 'Four seasons', 'price' => 10.5],
    ['name' => 'Scampi', 'price' => 11.5]
];

$drinks = [
    ['name' => 'Water', 'price' => 1.8],
    ['name' => 'Sparkling water', 'price' => 1.8],
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 2.2],
];

$menuSwitch= $pizzas; // switch entre  le menu pizza et drinks
if(isset($_GET['food'])){
    if($_GET['food'] == false){
        $menuSwitch = $drinks;
    }
}



//--------------------------Calcul du prix total-------------------------------
if(isset($_POST['products'])){
    $products_select = $_POST['products'];
    foreach($products_select AS $i => $choice){
        $choice = $menuSwitch[$i]['price'];
        $totalValue += $choice;
    }
    $_SESSION['total-price'] = $totalValue;
}

require 'src/form-view.php';