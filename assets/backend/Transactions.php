<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './backend.php';

class Verificacoes
{
    private $conn;
    private $Transaction;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "fazenda_db", "cas20182018", "fazenda_db");
        $this->conn->set_charset("utf8");

        $this->Transaction = new Transactions();
    }

    public function SalvaForm()
    {
        $consulta = $this->conn->query("SELECT * FROM hagro_cadastros WHERE cpf_cnpj = " . $_POST['cpf_cnpj'] . "");
        $verifica = $consulta->fetch_all(PDO::FETCH_ASSOC);

        if (!$verifica) {
            if ($this->Transaction->save($_POST, 'hagro_cadastros')) {
                echo json_encode(['title' => 'Sucesso!', 'type' => 'success', 'message' => 'Cadastro concluído com sucesso!']);
            } else {
                echo json_encode(['title' => 'Ops!', 'type' => 'error', 'message' => 'Erro ao realizar o cadastro!']);
            }
        } else {
            echo json_encode(['title' => 'Atenção!', 'type' => 'warning', 'message' => 'Já existe um registro com esse CPF/CNPJ!']);
        }
    }
}

$class = new Verificacoes();
$execute = $class->SalvaForm();
