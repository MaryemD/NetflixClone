<?php
require_once ("includes/header.php");
require_once ("PHPMailer.php");

if (isset($_POST["submitButton"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    if ($name == "" || $email == "" || $subject == "" || $message == "") {
        header("Location: contact.php?error=1");
    } else {

        $mail->setFrom($email, $name);
        $mail->addAddress('tuniflix.contact.tn@gmail.com', 'Tuniflix');     //Add a recipient
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<h4> Mail using PHPMailer </h4>
        <b>The content:</b>
            <p> " . $message . "</p>";

        if (!$mail->send()) {
            header("Location: contact.php?error=1");
        } else {
            header("Location: contact.php?success=1");
        }
        $mail->smtpClose();

    }
}

?>

<div class="contactContainer column">
    <div class="formSection">
        <form method="POST">
            <h2>Contact Us</h2>
            <p>If you have any questions, please feel free to contact us. We are here to help.</p>
            <?php
            if (isset($_GET["error"])) {
                echo "<p style='color: red;'>Something Went Wrong</p>";
            }
            if (isset($_GET["success"])) {
                echo "<p style='color: green;'>Email sent successfully</p>";
            }
            ?>
            <input type="text" name="name" placeholder="Full Name">
            <input type="email" name="email" placeholder="Email Address">
            <input type="text" name="subject" placeholder="Subject">
            <textarea name="message" placeholder="Your Message"></textarea>
            <input type="submit" name="submitButton" value="Submit">
        </form>
    </div>
</div>