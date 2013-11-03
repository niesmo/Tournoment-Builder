<?
class Participant{
        private $db;
        public function __construct( $db ){
                $this->db = $db;
                echo "Participant Created";
        }
}
?>
