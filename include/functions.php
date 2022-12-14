<?php
 //Converter data para o padrao brasileiro dd/mm/yyyy 
 function convDate($date){
    //explode: separa a string em array de acordo com o primeiro elemento
    //array_reverse: organiza o array em ordem reversa
    //implode pega um array e junta tudo de acordo com o primeiro argumento
    return implode('/', array_reverse(explode('-', $date)));
}
/*
Limpa as variaveis de acordo com um filtro
*/ 
function clean($s,$string=TRUE){
    if($string === TRUE)//FILTRO PARA STRINGS
            $filtro = '/[@#$%^&*{}\\/=<>|]/';//!?.,;()
    else if($string === FALSE)//FILTRO PARA HORA E DATA
        $filtro = '/[a-zA-Z!@#$%^&*()\"\'\\/;=<>|.,?]/';
            
    return trim(htmlspecialchars(preg_replace($filtro, '',$s),ENT_QUOTES, 'UTF-8'));
}
function hashIt($string,$salt){
    $hash = $salt . $string . $salt;
    return hash('sha256', $hash);
}
function createRandom(){
    //Cria um numero aleatorio entre 100000 e 999999
    $random = random_int(100000,999999);
    return $random;
}