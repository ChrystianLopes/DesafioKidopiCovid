<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "covidKidop";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully" . "<br>";

//Log do Banco de Dados
$data_e_hora = date('d-m-Y H:i'); 
echo $data_e_hora; 

// Comando SQL para criar a tabela
$sql = "CREATE TABLE IF NOT EXISTS logCovidKidop (
  ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  dataHora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  Pais VARCHAR(30)
)";

// Execução do comando SQL
if (mysqli_query($conn, $sql)) {
  echo "Tabela criada com sucesso!";
} else {
  echo "Erro na criação da tabela: " . mysqli_error($conn);
}
?>