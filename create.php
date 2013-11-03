<?
require_once("conf/config.php");
include("inc/header.php");
if($_POST['submit']){
	$tournament->newTournament($_POST[name], $_POST[type], $_POST[description], $_POST[rules]);
}
?>
<div class="container">
	<div class="row-fluid">
	        <div class="span6">
			<form action="#" method="POST" class="form-signin">
			  <fieldset>
			    <h2 class="form-signin-heading">Create a tournament</h2>
				<input class="input-block-level" name="name" type="text" placeholder="Tournament Name"><br>
				<select name="type">
				  <option value="SINGLE">Single Elimination</option>
				  <option value="DOUBLE">Double Elimination</option>
				  <option value="ELO">Elo Ranking System</option>
				  <option value="MTG">Tournament Inspired by MtG</option>
				</select><br>
				<textarea class="input-block-level" name="description" rows="3" placeholder="Description"></textarea><br>
				<textarea class="input-block-level" name="rules" rows="3" placeholder="Rules"></textarea><br>
				<input class="btn btn-primary btn-large" type="submit" name="submit" value="Create Tournament" />
			  </fieldset>
			</form>
		</div>
      	</div>
</div>
<?include("inc/footer.php");?>
