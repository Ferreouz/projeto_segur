<?php
/*
Enviar para o banco FORM e os arquivo e retorna para os campos serem preenchidos
 */
require_once 'include/conexao.class.php';
require_once 'include/file.class.php';
require_once 'include/response.class.php';
require_once 'include/functions.php';

if(!$_POST){
    header("Location: ./home");
    exit;
}

$resposta = new response($mysqli);
if(!isset($_POST['idos'])){
    $resposta->osInsert();
}else $resposta->id = $_POST['idos'];

$resposta->riscoInsert();

if(empty($resposta->erro)){
    if(!$_FILES['f']['size'][0] == 0 && !$_FILES['f']['error'][0] == 4){
        $ff = restructureFilesArray($_FILES['f']);
        foreach ($ff as $File){
            if(!$File['error'] != 0){
                $file = new File($File);
                $file->verTamanho();
                $nomeArq = $file->upload();
                if(!empty($file->erro)){
                    $resposta->erro .= $file->erro;
                }else $resposta->arqInsert($nomeArq);
        }else $resposta->erro .= "ERRO!! ".errorArq($File['error'],$File['name']);
        } 
    }
    
}
$mysqli->close();
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($resposta);
unset($resposta);
exit;