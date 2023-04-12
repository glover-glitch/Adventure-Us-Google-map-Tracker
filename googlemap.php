<?php
session_start();  
$range=$_SESSION['range'];




//echo $range;




//get last 24hours of latitude
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array("Authorization: Token <INSERT YOUR TOKEN HERE>", "Accept: application/csv", "Content-type: application/vnd.flux");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
if ($range==0){
    $data = "from(bucket: \"AdventureUs\") |> range(start: 2022-08-02T00:00:00Z) |> filter(fn: (r) => r._measurement == \"navigation.position.latitude\") |> aggregateWindow(every: 4h, fn: mean, createEmpty: false)";
} else if ($range==2){
   $data = "from(bucket: \"AdventureUs\") |> range(start: -24h) |> filter(fn: (r) => r._measurement == \"navigation.position.latitude\")  |> aggregateWindow(every: 2m, fn: mean, createEmpty: false) |> yield(name: \"mean\")";   
} else if ($range==1){
     $data = "from(bucket: \"AdventureUs\") |> range(start: -1w) |> filter(fn: (r) => r._measurement == \"navigation.position.latitude\") |> aggregateWindow(every: 30m, fn: mean, createEmpty: false)";   
}
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$latitude = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }

//get last 24hours of longitude
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(
    "Authorization: Token <INSERT YOUR TOKEN HERE>",
    "Accept: application/csv",
    "Content-type: application/vnd.flux"
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
if ($range==0){
    $data = "from(bucket: \"AdventureUs\") |> range(start: 2022-08-02T00:00:00Z) |> filter(fn: (r) => r._measurement == \"navigation.position.longitude\") |> aggregateWindow(every: 4h, fn: mean, createEmpty: false)";
} else if ($range==2){
     $data = "from(bucket: \"AdventureUs\") |> range(start: -24h) |> filter(fn: (r) => r._measurement == \"navigation.position.longitude\")   |> aggregateWindow(every: 2m, fn: mean, createEmpty: false)  |> yield(name: \"mean\")";
} else if ($range==1){
    $data = "from(bucket: \"AdventureUs\") |> range(start: -1w) |> filter(fn: (r) => r._measurement == \"navigation.position.longitude\") |> aggregateWindow(every: 30m, fn: mean, createEmpty: false)";
}
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$longitude = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }

//get last outside temperature
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(
    "Authorization: Token <INSERT YOUR TOKEN HERE>",
    "Accept: application/csv",
    "Content-type: application/vnd.flux"
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data="from(bucket: \"AdventureUs\")  |> range(start: -10m)  |> filter(fn: (r) => r[\"_measurement\"] == \"environment.outside.temperature\")  |> last()";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$outside_temp = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }

//get last depth
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(
    "Authorization: Token <INSERT YOUR TOKEN HERE>",
    "Accept: application/csv",
    "Content-type: application/vnd.flux"
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data="from(bucket: \"AdventureUs\")  |> range(start: -10m)  |> filter(fn: (r) => r[\"_measurement\"] == \"environment.depth.belowKeel\")  |> last()";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$depth = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }

//get last water temperature
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(
    "Authorization: Token <INSERT YOUR TOKEN HERE>",
    "Accept: application/csv",
    "Content-type: application/vnd.flux"
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data="from(bucket: \"AdventureUs\")  |> range(start: -10m)  |> filter(fn: (r) => r[\"_measurement\"] == \"environment.water.temperature\")  |> last()";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$water_temp = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }

//get last apparant wind speed
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(
    "Authorization: Token <INSERT YOUR TOKEN HERE>",
    "Accept: application/csv",
    "Content-type: application/vnd.flux"
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data="from(bucket: \"AdventureUs\")  |> range(start: -10m)  |> filter(fn: (r) => r[\"_measurement\"] == \"environment.wind.speedApparent\")  |> last()";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$aws = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }

//get last speed over ground
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(
    "Authorization: Token <INSERT YOUR TOKEN HERE>",
    "Accept: application/csv",
    "Content-type: application/vnd.flux"
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data="from(bucket: \"AdventureUs\")  |> range(start: -10m)  |> filter(fn: (r) => r[\"_measurement\"] == \"navigation.speedOverGround\")  |> last()";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$sog = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }

//get last course over ground
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(
    "Authorization: Token <INSERT YOUR TOKEN HERE>",
    "Accept: application/csv",
    "Content-type: application/vnd.flux"
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data="from(bucket: \"AdventureUs\")  |> range(start: -10m)  |> filter(fn: (r) => r[\"_measurement\"] == \"navigation.courseOverGroundTrue\")  |> last()";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$cog = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }


