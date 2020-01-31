<?php
session_start();
// Turn on error reporting -- this is critical!
ini_set('display_errors',1);
error_reporting(E_ALL);

//Require autoload file
require("vendor/autoload.php");

//Instantiate F3
$f3 = Base::Instance();

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

$f3->route("GET /order", function() {
    $views = new Template();
    echo $views->render('views/form1.html');
});

$f3->route("POST /order2", function() {
    //var_dump($_POST);
    $_SESSION['animal'] = $_POST['animal'];
    //var_dump($_SESSION);
    $views = new Template();
    echo $views->render('views/form2.html');
});

$f3->route("POST /results", function() {
    //var_dump($_POST);
    $_SESSION['color'] = $_POST['color'];
    $views = new Template();
    echo $views->render('views/results.html');
});

//Run f3
$f3->run();