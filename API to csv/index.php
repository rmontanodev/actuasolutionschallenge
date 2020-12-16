<?php
function jsonToCSV($jfilename, $cfilename)
{
    if (($json = file_get_contents($jfilename)) == false)
        die('Error reading json file...');
    $data = json_decode($json, true);
    $fp = fopen($cfilename, 'w');
    $header = false;
    foreach ($data as $row)
    {
        if (empty($header))
        {
            $header = array_keys($row);
            fputcsv($fp, $header,';');
            $header = array_flip($header);
        }
        fputcsv($fp, array_merge($header, $row),';');
    }
    fclose($fp);
    return;
}

$ch = curl_init();
$fp = fopen("images.json","w");
curl_setopt($ch, CURLOPT_URL, "https://picsum.photos/v2/list?page=1&limit=75");
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ( $httpCode == 404 ) {
    die("No se pudo descargar el JSON de las imagenes");
} else {
    $contents = curl_exec($ch);
    fwrite($fp, $contents);
}

curl_close($ch);
fclose($fp);

$json_filename = 'images.json';
$csv_filename = 'images.csv';
jsonToCSV($json_filename, $csv_filename);
echo 'Se ha convertido de el fichero de JSON a csv correctamente. <a href="' . $csv_filename . '" target="_blank">Clic aqui para abrirlo.</a>';