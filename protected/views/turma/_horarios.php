<?php if (!isset($model->horarios) || $model->horarios[0] == '@') { ?>
<?php echo $form->labelEx($model,'horarios'); ?>

<style type="text/css">
.agenda {  }

.agenda thead { text-align: center; }

/* Dates */
.agenda .agenda-date {  }
.agenda .agenda-date .dayofmonth {
  font-size: 36px;
  line-height: 36px;
  float: left;
  text-align: right;
}
.agenda .agenda-date .Sab,
.agenda .agenda-date .Dom{
  color: darkred;
}

.agenda .agenda-date .shortdate {
  font-size: 0.75em; 
}


/* Times */
.agenda .agenda-time { width: 140px;vertical-align: middle;text-align: center; } 


/* Events */
.agenda .agenda-events { text-align: center; } 
.agenda .agenda-events .agenda-event {  } 

@media (max-width: 767px) {
    
}
</style>

<?php 
	$dias = array('Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom');
	$turnos = array('M', 'T', 'N');
?>

<div class="container">
    <div class="agenda">
        <div class="table-responsive">
            <table class="table table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Horário</th>
                        <?php foreach ($dias as $dia) { ?>
                        <td class="agenda-date" class="active" rowspan="1">
                            <div class="dayofmonth <?php echo $dia; ?>"><?php echo $dia; ?></div>
                        </td>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach ($turnos as $turno) { ?>
                	<?php for ($i=1; $i <= 5; $i++) { ?>
                    <tr>
                    	<td class="agenda-time">
                            <?php echo PTD::turno_hora(PTD::$TURNO[$dia][$turno][$i]); ?>
                        </td>
                    	<?php foreach ($dias as $dia) { ?>
						<td class="agenda-events">
							<?php echo $form->checkBox($model,'horarios',  array('value'=>PTD::$TURNO[$dia][$turno][$i])); ?>
                        </td>
						<?php } ?>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php } else { 
	echo $form->textAreaRow($model,'horarios',array('class'=>'span5','maxlength'=>100));
 } ?>