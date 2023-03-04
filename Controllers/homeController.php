<?php 
namespace Controllers;
use Controllers\userController as user;
class homeController extends Controller{


public static function home(){
    
    self::includeFile('home.php');
}
public static function sobre(){
    
    self::includeFile('sobre.php');

}
}

?>