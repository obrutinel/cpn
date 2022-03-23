<?php

    require_once('../../vendor/autoload.php');

    if(!empty($_POST)) {

        $client = \Wagaia\Client::find($_POST['id']);


        $client->sendMail($_POST['type_mail'], $client->mail, $client, $_POST['content'], $_POST['subject']);

    }