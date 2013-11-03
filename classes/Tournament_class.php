<?
class Tournament{
	private $db;
	
	public function __construct( $db ){
		$this->db = $db;
	}
	
	public function newTournament($name, $type, $description, $rules){
		$now = date("Y-m-d H:i:s"); 
	        if($this->db->insert("Tournament", "Name, Type, StartDate, Status, Description, Rules",
	                "'$name', '$type', '$now', 'OPEN', '$description', '$rules'") == 1)
	        	return $this->db->lastInsertedId();
	        else
	        	return -1;
	}
	
	
	public function getParticipants($tournament_id){
		return $this->db->select("Entry as e, Participant as p" , "*" , "e.TournamentID = $tournament_id AND e.ParticipantID = p.ParticipantID");
	}
	
	public function getMatches($tournament_id, $field="*") {
		return $this->db->select("`Match` as m , Entry as e", $field,
		"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
		e.TournamentID = 'tournament_id'", "MatchID");}
}
?>
