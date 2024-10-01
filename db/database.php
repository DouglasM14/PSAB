<?php
class Database
{
    private $pdo;
    private $host = 'localhost';
    private $db = 'psab';
    private $user = 'root';
    private $pass = '';

    public function connect()
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
        $sql = "SELECT $columns FROM $table WHERE $condition";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectJoin($table, $columns = "*", $joins = "", $condition = "1")
    {
        $sql = "SELECT $columns FROM $table $joins WHERE $condition";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function transaction($state)
    {
        switch ($state) {
            case 'start':
                $this->getPdo()->beginTransaction();
                break;
            case 'commit':
                $this->getPdo()->commit();
                break;
            case 'rollBack':
                $this->getPdo()->rollBack();
                break;
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
