<!DOCTYPE html>
<?php
//ini_set('display_startup_errors',1);
//ini_set('display_errors',1);
//error_reporting(-1);

require 'vendor/autoload.php';

use Captioning\Format\SubripFile;
use Captioning\Format\WebvttFile;

if (array_key_exists('submit', $_POST)) {
    $popIp=$_POST["video_link"];

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
            unlink('upload/legenda.srt');
        } catch(Exeption $e) {
            echo "Error: ".$e->getMessage()."\n";
        }
    }
}

?>

<html>
<head>
<title>PopcornCast: Cast videos with subtitles to your Chromecast</title>
<link rel="icon" type="image/x-icon" href="imagefiles/favicon.png" />
<link rel="stylesheet" type="text/css" href="CastVideos.css">
<link href='//fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic-ext,greek-ext,latin-ext' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script>
<script src="CastVideos.js"></script>
<!-- <meta name="google-site-verification" content="AmFQw6ZD70dzi7lB9j0I_eRv-hmdYUqOl4dJGQ7yZ1U" />

<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
<meta content="PopcornCast Bookmarklet Sends Web Video with subtetles to Chromecast" name="description" />
<meta content="chromecast, video, bookmarklet, web video, ted, vimeo, subtitles" name="keywords" />
<meta content="PopcornCast: Bookmarklet to Send Web Video with subtitles to Chromecast" property="og:title" />
<meta content="Start playing a video file, click the bookmarklet and you're taken to a new tab. Once the file is loaded, click the play button and it will cast the file to your TV." property="og:description" />
<meta content="http://dabble.me/cast/imagefiles/vidcast_logo_ogimage.png" property="og:image" />
<meta content="https://dabble.me/cast/imagefiles/vidcast_logo_ogimage.png" property="og:image:image:secure_url" />
<meta content="summary_large_image" property="twitter:card" />
<meta content="@parterburn" property="twitter:site" />
<meta content="VidCast: Bookmarklet to Send Web Video to Chromecast" property="twitter:title" />
<meta content="Start playing a video file, click the bookmarklet and you're taken to a new tab. Once the file is loaded, click the play button and it will cast the file to your TV." property="twitter:description" />
<meta content="http://dabble.me/cast/imagefiles/vidcast_logo_ogimage.png" property="twitter:image:src" /> -->
</head>
<body>
<p>
<!-- <div class="bookmarklet"><span class="header"><h1><a href="https://dabble.me/cast">VidCast</a>: Video to Chromecast &nbsp;<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://dabble.me/cast" data-via="parterburn" data-count="none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></h1></span>
<a href="javascript:function iprl5(){var d=document,z=d.createElement('scr'+'ipt'),b=d.body,l=d.location;try{if(!b)throw(0);z.setAttribute('src','https://dabble.me/cast/bookmarklet.js?'+(new Date().getTime()));b.appendChild(z);}catch(e){alert('Please wait until the page has loaded.');}}iprl5();void(0)" id="the_bookmarklet">VidCast</a> &#8594; drag this bookmarklet to your bookmarks bar &amp; click it when a video is on the page.
-->
<form method="post" action="" enctype="multipart/form-data">
    <label for="file">Subtitle:</label>
    <input type="file" name="file" id="file"><br>
    <label for="video_link">Popcorn IP:</label>
    <input type="text" name="video_link" placeholder="http://PopcornIP:8888" value="http://192.168.1.5:8888"  size="65">
    <input type="submit" name="submit" value="Go">
</form>


<div class="prereqs">You must have <a href="http://chrome.google.com">Chrome</a>, <a href="https://chrome.google.com/webstore/detail/google-cast/boadgeojelhgndaghljhdicfkmllpafd">Google Cast Extension</a>, and a <a href="http://www.amazon.com/gp/product/B00DR0PDNE/ref=as_li_qf_sp_asin_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B00DR0PDNE&linkCode=as2&tag=thewashburnex-20">Chromecast</a>. See <a href="https://developers.google.com/cast/docs/media" target="_blank">supported media</a>.</div></div>
<br>
<div id="example"><img src="imagefiles/popcorn.jpg" style="width:585px;"></div>
</p>

      <div id="main_video">
        <div class="imageSub"> <!-- Put Your Image Width -->
           <div class="blackbg" id="playerstatebg">IDLE</div>
           <div class=label id="playerstate">IDLE</div>
           <div id="video_image_overlay"></div>
           <video id="video_element" preload="metadata">
           </video>
        </div>
          
        <div id="media_control">
           <div id="play"></div>
           <div id="pause"></div>
           <div id="progress_bg"></div>
           <div id="progress"></div>
           <div id="progress_indicator"></div>
           <div id="casticonactive"></div>
           <div id="casticonidle"></div>
           <div id="audio_bg"></div>
           <div id="audio_bg_track"></div>
           <div id="audio_indicator"></div>
           <div id="audio_bg_level"></div>
           <div id="audio_on"></div>
           <div id="audio_off"></div>
           <div id="duration">00:00:00</div>
        </div>
        <div class="prereqs" id="referrer-container"><a href="" id="referrer">&#8592; Go back</a></div>
      </div>
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
      </div>

<div class="footer">
<br>
</div>

<script type="text/javascript">

var video_link = decodeURIComponent('<?=$popIp?>');
video_link = decodeURIComponent(video_link);
if (video_link=="") {
  document.getElementById('main_video').remove();
} else {
  document.getElementById('example').remove();
  var CastPlayer = new CastPlayer();
  CastPlayer.stopApp();

  var ext = video_link.split('.').pop();
  var image_exts = ['jpeg','jpg','gif','png','bmp','webp'];
  var is_image = image_exts.indexOf(ext);
  if (is_image > 0) {
    //image, so load as the poster
    CastPlayer.localPlayer.poster = video_link;
  } else {
    CastPlayer.localPlayer.src = video_link;
    CastPlayer.localPlayer.addEventListener('loadeddata', CastPlayer.onMediaLoadedLocally.bind(CastPlayer, 0));
    CastPlayer.localPlayer.addEventListener( "error", function(e) {
            document.getElementById("playerstate").style.display = 'block';
            document.getElementById("playerstatebg").style.display = 'block';
            document.getElementById("playerstate").innerHTML = "<span class='loaded'>Error...could not load file</span><span class='vid_link'><a href='"+video_link+"'>"+video_link+"</a></span>";
          });
  }

  if (document.referrer) {
    document.getElementById("referrer-container").style.display = 'block';
    document.getElementById('referrer').href=document.referrer;
  }
}
</script>
</body>
</html>
