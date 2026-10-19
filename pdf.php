<?php
session_start();
include 'db.php';
require 'vendor/autoload.php';

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$result=$conn->query("select * from properties");

$pdf=new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Property Details',0,1,'C');

$html = '<table border="1" cellpadding="5">
<tr>
<td>ID</td>
<td>Property Name</td>
<td>Description</td>
<td>Price</td>
<td>Location</td>
<td>Property Type</td>
<td>Bedrooms</td>
</tr>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
    <td>'.$row['id'].'</td>
    <td>'.$row['property_name'].'</td>
    <td>'.$row['description'].'</td>
    <td>'.$row['price'].'</td>
    <td>'.$row['location'].'</td>
    <td>'.$row['property_type'].'</td>
    <td>'.$row['bedrooms'].'</td>
    </tr>';
}

$html.='</table>';

$pdf->writeHTML($html,true,false,true,false,'');
$pdf->Output('properties.pdf','D');
?>