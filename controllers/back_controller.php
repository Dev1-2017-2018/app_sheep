<?php
function dashboard(){

	$pdo = get_pdo();

	$lastDepenses = getSpendByUserPart(3, 0);

	$allUserSpended = getTotalSpend();

	$userSpended = getAllSpendByUser();

	$colors = ["purple", "orange", "red", "yellow", "green", "pink", "#65A4C5", "#EA69A9", "#1378A2", "#820333"];
	$i = 0;

	$diff = 25;

    include __DIR__ . '/../views/back/dashboard.php';
   
}

function history(){

	$pdo = get_pdo();

	if (isset($_GET['page'])) {
		if (intval($_GET['page']) != 0) {
			$page = ($_GET['page'] - 1) * 5;
		} else {
			header('Location: /history');
			exit;
		}
		

	} else {
		$page = 0;
	}
	

	$depenses = getSpendByUserPart($page, 5);

    include __DIR__ . '/../views/back/history.php';

}

function logout(){
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}

	// Finalement, on détruit la session.
	session_destroy();
	header('Location: /');
	exit;
}

function add_spend(){

	$users = getAllSpendByUser();

	include __DIR__ . '/../views/back/add_spend.php';
}

function balance(){

	$balance = calcul_balance();

	include __DIR__ . '/../views/back/balance.php';
}







