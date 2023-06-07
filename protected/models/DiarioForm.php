<?php

class Diario extends CFormModel
{
	public $id;
	public $data;
	public $aulas = 2;
	public $conteudo;
	public $turma_id;
	public $itens_freq = array();
	
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('turma_id', 'required'),
			array('aulas, turma_id', 'numerical', 'integerOnly'=>true),
			array('conteudo', 'length', 'max'=>100),
			array('data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, data, aulas, conteudo, turma_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'data' => 'Data',
			'aulas' => 'Aulas',
			'conteudo' => 'Conteúdo',
			'turma_id' => 'Turma',
		);
	}

}
