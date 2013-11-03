<?
class Tournament{
	private $db;
	
	public function __construct( $db ){
		$this->db = $db;
	}
	
	public function addTournament($name, $type, $description, $rules){
		$now = date("Y-m-d H:i:s"); 
	        $db->insert("Tournament", "Name, Type, StartDate, Status, Description, Rules",
	                "'$name', '$type', '$now', 'OPEN', '$description', '$rules'");
	}
}
?>
