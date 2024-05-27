<?php
if ( isset($_POST['question']) )  {

    //Limpiamos respuesta
    $question = addslashes(strip_tags(trim($_POST['question'])));

    //API KEY
    $key = ""; // Tu api key obtenida en https://platform.openai.com/

    // Chat Chat
    $chat_url = "https://api.openai.com/v1/chat/completions";

    // Chat Model
    $chat_model = "gpt-4o";

    //Aquí explicaremos a Chat GPT cual debe ser su comportamiento
    $system = "Eres un copywriter de una agencia de viajes y estas escribiendo texto sobre destinos turísticos.

    El usuario te indicará un destino turistico y necesito que escribas una descripción de este destino.

    El texto debe tener el siguiente formato:
    - Debe ser corto, máximo 150 palabras.
    - Debe estar en formato HTML. Necesito que crees un título con etiqueta h1 y después cada párrafo esté dentro de la etiqueta <p>, además añadele <strong> a las palabras importantes.
    - Debes hablar al público como un posible cliente que va a comprar paquetes de turismo en el destino.
    - Debes explicar a grandes rasgos por que, el destino indicado por el usuario, es un excelente destino para vacacionar.";

    //Este será el mensaje de usuario
    $user = "Destino: ".$question;

    // Cuerpo de respuesta
    $body = array(
		'model' => $chat_model,
		"messages" => array(
			0 => array( 'role' => 'system', 'content' => $system ),
			1 => array( 'role' => 'user', 	'content' => $user )
		)
	);

    $body = json_encode($body);

    //Curl
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$chat_url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($ch,CURLOPT_HTTPHEADER,[
		'Content-Type: application/json',
		'Authorization: Bearer '.$key
	]);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response);
    echo $response->choices[0]->message->content;
}
?>
