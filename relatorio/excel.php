<?php
/*
Imprimir relatorio em tabela de excel, baseado em parametros de data
*/
require_once '../include/conexao.class.php';
require_once '../include/functions.php';

if(!$_GET['data1'] || !$_GET['data2']){    
    header("Location: ../home");
    exit;
}
$data1 = clean($_GET['data1'], FALSE);
$data2 = clean($_GET['data2'], FALSE);

if(!$_GET['equipe']){
    $equipe = "TODAS";
    $stmt = $mysqli->prepare("SELECT * from tabela_os WHERE data1 BETWEEN ? AND ?");
    $stmt->bind_param("ss", $data1,$data2);
}else{
    $equipe = clean($_GET['equipe']);
    $stmt = $mysqli->prepare("SELECT * from tabela_os WHERE n_equipe = ? AND data1 BETWEEN ? AND ?");
    $stmt->bind_param("iss", $equipe,$data1,$data2);
}

$nome_arquivo = 'relatorio.xls';
$excel = '<meta charset="UTF-8">';
$excel .='<table border="2">';
$excel .='<tr>';
$excel .='<td colspan="4">OS de '.convDate($data1).' a '.convDate($data2).' equipe: '.$equipe.' </td>';
$excel .='</tr>';

$excel .= '<tr>';
$excel .= '<td>Numero OS</td>';
$excel .= '<td>Diretoria</td>';
$excel .= '<td>Data</td>';
$excel .= '<td>Hora</td>';
$excel .= '<td>Empresa</td>';
$excel .= '<td>Responsavel</td>';
$excel .= '<td>Equipe</td>';
$excel .= '<td>Risco</td>';
$excel .= '<td>Fator Risco</td>';
$excel .= '<td>Descrição </td>';
$excel .= '<td>Medidas p/ correção</td>';
$excel .= '<td>Gradação</td>';
$excel .='</tr>';

$stmt->execute();
$d = $stmt->get_result();
$stmt2 = $mysqli->prepare("SELECT * from tabela_risco WHERE id_os = ?");

while($result = $d->fetch_assoc()){
    $excel .= '<tr>';
    $excel .= '<td>'.$result['id_os'].'</td>';
    $excel .= '<td>'.$result['diretoria'].'</td>';
    $excel .= '<td>'.$result['data1'].'</td>';
    $excel .= '<td>'.$result['hora'].'</td>';
    $excel .= '<td>'.$result['empresa'].'</td>';
    $excel .= '<td>'.$result['responsavel'].'</td>';
    $excel .= '<td>'.$result['n_equipe'].'</td>';

    $stmt2->bind_param("i", $result['id_os']);
    $stmt2->execute();
    $d2 = $stmt2->get_result();
    $i = 0;
    while($result2 = $d2->fetch_assoc()){
        if($i != 0){
            $excel .= '<td> </td>';
            $excel .= '<td> </td>';
            $excel .= '<td> </td>';
            $excel .= '<td> </td>';
            $excel .= '<td> </td>';
            $excel .= '<td> </td>';
            $excel .= '<td> </td>';
        }
        
        $excel .= '<td>'.$result2['risco'].'</td>';
        $excel .= '<td>'.$result2['fator_risco'].'</td>';
        $excel .= '<td>'.$result2['desc_risco'].'</td>';
        $excel .= '<td>'.$result2['medidas_correcao'].'</td>';
        $excel .= '<td>'.$result2['gradacao'].'</td>';
        $excel .= '</tr>';
        $i++;
    }
}

/*TODO 
$excel .= '<tr>';
$excel .= '<img src="../2a96e9b884d60d59e0e359ece539a5f8b45be21816e991ffe185a5a099dac92c.jpeg">';
$excel .= '</tr>';
*/


$mysqli->close();
// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=".$nome_arquivo);
header ("Content-Description: PHP Generated Data" );
// Envia o conteúdo do arquivo
echo $excel;
exit;