//get last heading
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(    "Authorization: Token <INSERT YOUR TOKEN HERE>",    "Accept: application/csv",    "Content-type: application/vnd.flux");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data="from(bucket: \"AdventureUs\")  |> range(start: -10m)  |> filter(fn: (r) => r[\"_measurement\"] == \"navigation.headingMagnetic\")  |> last()";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$mag_hdg = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }

//get last apparent wind direction
curl_setopt($ch, CURLOPT_URL,"https://us-east-1-1.aws.cloud2.influxdata.com/api/v2/query?orgID=51ff8e3a375def5a");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$headers = array(    "Authorization: Token <INSERT YOUR TOKEN HERE>",    "Accept: application/csv",    "Content-type: application/vnd.flux");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$data="from(bucket: \"AdventureUs\")  |> range(start: -10m)  |> filter(fn: (r) => r[\"_measurement\"] == \"environment.wind.angleApparent\")  |> last()";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$awd = curl_exec($ch);
if (curl_errno($ch)) { echo curl_error($ch); }
curl_close($ch);




//put influxdb csv output into arrays
$lines = explode(PHP_EOL, $latitude);
$data_lat = array();
foreach ($lines as $line) {
    $data_lat[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $longitude);
$data_long = array();
foreach ($lines as $line) {
    $data_long[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $outside_temp);
$data_out_temp = array();
foreach ($lines as $line) {
    $data_out_temp[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $depth);
$data_depth = array();
foreach ($lines as $line) {
    $data_depth[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $water_temp);
$data_water_temp = array();
foreach ($lines as $line) {
    $data_water_temp[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $aws);
$data_aws = array();
foreach ($lines as $line) {
    $data_aws[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $sog);
$data_sog = array();
foreach ($lines as $line) {
    $data_sog[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $cog);
$data_cog = array();
foreach ($lines as $line) {
    $data_cog[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $mag_hdg);
$data_mag_hdg = array();
foreach ($lines as $line) {
    $data_mag_hdg[] = str_getcsv($line);
}
$lines = explode(PHP_EOL, $awd);
$data_awd = array();
foreach ($lines as $line) {
    $data_awd[] = str_getcsv($line);
}

//join the arrays and select only time, lat/long data
$data=array();
$data_lat_count=count($data_lat)-4;
$x=0;
while($x<$data_lat_count){
	$x++;
	$data[]=array('time_lat' => $data_lat[$x][3], 'lat' => $data_lat[$x][6], 'time_long' =>$data_long[$x][3], 'long' => $data_long[$x][6]);
}
$current_loc=$x-1;



//display the google map - centered on myboat
?>


function initMap() {
  const currentloc = {lat: <?php echo $data[$current_loc]['lat']; ?>, lng: <?php echo $data[$current_loc]['long']; ?>};
  const map = new google.maps.Map(document.getElementById("map"), { zoom: 
  
<?php
if ($range==0){ echo "5";} else if ($range==1){ echo "7"; } else if ($range==2) {echo "11";}
?>
, center: currentloc, mapTypeId: 'hybrid', disableDefaultUI: true});
  const beachMarker = new google.maps.Marker({ position: currentloc, map, title: "Here is current data live from Adventure Us! Depth: <?php echo round($data_depth[1][6]*3.2808399, 1); ?>ft, Speed Over Ground: <?php echo round($data_sog[1][6]*1.9438445, 2); ?>knots, True Course Over Ground: <?php echo sprintf('%03s',round($data_cog[1][6]*57.2957795)); ?>°; Magnetic heading: <?php echo sprintf('%03s',round($data_mag_hdg[1][6]*57.2957795)) ?>°,  Water temperature: <?php echo $data_water_temp[1][6]-273.15; ?>°c, Outside temperature: <?php echo $data_out_temp[1][6]-273.15; ?>°c, Apparent Wind Speed: <?php echo round($data_aws[1][6]*1.9438445, 2); ?>knots, Apparent Wind Direction: <?php echo sprintf('%03s',round($data_awd[1][6]*57.2957795)) ?>°" });

<?php
if (!$range){ echo "const homeportMarker = new google.maps.Marker({ position: {lat: 46.183, lng: -82.361}, map,  title: \"Adventure Us home port of Spanish, Ontario!   We left on August 2nd, 2022!\", });";}
?>
  
  
  
  const flightPlanCoordinates = [
<?php
$x=0;
while($x<$current_loc){
	$x++;
	echo "{ lat: ".$data[$x]['lat'].", lng: ".$data[$x]['long']." }, ";
}
?>

  ];
  const flightPath = new google.maps.Polyline({path: flightPlanCoordinates, geodesic: true, strokeColor: "#FF0000", strokeOpacity: 1.0, strokeWeight: 2, });
  flightPath.setMap(map);
}
window.initMap = initMap;




