<? include('../conf/config.php');
global $db;
if(isset($_GET['round']) && isset($_GET['id'])) {
	$initialEntries = $db->select("Entry", "EntryID", "TournamentID=$_GET[id]");
	$initialEntries = merge($initialEntries, []);
	if($_GET['round'] == '0') { // first round: gen from Entry
		gen_matches(0, $initialEntries , $db);
	} else {
		if($db->select("`Match` as m , Entry as e", "COUNT(*)",
		"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
		e.TournamentID = '$_GET[id]' AND m.Round = $_GET[round]-1 AND 
		m.Result != 'null'", "MatchID")[0][0] == 0) { // all results in from previous round
			if($_GET['round'] >= ceil(log(count($initialEntries), 2))) // final round
				$db->update("Tournament", "Status='CLOSE'", "TournamentID='$_GET[id]'");
			else {
				$first = $db->select("`Match` as m , Entry as e", "EntryID1",
				"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
				e.TournamentID = '$_GET[id]' AND m.Round = $_GET[round]-1 AND
				m.Result = 'FIRST'", "MatchID");
				$second = $db->select("`Match` as m , Entry as e", "EntryID2",
				"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
				e.TournamentID = '$_GET[id]' AND m.Round = $_GET[round]-1 AND
				m.Result = 'SECOND'", "MatchID");
				gen_matches($_GET['round'], merge($first, $second), $db );
			}
		}
	}
} else echo "round and/or id not found in request!";

function merge($a, $b) {
	$out = [];
	foreach($a as $array) foreach($array as $key => $value)	$out[] = $value;
	foreach($b as $array) foreach($array as $key => $value)	$out[] = $value;
	sort($out);
	return $out;
}

function gen_matches($round, $entryIDs , $db) {
	
	print_r($entryIDs);
	for($i=0;$i<count($entryIDs)/2;$i++) {
		$db->insert("`Match`", "EntryID1, EntryID2, Round, Order",
		"'".$entryIDs[$i*2]."', '".$entryIDs[$i*2+1]."', '$round', '$i'");
	}
}
?>
