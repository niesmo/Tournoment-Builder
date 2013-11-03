<? include('../conf/config.php');
if(isset($_GET['MatchID']) && isset($_GET['id'])) {
	$match = $db->select("`Match`", "Round, EntryID1", "MatchID='$_GET[MatchID]'")[0];
	$round = $match['Round']+1;
	$initialEntries = $db->select("Entry", "EntryID", "TournamentID=$_GET[id]");
	$initialEntries = merge($initialEntries, []);
	if($db->select("`Match` as m , Entry as e", "COUNT(*)",
	"(e.EntryID = m.EntryID1 OR (e.EntryID = m.EntryID2 OR m.EntryID2 = -1)) 
	AND e.TournamentID = '$_GET[id]' AND m.Round = $round-1 AND 
	m.Result IS NULL")[0]['COUNT(*)'] == 0) { // all results in from previous round
		if($round >= ceil(log(count($initialEntries), 2))) {// final round
			$lastMatch = $db->select("`Match` as m , Entry as e", "EntryID1, EntryID2, Result",
				"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
				e.TournamentID = '$_GET[id]' AND m.Round = $round-1")[0];
			print_r($lastMatch);
			$winnerID = $lastMatch[$lastMatch['Result'] == 'FIRST' ? 'EntryID1' : 'EntryID2'];
			$winner = $participant->getParticipantInfo($winnerID)['Name'];
			$db->update("Tournament", "Status='CLOSE', Winner='$winner'", "TournamentID='$_GET[id]'");
		} else {
			$first = $db->select("`Match` as m , Entry as e", "EntryID1",
			"(e.EntryID = m.EntryID1 OR (e.EntryID = m.EntryID2 OR m.EntryID2 = -1)) 
			AND e.TournamentID = '$_GET[id]' AND m.Round = $round-1 AND
			m.Result = 'FIRST'", "MatchID");
			$second = $db->select("`Match` as m , Entry as e", "EntryID2",
			"(e.EntryID = m.EntryID1 OR (e.EntryID = m.EntryID2 OR m.EntryID2 = -1)) 
			AND e.TournamentID = '$_GET[id]' AND m.Round = $round-1 AND
			m.Result = 'SECOND'", "MatchID");
			gen_matches($round, merge($first, $second), $db );
		}
	}
} elseif(isset($_GET['id'])) { // first round
	$initialEntries = $db->select("Entry", "EntryID", "TournamentID=$_GET[id]");
	$initialEntries = merge($initialEntries, []);
	$byes = pow(2, ceil(log(count($initialEntries), 2)))-count($initialEntries);
	for($i=0;$i<$byes;$i++) { // award byes
		array_splice($initialEntries, $i*2+1, 0, [-1]);
	}
	gen_matches(0, $initialEntries , $db);
}
	

function merge($a, $b) {
	$out = [];
	if($a != [])
		foreach($a as $array) foreach($array as $key => $value)	$out[] = $value;
	if($b != [])
		foreach($b as $array) foreach($array as $key => $value)	$out[] = $value;
	usort($out, 'cmp');
	return $out;
}

function cmp($a, $b) {
	return MD5($a) > MD5($b) ? 1 : -1;
}

function gen_matches($round, $entryIDs, $db) {
	for($i=0;$i<count($entryIDs)/2;$i++) {
		$db->insert("`Match`", "EntryID1, EntryID2, Round, `Order`",
		$entryIDs[$i*2] . ", ".$entryIDs[$i*2+1].", $round, $i");
		$id = $db->lastInsertedId();
		if($entryIDs[$i*2+1] == -1) { // set result for bye
			$db->update("`Match`", " Result='FIRST' ", " MatchID = $id " );
		}
	}
}
?>
