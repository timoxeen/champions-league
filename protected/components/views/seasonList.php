<?php foreach($this->getSeasonList() as $season): ?>
	<?php echo CHtml::link(
						CHtml::encode($season->title), 
						HelpersUrl::getSeasonUrl($season->season_id), 
						array('class'=>'list-group-item active')
					); ?>
<?php endforeach; ?>