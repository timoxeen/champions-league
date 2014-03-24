<?php $this->beginContent('/layouts/main-layout'); ?>
  <?php echo $content; ?>
  <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="list-group">
      <?php $this->widget('SeasonList'); ?>      
    </div>
  </div><!--/span-->

<?php $this->endContent(); ?>