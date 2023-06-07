<?php 

$profe = !Yii::app()->user->isGuest && (Yii::app()->user->papel == UserIdentity::ROLE_PROFE || Yii::app()->user->papel == UserIdentity::ROLE_ADMIN);
$cope  = !Yii::app()->user->isGuest && (Yii::app()->user->papel == UserIdentity::ROLE_COPE  || Yii::app()->user->papel == UserIdentity::ROLE_ADMIN);

$menuAddDiario = array('label'=>'Diário', 'url'=>array('/diario/create'), 'icon'=>'icon-plus-sign');
$menuAddPE = array('label'=>'Plano de Ensino', 'url'=>array('/planoensino/create'), 'icon'=>'icon-plus-sign');

$linksTurmasDiario = array();
$linksTurmasPE = array();
$linksEmailsTurmas = array();

$menuListDocs = array();

if (isset(Yii::app()->user->papel_id) && 
	(Yii::app()->user->papel == UserIdentity::ROLE_PROFE || Yii::app()->user->papel == UserIdentity::ROLE_ADMIN)) {
	$turmas = Yii::app()->helper->currentTurmas();
	
	foreach ($turmas as $turma) {
		array_push($linksTurmasDiario, array('label'=>$turma->nome, 'url'=>array('/diario/create','turma_id'=>$turma->id)));
		array_push($linksEmailsTurmas, array('label'=>$turma->nome, 'url'=>array('/turma/emails','id'=>$turma->id)));
		array_push($linksTurmasPE, array('label'=>$turma->nome, 'url'=>array('/planoensino/update','id'=>$turma->id)));
	}
	
	$menuAddDiario = array('label'=>'Diário', 'url'=>'#', 'items'=>$linksTurmasDiario, 'icon'=>'icon-plus-sign');
	$menuAddPE = array('label'=>'Plano de Ensino', 'url'=>'#', 'items'=>$linksTurmasPE, 'icon'=>'icon-plus-sign');
	
	// ---
	array_push($menuListDocs, array('label'=>'Todos', 'url'=>array('/documento/index')));
	$docs = DocumentoModelo::model()->search();
	foreach ($docs->getData() as $d) {
		array_push($menuListDocs, array('label'=>$d->nome, 'url'=>array('/documento/index','modelo_id'=>$d->id)));
	}
}

