<?php

// Vérifier si l'extension JSON est chargée
if (!extension_loaded('json')) {
    die('Extension JSON non chargée.');
}

// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $entreprise = $_POST["entreprise"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Construire le message à envoyer à Discord
    $discord_message = "Nouveau message du formulaire de contact :\n";
    $discord_message .= "Nom : $nom\n";
    $discord_message .= "Entreprise : $entreprise\n";
    $discord_message .= "Email : $email\n";
    $discord_message .= "Message : $message\n";

    // Données à envoyer au format JSON
    $data = array(
        'content' => $discord_message
    );

    // Encodage des données au format JSON
    $json_data = json_encode($data);

    // Configuration de la requête HTTP
    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n" .
                         "Authorization: Bot MTIwODE3MDEwMTE2NjA1NTUzNQ.GzNfQK.gYnppUWXUWdkZVrdiOLE9YOVS6z5GVSTM0e4bM\r\n", // Remplacez VOTRE_JETON_DISCORD par votre jeton d'authentification du bot Discord
            'method'  => 'POST',
            'content' => $json_data
        )
    );

    // Création du contexte de la requête
    $context  = stream_context_create($options);

    // Envoi de la requête à l'API Discord
    $result = file_get_contents('https://discord.com/api/channels/1208171409876975630/messages', false, $context);

    // Vérifier si la requête a réussi
    if ($result === FALSE) {
        echo "Échec de l'envoi du message à Discord.";
    } else {
        echo "Message envoyé avec succès à Discord.";
    }
}
