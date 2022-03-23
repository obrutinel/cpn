<?php
/**
 * ====================
 *  Classe Database
 * ====================
 */

namespace Wagaia;

class Database
{
    /*
    |--------------------------------------------------------
    | Variables de connexion
    |--------------------------------------------------------
    */
    protected $server;
    protected $user;
    protected $pass;
    protected $db;
    protected $origin = array('90.37.193.90','109.208.23.211');
    /*
    |--------------------------------------------------------
    | L'objet MYSQLI
    |--------------------------------------------------------
    */
    public $mysqli;
    private $result = false;
    public $array_key = false;
    protected $results = array();
    public $encoding;
    /*
    |--------------------------------------------------------
    | Instantiation de la classe : connexion
    |--------------------------------------------------------
    | 1 - les paramètres sont définis qqpart ou...
    | 2 - les paramètres sont passés au constructeur
    */
    function __construct($server = null, $user = null, $pass = null, $db = null)
    {
        $this->encoding = "'utf8' COLLATE 'utf8_general_ci'";
        $this->mode = 'object'; // or array


        if (defined('DB_SERVER')) {
            $this->server = DB_SERVER;
        } elseif ($server) {
            $this->server = $server;
        }
        if (defined('DB_USER')) {
            $this->user = DB_USER;
        } elseif ($user) {
            $this->user = $user;
        }
        if (defined('DB_PASS')) {
            $this->pass = DB_PASS;
        } elseif ($pass) {
            $this->pass = $pass;
        }
        if (defined('DB_NAME')) {
            $this->db = DB_NAME;
        } elseif ($db) {
            $this->db = $db;
        }
        //dump($this->server); dump($this->user); dump($this->db);
        if (!$this->server or !$this->user or !$this->db) {
            printf("Les paramètres de connexions ne sont pas renseignés :\nserveur : %s, utilisateur : %s, base de données : %s, mot de passe : %s", $this->server, $this->user, $this->db, $this->pass);
        } else {
            $this->db_connect();
        }
    }
    /*
    |--------------------------------------------------------
    | Connexion à la DB
    |--------------------------------------------------------
    */
    private function db_connect()
    {
        $this->mysqli = new \mysqli($this->server, $this->user, $this->pass, $this->db);
        if ($this->mysqli->connect_errno) {
            printf("La connexion a échouée: %s\n", mysqli_connect_error());
            exit();
        }
        $this->setEncoding();
		$this->query("SET sql_mode = '' ");
    }
    /*
    |--------------------------------------------------------
    | Set connection encoding
    |--------------------------------------------------------
    */
    public function setEncoding($encoding = null)
    {
        switch ($encoding) {
            case 'CP1251' :
            $this->encoding = "'" . $encoding . "'";
            break;
        }
        $this->query("SET NAMES " . $this->encoding);
    }
    /*
    |--------------------------------------------------------
    | Vérifier la connextion existante
    |--------------------------------------------------------
    */
    public function ping()
    {
        if ($this->mysqli->ping()) {
            return true;
        }
        return false;
    }
    /*
    |--------------------------------------------------------
    | Type de résultat retourné par une requête
    |--------------------------------------------------------
    | par défaut : object
    */
    public function fetch($mode='array')
    {
        $this->mode = $mode;
        return $this;
    }
    /*
    |--------------------------------------------------------
    | Dump pour voir la base à laquelle on est connecté
    |--------------------------------------------------------
    */
    public function db_name()
    {
        echo "Connecté à <strong>" . $this->db . "</strong><br />";
    }
    /*
    |--------------------------------------------------------
    | Récupère le dernier id généré par la requête
    |--------------------------------------------------------
    */
    function last_id()
    {
        return $this->mysqli->insert_id;
    }
    /*
    |--------------------------------------------------------
    | Nombre de lignes affectées
    |--------------------------------------------------------
    */
    function affected_rows()
    {
        return $this->mysqli->affected_rows;
    }
    /*
    |--------------------------------------------------------
    | Echapper une variable
    |--------------------------------------------------------
    */
    function escape($string)
    {
        return $this->mysqli->real_escape_string($string);
    }
    /*
    |--------------------------------------------------------
    | Changer l'encodage
    |--------------------------------------------------------
    */
    public function convert($table)
    {
        return $this->query("ALTER TABLE `" . $table . "` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;");
    }
    /*
    |--------------------------------------------------------
    | Récupérer les champs d'une table
    |--------------------------------------------------------
    */
    public function getFields($table)
    {
        $r = $this->select("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='" . $this->db . "' AND `TABLE_NAME`='" . $table . "' order by COLUMN_NAME");

        $array = array();
        if (!empty($r)) {
            foreach ($r as $k => $v) {
                $array[] = $v->COLUMN_NAME;
            }
        }
        return $array;
    }
    /*
    |--------------------------------------------------------
    | RETOURNE UN RESULTAT SELECT
    |--------------------------------------------------------
    | pour l'heure que sur les select...
    |
    */
    public function select($s, $array_key = null)
    {
        $this->statement = $s;
        $this->array_key = $array_key;

        $this->pushArray();

        $this->mode = 'object';

        return $this->result;
    }

    /*
    |--------------------------------------------------------
    | Traite le résultat d'une requête Select
    |--------------------------------------------------------
    | return array assoc
    */
    private function pushArray()
    {
        $this->results = array();
        if ($this->query($this->statement)) {
            $n = 0;
            while ($row = $this->result->fetch_assoc()) {
                $this->results[$this->array_key ? $row[$this->array_key] : $n] = $row;
                ++$n;
            }
            $this->result->close();
        }

        $this->result = $this->results;

        if ($this->mode == 'object') {
            $this->result = (array) json_decode(json_encode($this->result));
        }

        return $this;
    }

