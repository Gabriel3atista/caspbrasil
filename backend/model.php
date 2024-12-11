<?php
// Exemplo de conexão com o banco de dados
$host = 'localhost';
$dbname = 'dbname';
$username = 'postgres';
$password = 'postgres';

// Para fins de exemplos e simplicidade, ignorei a captura de erros com try catch
$pdo = new PDO("pgsql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Definindo a query para resgatar os dados do banco
$query = "SELECT 
                  np.id_nfe,
                  n.nr_nfe,
                  np.nr_quantidade_produto,
                  np.vl_nfe,
                  p.id AS id_produto,
                  p.ds_produto,
                  p.nr_quantidade,
                  p.vl_produto
                FROM nfe_products np
                JOIN nfe n ON np.id_nfe = n.id
                JOIN products p ON np.id_produto = p.id
                WHERE np.id_nfe = 1"; // Em um exemplo real, o id é dinamico

$stmt = $pdo->query($query);
$nfe_result = $stmt->fetchAll();

// Definindo a estrutura do JSON
$nfe = [
    "id_nfe" => $nfe_result[0]["id_nfe"],
    "nr_nfe" => $nfe_result[0]["nr_nfe"],
    "nr_quantidade_produto" => $nfe_result[0]["nr_quantidade_produto"],
    "vl_nfe" => $nfe_result[0]["vl_nfe"],
    "produtos" => []
];

// Loop no resultado da busca no banco de dados e inserção dos dados no array de produtos
foreach ($nfe_result as $row) {
    $nfe["produtos"][] = [
        "id_produto" => $row["id_produto"],
        "ds_produto" => $row["ds_produto"],
        "nr_quantidade" => $row["nr_quantidade"],
        "vl_produto" => $row["vl_produto"]
    ];
}

// Exibindo o JSON
$products = json_encode($nfe, JSON_PRETTY_PRINT);

var_dump($products);
