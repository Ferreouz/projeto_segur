//funcao para bloquear os campos de serem digitados, e setarem valores dos campos
function setNblock(data, bool){
    let dir = document.getElementById("diretoria")
    dir.setAttribute("disabled", "")
    let res = document.getElementById("responsavel")
    res.setAttribute("disabled", "")
    let d = document.getElementById("data1")
    d.setAttribute("disabled", "")
    let empresa = document.getElementById("empresa")
    empresa.setAttribute("disabled", "")
    let hora = document.getElementById("time1")
    hora.setAttribute("disabled", "")
    let equipe = document.getElementById("equipe")
    equipe.setAttribute("disabled", "")
    
    if(bool === true){
        console.log(data)
        dir.value = data.diretoria
        res.value = data.responsavel
        d.value = data.data1
        empresa.value = data.empresa
        hora.value = data.hora
        equipe.value = data.equipe
    }
}
//funcao para limpar campos, arg = objeto pai
function clear(object){
    let clear = Array.from(object.children)
    clear.forEach(element => {
        element.value = ""
    })
}
//setar cookie com id da OS
function cookie(os) {
    let cookie = "os=" + os + ";expires=Fri, 31 Dec 9999 23:59:59 GMT;path=/segur/"
    document.cookie = cookie;
}
//funcao para salvar o arquivo pdf
function saveFile(blob, filename) {
    if (window.navigator.msSaveOrOpenBlob) {
      window.navigator.msSaveOrOpenBlob(blob, filename);
    } else {
      const a = document.createElement('a');
      document.body.appendChild(a);
      const url = window.URL.createObjectURL(blob);
      a.href = url;
      a.download = filename;
      a.click();
      setTimeout(() => {
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
      }, 0)

    }
}
//funcao para enviar para o banco depois limpar os cookie e começar nova OS    
async function novaOS(){
    const data = await sendForm().then(data => data)
    if(data.erro != null)
        showMSG(data.erro,false)
    else{
        const f = new FormData()
        f.append('id_pdf', data.id)
        fetch('relatorio/pdf.php',{ method: 'POST', body: f})
        .then(response => response.blob())
        .then(file => {
            const filename = "os_" + data.id
            saveFile(file, filename)//faz o download do arquivo
            //remove os cookies do navegador e atualiza a pagina
            document.cookie = "os=; expires=Fri, 18 Dec 1970 12:00:00 GMT;path=/segur/"
            id_os = null
            document.location = 'home'
        })
    }

}
//funcao de enviar o formulario para o banco
async function sendForm(evt = null){
    destroyMSG()
    const form1 = new FormData(form)    
    if (id_os!=null)
        form1.append('idos',id_os)

    const header = {method: 'POST', body: form1} 
    const response = await fetch('send.php', header)
    .then(resposta => resposta.json())
    .catch(error=> {
        console.error(error)
        //showMSG(error,false)
    })
    return response;
}
//mostrar mensagem dentro do card, 2° arg sendo true para mensagem verde e false para erros vermelhos
function showMSG(msg,boolean){
    let novaClasse
    if (boolean === true)
        novaClasse = "sucesso"
    else novaClasse = "erro"
    
    let output = document.createElement("h5")
    output.className = novaClasse
    output.innerText = msg
    output.setAttribute('id','mensagem')
    document.getElementById("container").insertBefore(output,r) 
}
//destruir mensagem de erro e sucesso
function destroyMSG(){
    let mensagem = document.getElementById("mensagem")
    if (mensagem != null)
        document.getElementById("container").removeChild(mensagem)  
}
function checkCookie(){
    let v = document.cookie.split(';').some(item=>item.trim().startsWith('os='))
    return v
}