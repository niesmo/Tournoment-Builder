<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET['id']) && !isset($_POST['id'])) {
        echo "Error: No tournament ID supplied";
} 
else 
{

	$t_id = (isset($_GET['id']))?$_GET['id']:$_POST['id'];
	if(isset($_POST['submit'])){
			$db->update("Tournament", "Name='$_POST[tournament_name]', Description='$_POST[description]'","TournamentID=$t_id");
			
	}?>
	<div class="row-fluid">
		<div class="span6">
		<?
		$result = $db->select("Tournament", "Name, Description, Rules",
				"TournamentID = $t_id")[0]; // get name, description, and rules
		echo "<h1>" . $result['Name'] . "</h1>"; // name
		echo "<p>" . $result['Description'] . "</p>"; // description
		echo "<h3>Rules:</h3><p>" . $result['Rules'] . "</p>";

		$participants =$tournament->getParticipants($t_id);
		// print_r($participants);
		if(count($participants)>0){
				echo "<h3>Current Participants:</h3><ol>";
				foreach($participants as $val){
						echo "<li>";
						echo "<i class='icon-remove'></i>" . $val['Name'];
						echo "</li>\n";
				}        
		}
		else{
				echo "<h3>No Participants</h3>";
		}

		echo "</ol>
	</div><div class='span6'>";
}
?>


<form action="register.php" method="POST">
  <fieldset>
    <h2 class="form-signin-heading">Add Player</h2>
        <input type="hidden" name="id" value="<? echo $t_id; ?>"/>
        <input name="name" type="text" placeholder="Participant Name"/><br>
        <input class="btn btn-primary btn-large" type="submit" name="submit" value="Add Player" />
  </fieldset>
</form>
</div>
<div class='span6'>
<form action="edit_tournament.php" method="POST">
  <fieldset>
    <h2 class="form-signin-heading"><? echo $result['Name']; ?></h2>
           <input type="hidden" name="id" value="<? echo $t_id; ?>"/>
        <input name="tournament_name" type="text" placeholder="<? echo $result['Name']; ?>"/>
        <select name="type">
          <option value="SINGLE">Single Elimination</option>
          <option value="DOUBLE">Double Elimination</option>
          <option value="ELO">Elo Ranking System</option>
          <option value="MTG">Tournament Inspired by MtG</option>
        </select><br>
        <textarea class="input-block-level" name="description" rows="3" placeholder="<? echo $result['Description'] ?>"></textarea><br>
                                <textarea class="input-block-level" name="rules" rows="3" placeholder="<? echo $result['Rules'] ?>"></textarea><br>
        <input class="btn btn-primary btn-large" type="submit" name="submit" value="Edit Tournament Details" />
  </fieldset>
</form>




</div>
</div>
<?require_once("inc/footer.php")?>
