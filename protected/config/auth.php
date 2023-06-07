<?php
$auth=Yii::app()->authManager;
$auth->clearAll();

$auth->createRole(UserIdentity::ROLE_ADMIN, 'Perfil Administrador');
$auth->createRole(UserIdentity::ROLE_PROFE, 'Perfil Professor');
$auth->createRole(UserIdentity::ROLE_ALUNO, 'Perfil Aluno');
$auth->createRole(UserIdentity::ROLE_INSTI, 'Perfil Instituição');

// $auth->assign(UserIdentity::ROLE_ADMIN,'tarlis');
		
$auth->save();
