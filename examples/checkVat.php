<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

$vies = new \DragonBe\Vies\Vies();
if (false === $vies->getHeartBeat()->isAlive()) {

    echo 'Service is not available at the moment, please try again later.' . PHP_EOL;

} else {

//  Using my own VAT to verify, should be valid
    $result = $vies->validateVat('BE', '0811231190');
    echo ($result->isValid() ? 'VALID' : 'INVALID') . ' VAT number' . PHP_EOL;

//  Using bogus VAT to verify, should be invalid
    $result = $vies->validateVat('BE', '1234567890');
    echo ($result->isValid() ? 'VALID' : 'INVALID') . ' VAT number' . PHP_EOL;
}
