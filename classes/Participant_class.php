<?
class Participant{
        private $db;
        public function __construct( $db ){
                $this->db = $db;
        
        }
        public function getParticipantInfo($entry_id , $fields = "*"){
                if($entry_id == -1){
                        return array("Name" , "<i>Bye</i>");
                }
                return $this->db->select("Entry as e, Participant as p" , "$fields" , "e.ParticipantID = p.ParticipantID AND e.EntryID = $entry_id")[0];
        }
        
        public function removeParticipant($participant_id){
                return $this->db->delete("Participant",  "ParticipantID = $participant_id");
        }
        
}
?>
