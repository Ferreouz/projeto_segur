<?php
/*
Classe para controle de recebimento e entrega de dados entro o banco e o html
*/
class response{
    public $id = NULL;
    public $erro = NULL;
    private $conn;
    //variaveis da tabela os
    public $diretoria;
    public $data1;
    public $hora;
    public $responsavel;
    public $empresa;
    public $equipe;
    //variaveis da tabela risco
    private $id_risco;
    private $risco;
    private $gradacao;
    private $fator_risco;
    private $descricao;
    private $medidas;
    //variaveis da tabela arquivos
    private $descArq;

    public function __construct($c){
        $this->conn = $c;//recebe a conexao do banco 
        return $this; //retorna o proprio objeto 
    }
     /*
    Insere no banco na tabela OS
    */ 
    public function osInsert(){
        $this->osPost();
        $stmt = $this->conn->prepare("INSERT INTO tabela_os(diretoria,data1,hora,empresa,responsavel,n_equipe) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssssi", $this->diretoria,$this->data1,$this->hora,$this->empresa,$this->responsavel,$this->equipe);
        if(!$stmt->execute()){
            return $this->erro.= "Erro ao enviar a OS ao banco\n";
        }else return $this->id = $this->conn->insert_id;
    }
     /*
    Insere no banco na tabela risco
    */ 
    public function riscoInsert(){
        $this->riscoPost();
        $stmt = $this->conn->prepare("INSERT INTO tabela_risco(id_os,risco,desc_risco,medidas_correcao,gradacao,fator_risco)VALUES(?,?,?,?,?,?)");
        $stmt->bind_param("isssss", $this->id,$this->risco,$this->descricao,$this->medidas,$this->gradacao,$this->fator_risco);
        if(!$stmt->execute()){
            return $this->erro .= "Erro ao enviar o Risco ao banco\n"; 
        }else return $this->id_risco = $this->conn->insert_id;
    }
     /*
    Insere no banco na tabela arquivo
    */ 
    public function arqInsert($nome){
        $this->descArq = clean($_POST['desc_foto'],TRUE);
        $stmt = $this->conn->prepare("INSERT INTO tabela_fotos(id_os,id_risco,nome_foto,desc_foto)VALUES(?,?,?,?)");
        $stmt->bind_param("iiss", $this->id,$this->id_risco,$nome,$this->descArq);
        if(!$stmt->execute()){
            return $this->erro .= "Erro ao enviar o Risco ao banco\n";  
        }
        return NULL;
    }
    /*
    Seta as variveis de acordo com o formulario
    */ 
    private function osPost(){
        $this->diretoria = clean($_POST['diretoria']);
        $this->data1 = clean($_POST['data1'],FALSE);
        $this->hora = clean($_POST['time1'],FALSE);
        $this->responsavel = clean($_POST['responsavel']);
        $this->empresa = clean($_POST['empresa']);
        $this->equipe = clean($_POST['equipe']);
    }
     /*
    Seta as variveis de acordo com o formulario
    */ 
    private function riscoPost(){
        $this->risco = clean($_POST['risco']);
        $this->gradacao = clean($_POST['gradacao']);
        $this->fator_risco = clean($_POST['fator_risco']);
        $this->descricao = clean($_POST['descricao']);
        $this->medidas = clean($_POST['medidas']);
    }
     /*
    Busca na tabela os
    */ 
    public function osBanco(){
        $this->id = (int)clean($this->id);
        if(!$this->id == NULL){
            $stmt = $this->conn->prepare("SELECT * from tabela_os WHERE id_os = ? LIMIT 1");
            $stmt->bind_param("i", $this->id);
            if(!$stmt->execute()){
                return $this->erro .= "Erro OS nao encontrada\n";  
            }
            $d = $stmt->get_result();
            $result = $d->fetch_assoc();
            
            $this->diretoria = clean($result['diretoria']);
            $this->data1 = clean($result['data1'],FALSE);
            $this->hora = clean($result['hora'],FALSE);
            $this->responsavel = clean($result['responsavel']);
            $this->empresa = clean($result['empresa']);
            $this->equipe = clean($result['n_equipe']);
        }else return $this->erro .= "Erro OS nao encontrada\n";
    }
     /*
    Busca na tabela risco e tabela foto e retorna array
    */ 
    public function riscoBanco(){
        $this->id = (int)clean($this->id);
        //$stmt = $this->conn->prepare("SELECT * from tabela_risco as t1 INNER JOIN tabela_fotos as t2 ON t1.id_risco = t2.id_risco WHERE t1.id_os = ?");
        $stmt = $this->conn->prepare("SELECT * from tabela_risco WHERE id_os = ?");
        $stmt->bind_param("i", $this->id);
        if(!$stmt->execute()){
            return $this->erro .= "Erro risco nao encontrado\n";  
        }
        $d = $stmt->get_result();
    
        $i = 0;
        while ($result = $d->fetch_assoc()) {
            $array[$i]['id_risco'] = $result['id_risco'];
            $array[$i]['risco'] = $result['risco'];
            $array[$i]['desc_risco'] = $result['desc_risco'];
            $array[$i]['medidas_correcao'] = $result['medidas_correcao'];
            $array[$i]['gradacao'] = $result['gradacao'];
            $array[$i]['fator_risco'] = $result['fator_risco'];
            $stmt2 = $this->conn->prepare("SELECT nome_foto,desc_foto from tabela_fotos WHERE id_risco = ?");
            $stmt2->bind_param("i", $result['id_risco']);
            if($stmt2->execute()){
                $d2 = $stmt2->get_result();
                while($result2 = $d2->fetch_assoc()){
                    $array[$i]['nome_foto'] = $result2['nome_foto'];
                    $array[$i]['desc_foto'] = $result2['desc_foto'];
                    $i++;
                }
            }
            $i++;
        }
        return json_decode( json_encode($array));
    }    
}
