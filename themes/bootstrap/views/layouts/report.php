<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo Yii::app()->params['logo'];?>" type="image/x-icon" />
</head>

<body>

<!-- Google Analytics - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56906074-1', 'auto');
  ga('send', 'pageview');

</script>
<!--  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - -  - - - -->

<?php //$this->beginContent(); ?>
<?php echo $content; ?>
<?php //$this->endContent(); ?>

</body>
</html>