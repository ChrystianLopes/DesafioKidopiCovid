var dataAtual = new Date().toLocaleDateString();
localStorage.setItem("dataAcesso", dataAtual);

var botoes = document.querySelectorAll("button");
for (var i = 0; i < botoes.length; i++) {
  botoes[i].addEventListener("click", function() {
    var nomeBotao = this.innerHTML;
    localStorage.setItem("ultimoBotao", nomeBotao);
  });
}

var rodape = document.getElementById("rodape");
var dataAcesso = localStorage.getItem("dataAcesso");
var ultimoBotao = localStorage.getItem("ultimoBotao");
rodape.innerHTML = "Último acesso em " + dataAcesso + " - Último país acessado: " + ultimoBotao;


var xhr = new XMLHttpRequest();
xhr.open('POST', 'conectSql.php');
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onload = function() {
  console.log('Resposta do PHP: ' + this.responseText);
};
xhr.send('dataPhp=' + encodeURIComponent(dataAcesso));
xhr.send('paisPhp=' + encodeURIComponent(ultimoBotao));