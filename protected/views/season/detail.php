<div class="col-xs-12 col-sm-9">
  <p class="pull-right visible-xs">
    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
  </p>
  <div>
    <h2>
      <?php echo $data->seasonTitle; ?>
      <?php if(NULL !== $data->championTeam) { ?>
          The champion is <?php echo $data->championTeam; ?>
      <?php } ?>
    </h2>
  </div>
 
    
  <?php $weekIndex = 1; foreach($data->weeks as $week) { ?>
  <div class="row" id="week-<?php echo $week->week_id; ?>">
    <h4><?php echo $week->title; ?></h4>

      <div class="col-md-4">        
        <table class="table table-striped">
          <thead>
            <tr>
              <th colspan="5">
                <?php if(Week::STATUS_NOT_COMPLETED === $week->status) { ?>
                Fixtures
                <?php } else { ?>
                Results
                <?php } ?>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($week->fixtures as $weekFixture) { ?>
              <tr>
               <td><?php echo $weekFixture->homeTeam->title; ?></td>
               <td>
                 <?php if(Week::STATUS_COMPLETED === $week->status) { ?> 
                  <?php echo $weekFixture->home_team_goal; ?>
                 <?php } ?>
               </td>
               <td>-</td>
               <td>
                 <?php if(Week::STATUS_COMPLETED === $week->status) { ?> 
                  <?php echo $weekFixture->away_team_goal; ?>
                 <?php } ?>
               </td>
               <td><?php echo $weekFixture->awayTeam->title; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

         <?php 
              if(TRUE === $data->isNextWeekButton 
                && $data->seasonLastCompletedWeekId === $week->week_id) { 
         ?>
         <p><a class="btn btn-default" href="<?php echo HelpersUrl::getSeasonNextWeekUrl($data->seasonId); ?>" role="button">Next week &raquo;</a></p>
         <?php } ?>

        </div>

      <?php if(Week::STATUS_COMPLETED === $week->status) { ?> 
      <div class="col-md-4">
        <table class="table table-striped">
          <thead>
            <tr>
              <th colspan="7">League Table</th>
            </tr>
            <tr>
               <th>Team</th>
               <th>Pts</th>
               <th>P</th>
               <th>W</th>
               <th>D</th>
               <th>L</th>
               <th>GD</th>
            </tr>
          </thead>
          <tbody>  
            <?php foreach($week->leagueTablesOrdered as $weekLeagueTable) { ?>
              <tr>
               <td><?php echo $weekLeagueTable->team->title; ?></td>
               <td><?php echo $weekLeagueTable->points; ?></td>
               <td><?php echo $weekIndex; ?></td>
               <td><?php echo $weekLeagueTable->total_win; ?></td>
               <td><?php echo $weekLeagueTable->total_deuce; ?></td>
               <td><?php echo $weekLeagueTable->total_lost; ?></td>
               <td><?php echo $weekLeagueTable->goal_difference; ?></td>
              </tr>
            <?php } ?>  

          </tbody>
        </table>  
      </div><!--/span-->
      <?php } ?>

      <?php 
            if(NULL !== $data->seasonLastCompletedWeekId 
              && $data->seasonLastCompletedWeekId === $week->week_id) { 
      ?>
      <div class="col-md-4">
        <table class="table table-striped">
          <thead>
            <tr>
              <th colspan="5">
               Championship Prediction
              </th>
            </tr>
          </thead>
          <tbody>
           
        </table>
      </div><!--/span-->
      <?php } ?>

  </div><!--/row-->
  <?php $weekIndex++; } ?>
   
 
</div><!--/span-->