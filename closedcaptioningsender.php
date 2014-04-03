<!-- 
Copyright 2014 Google Inc. All Rights Reserved.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 -->
<!--
This shows a very simple Chrome sender app to show how you could support closed captioning.
-->
<!DOCTYPE html>
<?php
require 'vendor/autoload.php';

use Captioning\Format\SubripFile;
use Captioning\Format\WebvttFile;

$popIp=$_POST["popIp"];

if ($_FILES["file"]["error"] > 0){
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
}else{
   //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
   //echo "Type: " . $_FILES["file"]["type"] . "<br>";
   //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
   //echo "Stored in: " . $_FILES["file"]["tmp_name"];

    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . "legenda.srt");
    mb_internal_encoding('UTF-8');
    try {
        $srt = new SubripFile('upload/legenda.srt');
        $srt->convertTo('webvtt')->build()->save('legenda.vtt');
    } catch(Exeption $e) {
        echo "Error: ".$e->getMessage()."\n";
    }
}

?>

<html>
<head>
<title>PopcornCast</title>
<link rel="stylesheet" type="text/css" href="closedcaptioning.css">
<script>var mediaURL = '<?='http://'.$popIp.':8888'?>'</script>
<script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script>
<script src="closedcaptioning.js"></script>
</head>
<body>
  <div>
    <div>
      <h2 style="display:block">PopcornCast</h2>
      <br>
	<h1><?=$popIp?></h1>
        <div style="margin:0px; float:left; width:250px;">
           <img src="images/popcorn.jpg" width="250" id="thumb">
           <img src="images/cast_icon_idle.png" id="casticon" width="30">
        </div>
      </div>
      <div style=" margin:10px; float:left; display:block; width:90%;">
        <button onclick="launchApp()">Launch app</button>
        <button onclick="stopApp()">Stop app</button>
        <br>
        <button onclick="loadMedia()">Load media</button>
        <button id="playpauseresume" onclick="playMedia()">Play</button>
        <button onclick="stopMedia()">Stop media</button>
      <div>
		<div style="margin:10px;">
	        Captions:
	        <button onClick="setCaptions()">Off</button>
	        <button onClick="setCaptions(0)">On</button>
	      </div>
		<div style="margin:10px;">
	        Font:
	        <button onClick="setFont(0)">Normal</button>
	        <button onClick="setFont(1)">Yellow</button>
	      </div>
      <div style="margin:10px;">
        State : <span id="playerstate">IDLE</span>
      </div>
      <div style="margin:10px;">
        <textarea rows="20" cols="70" id="debugmessage">
        </textarea>
      </div>
    </div>
  </div>
</body>
</html>
