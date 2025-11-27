<?php

namespace app\core;
use mysqli;

class Db {
  private $DBServer;
  private $DBUser;
  private $DBPass;
  private $DBName;

  private $conn;

  public function __construct() {
    // --- DADOS DA CLEVER CLOUD ---

    $this->DBServer = 'bg93lad9nxdevap2m0ra-mysql.services.clever-cloud.com';
    $this->DBUser   = 'ucqpp4eeekja77as';
    $this->DBPass   = 'fD6nRMHlpSbt2EKFWdnF';
    $this->DBName   = 'bg93lad9nxdevap2m0ra';

    // Cria a conexão
    $this->conn = new mysqli($this->DBServer, $this->DBUser, $this->DBPass, $this->DBName);

    // Verifica se houve erro na conexão (importante para debug)
    if ($this->conn->connect_error) {
        die("Falha na conexão à Cloud: " . $this->conn->connect_error);
    }

    $this->conn->set_charset("utf8");
  }


  /**
  * Método para a definição dos parâmetros para o prepared statement
  * @param  MySQLiStatement  
  * @param  array           
  */
  private function setParameters($stmt, array $parameters) {
    if (count($parameters)) {
      $types = $parameters[0];
      $values = $parameters[1];
      $stmt->bind_param($types, ...$values); // *1
    }
  }

  /**
  * @param  string   
  * @param  array    
  *
  * @return array   
  */
  
  // Este método faz a execução de queries SQL com prepared statements
  public function execQuery(string $sql, array $parameters = []) {
      try {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
         
          error_log('DB prepare failed: ' . $this->conn->error);
          return false;
        }
        $this->setParameters($stmt, $parameters);
        $stmt->execute();

        $trim = strtoupper(trim($sql));
        if (strpos($trim, 'SELECT') === 0) {
          $result = $stmt->get_result();
          $response = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } elseif (strpos($trim, 'INSERT') === 0) {
          // Retorna o ID do último registro inserido
          $response = $this->conn->insert_id;
        } elseif (strpos($trim, 'UPDATE') === 0) {
          $response = $this->conn->affected_rows;
        } elseif (strpos($trim, 'DELETE') === 0) {
          $response = $this->conn->affected_rows;
        } else {
          $response = true;
        }

        return $response;
      } catch (\Throwable $e) {
        // Log de erro para debug
        error_log('DB error: ' . $e->getMessage());
        if (stripos(trim($sql), 'SELECT') === 0) {
          return [];
        }
        return false;
      }
  }


}