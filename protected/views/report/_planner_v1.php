<?php
// $this->layout='//layouts/column1';

// Config: 
// $NUM_SEM = 5;

?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->

<style type="text/css">
.agenda {  }

/* Dates */
.agenda .agenda-date { width: 170px;  }
.agenda .agenda-date .dayofmonth {
  width: 40px;
  font-size: 36px;
  line-height: 36px;
  float: left;
  text-align: right;
  margin-right: 10px; 
}
.agenda .agenda-date .weekend{
  color: darkred;
}

.agenda .agenda-date .shortdate {
  font-size: 0.75em; 
}


/* Times */
.agenda .agenda-time { min-width: 118px;vertical-align: middle;text-align: center; } 


/* Events */
.agenda .agenda-events {  } 
.agenda .agenda-events .agenda-event {  } 

@media (max-width: 767px) {
    
}
@media print {
    .page {
    	page-break-before: always;
    } 
}


.todolist{
    background-color:#FFF;
    padding:20px 20px 10px 20px;
    margin-top:30px;
}
.todolist h1{
    margin:0;
    padding-bottom:20px;
    text-align:center;
}
li.ui-state-default{
    background:#fff;
    border:none;
    border-bottom:1px solid #ddd;
}

.list-unstyled {
    padding-left: 0;
    list-style: none;
}
</style>

<div class="page">
<h2>Semana <?php echo $sem; ?>
    <p class="lead" style="float: right;">
        <?php echo DocumentHelper::dataPorMascara($mon, NowField::FORMAT_MM_TEXT) . ', ' . DocumentHelper::dataPorMascara($mon, NowField::FORMAT_YYYY) ?>
    </p>
</h2>

    <hr />
    <div class="agenda">
        <div class="table-responsive">
            <table class="table table-condensed table-bordered">
            	<?php foreach ($turnos as $turno) { ?>
                <thead>
                    <tr>
                        <th class="agenda-time"><?php echo turno($turno); ?></th>
                        <?php
                         $date = $mon; $end_date = date("Y-m-d", strtotime("+6 day", strtotime($date)));
                       	 while (strtotime($date) <= strtotime($end_date)) { ?>
                        <th class="agenda-date" class="active" rowspan="1">
                        <?php  if ($turno == 'M') { ?>
                            <div class="dayofmonth<?php echo isweekend($date)? ' weekend': '';?>"><?php echo DocumentHelper::dataPorMascara($date, NowField::FORMAT_DD) ?></div>
                            <div class="dayofweek<?php echo isweekend($date)? ' weekend': '';?>"><?php echo ucfirst(str_ireplace('Feira', '', DocumentHelper::dataPorMascara($date, NowField::FORMAT_WK_TEXT))); ?></div>
                            <div class="shortdate text-muted"><?php echo isweekend($date)? '': 'Feira';?></div>
                        <?php } ?>
                        </th>
                        <?php
                        	$date = date ("Y-m-d", strtotime("+1 day", strtotime($date))); 
						} ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    	<td class="agenda-time" rowspan="5">
                    		<?php for ($i=1; $i <= 5; $i++) { ?>
                            <div class="dayofweek"><?php echo PTD::turno_hora(PTD::$TURNO['Seg'][$turno][$i]); ?></div>
                            <?php } ?>
                        </td>
                        <?php foreach ($dias as $dia) { ?>
                        <td class="agenda-events" rowspan="5">
                        </td>
                        <?php } ?>
                    </tr>
                </tbody>
    			<?php } ?>
            </table>
        </div>
    </div>
    <hr/>
    <div class="row-fluid">
        <div class="span6">
    <ul id="sortable" class="list-unstyled">
    	<?php for ($k=0; $k < 5; $k++) { ?>
        <li class="ui-state-default">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="" /></label>
            </div>
        </li>
        <?php } ?>
    </ul>
    </div>
    <div class="span6">
    <ul id="sortable" class="list-unstyled">
    	<?php for ($k=0; $k < 5; $k++) { ?>
        <li class="ui-state-default">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="" /></label>
            </div>
        </li>
        <?php } ?>
    </ul>
    </div>
    </div>
</div>
<?php 

?>