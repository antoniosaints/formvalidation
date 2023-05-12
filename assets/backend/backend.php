<?php

class Transactions
{
    private $conn;

    public function __construct()
    {
        //Cria uma conexão com o banco
        $this->conn = new mysqli("localhost", "fazenda_db", "cas20182018", "fazenda_db");
        $this->conn->set_charset("utf8");
    }

    public function save($data, $table) // salva os dados de acordo com os nomes de chaves de cada linha e passando qual tabela salvar
    {
        //Mapea as colunas de acordo com os indices
        $columns = implode(", ", array_keys($data));
        //Mapea os dados de acordo com os valores dos indices
        $values  = implode("', '", array_map(array($this->conn, "real_escape_string"), array_values($data)));
        //Cria a query de acordo com os valores dos indices
        $query = "INSERT INTO $table ($columns) VALUES ('$values')";
        //Insere os valores na tabela
        if ($this->conn->query($query)) {
            return true;
        } else {
            return false;
        }
    }
    public function findAll($table) // busca na tabela por id
    {
        // Cria a query
        $query = "SELECT * FROM $table";

        $values  = $this->conn->query($query);
        $results = $values->fetch_all(PDO::FETCH_ASSOC);
        // Fetch do resultado 
        return $results;
    }
}
