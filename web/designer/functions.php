<?php


function urls_amigables($url) {
    // Tranformamos todo a minusculas
    $url = strtolower($url);

    //Reememplazamos caracteres especiales latinos
    $find = array('Á', 'á', 'é', 'í', 'ó', 'ú', 'ñ');

    $repl = array('A', 'a', 'e', 'i', 'o', 'u', 'n');

    $url = str_replace($find, $repl, $url);

    // Añadimos los guiones
    $find = array(' ', '&', '\r\n', '\n', '+');

    $url = str_replace($find, '-', $url);

    $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/', '/“/', '/”/');

    $repl = array('', '-', '', '', '');

    $url = preg_replace($find, $repl, $url);

    return $url;
}

function specialCharacter($text) {

    $find = array('“', '”', "‘", "’");

    $repl = array('&quot;', '&quot;', '&#39;', '&#39;');

    $text = str_replace($find, $repl, $text);

    return $text;
}

function parseString($str) {
    $result = str_replace('"', "'", $str);
    return $result;
}

function cut_string_using_last($character, $string, $side, $keep_character = true) {
    $offset = ($keep_character ? 1 : 0);
    $whole_length = strlen($string);
    $right_length = (strlen(strrchr($string, $character)) - 1);
    $left_length = ($whole_length - $right_length - 1);
    switch ($side) {
        case 'left':
            $piece = substr($string, 0, ($left_length + $offset));
            break;
        case 'right':
            $start = (0 - ($right_length + $offset));
            $piece = substr($string, $start);
            break;
        default:
            $piece = false;
            break;
    }
    return($piece);
}

function thumbnail($img, $source, $dest, $maxw, $maxh) {
    $jpg = $source . $img;

    if ($jpg) {
        list( $width, $height ) = getimagesize($jpg); //$type will return the type of the image
        $source = imagecreatefromjpeg($jpg);

        if ($maxw >= $width && $maxh >= $height) {
            $ratio = 1;
        } elseif ($width > $height) {
            $ratio = $maxw / $width;
        } else {
            $ratio = $maxh / $height;
        }

        $thumb_width = round($width * $ratio); //get the smaller value from cal # floor()
        $thumb_height = round($height * $ratio);

        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
        imagelegendresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);

        //$path = $dest . $img . "_thumb.jpg";
        $path = $dest . $img;
        imagejpeg($thumb, $path, 75);
    }
    imagedestroy($thumb);
    imagedestroy($source);
}

function makeThumbnail($source_image_path, $thumbnail_image_path, $maxWidhtP, $maxHeightP) {
    $maxWidht = $maxWidhtP;
    $maxHeight = $maxHeightP;
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }

    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $maxWidht / $maxHeight;
    if ($source_image_width <= $maxWidht && $source_image_height <= $maxHeight) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) ($maxHeight * $source_aspect_ratio);
        $thumbnail_image_height = $maxHeight;
    } else {
        $thumbnail_image_width = $maxWidht;
        $thumbnail_image_height = (int) ($maxWidht / $source_aspect_ratio);
    }

    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

    $img_disp = imagecreatetruecolor($maxWidht, $maxHeight);

    imagesavealpha($img_disp, true);
    $color = imagecolorallocatealpha($img_disp, 0, 0, 0, 127);
    imagefill($img_disp, 0, 0, $color);

    imagecopy($img_disp, $thumbnail_gd_image, (imagesx($img_disp) / 2) - (imagesx($thumbnail_gd_image) / 2), (imagesy($img_disp) / 2) - (imagesy($thumbnail_gd_image) / 2), 0, 0, imagesx($thumbnail_gd_image), imagesy($thumbnail_gd_image));
    imagepng($img_disp, $thumbnail_image_path);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    imagedestroy($img_disp);
    return true;
}

function alphaID($in, $to_num = false, $pad_up = false, $passKey = null) {
    $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if ($passKey !== null) {
        /* Although this function's purpose is to just make the
         * ID short - and not so much secure,
         * with this patch by Simon Franz (http://blog.snaky.org/)
         * you can optionally supply a password to make it harder
         * to calculate the corresponding numeric ID */

        for ($n = 0; $n < strlen($index); $n++) {
            $i[] = substr($index, $n, 1);
        }

        $passhash = hash('sha256', $passKey);

        $passhash = (strlen($passhash) < strlen($index)) ? hash('sha512', $passKey) : $passhash;

        for ($n = 0; $n < strlen($index); $n++) {
            $p[] = substr($passhash, $n, 1);
        }

        array_multisort($p, SORT_DESC, $i);
        $index = implode($i);
    }

    $base = strlen($index);

    if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $in = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;

        for ($t = 0; $t <= $len; $t++) {
            $bcpow = bcpow($base, $len - $t);
            $out = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }

        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
    } else {
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }

        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
    }
    return $out;
}

