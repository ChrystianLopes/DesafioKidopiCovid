<?php
    //Conexão com a base de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "covidKidop";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    //Estilo da pagina da API
    echo "<style type='text/css'>
        #api {
            font-family: 'Bebas Neue', cursive;
            background: #c9e2ff;
        }
        
        #header {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 20px;
        }
        
        #table {
            border-collapse: collapse; /* CSS2 */
            position: absolute;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        #table td,
        #table th {
            border: 2px solid black;
            padding-left: 20px;
            padding-right: 20px;
        }

    </style>";

    //Back-end PHP
    echo "<body id='api'>";
    if(isset($_POST['Button'])) {
        $value_button = $_POST['Button'];
    }

    $url = "https://dev.kidopilabs.com.br/exercicio/covid.php?pais=" . $value_button;
    $estados = json_decode(file_get_contents($url));
    
    switch ($value_button) {
        case "Brazil":
          $value_button = "Brasil";
          break;
        case "Canada":
          $value_button = "Canadá";
          break;
        case "Australia":
            $value_button = "Austrália";
            break;
        default:
            $value_button = " ";
    }

    echo "<header id='header'>" . "Casos de Covid no " . $value_button . "<br>" . "<br>" . "</header>";
    $mortos = 0;
    $confirmados = 0;

    echo "<table id='table'> 
        <tr> 
            <th>Estados</th> 
            <th>Confirmados</th> 
            <th>Mortos</th> 
        </tr>";

    foreach ($estados as $ProvinciaEstado) {
        echo "<tr>";
        echo "<td>" . $ProvinciaEstado->ProvinciaEstado . "</td>";
        echo "<td>" . number_format($ProvinciaEstado->Confirmados, 0, ",", ".") . "</td>";
        $confirmados += $ProvinciaEstado->Confirmados;
        echo "<td>" . number_format($ProvinciaEstado->Mortos, 0, ",", ".") . "</td>";
        echo "</tr>";
        $mortos += $ProvinciaEstado->Mortos;
    }
    echo "</table>" . "<br>";
    echo sprintf("Total de casos confirmados no %s: %s <br><br>", $value_button, number_format($confirmados, 0, ",", "."));
    echo sprintf("Total de mortos no %s: %s",$value_button , number_format($mortos, 0, ",", "."));
    echo "</body>";

    // Comando SQL para inserir dados na tabela
    $sql = sprintf("INSERT INTO logcovidkidop (dataHora, Pais)
    VALUES (CURRENT_TIMESTAMP, '%s')", $value_button);

    if (mysqli_query($conn, $sql)) {
        echo "Tabela criada com sucesso!";
    } else {
        echo "Erro na criação da tabela: " . mysqli_error($conn);
    }

    //Fecha a conexão
    mysqli_close($conn);
?>

