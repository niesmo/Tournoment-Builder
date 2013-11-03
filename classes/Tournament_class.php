<?
class Tournament{
	private $db;
	
	public function __construct( $db ){
		$this->db = $db;
	}
	
	public function newTournament($name, $type, $description, $rules){
		$now = date("Y-m-d H:i:s"); 
	        return $this->db->insert("Tournament", "Name, Type, StartDate, Status, Description, Rules",
	                "'$name', '$type', '$now', 'OPEN', '$description', '$rules'");
	}
	
	
	public function getParticipants($tournament_id){
		return $this->db->select("Tournament as t, Entry as e, Participant as p" , "*" , "e.TournamentID = t.TournamentID AND e.ParticipantID = p.ParticipantID");
	}
}
?>
