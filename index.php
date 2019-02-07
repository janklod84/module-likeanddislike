<?php 

require __DIR__.'/debug.php';
require_once __DIR__.'/_db.php';

// AUTOLOADING CLASSES
spl_autoload_register(function ($class){
 
   @require_once __DIR__.'/class/'. $class . '.php';

});



// CONSTANTES
define('LAYOUT', 'default');


// GET PAGE
$page = isset($_GET['p']) ? $_GET['p'] : 'index';
$view = __DIR__.'/views/posts/'. $page . '.php';
$layout = __DIR__.'/views/layouts/'. LAYOUT . '.php';


ob_start();
if(file_exists($view))
{
	require_once($view);
}

$content = ob_get_clean();
if(file_exists($layout))
{
	require_once($layout);
}




