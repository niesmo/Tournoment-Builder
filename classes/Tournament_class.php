<?
class Tournament{
	private $db;
	
	public function __construct( $db ){
		$this->db = $db;
	}
	
	public function newTournament($name, $type, $description, $rules, $maxPlayer){
		$now = date("Y-m-d H:i:s"); 
	        if($this->db->insert("Tournament", "Name, Type, StartDate, Status, Description, Rules, MaxPlayer",
	                "'$name', '$type', '$now', 'OPEN', '$description', '$rules' , $maxPlayer") == 1)
	        	return $this->db->lastInsertedId();
	        else
	        	return -1;
	}
	
	public function getParticipants($tournament_id){
		return $this->db->select("Entry as e, Participant as p" , "*" , "e.TournamentID = $tournament_id AND e.ParticipantID = p.ParticipantID");
	}
	
	public function getMatches($tournament_id, $field="*") {
		return $this->db->select("`Match` as m , Entry as e", $field,
		"(e.EntryID = m.EntryID1 OR (e.EntryID = m.EntryID2 OR m.EntryID2 = -1)) 
		AND e.TournamentID = '$tournament_id'", "MatchID");
	}
	
	public function closeRegistration($tournament_id){
		$this->db->update("Tournamet" , "Status = 'PROGRESS'" , "TournamentID = $tournament_id");
	}
}
?>
