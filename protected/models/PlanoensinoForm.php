<?php

class PlanoensinoForm extends CFormModel	
{
	
	public $periodo;
	public $ementa;
	public $bibbasica;
	public $objetivosgerais;
	public $objetivosespecificos;
	public $conteudo;
	public $metodologia;
	public $recursos;
	public $bibcomplementar;
	public $publicarpe;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodo, publicarpe', 'numerical', 'integerOnly'=>true),			
			array('ementa, bibbasica, objetivosgerais, objetivosespecificos, conteudo, metodologia, recursos, bibcomplementar, publicarpe', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			// array('id, periodo, ementa, bibbasica, objetivosgerais, objetivosespecificos, conteudo, metodologia, recursos, bibcomplementar', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'periodo' => 'Período',
			'ementa' => 'Ementa',
			'bibbasica' => 'Bibliografia Básica',
			'objetivosgerais' => 'Objetivos Gerais',
			'objetivosespecificos' => 'Objetivos Específicos',
			'conteudo' => 'Conteúdo Programático',
			'metodologia' => 'Metodologia',
			'recursos' => 'Recursos Didáticos',
			'bibcomplementar' => 'Bibliografia Complementar',
			'publicarpe' => 'Publicar Plano de Ensino?',
		);
	}
}
