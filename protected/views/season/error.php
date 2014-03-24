<?php
$this->pageTitle=Yii::app()->name . ' - Error';
?>

<h2>Hata: </h2>

<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>