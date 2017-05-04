<?php
// traitement fichier json pour prévisions météo
// source : http://www.prevision-meteo.ch/services
$jsonFile = "http://www.prevision-meteo.ch/services/json/menigoute";
$json = file_get_contents( $jsonFile );
$json = json_decode($json);

// $modl = "<div  class='mto-fcst'>{jour}<img src='{icon}'><span class='tmin'>{tmin}</span><span class='tmax'>{tmax}</span></div>\n";
$modl = "<div  class='mto-fcst' title='{title}'><img src='{icon}'><span class='jour'>{jour}</span><span class='tmin'>{tmin}°</span><span class='tmax'>{tmax}°</span></div>\n";

if(isset($_GET["e"]))  {

echo "<div  class='mto'>"
	// . str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array($json->fcst_day_0->day_short, $json->fcst_day_0->icon, $json->fcst_day_0->tmin, $json->fcst_day_0->tmax, $json->fcst_day_0->day_short), $modl)
	// . ( $_GET["e"] > 1 ? str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array($json->fcst_day_1->day_short, $json->fcst_day_1->icon, $json->fcst_day_1->tmin, $json->fcst_day_1->tmax, $json->fcst_day_1->day_short), $modl) : "")
	// . ( $_GET["e"] > 2 ? str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array($json->fcst_day_2->day_short, $json->fcst_day_2->icon, $json->fcst_day_2->tmin, $json->fcst_day_2->tmax, $json->fcst_day_2->day_short), $modl) : "")
	// . "</div>\n";
	. str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array("aujourd'hui", $json->fcst_day_0->icon, $json->fcst_day_0->tmin, $json->fcst_day_0->tmax, $json->fcst_day_0->day_short), $modl)
	. ( $_GET["e"] > 1 ? str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array("demain", $json->fcst_day_1->icon, $json->fcst_day_1->tmin, $json->fcst_day_1->tmax, $json->fcst_day_1->day_short), $modl) : "")
	. ( $_GET["e"] > 2 ? str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array($json->fcst_day_2->day_short, $json->fcst_day_2->icon, $json->fcst_day_2->tmin, $json->fcst_day_2->tmax, $json->fcst_day_2->day_short), $modl) : "")
	. "</div>\n";
	
}	

?>