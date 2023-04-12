<?php
$range=0;
session_start();  
if (isset($_POST["range"])){
    $range=$_POST["range"];
}
$_SESSION['range']=$range;
?>



<html lang="en">
  <head>
    <title>Adventure Us on the Map!</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- playground-hide -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" enctype="multipart/form-data">
    <script>
      const process = { env: {} };
      process.env.GOOGLE_MAPS_API_KEY =
        "<INSERT YOUR KEY HERE>";
    </script>
    <!-- playground-hide-end -->

    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script type="text/javascript" src="./googlemap.php"></script>
  </head>
  <body>
<?php





echo "<FORM action=./index.php method=post><BR><CENTER>Welcome to Diane and Garnet's journey onboard Adventure Us! <br>Follow along as we bring the boat someplace where the water doesn't freeze!<BR><BR>
Select to see an overview view of entire trip so far? (DEFAULT) <input type=radio name=range value=0 onclick=\"this.form.submit()\" ";
if (!$range) {echo "checked=checked";}
echo "> or the last week of travel? <input type=radio name=range value=1 onclick=\"this.form.submit()\" ";
if ($range==1) {echo "checked=checked";}
echo "> or the last 24 hours in detail? <input type=radio name=range value=2 onclick=\"this.form.submit()\" ";
if ($range==2) {echo "checked=checked";}
echo "></center></form>";


?>
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=<INSERT YOUR KEY HERE>&q=&callback=initMap" async defer></script>
  </body>
</html>