<?
class Participant{
        private $db;
        public function __construct( $db ){
                $this->db = $db;
        
        }
        public function getParticipantInfo($entry_id , $fields = "*"){
                return $this->db->select("Entry as e, Participant as p" , "$fields" , "e.ParticipantID = p.ParticipantID AND e.EntryID = $entry_id");
        }
        
}
?>
