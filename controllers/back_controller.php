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
		$page = ($_GET['page'] - 1) * 5;

	} else {
		$page = 0;
	}
	

	$depenses = getSpendByUserPart($page, 5);

    include __DIR__ . '/../views/back/history.php';

}

function logout(){
	
}