<div class="col-xs-12 col-sm-9">
  <p class="pull-right visible-xs">
    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
  </p>

  <?php if(FALSE === $data['is_season_exists']) { ?>
  <div class="jumbotron">
    <h1>Hello, welcome to Champions League!</h1>
    <p>Do you want to show league 
    <a href="<?php echo $this->createUrl('/league/next-week'); ?>">one by one</a> 
    or 
    <a href="<?php echo $this->createUrl('/league/end-season'); ?>">at once</a>?</p>
  </div>
  <?php } ?>
</div><!--/span-->