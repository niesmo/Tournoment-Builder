<?
class Tournament{
	private $db;
	
	public function __construct( $db ){
		$this->db = $db;
		echo "Tournament Class Created";
	}
	
	public function newTournament($name, $type, $description, $rules){
		$now = date("Y-m-d H:i:s"); 
		echo "test";
	        return $this->db->insert("Tournament", "Name, Type, StartDate, Status, Description, Rules",
	                "'$name', '$type', '$now', 'OPEN', '$description', '$rules'");
	}
}
?>
