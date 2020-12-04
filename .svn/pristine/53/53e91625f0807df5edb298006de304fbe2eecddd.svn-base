<?php
//include ("designer/functions.php");

// http://query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.quotes where symbol in ("YHOO","AAPL","GOOG","MSFT")
function getResultFromYQL() {///select * from yahoo.finance.quote where symbol in ("YHOO","AAPL","GOOG","MSFT")
    $yql_query_url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from'
            . '%20yahoo.finance.quote%20where%20symbol%20IN("YHOO","AAPL","GOOG")&diagnostics=true'
            . '&format=json&env=http://datatables.org/alltables.env';




    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

    $json = curl_exec($session);
    curl_close($session);
    // echo json_encode($json, JSON_PRETTY_PRINT);
    //echo json_decode($json);
    return json_decode($json); //,true
}

$manage = getResultFromYQL();



//echo print_r($manage['query']);
//echo print_r($manage->query->results->quote);


$manage = (array) $manage->query->results->quote;

//echo print_r($manage[0]->AverageDailyVolume);

echo print_r($manage[0]);
echo '<br>';
echo '<br>';
echo print_r($manage[1]);
echo '<br>';
echo '<br>';
echo print_r($manage[2]);



require ("phpmailer/PHPMailerAutoload.php");
function sendMail($tomail, $subject, $msg) { 
    $mail = new PHPMailer();
    $mail->SMTPSecure = 'SSL';
    $mail->Username = "answer@skarter.com";
    $mail->Password = "Answer89";
    $mail->AddAddress($tomail);
    //  $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    //$mail->addAttachment('images/logo2.png');
    $mail->FromName = "Trading co.";
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->Host = "smtp.skarter.com";
    $mail->Port = 587;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->From = $mail->Username;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
//send the message, check for errors
    if (!$mail->send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return "Message sent!";
    }
}



while (true) {
    //exp();
    sendMail("erniecastle@hotmail.com", utf8_decode("Million"), utf8_decode(json_encode($manage[0])));
    sleep(1200);//20minutes
}


//echo print_r($manage->query->results->quote);
//echo print_r(count($manage->query->results->quote));

//echo print_r($elementCount);

//echo print_r($manage->query);

//echo print_r($manage->query);
//echo print_r($manage->query->results);
//echo print_r(count($manage));
//count($cars);
//
//
//foreach($manage->query->results as $f) {
//    echo print_r($f);
//}

//print_r($manage);
//echo $manage['query']; // working
