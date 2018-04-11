<?php
    if(isset($_SESSION['']))
        session_destroy();

    session_start();
    
    //creazione dell'immagine
    $image = imagecreatetruecolor(165, 40);  //ritorna un'immagine dalle dimensioni specificate
    $background = imagecolorallocate($image, 192, 57, 43); //ritorna il colore
    imagefill($image, 0, 0, $background); //riempie l'immagine

    //creazione linee
    $linesColor = imagecolorallocate($image, 51, 54, 59); //colore 
    for ($i=1; $i<=5; $i++) {
        imagesetthickness($image, rand(0,2)); //imposta 5 linee di dimensioni diverse
        imageline($image, 0, rand(0,30), 165, rand(0,30), $linesColor); //disegna una linee tra i due punti
    }

    //creazione stringa di numeri
    $captcha = '';
    $textColor = imagecolorallocate($image, 0, 0, 0);
    for ($x = 15; $x <= 150; $x += 30) {
        $value = rand(0, 9);
        imagechar($image, rand(4, 5), $x, rand(2, 18), $value, $textColor); //disegna un carattere
    
        $captcha .= $value;
    }
    $_SESSION['captcha_controllo'] = hash("sha512", $captcha);
    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
?>