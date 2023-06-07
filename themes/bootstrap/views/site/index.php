<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;

?>
<?php //$this -> beginWidget('bootstrap.widgets.TbHeroUnit', array('heading' => CHtml::encode(Yii::app()->name), )); ?>
<?php //$this -> endWidget(); ?>

<div id="DIV_1">
	<div id="DIV_2">
		<div id="DIV_3">
			<div id="DIV_4">
				<div id="DIV_5">
					<img src ="<?php echo Yii::app() -> request -> baseUrl; ?>/images/<?php echo Yii::app()->params['logo'];?>" id="IMG_6" alt='' />
				</div>
				<div id="DIV_7">
					<h1 id="H1_8">
						<?php echo CHtml::encode(Yii::app()->name); ?>!
					</h1>
					<p id="P_9">
						Aplicativo Diário de Classe (versão Beta)...
					</p>
					<p id="P_10">
						Aluno, Veja suas Notas e Faltas <?php echo CHtml::link('aqui', array('aluno/grades'), array('id'=>'A_11')); ?>.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>