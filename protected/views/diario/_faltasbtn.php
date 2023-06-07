<div id='container-faltas-<?php echo $i; ?>'>
<?php echo CHtml::beginForm('','post',array('id'=>'form-faltas-'.$i)); 

if(isset($freq->id)) 
	echo CHtml::activeHiddenField($freq,'['.$i.']id');

echo CHtml::activeHiddenField($freq,'['.$i.']aluno_id', array('value' =>$freq->aluno->id)); 

echo CHtml::activeHiddenField($freq,'['.$i.']diario_id', array('value' =>$freq->diario->id)); 

echo CHtml::button($freq->faltas, array('value' =>$freq->faltas, 
'class'=>'btn btn-sm' . (($freq->faltas == 0)? ' btn-success' : ' btn-warning'), 
'style'=>'line-height:10px','onclick'=>'send_'.$i.'();',
'id'=>'btn-faltas-'.$i));

echo CHtml::activeHiddenField($freq,'['.$i.']faltas');

echo CHtml::endForm();

?>

<script type="text/javascript">
	function send_<?php echo $i; ?>()
	{
		toogleFaltas('<?php echo $i; ?>', '<?php echo $freq->diario->aulas; ?>');
		var data=$('#form-faltas-<?php echo $i; ?>').serialize();

	  	$.ajax({
	   		type: 'POST',
	    	url: '<?php echo CController::createUrl('AjaxUpdate') . '&index='.$i; ?>',
	   		data: data,
			success: function (data) {
                $('#container-faltas-<?php echo $i; ?>').html(data);
          	},
	   		error: function(data) { // if error occured
	        	alert("Aconteceu algum erro, tente novamente mais tarde.");
	        	alert(data);
	    	},
	 		dataType:'html'
	  	});
	}
</script>

</div>