function sendContactMail($tomail, $subject, $msg) {
    require ("phpmailer/PHPMailerAutoload.php");
    $mail = new PHPMailer();
    $mail->SMTPSecure = 'SSL';
    $mail->Username = fromMailReply;
    $mail->Password = "Busy@2016";
    $mail->AddAddress($tomail);
    //  $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    //$mail->addAttachment('images/logo2.png');
    $mail->FromName = nameweb;
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->Host = "smtp.bulovo.com";
    $mail->Port = 587;
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->From = $mail->Username;
    $mail->IsHTML(false);

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

function sendMailNotificationStock($tomail, $nameUser, $mailBuy, $mailSell, $mailApBuy, $mailApSell) {
    require_once ("phpmailer/PHPMailerAutoload.php");
    require_once ('./kernel/config.php');
    $message = file_get_contents('mailtemplates/alertstock/alert.html');
    $message = utf8_decode($message);
    $message = str_replace('%nombre%', $nameUser, $message);
    $messageStocks = "";

    if (!empty($mailBuy)) {
        $messageStocks.= '<b style="text-align: justify; color: black;">Acciones para disposición de compra:</b>';
        $messageStocks.= '<br>';
        $messageStocks.= '</br><b style="color: brown; font-size: 15px; ">Stocks:</b>';
        $long = count($mailBuy);
        for ($i = 0; $i < $long; $i++) {
            $messageStocks.= '<br>';
            $messageStocks.= '<b style="color: #2b2b2b;">No. Inversión: ' . $mailBuy[$i][8] . ' </b>';
            $messageStocks.= '</br>';
            $messageStocks.= '<b style="color: #2e6da4;">(' . $mailBuy[$i][3] . ')</b>';
            $messageStocks.= '<b style="color: #b53f31"> Precio actual:</b>';
            $messageStocks.= '<b style="color: red; ">' . $mailBuy[$i][5] . '</b>';
            $messageStocks.= '<b style="color: #b53f31; "> Precio notificador:</b>';
            $messageStocks.= '<b style="color: red; ">' . $mailBuy[$i][6] . '</b>';
        }
    }

    if (!empty($mailSell)) {
        $messageStocks.= '<br></br>';
        $messageStocks.= '<b style="text-align: justify; color: red;">Acciones para disposición de venta:</b>';
        $messageStocks.= '<br>';
        $messageStocks.= '</br><b style="color: brown; font-size: 15px; ">Stocks:</b>';
        $long = count($mailSell);
        for ($i = 0; $i < $long; $i++) {
            $messageStocks.= '<br>';
            $messageStocks.= '<b style="color: #2b2b2b;">No. Inversión: ' . $mailSell[$i][8] . ' </b>';
            $messageStocks.= '</br>';
            $messageStocks.= '<b style="color: #2e6da4;">(' . $mailSell[$i][3] . ')</b>';
            $messageStocks.= '<b style="color: #b53f31"> Precio actual:</b>';
            $messageStocks.= '<b style="color: red; ">' . $mailSell[$i][5] . '</b>';
            $messageStocks.= '<b style="color: #b53f31; "> Precio notificador:</b>';
            $messageStocks.= '<b style="color: red; ">' . $mailSell[$i][7] . '</b>';
        }
    }

    if (!empty($mailApBuy)) {
        $messageStocks.= '<br></br>';
        $messageStocks.= '<b style="text-align: justify; color: green;">Acciones en aproximación de compra:</b>';
        $messageStocks.= '<br>';
        $messageStocks.= '</br><b style="color: brown; font-size: 15px; ">Stocks:</b>';
        $long = count($mailApBuy);
        for ($i = 0; $i < $long; $i++) {
            $messageStocks.= '<br>';
            $messageStocks.= '<b style="color: #2b2b2b;">No. Inversión: ' . $mailApBuy[$i][8] . ' </b>';
            $messageStocks.= '</br>';
            $messageStocks.= '<b style="color: #2e6da4;">(' . $mailApBuy[$i][3] . ')</b>';
            $messageStocks.= '<b style="color: #b53f31"> Precio actual:</b>';
            $messageStocks.= '<b style="color: red; ">' . $mailApBuy[$i][5] . '</b>';
            $messageStocks.= '<b style="color: #b53f31; "> Precio notificador:</b>';
            $messageStocks.= '<b style="color: red; ">' . $mailApBuy[$i][6] . '</b>';
        }
    }

    if (!empty($mailApSell)) {
        $messageStocks.= '<br></br>';
        $messageStocks.= '<b style="text-align: justify; color: blue;">Acciones en aproximación de venta:</b>';
        $messageStocks.= '<br>';
        $messageStocks.= '</br><b style="color: brown; font-size: 15px; ">Stocks:</b>';
        $long = count($mailApSell);
        for ($i = 0; $i < $long; $i++) {
            $messageStocks.= '<br>';
            $messageStocks.= '<b style="color: #2b2b2b;">No. Inversión: ' . $mailApSell[$i][8] . ' </b>';
            $messageStocks.= '</br>';
            $messageStocks.= '<b style="color: #2e6da4;">(' . $mailApSell[$i][3] . ')</b>';
            $messageStocks.= '<b style="color: #b53f31"> Precio actual:</b>';
            $messageStocks.= '<b style="color: red; ">' . $mailApSell[$i][5] . '</b>';
            $messageStocks.= '<b style="color: #b53f31; "> Precio notificador:</b>';
            $messageStocks.= '<b style="color: red; ">' . $mailApSell[$i][7] . '</b>';
        }
    }
    $messageStocks = utf8_decode($messageStocks);

    $message = str_replace('%stocksDefined%', $messageStocks, $message);


    $mail = new PHPMailer();
    $mail->SMTPSecure = 'SSL';
    $mail->Username = userMail;
    $mail->Password = pwMail;
    $mail->AddAddress($tomail);
    $mail->FromName = utf8_decode(fromMail);
    $mail->Subject = utf8_decode(subjectMail);
    $mail->Host = smtpMail;
    $mail->Port = 587;
    //$mail->AddEmbeddedImage('./images/icon_fb_1.jpg', 'logo_2u');
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->From = $mail->Username;
    $mail->IsHTML(true);
    $mail->MsgHTML($message);
    $mail->AltBody = strip_tags($message);

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

function array_push_assoc($array, $key, $value) {
    $array[$key] = $value;
    return $array;
}

?>