<?php
function isweekend($date){
    return (date('N', strtotime($date)) >= 6);
}

function turno($t){
    switch ($t) {
        case 'M': return 'Manhã';
		case 'T': return 'Tarde';
        default:
		case 'N': return 'Noite';
    }
}

// $this->layout='//layouts/column1';
// $mon = date ("Y-m-d", strtotime('monday this week'));

$dias = array('Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom');
$turnos = array('M', 'T', 'N');

// $sem = date("W", strtotime($mon));	

// $this->pageTitle = 'Planner ' . $sem . '-' . ($sem+$NUM_SEM);
$NUM_SEM = 1;

if (Yii::app()->helper->set($_GET['n']) && $_GET['n'] > 1)
	$NUM_SEM = $_GET['n'];

for ($i=1; $i <= $NUM_SEM; $i++) { 

	$sem = date("W", strtotime($mon));

	if (Yii::app()->helper->set($_GET['v']) && $_GET['v'] == '1') {
		echo $this->renderPartial('_planner_v1', array('mon' => $mon, 'dias' => $dias, 
			'turnos' => $turnos, 'sem' => $sem));
	} else if (Yii::app()->helper->set($_GET['v']) && $_GET['v'] == '3') {
		echo $this->renderPartial('_planner_v3', array('mon' => $mon, 'dias' => $dias, 
			'turnos' => $turnos, 'sem' => $sem));
	} else {
		echo $this->renderPartial('_planner_v2', array('mon' => $mon, 'dias' => $dias, 
			'turnos' => $turnos, 'sem' => $sem));
	}
	
	$mon = date ("Y-m-d", strtotime("+7 day", strtotime($mon)));

}
?>


