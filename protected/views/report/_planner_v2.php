<?php 
$user = Yii::app()->helper->user();
$main_color = 'rgb(194,197,197)';
$main_color2 = 'rgb(60,62,60)';
$mono = './images/mono.jpg'; 

?>
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	margin-top: -5px;
	font-family: Lucidatypewriter, monospace;
	font-variant: small-caps;
}
.border {
	background-color: <?php echo $main_color; ?>;
	height: 35px;
	width: 100%;
	margin-top: 3px;
	margin-bottom: 3px;
	clear: both;
}
.border.page {
	height: 20px;
}
.row1 {
	height: 260px;
	clear: both;
}
.week {
	border: 1px solid <?php echo $main_color; ?>;
	margin-right: 3px;
}
.day {
	width: 16%;
	float: left;
	height: 100%;
}
.end {
	width: 16%;
	float: right;
	height: 48.5%;
	margin-bottom: 4px;
}
.box {
	border: 1px solid <?php echo $main_color; ?>;
	margin-top: 5px;
	width: 100%;
}
.box h1,
.insight h1 {
	font-weight: normal;
	font-size: 10pt;
	color: <?php echo $main_color2; ?>;
	margin: 5px;
}
.insight h1 {
	padding: 5px;
	margin: 0;
	color: white;
	font-size: 15pt;
}
.week h1,
.todo h1 {
	font-weight: normal;
	font-size: 15pt;
	text-align: center;
	background-color: <?php echo $main_color; ?>;
	margin: 5px;
	color: white;
	height: 25px;
}
.insight {
	margin-top: 3px;
	height: 125px;
	background-color: <?php echo $main_color; ?>;
	border-radius: 5px;
	width: 100.5%;
	text-align: right;
	opacity: 0.6;
}
.notes {
	height: 206px;
}
.notforget {
	height: 206px;	
}
.name {
	margin: 5px;
	height: 125px;
	text-align: center;
}
.name * {
	display: table-cell;
}
.name img {
	height: 125px;
	vertical-align: middle;
}
.name .full {
	height: 125px;
	overflow: hidden;
	width: 74%;
    vertical-align: middle;
    font-size: 20pt;
    color: <?php echo $main_color2; ?>;
}

.row2 {
	height: 346px;
	clear: both;
}

.row2a {
	width: 32.4%;
	float: left;
	height: 100%;
	margin-right: 5px;
}

.todo {
	height: 96%;
	margin-top: 5px;
}

.alfa {
	border: none;
	min-width: 103px;
    height: 126px;
}

.A {background: url(<?php echo $mono; ?>) -124px 787px;}
.B {background: url(<?php echo $mono; ?>) -232px 787px;}
.C {background: url(<?php echo $mono; ?>) -340px 787px;}
.D {background: url(<?php echo $mono; ?>) -448px 787px;}
.E {background: url(<?php echo $mono; ?>) -556px 787px;}
.F {background: url(<?php echo $mono; ?>) -664px 787px;}
.G {background: url(<?php echo $mono; ?>) -772px 787px;}

.H {background: url(<?php echo $mono; ?>) -124px 637px;}
.I {background: url(<?php echo $mono; ?>) -232px 637px;}
.J {background: url(<?php echo $mono; ?>) -340px 637px;}
.K {background: url(<?php echo $mono; ?>) -448px 637px;}
.L {background: url(<?php echo $mono; ?>) -556px 637px;}
.M {background: url(<?php echo $mono; ?>) -664px 637px;}
.N {background: url(<?php echo $mono; ?>) -772px 637px;}

.O {background: url(<?php echo $mono; ?>) -124px 489px;}
.P {background: url(<?php echo $mono; ?>) -233px 489px;}
.Q {background: url(<?php echo $mono; ?>) -341px 489px;}
.R {background: url(<?php echo $mono; ?>) -449px 489px;}
.S {background: url(<?php echo $mono; ?>) -557px 489px;}
.T {background: url(<?php echo $mono; ?>) -665px 489px;}
.U {background: url(<?php echo $mono; ?>) -773px 489px;}

.V {background: url(<?php echo $mono; ?>) -232px 339px;}
.W {background: url(<?php echo $mono; ?>) -341px 339px;}
.X {background: url(<?php echo $mono; ?>) -449px 339px;}
.Y {background: url(<?php echo $mono; ?>) -557px 339px;}
.Z {background: url(<?php echo $mono; ?>) -665px 339px;}

/* Task list */
ul {
	padding-left: 10px;
  	padding-right: 10px;
  	margin-top: 10px;
}
li {
  overflow: hidden;
  padding: 20px 0;
  border-bottom: 1px solid <?php echo $main_color; ?>;
  padding-top: 8px;
  padding-bottom: 2px;
}
li .check {
	border: 2px solid <?php echo $main_color; ?>;
	position: relative;
    display: inline-block;
    width: 15px;
    height: 15px;
    top: 2px;
}

.header {
	height: 100%;
	font-family: Arial, Helvetica, sans-serif;
	font-variant: normal;
	color: white;
}

.header * {
	vertical-align: middle;
	margin: 10px
}
.header .left {
	float: left;
}
.header .right {
	float: right;
}
@media print {
    .page {
    	page-break-after: always;
    } 
}
</style>
<div style="width: 100%">
<div class="border">
	<div class="header">
		<span class="left">Semana <?php echo $sem; ?></span>
	    <span class="right">
	        <?php echo ucfirst(DocumentHelper::dataPorMascara($mon, NowField::FORMAT_MM_TEXT)) . ', ' . DocumentHelper::dataPorMascara($mon, NowField::FORMAT_YYYY) ?>
	    </span>
	</div>
</div>
<div class="row1">
	 <?php
     $date = $mon; $end_date = date("Y-m-d", strtotime("+6 day", strtotime($date)));
   	 foreach ($dias as $dia) { //while (strtotime($date) <= strtotime($end_date)) { 
	 ?>
		<div class="week<?php echo isweekend($date)? ' end': ' day';?>">
			<h1><div style="float:left;margin-left: 5px;"><?php echo $dia; ?></div>
				<div style="float:right;margin-right: 5px;"><?php echo DocumentHelper::dataPorMascara($date, NowField::FORMAT_DD) ?>/<?php echo DocumentHelper::dataPorMascara($date, NowField::FORMAT_MM) ?></div></h1>
		</div>
    <?php
    	$date = date ("Y-m-d", strtotime("+1 day", strtotime($date))); 
	} ?>
</div>
<div class="row2">
	<div class="row2a">
		<div class="box notes">
			<h1>Notas</h1>
		</div>
		<div class="name">
			<div class="alfa <?php echo strtoupper($user->perfil->nome[0]); ?>" ></div>
			<div class="full"><?php echo $user->perfil->nome; ?></div>
		</div>
	</div>
	<div class="row2a">
		<div class="box notforget">
			<h1>Don't Forget</h1>
		<ul id="incomplete-tasks">
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	    </ul>
		</div>
		<div class="insight">
			<h1>Insights</h1>
		</div>
	</div>
	<div class="row2a" style="width: 33.5%;">
		<div class="box todo">
			<h1>To Do</h1>
		<ul id="incomplete-tasks">
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	        <li><div class="check"></div></li>
	    </ul>

		</div>
	</div>
</div>
</div>
<div class="border page"></div>

