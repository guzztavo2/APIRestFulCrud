<?php 

spl_autoload_register(function ($class_name) {
 
    if (file_exists('.\\'.$class_name.'.php')){
        include_once('.\\'.$class_name.'.php');
    }
});
session_start();
define('HOME', 'CRUD_PHP');
define('URL', 'http://192.168.100.83/');
define('HOME_URL', URL.HOME.'/');

define('DATABASE_CONFIGS', [
'HOST' => 'localhost',
'DB_NAME' => 'crud',
'USERNAME' => 'root',
'PASSWORD' => ''
]);
reescreverHTACCESS();

function reescreverHTACCESS()
{
    $strHtaccess = "Options -Indexes
    RewriteEngine On
    RewriteCond %{SCRIPT_FILENAME} !-f
    RewriteCond %{SCRIPT_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [NC,L]
    SetEnvIf Referer ".HOME_URL." localreferer
    <FilesMatch \.(jpg|jpeg|png|gif|css|json|gz|xml)$>
    Order deny,allow
    Deny from all
    Allow from env=localreferer
    </FilesMatch>
    ErrorDocument 403 /".HOME."/index.php
    ";
    $file = fopen('.htaccess', 'w');
    fwrite($file, $strHtaccess);
    fclose($file);
}



?>