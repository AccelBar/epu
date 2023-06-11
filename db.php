<?php
class Db
{
  /**
   * Proměnná se spojením
   * @access private
   */
  private $connection;

  /**
   * Nastavení PDO
   * @access private
   */
  private $settings = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
  );

  /**
   * Připojí k databázi
   * @param String Hostitel
   * @param String Uživatel
   * @param String Heslo
   * @param String Databáze
   * @return void
   */
  public function connect ($host, $db, $user, $pass) {
      if (!isset(self::$connection)) {
        $this->connection = new PDO(
          "mysql:host=$host;dbname=$db",
          $user,
          $pass,
          $this->settings
        );
      }
  }

  /**
   * Vrátí jeden řádek z dotazu
   * @param String Dotaz
   * @param Array Parametry
   * @return Array Výsledek dotazu
   */
  public function oneResult($query, $parameters = array()) {
      $result = $this->connection->prepare($query);
      $result->execute($parameters);
      return $result->fetch();
  }

  /**
   * Vrátí všechny řádky z dotazu
   * @param String Dotaz
   * @param Array Parametry
   * @return Array Výsledek dotazu
   */
  public function allResults($query, $parameters = array()) {
      $result = $this->connection->prepare($query);
      $result->execute($parameters);
      return $result->fetchAll();
  }

  /**
   * Vrátí první buňku z dotazu
   * @param String Dotaz
   * @param Array Parametry
   * @return Array Výsledek dotazu
   */
  public function firstCell($query, $parameters = array()) {
           $result = $this->oneResult($query, $parameters);
     return $result[0];
  }

  /**
   * Vrátí jeden řádek z výsledku
   * @param String Dotaz
   * @param Array Parametry
   * @return Array Výsledek dotazu
   */
  public function tt() {
     
     return "ok";
  }
  public function query($query, $parameters = array()) {
     $result = $this->connection->prepare($query);
     $result->execute($parameters);
     return $result->rowCount();
  }

  /**
   * Vložení záznamů do databáze
   * @param String Tabulka
   * @param Array Parametry
   * @return Array Výsledek dotazu
   */
  public function addRow($table, $parameters = Array()) {
     return $this->query("INSERT INTO `$table` (`".
     implode('`, `', array_keys($parameters)).
     "`) VALUES (".str_repeat('?,', sizeOf($parameters)-1)."?)",
     array_values($parameters));
  }

  /**
   * Změnění záznamů v databázi
   * @param String Tabulka
   * @param String Hodnoty
   * @param String Podmínka
   * @param Array Parametry
   * @return Array Výsledek dotazu
   */
    public function changeRow($table, $values = Array(), $parameters = Array()) {
    	return $this->query("UPDATE `$table` SET `".
    			implode('` = ?, `', array_keys($parameters)).
    			'` = ? ' .'WHERE `'.implode('` = ?, `', array_keys($values)).'` = ? ;',
    			array_values(array_merge($parameters,$values)));
    }
    public function changeallRow($table, $id,$parameters = Array()) {
    	$par_set="";
	    foreach ($parameters as $key => $value) {
	  		$par_set=$par_set.'`'.$key .'` = "'. $value.'",';
	  		
		}
		$par_set=substr($par_set, 0,strlen($par_set)-1);
    	return $this->query("UPDATE `".$table."` SET ".$par_set."WHERE"."`id`=".$id.";");
    }
    
}
$servername = "localhost";
$username = "school";
$password = "Aa123456Bb654321";
$dbname = "school";