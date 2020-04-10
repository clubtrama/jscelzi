<?php

require_once __DIR__."/../config.php";
require __DIR__  . '/../vendor/autoload.php';

$consulta = "SELECT ";


$filename = "EXPORT-BOOTCAMP.xls";
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$user_query = mysqli_query($con, $consulta);
$flag = false;


$provincias = array();

while ($row = mysqli_fetch_assoc($user_query)) {

  $province = $row['province'];



    switch ($province) {
        case (($province === "Buenos Aires") OR ($province === "Buenos Aires Province")):
            $province = "Provincia de Buenos aires";
            break;
        case (($province === "Buenos Aires Autonomous City") OR ($province === "Buenos Aires F.D.")):
            $province = "CABA";
            break;
        case ($province === "Catamarca"):
            $province = 'Catamarca';
            break;
        case ($province === "Chaco"):
            $province = 'Chaco';
            break;
        case ($province === "Chubut"):
            $province = 'Chaco';
            break;
        case (($province === "Córdoba") OR ($province === "Cordoba")):
        $province = 'Cordoba';
            break;
        case ($province === "Corrientes"):
        $province = 'Corrientes';
            break;
        case (($province === "Entre Rios") OR ($province === "Entre Ríos")):
        $province = 'Entre Rios';
            break;
        case ($province === "Formosa"):
        $province = 'Formosa';
            break;
        case ($province === "Jujuy"):
        $province = 'Jujuy';
            break;
        case ($province === "La Pampa"):
        $province = 'La Pampa';
            break;
        case ($province === "La Rioja"):
        $province = 'La Rioja';
            break;
        case ($province === "Mendoza"):
        $province = 'Mendoza';
            break;
        case ($province === "Misiones"):
        $province = 'Misiones';
            break;
        case (($province === "Neuquen") OR ($province === "Neuquén")):
        $province = 'Neuquen';
            break;
        case (($province === "Rio Negro") OR ($province === "Río Negro")):
        $province = 'Rio Negro';
            break;
        case ($province === "Salta"):
        $province = 'Salta';
            break;
        case ($province === "San Juan"):
        $province = 'San Juan';
            break;
        case ($province === "San Luis"):
        $province = 'San Luis';
            break;
        case ($province === "Santa Cruz"):
        $province = 'Santa Cruz';
            break;
        case ($province === "Santa Fe"):
        $province = 'Santa Fe';
            break;
        case ($province === "Santiago del Estero"):
        $province = 'Santiago del Estero';
            break;
        case ($province === "Tierra del Fuego"):
        $province = 'Tierra del Fuego';
            break;
        case (($province === "Tucuman") OR ($province === "Tucumán")):
        $province = 'Tucuman';
            break;
        default:
        $province = 'CABA';
        break;
        }
        // end determinación de provincia


// desactivado el replace de provincia
$row['province'] = $province;


$provincias[] = $row;


}





$amount = array();
foreach($provincias as $provincia) {
    $index = provincia_exists($provincia['province'], $amount);
    if ($index < 0) {
        $amount[] = $provincia;
    }
    else {
        $amount[$index]['monto_facturado'] +=  $provincia['monto_facturado'];
    }
}
// print_r($amount); //display

// for search if a bank has been added into $amount, returns the key (index)
function provincia_exists($provincianombre, $array) {
    $result = -1;
    for($i=0; $i<sizeof($array); $i++) {
        if ($array[$i]['province'] == $provincianombre) {
            $result = $i;
            break;
        }
    }
    return $result;
}






foreach($amount as $amoun) {
  if (!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($amoun)) . "\r\n";
      $flag = true;
  }
  echo implode("\t", array_values($amoun)) . "\r\n";
}





 ?>
