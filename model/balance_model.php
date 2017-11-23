<?php
	
	function calcul_balance(){
		
		$pdo = get_pdo();

		try {

			$pdo->beginTransaction(); // ce met en mode transactionnel
			
			$selectTitle = $pdo->prepare("
				SELECT title 
				FROM spends 
				INNER JOIN user_spend 
				ON id = user_id;
			");

			$pdo->commit();  // les exécutés 
		
		} catch (Exception $e) {
			
			$pdo->rollback(); // si une exception a été retourner par PDO ou PHP on retourne dans l'état initial 
        	setFlashMessage("Erreur de requête veuillez réessayer dans un instant");
        	header('Location: add_spend');

		}
	}