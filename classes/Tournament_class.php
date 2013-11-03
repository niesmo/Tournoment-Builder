<?
class Tournament{
	private $db;
	
	public function __construct( $db ){
		$this->db = $db;
	}
	
	public function newTournament($name, $type, $description, $rules){
		$now = date("Y-m-d H:i:s"); 
	        $this->db->insert("Tournament", "Name, Type, StartDate, Status, Description, Rules",
	                "'$name', '$type', '$now', 'OPEN', '$description', '$rules'");
	        return $this->db->lastInsertedID;
	}
	
	
	public function getParticipants($tournament_id){
		return $this->db->select("Entry as e, Participant as p" , "*" , "e.TournamentID = $tournament_id AND e.ParticipantID = p.ParticipantID");
	}
}
?>
