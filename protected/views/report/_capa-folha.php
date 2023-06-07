<!-- ************************************************************************** -->
<div class="container-report">
<?php
	echo $this->renderPartial('_cabecalho-IFPR', array('turma'=>$turma));
?>
<table align="left" cellspacing="0" border="0" width="100%">
	<tr>
		<td style="border-top: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=9 height="20" align="left" valign=bottom><b><font face="Verdana" color="#000000">Departamento</font></b></td>
		<td style="border-top: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=4 align="left" valign=bottom><b><font face="Verdana" color="#000000">Classe</font></b></td>
		</tr>
	<tr>
		<td style="border-bottom: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=9 height="20" align="left" valign=bottom><font face="Verdana" color="#000000">Colegiado Institucional</font></td>
		<td style="border-bottom: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=4 align="left" valign=bottom><font face="Verdana" color="#000000"><?php echo $turma->classe; ?></font></td>
		</tr>
	<!-- <tr>
		<td colspan=9 height="13" align="left" valign=bottom><b><font face="Verdana" color="#000000"><br></font></b></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
	</tr> -->
	<tr>
		<td style="border-top: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=9 height="20" align="left" valign=bottom><b><font face="Verdana" color="#000000">Disciplina</font></b></td>
		<td style="border-top: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=2 align="center" valign=bottom><b><font face="Verdana" color="#000000">Carga Horária</font></b></td>
		<td style="border-top: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=2 align="center" valign=bottom><b><font face="Verdana" color="#000000">Limite Faltas</font></b></td>
		</tr>
	<tr>
		<td style="border-bottom: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=9 height="20" align="left" valign=bottom><font face="Verdana" color="#000000"><?php echo $turma->disciplina->codigo . ' - ' . $turma->disciplina->nome; ?></font></td>
		<td style="border-bottom: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=2 align="center" valign=bottom><font face="Verdana" color="#000000"><?php echo $turma->chrelogio; ?>  horas</font></td>
		<td style="border-bottom: 1px solid #bfbfbf; border-left: 1px solid #bfbfbf; border-right: 1px solid #bfbfbf" colspan=2 align="center" valign=bottom sdval="20" sdnum="1033;"><font face="Verdana" color="#000000"><?php echo $turma->chaula/4; ?></font></td>
		</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="30" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td colspan=5 align="center" valign=bottom><b><font face="Verdana" size=5 color="#000000">DIÁRIO DE CLASSE</font></b></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="30" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td colspan=5 align="center" valign=bottom><font face="Verdana" size=5 color="#000000"><?php echo $turma->ano . '-' . $turma->semestre; ?></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #d9d9d9; border-bottom: 1px solid #000000; border-left: 1px solid #d9d9d9; border-right: 1px solid #d9d9d9" align="left" valign=bottom bgcolor="#EEECE1"><font face="Verdana" color="#000000">Horário</font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #d9d9d9; border-bottom: 1px solid #000000; border-left: 1px solid #d9d9d9; border-right: 1px solid #d9d9d9" align="left" valign=bottom bgcolor="#EEECE1"><font face="Verdana" color="#000000">Local</font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" style="vertical-align: top;" sdnum="1033;0;# ?/?" rowspan="4" colspan="6"><font face="Verdana" size=3 color="#000000"><?php echo nl2br($turma->horarios); ?></font></td>
		<!-- <td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" size=1 color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td> -->
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<!-- <td align="left" valign=bottom sdnum="1033;0;# ?/?"><font face="Verdana" size=1 color="#000000">TER 22:15 às 23:05</font></td> -->
		<!-- <td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" size=1 color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td> -->
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<!-- <td align="left" valign=bottom sdnum="1033;0;# ?/?"><font face="Verdana" size=1 color="#000000">QUI 19:30 às 20:20</font></td> -->
		<!-- <td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" size=1 color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td> -->
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<!-- <td align="left" valign=bottom sdnum="1033;0;# ?/?"><font face="Verdana" size=1 color="#000000">QUI 20:20 às 21:10</font></td> -->
		<!-- <td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" size=1 color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td> -->
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<!-- <tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<!-- <td align="left" valign=bottom sdnum="1033;0;# ?/?"><font face="Verdana" size=1 color="#000000"><br></font></td> -->
		<!-- <td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td> --
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr> 
	<tr>
		<td height="20" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<!-- <td align="left" valign=bottom sdnum="1033;0;# ?/?"><font face="Verdana" size=1 color="#000000"><br></font></td> -->
		<!-- <td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td> --
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
	</tr> -->
	<tr>
		<td height="20" align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td style="border-top: 1px solid #d9d9d9; border-bottom: 1px solid #000000; border-left: 1px solid #d9d9d9; border-right: 1px solid #d9d9d9" align="left" valign=bottom bgcolor="#EEECE1"><font face="Verdana" color="#000000">Professor(es)</font></td>
		<td style="border-top: 1px solid #d9d9d9; border-bottom: 1px solid #000000; border-left: 1px solid #d9d9d9; border-right: 1px solid #d9d9d9" align="left" valign=bottom bgcolor="#EEECE1"><font face="Verdana" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign=bottom><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" size=3 color="#000000"><?php echo $turma->professor->nome; ?></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font face="Verdana" color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
	</tr>
</table>

<br clear=left>
</div>
<!-- ************************************************************************** -->