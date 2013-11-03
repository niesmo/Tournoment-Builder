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
			//echo " COUNT " . $count . "\n" ;
			//echo " I " . $i . "\n" ;
			
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
        	$this->db->update("`Match`", "Result = '$result'", " MatchID = $matchID");
        	$matchLeft = $this->matchesLeft($t_id);
        	//echo "LEFT : " . count($matchLeft) . "\n";
        	if(count($matchLeft) == 0){
        		$round = $this->getRound($t_id);
        		echo "ROUND  :  " . $round . "\n";
        		$n = $this->getNumberOfMatchesInRound($t_id , $round);
        		//$n = $n /2;
        		echo  "N : " . $n . "\n";
          		$winner = $this->getWinners($t_id, $round);
          		print_r($winner);
          		for($i = 0;$i<$n;$i++){
         			$this->db->insert("`Match`" , "EntryID1, EntryID2, Result , Round , Bye" , $winner[$i++]['EntryID'] . " , ". $winner[$i]['EntryID'] . " , NULL, $round+1 , -1");
        		}
        	}
        	
        }
        
        public function getTournamentID($matchID){
        	$entry  = $this->db->select("`Match` as m, Entry as e" , "e.EntryID" , "e.EntryID = m.EntryID1 AND m.MatchID = $matchID");
        	$entry = $entry[0]['EntryID'];
        	
        	$t_id = $this->db->select("Tournament as t, Entry as e", "e.TournamentID" , "t.TournamentID = e.TournamentID AND e.EntryID = $entry");
        	return $t_id[0]['TournamentID'];
        }
        
        public function matchesLeft($tournamentID , $fields = "*"){
        	return $this->db->select("Entry as e, `Match` as m" , $fields , "(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND e.TournamentID = $tournamentID AND Result IS NULL" , "MatchID");
        	// SELECT * FROM Entry as e, `Match` as m WHERE e.EntryID = m.EntryID1 AND e.TournamentID = 17 AND Result IS NULL;

        }
        
        public function getRound($tournamentID){
        	$data = $this->db->select("Entry as e, `Match` as m" , "MAX(Round) as r" , "e.EntryID = m.EntryID1 AND e.TournamentID = $tournamentID AND Result IS NOT NULL");
        	return $data[0]['r'];
        	//SELECT Round FROM Entry as e, `Match` as m WHERE e.EntryID = m.EntryID1 AND e.TournamentID = 17 AND Result IS NOT NULL LIMIT 1;

        }
        public function getNumberOfMatchesInRound($tournamentID , $round ){
        	$data = $this->db->select("Entry as e, `Match` as m" , "COUNT(*) as c" ,  "e.EntryID = m.EntryID1 AND e.TournamentID = $tournamentID AND Round = $round");
        	return $data[0]['c'];
        	//SELECT COUNT(*) as c FROM Entry as e, `Match` as m WHERE e.EntryID = m.EntryID1 AND e.TournamentID = 17 AND Round = 0;
        }
        public function getWinners($t_id , $round ){
        	//merge the first winners and second winners
        	// SELECT * FROM Entry as e, `Match` as m WHERE (e.EntryID = m.EntryID2)   AND e.TournamentID = 17 AND Result = "SECOND" GROUP BY MatchID;
        	$first = $this->db->select("Entry as e, `Match` as m" , "*" , "e.EntryID = m.EntryID1  AND e.TournamentID = $t_id AND Result = 'FIRST' AND Round = $round GROUP BY MatchID ") ;
        	$second = $this->db->select("Entry as e, `Match` as m" , "*" , "e.EntryID = m.EntryID2  AND e.TournamentID = $t_id AND Result = 'SECOND' AND Round = $round GROUP BY MatchID ") ;
        	$total = array_merge($first, $second);
        	//print_r($total);
        	sort($total);
        	return $total;
        }
        
}
//SELECT e.EntryID FROM `Match` as m, Entry as e WHERE e.EntryID = m.EntryID1 AND m.MatchID = 171;
//SELECT e.TournamentID FROM Tournament as t, Entry as e WHERE t.TournamentID = e.TournamentID AND e.EntryID = 67;

?>
