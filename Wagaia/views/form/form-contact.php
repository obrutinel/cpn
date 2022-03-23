<?php

	use Wagaia\Lib;
	use Wagaia\Mail;
	use ReCaptcha\ReCaptcha;
	
	if(!empty($_POST)) {
		
		// CAPTCHA
		if(!empty($_POST['g-recaptcha-response'])) {
			
			$recaptcha = new ReCaptcha(SECRET_KEY);
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
			
			if(!$resp->isSuccess()) $error[] = 'Veuillez cocher le captcha';
			
		}
		
		if(!filter_input(INPUT_POST, 'nom'))  		$error[] = 'Veuillez renseigner votre nom';
		if(!filter_input(INPUT_POST, 'mail'))  		$error[] = 'Veuillez renseigner votre adresse e-mail';
		else if(!Lib::isEmail($_POST['mail']))		                    $error[] = 'Votre adresse e-mail est invalide';
		if(!filter_input(INPUT_POST, 'message'))  	$error[] = 'Veuillez renseigner un message';
		if(empty($_POST['g-recaptcha-response'])) 	                    $error[] = 'Veuillez cocher le captcha';

		if (!$error) {
			
			// ----- BDD ----- //
			
			$db->query("INSERT INTO wagaia_pages (titre, type, parent, date) VALUES ('', 'demande-contact', 6, NOW())");
			$lastID = $db->last_id();
			
			$db->query("INSERT INTO wagaia_pages_data (page_id, titre, sous_titre, texte, lg) 
							VALUES (
								".$lastID.",
								'".$db->escape($_POST['nom'])."', 
								'".$db->escape($_POST['mail'])."',
								'".$db->escape($_POST['message'])."',
								'fr'
							)");


            // ----- MAIL ----- //

            $modele = include ABSPATH.'panel/lib/mail/modele-1.php';

            $contenu  = "Bonjour, <br /><br />";
            $contenu .= "Une nouvelle demande de contact vient d'être envoyé depuis votre site internet :<br /><br />";
            $contenu .= "<strong>Nom : </strong>".$_POST['nom']."<br />";
            $contenu .= "<strong>Email : </strong>".$_POST['mail']."<br />";
            $contenu .= "<strong>Message : </strong><br />".nl2br($_POST['message'])."<br /><br />";

            $contenu = str_replace("##MESSAGE##", $contenu, $modele);
            sendMail('Contact', $contenu, TO_ADMIN);

			$success = true;

        }
		else $success = false;
		
	}

?>
	
	
	<?php if(!empty($_POST) && $success === false) : ?>

		<div class="alert alert-danger">
            <?php foreach($error as $err) : ?>
                <?=$err?><br />
            <?php endforeach; ?>
		</div>

	<?php elseif(!empty($_POST) && $success) : ?>

		<div class="alert alert-success">
			Votre demande de contact a bien été prise en compte.
		</div>
	<?php unset($_POST); ?>
	<?php endif; ?>