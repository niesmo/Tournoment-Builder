<?require_once("conf/config.php");?>
<?require_once("inc/header.php");?>
    <div class="container">
      <div class="row-fluid">
        <div class="span12">
          <div class="hero-unit">
            <h1>Tournament Builder</h1>
            <p>Tournament Builder lets you build Coowesomazing tournaments easily</p>
            <p><a href="create.php" class="btn btn-primary btn-large">Create a Tournament &raquo;</a></p>
          </div>
          <div class="row-fluid">
          
      <?php 
      $list_of_tournaments = $db->select("Tournament","*" , "Status ='OPEN'");
   
      
      for ($x=0; $x<9; $x++)
      {

        echo "<div class='span4'>\n";
        echo "<h4><a href=\"view_tournament.php?id=". $list_of_tournaments[$x]['TournamentID']. "\">". $list_of_tournaments[$x]['Name']." </a></h4>\n";
        echo "<p>Tournament Description:". $list_of_tournaments[$x]['Description'] ." </p>\n";
        echo "<p><a class='btn' href='register.php?id=". $list_of_tournaments[$x]['TournamentID']."'>Register &raquo;</a></p>\n";
        echo "</div>\n";
        if ((($x+1)%3)==0) {
          echo "</div> <!--/row-->";
          echo "<div class='row-fluid'>\n";
        }
      } 
      ?>
    </div>
   </div>
<?require_once("inc/footer.php")?>
