<?php

session_start();

define('SALT', 'pU1TIYoa6f3Gmqkg0UviAewPvkCLc9mCxKJsVFUX2cU9CiasvsLei');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// PDO
$defaults = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // PDO remonte les erreurs SQL, sinon il retourne une bête erreur PHP
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // retournera les données dans un tableau associatifs
];

$pdo = new PDO('mysql:host=localhost;dbname=sheep', 'root', '', $defaults);

if ('/' === $uri) {

	include __DIR__ . '/../views/front/auth.php';
	
} elseif ('/auth' == $uri and $method == 'POST') {

	$flagToken = false;
	$token = $_POST['token'];
	if ( !empty($token) ) {
		foreach (range(0, 5) as $v) {
			if ( ($token == md5(date('Y-m-d h:i:00', time() - $v * 60) . SALT))) {
				$flagToken = true;
			}
		}
	}

	if( $flagToken == false ){
		header('Location: /');
		exit;
	}

	// API php pour filtre les données
	$rules = [
		'email'        => FILTER_VALIDATE_EMAIL,
		'password'      => [
			'filter'  => FILTER_CALLBACK,
			'options' => function ($pass) {
				if ( strlen($pass) < 4 ) {
					return false;
				} else {
					return $pass ;
				}
			},
		]
	];

	$sanitize = filter_input_array(INPUT_POST, $rules);

    $email = $sanitize['email'];
    $password =  $sanitize['password'];

	$prepare = $pdo->prepare("
		SELECT id, password FROM users WHERE email=? 
	");

	$prepare->bindValue(1, $email);
	$prepare->execute();

	$stmt = $prepare->fetch();

	$_SESSION['email'] = null;
	$_SESSION['email'] = $sanitize['email'];

    if ( $stmt  == false) {
		// redirection avec message d'erreur
		$_SESSION['message'] = "Une erreur dans le mot de passe ou email";

		header('Location: /');
		exit;

    } else {
		if( password_verify($sanitize['password'], $stmt['password']) )
		{
			session_regenerate_id(true); // crée un nouvel identifiant
			$_SESSION['auth'] = $stmt['id'];

			header('Location: admin');// redirection vers une page sécurisée
			exit;
		}else{
			$_SESSION['message'] = "Erreur dans le mot de passe ou email";
			
			header('Location: /');
			exit;
		}
	}

} elseif( $uri == '/admin' ){
	if( !isset($_SESSION['auth']) ){
		$_SESSION['message'] = "Vous n'avez pas l'autorisation";
		
		header('Location: /');
		exit;
	}
	else{
		echo "Bravo vous êtes connecté";
	}
}
else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}