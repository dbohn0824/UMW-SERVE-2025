<?php 


require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;


$html = '<h1>Example<h1>';
$html .= "Hello <em> world</em>";
$html .= '<img src="images\SERVE_logo.png">'; 

$options = new Options;
$options->setChroot(__DIR__); 

$dompdf = new Dompdf($options);

//$dompdf->setPaper("A4", "landscape");

//$dompdf->loadHtml($html);
$dompdf->loadHtmlFile("pdf_template.html");


$dompdf->render();

$dompdf->addInfo("Title", "SERVE Volunteer Sign-up");

$dompdf->stream("Community_Service_Letter.pdf", ["Attachment" => 0]); 


?> 