<?php
$subjectPrefix = '[Contact Site Guide]';
$emailTo = 'yourmail@domaine.com';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = stripslashes(trim($_POST['name']));
    $email    = stripslashes(trim($_POST['email']));
    $message= stripslashes(trim($_POST['message']));
    $pattern  = '/[\r\n]|Content-Type:|Bcc:|Cc:/i';

    if (preg_match($pattern, $name) || preg_match($pattern, $email)) {
        die("injection detecté");
    }

    $emailIsValid = preg_match('/^[^0-9][A-z0-9._%+-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', $email);

    if($name && $email && $emailIsValid && $message){
        $subject = "$subjectPrefix $email";
        $body = "Nom: $name <br /> Email: $email <br />  message: $message";

        $headers  = 'MIME-Version: 1.1' . PHP_EOL;
        $headers .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;
        $headers .= "From: $name <$email>" . PHP_EOL;
        $headers .= "Return-Path: $emailTo" . PHP_EOL;
        $headers .= "Reply-To: $email" . PHP_EOL;
        $headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;

        mail($emailTo, $subject, $body, $headers);
        $emailSent = true;

    } else {
        $hasError = true;
    }
}
?>

    <?php if(isset($emailSent) && $emailSent): ?>
        <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-success text-center">Votre message est envoyer merci de votre visite!</div>
        </div>
    <?php else: ?>
        <?php if(isset($hasError) && $hasError): ?>
        <div class="col-md-5 col-md-offset-4">
            <div class="alert alert-danger text-center">Réessayer plus tard, message pas envoyé</div>
        </div>
        <?php endif; ?>

 <?php endif; ?>

    <?php
        $ieVersion = preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches) ? floatval($matches[1]) : null;

        if($ieVersion < 9 && $ieVersion != null) {
            $jQueryVersion = '1.10.2';
        } else {
            $jQueryVersion = '2.0.3';
        }
    ?>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/<?php echo $jQueryVersion; ?>/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/contact-form.js"></script>
