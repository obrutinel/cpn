<?php


namespace Wagaia;


class Mail
{
    private $to;
    private $from = MAIL_FROM;
    private $charset = "utf-8";
    private $content = 'Lorem ipsum';
    private $subject;
    private $site = " - ALTERIMMO";
    private $model = 'modele-1.php';
    private $mailer;
    private $headers = array();

    public function __construct() {

        if(is_localhost()) {
            $transport = (new \Swift_SmtpTransport(MAIL_SMTP, MAIL_PORT))
                ->setUsername(MAIL_USERNAME)
                ->setPassword(MAIL_PASSWORD);

            $this->mailer = new \Swift_Mailer($transport);
        }
        else {
            $this->headers[] = 'MIME-Version: 1.0';
            $this->headers[] = 'Content-type: text/html; charset='.$this->charset;
            $this->headers[] = 'From: <'.$this->from.'>';
        }
    }

    public function setMessage() {

        if(is_localhost()) {

            $message = (new \Swift_Message($this->subject))
                ->setCharset($this->charset)
                ->setFrom($this->from)
                ->setTo($this->to)
                ->setBody($this->content, 'text/html');

            $this->mailer->send($message);
        }
        else {

            mail($this->to, $this->subject, $this->content, implode("\r\n", $this->headers));

        }

    }
	
