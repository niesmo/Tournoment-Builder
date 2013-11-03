<?
class Participant{
        private $db;
        public function __construct( $db ){
                $this->db = $db;
                echo "Participant object Created";
        
        }
        public function getParticipantInfo($entry_id , $fields = "*"){
                echo "we are in the info";
                if($entry_id == -1){
                        return  array("Name" => "Bye");
                }
                print_r($this->db->select("Entry as e, Participant as p" , "$fields" , "e.ParticipantID = p.ParticipantID AND e.EntryID = $entry_id")[0]);
                return $this->db->select("Entry as e, Participant as p" , "$fields" , "e.ParticipantID = p.ParticipantID AND e.EntryID = $entry_id")[0];
        }
        
        public function removeParticipant($participant_id){
                return $this->db->delete("Participant",  "ParticipantID = $participant_id");
        }
        
}
?>
