<?php

require_once __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Client;

$climate = new League\CLImate\CLImate;

$climate->arguments->add([
    'url' => [
        'description' => 'The URL to convert',
        'required'    => true,
    ],
    'path' => [
        'description' => 'Path to converted PDF',
        'required'    => true,
    ],
]);
$climate->arguments->parse();

$mpdf = new mPDF('utf-8', 'A4');
//Remove HTTPS for now because we have some SSL errors when generating the PDF
$url = str_replace('https://', 'http://', $climate->arguments->get('url'));
$client = new Client();
$html = $client->get($url)->getBody()->getContents();
$mpdf->setBasePath($url);
$mpdf->WriteHTML($html);
$mpdf->Output($climate->arguments->get('path'));