    public function send($type, $to, $data = null, $text = null, $subject = null) {

        $this->to = $to;
        //$model = file_get_contents($this->model);
		$model = include(dirname(__FILE__)."/../../panel/lib/mail/".$this->model);


        switch ($type) {

            // TEST
            case 'test':

                $this->subject = "test email".$this->site;

                $contenu = 'TEST Lorem ipsum';

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Nouvelle demande de contact
            case 'contact':

                $this->subject = $subject.$this->site;

                /*$contenu = str_replace("{firstname}", $data->firstname, $content);
                $contenu = str_replace("{lastname}", $data->lastname, $contenu);
                $contenu = str_replace("{login}", $data->mail, $contenu);
                $contenu = str_replace("{password}", $data->password_decrypt, $contenu);*/

                $contenu  = "Bonjour ".$data->firstname." ".$data->lastname.",<br /><br />";
                $contenu .= "Veuillez trouver ci-dessous vos identifants de connexion :<br /><br />";
                $contenu .= "Identifiant : ".$data->mail."<br />";
                $contenu .= "Mot de passe : ".$data->password_decrypt."<br /><br />";
                $contenu .= "Bonne journée,";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Mise à jour du mot de passe de connexion des comptes AlterImmos et propriétaires
            case 'forgot_password':

                $this->subject = 'Vos identifiants'.$this->site;

                if($text == 'agent') $link = URL_ACCOUNT_AI;
                else $link = URL_ACCOUNT_PB;

                $contenu  = "Bonjour ".$data->{$text}->firstname.",<br /><br />";
                $contenu .= "Veuillez trouver ci-dessous vos identifants de connexion :<br /><br />";
                $contenu .= "<b>Identifiant</b> : ".$data->{$text}->email."<br />";
                $contenu .= "<b>Mot de passe</b> : ".$data->{$text}->password."<br /><br />";
                $contenu .= '<a href="'.$link.'" style="color: #00bcf1">Cliquez-ici</a> pour vous connecter sur votre compte.<br /><br />';
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Notification à l'internaute que son compte AlterImmo a bien été créé
            case 'agent_register':

                $this->subject = 'Votre compte Alterimmo'.$this->site;

                $contenu  = "Bonjour ".$data->agent->firstname.",<br /><br />";
                $contenu .= "La création de votre compte Alterimmo a bien été prise en compte.<br />";
                $contenu .= "Nos administrateurs vont étudier votre demande, vous recevrez rapidement un mail de confirmation.<br /><br />";
                $contenu .= "Vous pourrez alors vous connectez sur votre compte Alterimmo.<br /><br />";
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Notification à l'admin qu'un nouveau compte AlterImmo a été créé
            case 'notif_agent_register':

                $this->subject = 'Nouveau compte Alterimmo'.$this->site;

                $contenu  = "Bonjour,<br /><br />";
                $contenu .= "Un nouveau compte Alterimmo vient d'être crée :<br />";
                $contenu .= "<b>".$data->agent->firstname." ".$data->agent->lastname."</b><br />";
                $contenu .= $data->agent->email."<br /><br />";
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Notification à l'internaute que son compte proprriétaire a bien été créé
            case 'user_pb_register':

                $this->subject = 'Votre compte propriétaire / bailleur'.$this->site;

                $contenu  = "Bienvenue au sein de la communauté MonAlterImmo.<br /><br />";
                $contenu .= "La confirmation de votre adresse email vous permettra d'accéder à la plateforme. Les futurs emails de notification vous seront transmis à cette adresse.<br />";
                $contenu .= '<br /><a href="'.$text.'" style="color: #fff;background: #00bcf1;padding: 8px 10px;text-decoration: none;text-transform: uppercase;font-size: 12px;">Confirmez votre inscription des maintenant</a><br /><br /><br />';
                $contenu .= "Merci d'avoir choisi MonAlterImmo !<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Notification à l'admin qu'une nouveau compte propriétaire a été créé
            case 'notif_user_pb_register':

                $this->subject = 'Nouveau compte Propriétaire'.$this->site;

                $contenu  = "Bonjour,<br /><br />";
                $contenu .= "Un nouveau compte propriétaire vient d'être crée :<br /><br />";
                $contenu .= "<b>".$data->profile->firstname." ".$data->profile->lastname."</b><br />";
                $contenu .= "<b>Email : </b>".$data->profile->email."<br />";
                $contenu .= "<b>Téléphone : </b>".$data->profile->phone_mobile."<br /><br />";
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Notification à l'admin d'une demande de rappel
            case 'notif_callback':

                $this->subject = 'Demande de rappel'.$this->site;

                $contenu  = "Bonjour,<br /><br />";
                $contenu .= "Vous avez reçu une nouvelle demande de rappel :<br /><br />";
                $contenu .= "<b>".$data->firstname." ".$data->lastname."</b><br />";
                $contenu .= "<b>Email : </b> ".$data->email."<br />";
                $contenu .= "<b>Téléphone : </b> ".$data->phone."<br />";
                $contenu .= "<b>Créneau : </b> ".$data->recallSlot."<br /><br />";
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Notification à l'internaute comme quoi la demande de rappel a bien été prise en compte
            case 'callback':

                $this->subject = 'Demande de rappel'.$this->site;

                $contenu  = "Bonjour ".$data->firstname.",<br /><br />";
                $contenu .= "Votre demande de rappel a bien été prise en compte.<br /><br />";
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // Le choix de la diffusion d'une annonce vient d'être faite par un PB
            case 'notif_property_diffusion':

                $this->subject = 'Diffusion annonce'.$this->site;

                $contenu  = "Bonjour,<br /><br />";
                $contenu .= "Une annonce vient d'être soumise à modération :<br />";
                $contenu .= '<br /><a href="'.HTTP.'panel/property.php?show=edit&id='.$data->data->id.'" style="color: #fff;background: #00bcf1;padding: 8px 10px;text-decoration: none;text-transform: uppercase;font-size: 12px;">Voir l\'annonce</a><br /><br /><br />';
                $contenu .= $data->agent->email."<br /><br />";
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // L'admin a validé un annonce
            case 'user_pb_property_validation':

                $this->subject = 'Votre annonce'.$this->site;

                $contenu  = "Bonjour,<br /><br />";
                $contenu .= "Félicitation, votre annonce a été validée !<br /><br />";
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

            break;

            // L'admin a refusé un annonce
            case 'user_pb_property_refused':

                $this->subject = 'Votre annonce'.$this->site;

                $contenu  = "Bonjour,<br /><br />";
                $contenu .= "Votre annonce n'a pas été rentenue pour les raisons suivantes : <br /><br />";
                $contenu .= $text;
                $contenu .= "<br /><br />";
                $contenu .= "Bonne journée,<br /><br />";

                $this->content = str_replace("##MESSAGE##", nl2br($contenu), $model);

                $this->setMessage();

                break;

        }

    }

}