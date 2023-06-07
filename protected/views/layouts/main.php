<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
		    'type'=>'inverse', // null or 'inverse'
		    'brand'=>CHtml::encode(Yii::app()->name),
		    'brandUrl'=>'#',
		    'collapse'=>true, // requires bootstrap-responsive.css
		    'items'=>array(
		        array(
		            'class'=>'bootstrap.widgets.TbMenu',
		            'items'=>array(
		                array('label'=>'Arquivo', 'url'=>'#', 'items'=>array(
		                    array('label'=>'Alunos', 'url'=>'#'),
		                    array('label'=>'Professores', 'url'=>'#'),
		                    '---',
		                    array('label'=>'Instituições', 'url'=>'#'),
		                    array('label'=>'Cursos', 'url'=>'#'),
		                    array('label'=>'Disciplinas', 'url'=>'#'),
		                    array('label'=>'Turmas', 'url'=>'#'),
		                )),
		                array('label'=>'Diário de Classe', 'url'=>'#', 'items'=>array(
		                    array('label'=>'Diarios', 'url'=>'#'),
		                    '---',
		                    array('label'=>'Avaliações', 'url'=>'#'),
		                    array('label'=>'Notas', 'url'=>'#'),
		                )),
		                array('label'=>'Relatórios', 'url'=>'#', 'items'=>array(
		                    array('label'=>'OFICIAL'),
		                    array('label'=>'Capa', 'url'=>'#'),
		                    array('label'=>'Frequência', 'url'=>'#'),
		                    array('label'=>'Conteúdo', 'url'=>'#'),
		                    array('label'=>'Avaliações', 'url'=>'#'),
		                    array('label'=>'Todos', 'url'=>'#'),
		                    '---',
		                    array('label'=>'ACOMPANHAMENTO'),
		                    array('label'=>'Boletim', 'url'=>'#'),
		                    array('label'=>'Boletim Parcial', 'url'=>'#'),
		                    array('label'=>'Boletim Individual', 'url'=>'#'),
		                    array('label'=>'Notas', 'url'=>'#'),
		                    array('label'=>'Notas Individuais', 'url'=>'#'),
		                )),
		                array('label'=>'Ferramentas', 'url'=>'#', 'items'=>array(
		                    array('label'=>'Configurações', 'url'=>'#'),
		                    '---',
		                    array('label'=>'Enviar E-mails', 'url'=>'#'),
		                    array('label'=>'E-mails da Turma', 'url'=>'#'),
		                )),
		            ),
		        ),
		        array(
		            'class'=>'bootstrap.widgets.TbMenu',
		            'htmlOptions'=>array('class'=>'pull-right'),
		            'items'=>array(
		                array('label'=>'Início', 'url'=>array('/site/index')),
						array('label'=>'Sobre', 'url'=>array('/site/page', 'view'=>'about')),
						array('label'=>'Contato', 'url'=>array('/site/contact')),
						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
		            ),
		        ),
		    ),
		)); ?>
			</div><!-- mainmenu -->
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				)); ?><!-- breadcrumbs -->
			<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<!--div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
