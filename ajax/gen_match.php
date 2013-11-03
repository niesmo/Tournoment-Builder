<? include('../conf/config.php');
if(isset($_GET['round']) && isset($_GET['TournamentID'])) {
	$initialEntries = $db->select("Entry", "COUNT(*)", "TournamentID=$_GET[TournamentID]")[0][0];
	if($_GET['round'] == '0') { // first round: gen from Entry
		gen_matches(0, $initialEntries);
	} else {
		if($db->select("`Match` as m , Entry as e", "COUNT(*)",
		"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
		e.TournamentID = '$_GET[TournamentID]' AND m.Round = $_GET[round]-1 AND 
		m.Result != 'null'", "MatchID")[0][0] == 0) { // all results in from previous round
			if($round >= ceil(log(count($initialEntries, 2))) // final round
				db->update("Tournament", "Status='CLOSE'", "TournamentID='$_GET[TournamentID]'");
			else {
				$first = db->select("`Match` as m , Entry as e", "EntryID1",
				"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
				e.TournamentID = '$_GET[TournamentID]' AND m.Round = $_GET[round]-1 AND
				m.Result = 'FIRST'", "MatchID");
				$second = db->select("`Match` as m , Entry as e", "EntryID2",
				"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
				e.TournamentID = '$_GET[TournamentID]' AND m.Round = $_GET[round]-1 AND
				m.Result = 'SECOND'", "MatchID");
				gen_matches($_GET['round'], sort(array_merge($first, $second)));
			}
		}
	}
}

private function gen_matches($round, $entryIDs) {
	print_r($entryIDs);
?>
