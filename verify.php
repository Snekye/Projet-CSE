<?php 
    if(isset($_POST['g-recaptcha-response'])){
        $secret = "6LctE48mAAAAAFf6i84MLIdW2_51OQAyGOp3LMn4";
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $request = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";

        $get = file_get_contents($request);
        $decode = json_decode($get);

        if($decode->success==true){
        echo "success";
        }
        else{
            echo "Veuillez réessayer";
        }

        header("refresh:3;url=../Contact/ajouter_message.php");
    }
    else{
        echo "Erreur du Captcha";
    }
?>