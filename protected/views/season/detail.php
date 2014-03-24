<div class="col-xs-12 col-sm-9">
  <p class="pull-right visible-xs">
    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
  </p>
  <div>
    <h2><?php echo $data->title; ?></h2>
  </div>
 
    
  <?php foreach($data->weeks as $week) { ?>
  <div class="row">
    <h4><?php echo $week->title; ?></h4>
      <div class="col-md-4">        
        <table class="table table-striped">
          <thead>
            <tr>
              <th colspan="5">Maç sonuçları</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($week->fixtures as $weekFixture) { ?>
              <tr>
               <td><?php echo $weekFixture->homeTeam->title; ?></td>
               <td><?php echo $weekFixture->home_team_goal; ?></td>
               <td>-</td>
               <td><?php echo $weekFixture->away_team_goal; ?></td>
               <td><?php echo $weekFixture->awayTeam->title; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        </div>

        <div class="col-md-4">
        <table class="table table-striped">
          <thead>
            <tr>
              <th colspan="7">Puan Durumu</th>
            </tr>
            <tr>
               <th>Takım</th>
               <th>P</th>
               <th>O</th>
               <th>G</th>
               <th>B</th>
               <th>M</th>
               <th>A</th>
            </tr>
            <?php foreach($week->leagueTablesOrdered as $weekLeagueTable) { ?>
              <tr>
               <td><?php echo $weekLeagueTable->team->title; ?></td>
               <td><?php echo $weekLeagueTable->points; ?></td>
               <td></td>
               <td><?php echo $weekLeagueTable->total_win; ?></td>
               <td><?php echo $weekLeagueTable->total_deuce; ?></td>
               <td><?php echo $weekLeagueTable->total_lost; ?></td>
               <td><?php echo $weekLeagueTable->goal_difference; ?></td>
              </tr>
            <?php } ?>  

          </thead>
        </table>  

        <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
      </div><!--/span-->

      <div class="col-md-4">
        <h4>Şampiyonluk tahmini</h4>
      </div><!--/span-->

  </div><!--/row-->
  <?php } ?>
   
 
</div><!--/span-->