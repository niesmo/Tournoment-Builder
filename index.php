<?require_once("conf/config.php");?>
<?require_once("inc/header.php");?>
      <div class="row-fluid">
        <div class="span12">
          <div class="hero-unit">
            <h1>Tournament Builder</h1>
            <p>Tournament Builder lets you build Coowesomazing tournaments easily</p>
            <p><a href="create.php" class="btn btn-primary btn-large">Create a Tournament &raquo;</a></p>
          </div>
          <div class="row-fluid">
          
      <?php 
      $list_of_tournaments = $db->select("Tournament","*");
   
      
      for ($x=0; $x<9; $x++)
      {
        if ((($x+1)%3)==0) {
          echo "<div class='row-fluid'>";
        }
        echo "<div class='span4'>";
              echo "<h2>Tournament:" . $list_of_tournaments[$x][Name]." </h2>";
              echo "<p>Tournament Description:". $list_of_tournaments[$x][Description] ." </p>";
              echo "<p><a class='btn' href='#'>View details &raquo;</a></p>";
        echo "</div>";
        if ((($x+1)%3)==0) {
          echo "</div> <!--/row-->";
        }
      } 
      ?>
    </div>
<?require_once("inc/footer.php")?>
