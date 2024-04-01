<?php
require_once ("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AcMJWQ-OSsui0VhYgHuDFVB3moKyHaA6SfHtpQ-QGbRlyH1gAAyf1f7lMTXMS6p__rh5bIxB01kxbx_D',     // ClientID should be replaced with a real one
        'EEZMSWlmx4CYNHb3aekmZpVL8e0ZazIMl8SnJVpcT_MmWynydSqYCHYveefTd6b8wCum7lIOL3mtTeqC'      // ClientSecret should be replaced with a real one
    )
);

?>