<?php

// include the class
include "imagelessCaptcha.php";

// implement imageless
$imgLess = new imagelessCaptcha();
$questionPhrase = $imgLess->formPhrase();
$int = $imgLess->getInt();

// pre-filled values for faster demo
$email = "sample@email.com";
$body = "Some message...";

// don't show success message just yet
$sent = false;

// on post submit
if (isset($_POST['submit'])) {

    // imageless
    $imgLessAttempt = $_POST['imgLessAttempt'];
    $imgLessAnswerHash = $_POST['imgLessAnswerHash'];
    
    $errors = array();
    
    // check attempt against answer
    if (md5($imgLessAttempt) != $imgLessAnswerHash) {
        $errors['captcha'] = "The number you entered for the spam filter is incorrect.";
    }
    
    if (!$errors) {
        
        // do something...
        
        // result
        $sent = true;
        
        // reset imgLess
        $questionPhrase = $imgLess->formPhrase();
        $int = $imgLess->getInt();
        
    } 
}

?>

<!DOCTYPE HTML>
<html>
<head>

<meta charset="UTF-8">
<meta name="robots" content="index,follow"> 
<meta name="description" content="A demo of Imageless Captcha">

<title>Imageless Captcha</title>

<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <a href="https://github.com/inorganik/ImagelessCaptcha"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png" alt="Fork me on GitHub"></a>
    <div id="wrap">
        <header>
            <div class="inner">
                <h1 class="noMargin">Imageless Captcha Demo</h1>
            </div>
        </header>
        <section>
            <div class="inner">
                <p>Creates a random number on every page load, based on your preferences. From that number, it creates the number as a phrase. In the form, you use the phrase to ask the user to enter it as a number. When the form is posted, you simply check to see if the number matches.</p>
                <h3>Advantages</h3>
                <ul>
                    <li>Keeps your form clean, no ugly captcha images or third-party embedded styles</li>
                    <li>Extremely lightweight</li>
                    <li>Very easy to implement</li>
                    <li>Customizable</li>
                </ul>
                <h3>Example:</h3>
                <form action="index.php" method="post">
                    <?php if (count($errors) > 0) : 
                    // if there are errors ?>
                    <div class="col full">
                        <ul class="errors">
                            <?php foreach ($errors as $error) {
                                echo "<li>".$error."</li>\n";
                            } ?>
                        </ul>
                    </div>
                    <?php endif;
                    // if the message passed validation
                    if ($sent) : ?>
                    <div class="col full">
                        <ul class="success">
                            <li>Message sent!</li>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="col full">
                        <div class="form-inner">
                            <label style="opacity:.4">From</label>
                            <input type="email" name="email" class="textInput" style="opacity:.4" value="<?php echo $email; ?>" disabled>
                        </div>
                    </div>
                    <div class="col full">
                        <div class="form-inner">
                            <label style="opacity:.4">Message</label>
                            <textarea name="body" rows="4" style="opacity:.4" disabled><?php echo $body; ?></textarea>
                        </div>
                    </div>
                    <div class="col full">
                        <div class="form-inner">
                            <!-- here we echo the number phrase -->
                            <label><span><a href="http://inorganik.net/imagelessCaptcha/">Imageless Captcha</a> (spam filter):</span><br>
                            <?php echo $questionPhrase; ?></label>
                            <!-- input for users attempt -->
                            <input type="text" name="imgLessAttempt" class="textInput">
                            <!-- this is where the correct value is stored, one-way encrypted -->
                            <input type="hidden" name="imgLessAnswerHash" value="<?php echo md5($int); ?>">
                        </div>
                    </div>
                    <div class="col full">
                        <div class="form-inner marginTop">
                            <input type="submit" value="Send" name="submit" class="submit">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div><!-- end #wrap -->
    <div class="push">&nbsp;</div>
    <footer>
        <div class="footer-inner">By <a href="https://twitter.com/inorganik">Jamie Perkins</a>. </div>
    </footer>
</body>
</html>