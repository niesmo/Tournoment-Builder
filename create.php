<?
require_once("conf/config.php");
include("inc/header.php");
if($_POST[submit]){
	$now = date("Y-m-d H:i:s"); 
	$db->insert("Tournament", "Name, Type, StartDate, Status, Description, Rules",
		"'$_POST[name]', '$_POST[type]', '$now', 'OPEN', '$_POST[description]', '$_POST[rules]'");
}
?>
<div class="container">
<form action="#" method="POST" class="form-signin">
  <fieldset>
    <h2 class="form-signin-heading">Create Tournament</h2>
	<input class="input-block-level" name="name" type="text" placeholder="Tournament Name"><br>
	<select name="type">
	  <option value="SINGLE">Single Elimination</option>
	  <option value="DOUBLE">Double Elimination</option>
	  <option value="ELO">Elo Ranking System</option>
	  <option value="MTG">Tournament Inspired by MtG</option>
	</select><br>
	<textarea class="input-block-level" name="description" rows="3" placeholder="Description"></textarea><br>
	<textarea class="input-block-level" name="rules" rows="3" placeholder="Rules"></textarea><br>
	<input type="submit" name="submit" value="Create Tournament" />
  </fieldset>
</form>
</div>
<?include("inc/footer.php");?>