$this->widget('bootstrap.widgets.TbNavbar', array(
	    'type'=>'inverse', // null or 'inverse'
	    // 'brand'=>CHtml::encode(Yii::app()->name),
	    'brand' => '<img src ="' .Yii::app()->request->baseUrl .'/images/'.Yii::app()->params['logo'].'" />',
		'brandUrl'=>Yii::app()->homeUrl,
	    'collapse'=>true, // requires bootstrap-responsive.css
	    // 'encodeLabels'=>false,
	    'items'=>array(
	        array(
	            'class'=>'bootstrap.widgets.TbMenu',
	            'items'=>array(
	                array('label'=>'Manutenção', 'url'=>'#', 'visible'=>Yii::app()->helper->isAdmin(), 'items'=>array(
	                    array('label'=>'Instituições ...', 'url'=>array('/instituicao/admin'), 'icon'=>'fa fa-university'),
	                    array('label'=>'Professores ...', 'url'=>array('/professor/admin'), 'icon'=>'fa fa-male'),
	                    array('label'=>'Usuários ...', 'url'=>array('/usuario/admin'), 'icon'=>'icon-user'),
	                    '---',
	                    array('label'=>'Alunos ...', 'url'=>array('/aluno/admin'), 'icon'=>'fa fa-child'),
	                    array('label'=>'Alunos Duplicados ...', 'url'=>array('/aluno/duplicates'), 'icon'=>'fa fa-user-plus'),
	                    '---',
	                    array('label'=>'Cursos ...', 'url'=>array('/curso/admin'), 'icon'=>'fa fa-book'),
	                    array('label'=>'Disciplinas ...', 'url'=>array('/disciplina/admin'), 'icon'=>'fa fa-slideshare'),
	                    array('label'=>'Turmas ...', 'url'=>array('/turma/admin'), 'icon'=>'fa fa-group'),
	                    /*'---',
	                    array('label'=>'Coordenações de Cursos ...', 'url'=>array('/usuario/coordenacao'))*/
	                ), 'icon'=>'fa fa-database'),
	                array('label'=>'Arquivo', 'url'=>'#', 'visible'=>$profe, 'items'=>array(
	                    /*array('label'=>'Meus Dados', 'url'=>array('/usuario/view','id'=>Yii::app()->user->id), 'icon'=>'icon-user'), //, 'icon'=>''
	                    '---',*/
	                    array('label'=>'Cursos ...', 'url'=>array('/curso/index'), 'icon'=>'fa fa-book'),
	                    array('label'=>'Alunos ...', 'url'=>array('/aluno/index'), 'icon'=>'fa fa-child'),
	                    '---',
	                    array('label'=>'FERRAMENTAS'),
	                    array('label'=>'Planner', 'url'=>array('/report/planner'), 'icon'=>'fa fa-calendar-check-o', 'linkOptions'=>array('target'=>'_blank')),
	                    array('label'=>'Imprimir Arquivos...', 'url'=>'tools/print_files.php', 'icon'=>'fa fa-external-link', 'linkOptions'=>array('target'=>'_blank')),
	                    array('label'=>'Importar Alunos...', 'url'=>array('/aluno/import'), 'icon'=>'icon-download-alt'),
	                ), 'icon'=>'fa fa-archive'),
	                array('label'=>'Ensino', 'url'=>'#', 'visible'=>$profe, 'items'=>array(
	                    array('label'=>'Disciplinas ...', 'url'=>array('/disciplina/index'), 'icon'=>'fa fa-slideshare'),
	                    '---',
	                    array('label'=>'Turmas ...', 'url'=>array('/turma/index'), 'icon'=>'fa fa-group'),
	                    array('label'=>'Turma', 'url'=>array('/turma/create'), 'icon'=>'icon-plus-sign'),
	                    '---',
	                    array('label'=>'Planos de Ensino ...', 'url'=>array('/planoensino/index'), 'icon'=>'fa fa-file-powerpoint-o'),
	                    $menuAddPE,
	                   /* '---',
	                    array('label'=>'PTDs ...', 'url'=>array('/ptd/index'), 'icon'=>'fa fa-suitcase'),
	                    array('label'=>'Horários', 'url'=>array('/atvdocente/view','usuario_id'=>Yii::app()->user->id), 'icon'=>'fa fa-bell-o'),
	                    array('label'=>'Atividades Docente', 'url'=>array('/atvdocente/index', 'status'=>AtividadeDocente::STATUS_ATIVO), 'icon'=>'fa fa-tasks'),
	                    */'---',
	                    array('label'=>'E-mails da Turma', 'url'=>'#', 'items'=>$linksEmailsTurmas, 'icon'=>'icon-envelope'),
	                ), 'icon'=>'fa fa-slideshare'),
	                array('label'=>'Diário de Classe', 'url'=>'#', 'visible'=>$profe, 'items'=>array(
	                    array('label'=>'Diários ...', 'url'=>array('/diario/index'), 'icon'=>'fa fa-calendar'),
	                    $menuAddDiario,
	                    '---',
	                    array('label'=>'Avaliações ...', 'url'=>array('/avaliacao/index'), 'icon'=>'fa fa-calendar-check-o'),
	                    array('label'=>'Avaliação', 'url'=>array('/avaliacao/create'), 'icon'=>'icon-plus-sign'),
	                    '---',
	                    array('label'=>'Notas', 'url'=>array('/avaliacao/notas'), 'icon'=>'fa fa-graduation-cap'),
	                    array('label'=>'Conferir Notas...', 'url'=>array('/report/ckaval'), 'icon'=>'fa fa-check-circle'),
	                    '---',
	                    array('label'=>'Conferência de Diários', 'url'=>array('/diario/bulkupdate'), 'icon'=>'fa fa-dashboard'),
	                    array('label'=>'Ata de Exame', 'url'=>array('/diario/examata'), 'icon'=>'icon-list-alt'),
	                ), 'icon'=>'fa fa-calendar-o'),
	                array('label'=>'Relatórios', 'url'=>'#', 'visible'=>$profe, 'items'=>array(
	                    array('label'=>'OFICIAL'),
	                    array('label'=>'Capa ...', 'url'=>array('/report/capa')),
	                    array('label'=>'Frequência ...', 'url'=>array('/report/frequencia')),
	                    array('label'=>'Conteúdo ...', 'url'=>array('/report/conteudo')),
	                    array('label'=>'Avaliações ...', 'url'=>array('/report/avaliacoes')),
	                    array('label'=>'Todos ...', 'url'=>array('/report/todos')),
	                    '---',
	                    array('label'=>'Avaliações (Sem Arred.) ...', 'url'=>array('/report/avaliacoes', 'round'=>0)),
	                    array('label'=>'Todos (Sem Arred.) ...', 'url'=>array('/report/todos', 'round'=>0)),
	                    '---',
	                    array('label'=>'ACOMPANHAMENTO'),
	                    array('label'=>'Resultados', 'url'=>'#', 'items'=>array(
		                    array('label'=>'Todos', 'url'=>array('/report/result', 'nome'=>1,'RA'=>1,'notas'=>1,'pri_bim'=>1,'seg_bim'=>1,'faltas'=>1,'med_parc'=>1,'exame'=>1,'med_final'=>1,'result'=>1)),
		                    '---',
		                    array('label'=>'Em Exame (Nome)', 'url'=>array('/report/result', 'nome'=>1,'faltas'=>1,'med_parc'=>1,'result'=>1,'em_exame'=>1)),
		                    array('label'=>'Em Exame (RA)', 'url'=>array('/report/result', 'RA'=>1,'faltas'=>1,'med_parc'=>1,'result'=>1,'em_exame'=>1)),
		                    '---',
		                    array('label'=>'Aprovados', 'url'=>array('/report/result', 'nome'=>1,'faltas'=>1,'med_final'=>1,'result'=>1,'aprovado'=>1)),
		                    array('label'=>'Reprovados', 'url'=>array('/report/result', 'nome'=>1,'faltas'=>1,'med_final'=>1,'result'=>1,'reprovado'=>1)),
		                )),
	                    array('label'=>'Boletim', 'url'=>'#', 'items'=>array(
	                    	array('label'=>'Boletim', 'url'=>array('/report/result', 'nome'=>1,'RA'=>1,'pri_bim'=>1,'seg_bim'=>1,'faltas'=>1,'med_parc'=>1,'exame'=>1,'med_final'=>1,'result'=>1)),
	                    	array('label'=>'Boletim Parcial', 'url'=>array('/report/result', 'nome'=>1,'RA'=>1,'pri_bim'=>1,'seg_bim'=>1,'faltas'=>1,'med_parc'=>1,'result'=>1)),
	                    	// array('label'=>'Boletim Individual', 'url'=>'#'),
	                    )),
	                    array('label'=>'Notas', 'url'=>'#', 'items'=>array(
		                    array('label'=>'Notas', 'url'=>array('/report/result', 'nome'=>1,'RA'=>1,'notas'=>1,'pri_bim'=>1,'seg_bim'=>1,'exame'=>1)),
		                    array('label'=>'Notas e Faltas', 'url'=>array('/report/result', 'nome'=>1,'RA'=>1,'notas'=>1,'faltas'=>1,'pri_bim'=>1,'seg_bim'=>1,'exame'=>1)),
		                    // array('label'=>'Notas Individuais', 'url'=>'#'),
	                    )),
	                    '---',
	                    array('label'=>'Resultados (Sem Arred.)', 'url'=>'#', 'items'=>array(
		                    array('label'=>'Todos', 'url'=>array('/report/result', 'round'=>0, 'nome'=>1,'RA'=>1,'notas'=>1,'pri_bim'=>1,'seg_bim'=>1,'faltas'=>1,'med_parc'=>1,'exame'=>1,'med_final'=>1,'result'=>1)),
		                    '---',
		                    array('label'=>'Em Exame (Nome)', 'url'=>array('/report/result', 'round'=>0, 'nome'=>1,'faltas'=>1,'med_parc'=>1,'result'=>1,'em_exame'=>1)),
		                    array('label'=>'Em Exame (RA)', 'url'=>array('/report/result', 'round'=>0, 'RA'=>1,'faltas'=>1,'med_parc'=>1,'result'=>1,'em_exame'=>1)),
		                    '---',
		                    array('label'=>'Aprovados', 'url'=>array('/report/result', 'round'=>0, 'nome'=>1,'faltas'=>1,'med_final'=>1,'result'=>1,'aprovado'=>1)),
		                    array('label'=>'Reprovados', 'url'=>array('/report/result', 'round'=>0, 'nome'=>1,'faltas'=>1,'med_final'=>1,'result'=>1,'reprovado'=>1)),
		                )),
	                    array('label'=>'Boletim (Sem Arred.)', 'url'=>'#', 'items'=>array(
	                    	array('label'=>'Boletim', 'url'=>array('/report/result', 'round'=>0, 'nome'=>1,'RA'=>1,'pri_bim'=>1,'seg_bim'=>1,'faltas'=>1,'med_parc'=>1,'exame'=>1,'med_final'=>1,'result'=>1)),
	                    	array('label'=>'Boletim Parcial', 'url'=>array('/report/result', 'round'=>0, 'nome'=>1,'RA'=>1,'pri_bim'=>1,'seg_bim'=>1,'faltas'=>1,'med_parc'=>1,'result'=>1)),
	                    	// array('label'=>'Boletim Individual', 'url'=>'#'),
	                    )),
	                    array('label'=>'Notas (Sem Arred.)', 'url'=>'#', 'items'=>array(
		                    array('label'=>'Notas', 'url'=>array('/report/result', 'round'=>0, 'nome'=>1,'RA'=>1,'notas'=>1,'pri_bim'=>1,'seg_bim'=>1,'exame'=>1)),
		                    array('label'=>'Notas e Faltas', 'url'=>array('/report/result', 'round'=>0, 'nome'=>1,'RA'=>1,'notas'=>1,'faltas'=>1,'pri_bim'=>1,'seg_bim'=>1,'exame'=>1)),
		                    // array('label'=>'Notas Individuais', 'url'=>'#'),
	                    )),
	                    '---',
	                    array('label'=>'Ata de Exame', 'url'=>array('/diario/examata')),
	                    array('label'=>'Folha de Presenças', 'url'=>array('/report/folhafrequencia')),
	                ), 'icon'=>'fa fa-file-pdf-o'),
	                array('label'=>'COPE', 'url'=>'#', 'visible'=>($profe || $cope), 'items'=>array(
	                    array('label'=>'Areas ...', 'url'=>array('/area/index'), 'icon'=>'fa fa-cubes', 'visible'=>$cope),
	                    array('label'=>'Projetos ...', 'url'=>array('/projeto/index'), 'icon'=>'fa fa-file-text', 'visible'=>($profe || $cope)),
	                    array('label'=>'Relatórios ...', 'url'=>array('/relatorio/index'), 'icon'=>'fa fa-flag', 'visible'=>($profe || $cope)),
	                    // '---',
	                    // array('label'=>'Pareceres ...', 'url'=>array('/parecer/index'), 'icon'=>'fa fa-child'),
	                ), 'icon'=>'fa fa-cube'),
	                array('label'=>'e-Docs', 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
	                	array('label'=>'Modelos', 'url'=>'#', 'items'=>array(
	                		array('label'=>'Todos ...', 'url'=>array('/docmodelo/index')),
	                		'---',
	                    	array('label'=>'Meus ...', 'url'=>array('/docmodelo/index', 'criador_id'=>Yii::app()->user->id)),
	                    	array('label'=>'Coordenação ...', 'url'=>array('/docmodelo/index', 'filtro'=>'coordenacao')),
	                    	array('label'=>'Instituição ...', 'url'=>array('/docmodelo/index', 'filtro'=>'ies')),
	                    	array('label'=>'COPE ...', 'url'=>array('/docmodelo/index', 'filtro'=>'cope')),
	                	), 'icon'=>'fa fa-file'),
	                	array('label'=>'Modelo', 'url'=>array('/docmodelo/create'), 'icon'=>'icon-plus-sign'),
	                    '---',
	                    // array('label'=>'Documentos...', 'url'=>array('/documento/index')),
	                    array('label'=>'Documentos', 'url'=>array('/documento/index'), 'items'=>$menuListDocs, 'icon'=>'fa fa-file-text'),
	                    array('label'=>'Documento', 'url'=>array('/documento/create'), 'icon'=>'icon-plus-sign'),
	                    '---',
	                    array('label'=>'Ajuda', 'url'=>array('/documento/ex_help')),//, 'icon'=>'fa fa-file-text'),
	                ), 'icon'=>'fa fa-file-o'),
	                /*array('label'=>'Reservas', 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
	                    array('label'=>'Salas ...', 'url'=>array('/sala/index','id'=>Yii::app()->user->id), 'icon'=>'fa fa-building-o'), //, 'icon'=>''
	                    '---',
	                    array('label'=>'Reservas ...', 'url'=>array('/reserva/index'), 'icon'=>'fa fa-flag-o'),
	                    array('label'=>'Reserva', 'url'=>array('/reserva/create'), 'icon'=>'icon-plus-sign'),
	                    '---',
	                    array('label'=>'Confirmação de Reservas ...', 'url'=>array('/reserva/confirmar'), 'icon'=>'fa fa-flag'),
	                ), 'icon'=>'fa fa-building'),*/
	                /*array('label'=>'Coordenação', 'url'=>'#', 'visible'=>$profe, 'items'=>array(
	                    // array('label'=>'Meus Dados', 'url'=>array('/usuario/view','id'=>Yii::app()->user->id)),
	                    // '---',
	                    // array('label'=>'Alunos', 'url'=>array('/aluno/index')),
	                    // array('label'=>'Cursos', 'url'=>array('/curso/index')),
	                    // '---',
	                    // array('label'=>'Disciplinas', 'url'=>array('/disciplina/index')),
	                    // array('label'=>'Turmas', 'url'=>array('/turma/index')),
	                )),*/
	                // array('label'=>'Ferramentas', 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
	                    // array('label'=>'Configurações', 'url'=>'#', 'icon'=>'icon-cog'),
	                    // '---',
	                    // array('label'=>'Enviar E-mails', 'url'=>'#'),
	                // )),
	                array('label'=>'Alunos', 'url'=>'#', 'visible'=>Yii::app()->user->isGuest, 'items'=>array(
	                    array('label'=>'Notas e Faltas', 'url'=>array('/aluno/grades'), 'icon'=>'fa fa-graduation-cap'),
	                    // array('label'=>'Boletim', 'url'=>'#'),
	                ), 'icon'=>'fa fa-child'),
	            ),
	        ),
	        array(
	            'class'=>'bootstrap.widgets.TbMenu',
	            'htmlOptions'=>array('class'=>'pull-right'),
	            'items'=>array(
	                array('label'=>'', 'url'=>array('/site/index'), 'icon'=>'fa fa-home', 'itemOptions'=>array('class'=>'tooltipster','title'=>'Início'),'linkOptions'=>array('style'=>'color: #ffffff !important;')),
					array('label'=>'', 'url'=>array('/site/page', 'view'=>'about'), 'icon'=>'fa fa-info', 'itemOptions'=>array('class'=>'tooltipster','title'=>'Sobre'),'linkOptions'=>array('style'=>'color: #ffffff !important;')),
					array('label'=>'', 'url'=>array('/site/contact'), 'icon'=>'fa fa-envelope', 'itemOptions'=>array('class'=>'tooltipster','title'=>'Contato'), 'linkOptions'=>array('style'=>'color: #ffffff !important;')),
					array('label'=>'', 'url'=>array('/site/login'), 'icon'=>'fa fa-sign-in', 'visible'=>Yii::app()->user->isGuest, 'itemOptions'=>array('class'=>'tooltipster','title'=>'Login'),'linkOptions'=>array('style'=>'color: #ffffff !important;')),
					array('label'=>'', 'icon'=>'fa fa-sign-out', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest, 'itemOptions'=>array('class'=>'tooltipster','title'=>'Logout ('.Yii::app()->user->name.')'),'linkOptions'=>array('style'=>'color: #ffffff !important;'))
	            ),
	        ),
	    ),
	)
); 
		
?>