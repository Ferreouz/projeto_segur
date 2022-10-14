let id_os = null//id para controle do cookie
const form = document.getElementById('form')
const r = document.getElementById('resposta')
//enviar os dados e receber via JSON
form.addEventListener('submit', function(evt){
    evt.preventDefault()
    sendForm(evt).then(data => {
        console.log(data)
        if(data.erro != null){
            showMSG(data.erro,false)
        }else {
            r.innerText = "ID da OS:" + data.id
            cookie(data.id)
            setNblock(false,false)
            clear(document.getElementById("divRisco"))
            id_os = data.id
            showMSG("Sucesso ao enviar", true)
        }
    })
})
//pelos cookie "voltar" a sessao anterior
if (checkCookie()){
    fetch("cookie.php")
    .then(resposta => resposta.json())
    .then(data=>{
        setNblock(data,true)
        id_os = data.id
        document.getElementById("resposta").innerText = "OS: " + id_os
    })
}
//animacao de abrir e fechar pelo botao lateral
menuButton.addEventListener('click', ()=>{
    const drawer = document.getElementById("drawer")
    drawer.classList.toggle('sumir')
    drawer.classList.toggle('voltar')
})
function imprimirExcel(){
    const data1 = document.getElementById('data1_excel').value
    const data2 = document.getElementById('data2_excel').value
    const equipe = document.getElementById('equipe_excel').value

    const url = "relatorio/excel?data1="+data1+"&data2="+data2+"&equipe="+equipe
    window.location.href = url
}
//apos um segundo a animacao do botao lateral começar a animaçao
setTimeout(()=>{
    const root = document.querySelector(':root')
    root.style.setProperty('--time','0.4s')
},1000)