<?php
session_start();
// Turn on error reporting -- this is critical!
ini_set('display_errors',1);
error_reporting(E_ALL);

//Require autoload file
require("vendor/autoload.php");
require_once ("model/validate-functions.php");

//Instantiate F3
$f3 = Base::Instance();
$f3->set('colors', array('pink', 'green', 'blue'));
$f3->set('DEBUG', 3);


//Define a default route
$f3->route("GET /", function (){
    echo "<h1>My Pets</h1>";
    echo "<a href='order'>Order a Pet</a>";
});

$f3->route("GET /@animal", function($f3, $params) {
    $animal = $params['animal'];
    switch ($animal) {
        case 'chicken':
            echo "Cluck!";
            break;
        case 'dog':
            echo "Woof!";
            break;
        case 'cat':
            echo "Meow!";
            break;
        case 'horse':
            echo "Nay!";
            break;
        case 'cow':
            echo "Moo!";
            break;
        default:
            $f3->error(404);
    }
});

$f3->route("GET|POST /order", function($f3) {
    $_SESSION = array();
    if(isset($_POST['animal'])) {
        $animal = $_POST['animal'];
        if(validString($animal)) {
            $_SESSION['animal'] = $animal;
            $f3->reroute('/order2');
        } else {
            $f3->set("errors['animal']", "Please enter an animal.");
        }
    }
    $views = new Template();
    echo $views->render('views/form1.html');
});

$f3->route("GET|POST /order2", function($f3) {
    var_dump($_POST);
    if(isset($_POST['color'])) {
        $color = $_POST['color'];
        if(validColor($color)) {
            $_SESSION['color'] = $color;
            $f3->reroute('/results');
        } else {
            $f3->set("errors['color']", "Please select a color.");
        }
    }
    $views = new Template();
    echo $views->render('views/form2.html');
});

$f3->route("GET|POST /results", function() {
    //var_dump($_POST);
    $views = new Template();
    echo $views->render('views/results.html');
});

//Run f3
$f3->run();