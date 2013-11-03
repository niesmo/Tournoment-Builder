<?
class Participant{
        private $db;
        public function __construct( $db ){
                $this->db = $db;
                //echo "Participant object Created";
        
        }
        public function getParticipantInfo($entry_id , $fields = "*"){
                //echo "we are in the info";
                if($entry_id == -1){
                        return  array("Name" => "Bye");
                }
                //print_r($this->db->select("Entry as e, Participant as p" , "$fields" , "e.ParticipantID = p.ParticipantID AND e.EntryID = $entry_id"));
                $data = $this->db->select("Entry as e, Participant as p" , "$fields" , "e.ParticipantID = p.ParticipantID AND e.EntryID = $entry_id");
                return $data[0];
        }       
        
        public function removeParticipant($participant_id){
                //remove from the Entry table too
                $this->db->delete("Entry" , "ParticipantID = $participant_id");
                return $this->db->delete("Participant",  "ParticipantID = $participant_id");
        }
        
}
?>
