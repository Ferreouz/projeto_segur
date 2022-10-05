<?php
/*
Classe para validaçao e upload de arquivo 
*/
class File{
    private $file;
    private $name;
    private $dir = "./uploads/";
    private $max_size = 8;
    private $extensao;
    private $oldName;
    public $erro = NULL;

    public function __construct($f){
        if (!is_array($f)){
            $this->erro .="Upload não é um arquivo!\n";
        }else {
            $this->file = $f;
            $this->oldName = $this->file['name'];
            $this->name = $this->criarNome(NULL);   
        } 
        return $this;
    }

    private function verificarTipo(){
        if($check = getimagesize($this->file["tmp_name"]) === FALSE){
            return $this->erro .= "Arquivo $this->oldName nao é imagem!\n";
        }else return $this->extensao = pathinfo($this->file['name'], PATHINFO_EXTENSION);
    }

    private function criarNome($s){
        $extrasalt = $s ?? "BAZINGA";
        $salt = time().$extrasalt;
        $hash = hash('sha256', $this->file['tmp_name'].$salt); 
        return $hash.".";
    }

    public function verTamanho(){
        if($this->file['size'] > $this->max_size *1024 *1024){
            $this->erro .= "Arquivo $this->oldName excedeu $this->max_size MB\n";
        }
    }

    public function upload(){
        $this->verificarTipo();
        if(empty($this->erro)){
            $this->name = $this->name.$this->extensao;
            if(file_exists($this->dir.$this->name)){
                $this->name = $this->criarNome("null").$this->extensao;
            }   
            move_uploaded_file($this->file["tmp_name"], $this->dir.$this->name);
            return $this->name;
        }else {
            $this->erro .="ERRO ao fazer upload do arquivo $this->oldName!\n";
            return $this->erro;
        }
    }
    

}
function restructureFilesArray($files)
{
    $output = [];
    foreach ($files as $attrName => $valuesArray) {
        foreach ($valuesArray as $key => $value) {
            $output[$key][$attrName] = $value;
        }
    }
    return $output;
}
function errorArq($erro,$nome){
    if($erro===1)
        return "Arquivo $nome excedeu o limite de tamanho";
    if($erro===2)
        return "Arquivo $nome excedeu o limite de tamanho";
    if($erro===3)
        return "Arquivo $nome nao foi totalmente enviado";
}