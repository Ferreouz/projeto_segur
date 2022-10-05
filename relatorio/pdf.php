<?php
/*
Puxar cada risco do banco de acordo com o numero da os; Gerando um pdf com todas informações e imagens
*/
if(!$_POST['id_pdf']){    
    header("Location: ../home");
    exit;
}

require_once '../include/conexao.class.php';
require_once '../include/response.class.php';
require_once '../include/functions.php';
$resposta = new response($mysqli);
$resposta->id = $_POST['id_pdf'];
require_once '../../lib/pdf-php/src/Cezpdf.php';
$pdf = new Cezpdf('a4','portrait','color',[1,1,1]);
$pdf->ezSetMargins(20,20,20,20);
// Use one of the pdf core fonts
$mainFont = 'Times-Roman';
// Select the font
$pdf->selectFont($mainFont);
// Define the font size
$size=12;
// Modified to use the local file if it can
$pdf->openHere('Fit');

$resposta->osBanco();
$OS = json_decode( json_encode($resposta));//retorna objeto php com a os

$pdf->ezText("<c:color:1,0,0>OS:</c:color>$OS->id", 21, ['justification'=>'center']);
$pdf->ezText("   -------------------------------------------------------------------------------------------------------------------------------------", $size, ['justification'=>'center']);
$pdf->ezText("   Diretoria : $OS->diretoria", $size, ['justification'=>'left']);
$pdf->ezText("   Data : " . convDate($OS->data1), $size, ['justification'=>'left']);
$pdf->ezText("   Hora : $OS->hora", $size, ['justification'=>'left']);
$pdf->ezText("   Responsavel : $OS->responsavel", $size, ['justification'=>'left']);
$pdf->ezText("   Empresa : $OS->empresa", $size, ['justification'=>'left']);
$pdf->ezText("   Equipe : $OS->equipe", $size, ['justification'=>'left']);

$riscos = $resposta->riscoBanco();//retorna objeto php com todos os risco
foreach($riscos as $risco){
    if(isset($risco->id_risco)){
        $pdf->ezText("   -------------------------------------------------------------------------------------------------------------------------------------", $size, ['justification'=>'center']);
        $pdf->ezText("   Risco : $risco->risco", $size, ['justification'=>'left']);
        $pdf->ezText("   Descrição : $risco->desc_risco", $size, ['justification'=>'left']);
        $pdf->ezText("   Medidas de Correção : $risco->medidas_correcao", $size, ['justification'=>'left']);
        $pdf->ezText("   Gradação : $risco->gradacao", $size, ['justification'=>'left']);
        $pdf->ezText("   Fator risco : $risco->fator_risco", $size, ['justification'=>'left']);
        if(isset($risco->nome_foto))
            $pdf->ezText("   Descrição das fotos : $risco->desc_foto", $size, ['justification'=>'center']);
    }
    if(isset($risco->nome_foto)){
        $image = "../uploads/".$risco->nome_foto;
        $pdf->ezImage($image,5,200,"none");  
    }
}
// Output the pdf as stream, but uncompress
$mysqli->close();
$pdf->ezStream(['compress'=>0]);