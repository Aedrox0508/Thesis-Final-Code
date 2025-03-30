
<?php
    class Database{

        public $hostname = 'localhost';
        public $username = 'root';
        public $password = '';
        public $db_name = 'movewave';

        protected $connection;

        function connect(){
            try 
                {
                    $this->connection = new PDO("mysql:host=$this->hostname;dbname=$this->db_name", 
                                                $this->username, $this->password);
                } 
                catch (PDOException $e) 
                {
                    echo "Connection error " . $e->getMessage();
                }
            return $this->connection;
        }
    }
?>