<?php
require_once 'vendor/autoload.php';

session_start();

// === Boostrap ==========
// === Recupero il mio attuale environment
$env = getenv('APPLICATION_ENV');

// === Leggo la configurazione globale
$globalConfig = Utils::parse_ini_file_extended('config.ini');

// === Recupero la configurazione per questo environment
$cfg = $globalConfig[$env];

// === Imposto la visualizzazione degli errori (accesa/spenta)
ini_set('display_errors', $cfg['displayErrors']);

// === Imposto il livello di visualizzazione degli errori
error_reporting($cfg['errorLevel']);


// === Connessione al DB
$database = new medoo([
	// required
	'database_type' 	=> $cfg['db_provider'],
	'database_name' 	=> $cfg['db_name'],
	'server' 		=> $cfg['db_host'],
	'username' 		=> $cfg['db_user'],
	'password' 		=> $cfg['db_passwd'],
 
	// optional
	'port' => 3306,
	'charset' => 'utf8',
	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
]);

/*
// Adesso qui dobbiamo inserire Twig
// === Avvio interprete Template Twig
Twig_Autoloader::register();

// === Imposto Twig per caricare i template
// === Quindi gli dico quale è la cartella dei template
$loader = new Twig_Loader_Filesystem(
			__DIR__.DIRECTORY_SEPARATOR.$cfg['themeFolder']
					.DIRECTORY_SEPARATOR.$cfg['themeName']
		);


// === Imposto la cartella di cache
$twig = new Twig_Environment($loader, array(
     'cache' => $cfg['hasCache'] ?  __DIR__.DIRECTORY_SEPARATOR.$cfg['cacheFolder'] : false,
));
*/

// FligtPHP ==== Routing Zone =====
Flight::route('/', function() use ($twig, $database) {
    
    echo "home page";
    
});

Flight::route('/admin/login', function() use ($twig, $database) {
    
    echo file_get_contents('loginform.html');
    
});

Flight::route('/admin/fail', function() use ($twig, $database) {
    
    echo "utente non trovato";
    
});

Flight::route('/admin/login/user-no-active', function() use ($twig, $database) {
    
    echo "utente non attivo";
    
});

Flight::route('/admin/login/process', function() use ($twig, $database) {
    
    if(!empty($_POST)) {
        // === Recupeare i dati di login
        $user = $_POST['fldUserName'];
        $passwd = $_POST['fldPasswd'];
        
        // === Cercali nel database
        $rsLogin = $database->select('utenti'
                    ,'*'
                    ,[
                        "email" => $user,
         		"passwd" => $passwd
                    ]
                );
        
        if(!$rsLogin) {         
            // === In modo forzoso sposto la il routing verso questa url
            Flight::redirect('/admin/login/fail');
         } else {
             
             // === Se trovati allora utente da valutare
             if($rsLogin['attivo'] != 'attivo') 
             {
                 
                // === In modo forzoso sposto la il routing verso questa url
                Flight::redirect('/admin/login/user-no-active');
                 
             } else {
                 
                 // === Imposto delle variabili di sessione che rapperestano il login
                 $sessionVar = array(
                     'hasLogged'    => true
                     ,'userData'    => serialize($rsLogin)
                 );
                 
                $_SESSION['userLoggedData'] =  $sessionVar;        
                         
                 
             }
             
             
         }
        
        
        
    
    } else {
        
        // === In modo forzoso sposto la il routing verso questa url
        Flight::redirect('/');
    }
    
    
});

Flight::route('/admin/elenco-pagine', function() use ($twig, $database) {

    
    if($_SESSION['userLoggedData']['hasLogged']!=true)
    {
        // Significa che non sei un utente loggato
        Flight::redirect('/admin/login');
    }
    
});


// FligtPHP: passo 0
Flight::start();