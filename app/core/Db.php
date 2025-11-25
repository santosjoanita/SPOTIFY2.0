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
  * @param  MySQLiStatement   $stmt         query "preparada".
  * @param  array             $parameters   array com tipos e respetivos valores (caso existam)
  */
  private function setParameters($stmt, array $parameters) {
    if (count($parameters)) {
      $types = $parameters[0];
      $values = $parameters[1];
      $stmt->bind_param($types, ...$values); // *1
    }
  }

  /**
  * Método para a execução do SQL
  * @param  string   $sql         instrução SQL
  * @param  array    $parameters  array de parâmetros
  *
  * @return array    $response    dataset
  */
  
  // precisa de ser mais genérica porque, nesta versão, apenas responde corretamente para operações sobre a tabela "movies"
  public function execQuery(string $sql, array $parameters = []) {
      try {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
          // prepare failed — log and return false
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
          // return last insert id
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
        // Log error and return false/empty result to prevent fatal exceptions bubbling up
        error_log('DB error: ' . $e->getMessage());
        if (stripos(trim($sql), 'SELECT') === 0) {
          return [];
        }
        return false;
      }
  }

  // *1
  // ... Operador splat
  // Uma das funções deste operador é transformar um array em parâmetros separados a passar para
  // determinado método/função (Argument Unpacking)

}