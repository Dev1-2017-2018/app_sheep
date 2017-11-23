<?php

function insert_spend(){
	$pdo = get_pdo();

	if (empty($_POST['title'])) {

		setFlashMessage("Veuillez rentrer un titre");
		header('Location: add_spend');
		exit;

	} elseif (empty($_POST['price'])) {

		setFlashMessage("Veuillez rentrer un prix");
		header('Location: add_spend');
		exit;

	} elseif ($_POST['price'] <= 0){
		header('Location: add_spend');
		exit;

	} elseif (empty($_POST['date'])){

		setFlashMessage("Veuillez selectionner une date");
		header('Location: add_spend');
		exit;

	}

	$sumUserPart = 0;

	if(!empty($_POST['check_list'])) {

		foreach($_POST['check_list'] as $textbox){
		    if (empty($_POST['user_' . $textbox])) {

		    	setFlashMessage("Veuillez rentrer des prix pour les bons utilisateurs");
				header('Location: add_spend');
				exit;
		    } else if ($_POST['user_' . $textbox] <= 0) {

		    	setFlashMessage("Veuillez rentrer des prix valides");
				header('Location: add_spend');
				exit;
		    } else {
		    	$sumUserPart += $_POST['user_' . $textbox];
		    }
		}

		if ($sumUserPart != $_POST['price']) {
			setFlashMessage("Veuillez rentrer des prix valides");
			header('Location: add_spend');
			exit;
		}

		try{

			$pdo->beginTransaction(); // ce met en mode transactionnel

    		// les requêtes si une requête échoue => elle lance une exception 

			// Insert sur la table spends
			$prepareSpend = $pdo->prepare('INSERT INTO `spends` (`title`, `price`, `pay_date`) VALUES (?, ?, ?) ');

			$prepareSpend->bindValue(1, $_POST['title'], PDO::PARAM_STR);
			$prepareSpend->bindValue(2, $_POST['price'], PDO::PARAM_INT);
			$prepareSpend->bindValue(3, $_POST['date']);

			$prepareSpend->execute();

			// Select le dernier id INSERT donc ici dans notre table spends
			$insertId = $pdo->lastInsertId();

			// Insert dans la table user_spend

			$prepareUserSpend = $pdo->prepare('INSERT INTO `user_spend` (`user_id`, `spend_id`, `price`) VALUES (?, ?, ?) ');

			$checked = count($_POST['check_list']);

		    foreach($_POST['check_list'] as $check) {
		            
		    	$prepareUserSpend->bindValue(1, $check);
	            $prepareUserSpend->bindValue(2, $insertId);
	            $prepareUserSpend->bindValue(3, $_POST['user_' . $check]);

	            $prepareUserSpend->execute();

		    }
		    // Puis on affiche le message confirmant à l'utilisateur que la dépense à été ajoutée
		    setFlashMessage('Dépense ajoutée');
		    header('Location: add_spend');

		    $pdo->commit();  // les exécutés


		}catch(Exception $e){
			
        	$pdo->rollback(); // si une exception a été retourner par PDO ou PHP on retourne dans l'état initial 
        	setFlashMessage("Erreur de requête veuillez réessayer dans un instant");
        	header('Location: add_spend');

		}

		

	 } else {
    	setFlashMessage("Veuillez selectionner un ou plusieurs utilisateurs");

		header('Location: add_spend');
		exit;
    }

}