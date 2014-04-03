<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require 'vendor/autoload.php';

use Captioning\Format\SubripFile;
use Captioning\Format\WebvttFile;

mb_internal_encoding('UTF-8');
echo "start->" . mb_internal_encoding();
try {
    echo "1-3";
    $srt = new SubripFile('legenda.srt');
    echo "2-3";
    $srt->convertTo('webvtt')->build()->save('legenda.vtt');
    echo "3-3";
} catch(Exeption $e) {
    echo "Error: ".$e->getMessage()."\n";
}
echo "end";
?>