    /*
    |--------------------------------------------------------
    | Passe une chaine de requête à la BD
    |--------------------------------------------------------
    | return array stdClass
    */
    function query($s)
    {
        $this->result = $this->mysqli->query($s);
        $this->error($s, $this->result);
        return $this;
    }
    /*
    |---------------------------------------------------------
    | Retourn un ou le premier résultat
    |---------------------------------------------------------
    | return array stdClass - un niveau
    */
    public function get($s)
    {
        $this->select($s);

        if ($this->result) {
            $this->result = current($this->result);
        }
        return $this->result;
    }


    /*
    |---------------------------------------------------------
    | Insert Query
    |---------------------------------------------------------
    */

    public function insert($table=null, $array=null, $replace=false)
    {
        if (!is_array($array) or empty($table)) {
            return null;
        }

        if (!$this->is_table($table)) {
            return null;
        }

        $action = $replace ? 'replace' : 'insert';

        $keys = implode(",", array_keys($array));
        $values = array_values($array);
        $data = [];
        foreach($values as $v) {
            $data[] = $this->escape($v);
        }
        $values = "'". implode("', '", array_values($data)) ."'";
		//echo $action." into ".$table." (".$keys.") values (".$values.")";
        $this->query($action." into ".$table." (".$keys.") values (".$values.")");
	
        return $this->affected_rows();

    }

    /*
    |---------------------------------------------------------
    | Insert / Replace Query
    |---------------------------------------------------------
    */
    public function replace($table=null, $array=null)
    {
        return $this->insert($table, $array, true);
    }


    function update($table, $data, $key = null, $key2 = null, $escape = false)
    {
        // Quelles sont les colonnes dans la table
        $fields = $this->getFields($table);
        // print_r($fields); print_r($data);
        $update = array();
        if (!empty($fields)) {
            $s = "UPDATE `" . $table . "` SET ";
            // Recouper les colonnes avec les valeurs de $data
            foreach ($data as $k => $v) {
                if (in_array($k, $fields)) {
                    $update[$k] = $v;
                }
            }
        }
        if (!empty($update)) {
            // Où mettre à jour
            $key_string = (!empty($key) ? $key : 'id');
            $first_value = (!empty($key) && array_key_exists($key, $update)) ? $update[$key] : $update['id'];
            unset($update[$key_string]);
            if (!empty($key2) && array_key_exists($key2, $update)) {
                $key_string2 = $key2;
                $second_value = $update[$key2];
                unset($update[$key_string2]);
            }
            $n = 0;
            $n += 1;
            $count = count($update);

            $query = [];
            foreach($update as $k=>$v) {
                $query[] = $k . "='". $this->escape($v)."'";
            }
            $s.= implode(', ', $query);

            $s .= " WHERE `" . $key_string . "`='" . $first_value . "'"; # La partie ne s'incrémente pas dans ajax/blocs/sold.php ??!!
            if (!empty($key2)) {
                $s .= " AND `" . $key_string2 . "`='" . $second_value . "'";
            }
            //	echo $s."<br /><br />";
            $this->query($s);
        } else {
            echo "Aucune action à effectuer";
        }
    }


    /**
     * Retourne les tables d'une DB
     */

    function get_tables()
    {
        $q = $this->mysqli->query("SHOW TABLES FROM " . DB_NAME);
        while ($r = $q->fetch_row()) {
            $tables[] = $r[0];
        }
        return $tables;
    }



    function all($table, $order = null)
    {
        $s = "select * from `" . $table . "`" . ($order ? ' order by ' . $order : null);
        return $this->select($s);
    }

    function find($table, $id = null)
    {
        if (Lib::digital($id)) {
            return $this->get("select * from ".$table ." where id=".$id);
        }
        return null;
    }

    function error($s, $result)
    {
        if (!$result) {
          //  if (in_array($_SERVER['REMOTE_ADDR'], $this->origin)) {
            echo "<div style='padding:14px;background:pink;'>Erreur MySQL : " . $this->mysqli->error . '</div>';
            echo "<div style='padding:14px;background:powderblue;'>Requ&ecirc;te originale : " . $s . '</div>';
            echo "<div style='padding:14px;width:800px;'><pre>";
            debug_print_backtrace();
            echo "</pre></div>";
            exit;
         //  } else {
            echo "Възникна грешка !";
        }
    }

    public function transaction()
    {
        $this->mysqli->autocommit(FALSE);
        return $this->query('start transaction');
    }

    public function commit()
    {
        $this->mysqli->commit();
        $this->mysqli->autocommit(TRUE);
    }

    function num_rows() {

        return $this->mysqli->num_rows;
    }

    /*
    |--------------------------------------------------------
    | Vérifie si un champ existe
    |--------------------------------------------------------
    | return bool
    */
    function column($table,$column) {

        return (bool) $this->get("SELECT count(*) as count
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = '".DB_NAME."'
            AND TABLE_NAME = '".$table."'
            AND COLUMN_NAME = '".$column."'")->count;
    }

    /*
    |--------------------------------------------------------
    | Vérifie si une table existe
    |--------------------------------------------------------
    | return bool
    */
    function is_table($table) {

        return (bool) $this->query("SHOW TABLES LIKE '".$table."'")->result->num_rows;
    }

    /*
    |--------------------------------------------------------
    | Compter qqchose
    |--------------------------------------------------------
    | return (int)
    */
    function count($table,$col=null,$value=null) {

        $q = "select count(*) as total from ".$table;
        if ($col) {
            $q.= " where ".$col."='".$value."'";
        }
        return $this->get($q)->total;
    }


    # end of class Database
}
?>