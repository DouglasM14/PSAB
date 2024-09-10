<?php
class Database
{
    private $pdo;
    private $host = 'localhost';
    private $db = 'psab';
    private $user = 'root';
    private $pass = '';

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            date_default_timezone_set('America/Sao_Paulo');
        } catch (PDOException $e) {
            echo 'Conexão falhou: ' . $e->getMessage();
        }
    }

    public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    public function delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    public function update($table, $data, $condition)
    {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");
        $sql = "UPDATE $table SET $setClause WHERE $condition";

        $stmt = $this->pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    public function select($table, $columns = "*", $condition = "1")
    {
        // Monta a query SQL
        $sql = "SELECT $columns FROM $table WHERE $condition";

        // Prepara e executa a query
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Retorna os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
