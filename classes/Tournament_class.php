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
        
        public function closeRegistration($tournament_id , $fields = "*"){
                $this->db->update("Tournament" , "Status = 'PROGRESS'" , "TournamentID = $tournament_id");
		$participants = $this->db->select("Tournament as t, Entry as e, Participant as p" , "$fields" , "e.ParticipantID = p.ParticipantID AND e.TournamentID = t.TournamentID AND e.TournamentID = $tournament_id");
		$numberOfPartsNeeded = pow(2,ceil(log(count($participants) , 2)));
		$count = count($participants) -1;
		for($i=($numberOfPartsNeeded-1);$i>=0;$i--){
			if($count < 0)
				break;
			echo " COUNT " . $count . "\n" ;
			echo " I " . $i . "\n" ;
			
			if($i > count($participants)-1){
				$this->db->insert("`Match`" , "EntryID1, EntryID2, Bye, Result, Round" , $participants[$count--]['EntryID'] . " , -1 , 1 , 'FIRST' , 0");
			}
			else{
				$this->db->insert("`Match`" , "EntryID1, EntryID2, Bye, Result, Round" , $participants[$count--]['EntryID'] . " , " .$participants[$count--]['EntryID'] . " , -1 , NULL , 0");
				$i--;
			}
		}
        }
        public function submitMatch($matchID, $result){
        	$t_id = $this->getTournamentID($matchID);
        	//Adding the result
        	$db->update("`Match`", "Result = '$result'", " MatchID = $matchID");
        	//check and see if there is any match left
        	
        	
        }
        
        public function getTournamentID($matchID){
        	$entry  = $this->db->select("`Match` as m, Entry as e" , "e.EntryID" , "e.EntryID = m.EntryID1 AND m.MatchID = $matchID" , "" , "", 1);
        	print_r($entry);
        	$entry = $entry['EntryID'];
        	echo "ENTRY : " . $entry . "\n";
        	
        	$t_id = $this->db->select("Tournament as t, Entry as e", "e.TournamentID" , "t.TournamentID = e.TournamentID AND e.EntryID = $entry" , "" , "" , 1);
        	return $t_id['TournamentID'];
        }
        
        public function matchesLeft($tournamentID , $fields = "*"){
        	return $this->db->select("Entry as e, `Match` as m" , $fields , "(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND e.TournamentID = $tournamentID AND Result IS NULL" , "MatchID");
        	// SELECT * FROM Entry as e, `Match` as m WHERE e.EntryID = m.EntryID1 AND e.TournamentID = 17 AND Result IS NULL;

        }
        
}
//SELECT e.EntryID FROM `Match` as m, Entry as e WHERE e.EntryID = m.EntryID1 AND m.MatchID = 171;
//SELECT e.TournamentID FROM Tournament as t, Entry as e WHERE t.TournamentID = e.TournamentID AND e.EntryID = 67;

?>
