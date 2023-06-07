<?php
Yii::import('web.widgets.CWidget');
 
class LookupMultipleDialog extends CWidget
{

    public $title='Pesquisar';
	public $form;
	public $model;
    public $attribute;
    public $htmlOptions;
	public $displayFields = array(
		array(
			'header'=>'Selecione:',
            'name'=>'globalSearch',
			'value'=>'$data->toString()',
			// 'htmlOptions' => array('style' => 'text-align:center;'),
		),
	);
	// public $display;
	public $values;
	public $provider;
	
	public function init() {
  	}
 
    public function run()
    {
    	
		if (!isset($this->values) || empty($this->values)) {
			$this->values = array();
		}
		
    	$dialogId = 'lookup-m-dialog-'.$this->attribute;
    	$attr = $this->attribute;
        // $this->htmlOptions['disabled'] = 'true';
		// $this->htmlOptions['class'] .= ' form-control';
		$this->htmlOptions['placeholder'] = 'Selecionar...';
		$this->htmlOptions['class'] = (isset($this->htmlOptions['class']))? 
				$this->htmlOptions['class'].' form-control':
				$this->htmlOptions['class'] = ' form-control';
		// $this->htmlOptions['value'] = $this->display;
		
		// $this->form->labelEx($this->model,$this->attribute)
		
		echo 
		'<div class="panel panel-default">
		  <div class="panel-heading" style="display: flex;"><div style="margin-top: 5px;">'.$this->form->labelEx($this->model,$this->attribute, array('style'=>'display:inline;')).':&nbsp;</div>'.
		  
		  '<div class="input-group" style="margin-bottom: 0;">'.
		  
		  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	            'model'=>$this->model,
	            'name'=>$this->attribute.'AutoComplete',
	            'source'=>Yii::app()->createUrl('site/autocomplete', array('model'=>get_class($this->provider))),
	            'options'=>array(
	                'delay'=>300,
	                'minLength'=>1,
	                'showAnim'=>'fold',
	                'focus'=>'js:function( event, ui ) {
	                                $( "#'.$this->attribute.'AutoComplete" ).val( ui.item.label );
	                                        return false;
	                                }',
	                        'select'=>"js:function(event, ui) {
	                        	add_ld_".$this->attribute."(ui.item.label, ui.item.id);
	                        return false;
	                        }",
	             ),
	            'htmlOptions'=>$this->htmlOptions,
	        ), true)
			// .CHtml::textField($this->attribute, '', $this->htmlOptions)
	      .'<span class="input-group-btn">'.
	        '<input class="btn btn-default btn-icon-search" type="image" src="images/search.ico" id="'.$dialogId.'-btn" />'.
	        //isset($create)? 
	        //	CHtml::Link("", $create, array('target'=>'_blank', 'class'=>'btn btn-default icon-plus', 'title'=>'Adicionar', 'style'=>'margin-left: -1px;'))
			//	: "" .
	        // '<input class="btn btn-default btn-icon-plus" type="image" id="'.$dialogId.'-btn-add" />'.
	      '</span>'.//icon-search
	    '</div><!-- /input-group -->'.
	    
		  '</div>
		  <div class="panel-body">'.
		
		
	    $this->form->error($this->model,$this->attribute).
	    
	    $this->form->hiddenField($this->model,$this->attribute,array('value'=>''));
		$this->form->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'lookup-m-dialog-'.$this->attribute.'-tbl-selected',
			'dataProvider'=>new CArrayDataProvider($this->values, array('pagination'=>false)),
			'summaryText' => '',
			'emptyText' => null,
			// 'filter'=>$this->provider,
            'columns' => array(
				array(
		            'name'=>'globalSearch',
					// 'header'=>$this->model->getAttributeLabel($this->attribute).' Selecionados:',
					'header'=>'Selecionados:',
					'type' => 'raw',
					'value'=>'$data->toString() ."<input value=\'".$data->id."\' name=\''.CHtml::activeName($this->model,$this->attribute).'[]\' id=\''.CHtml::activeId($this->model,$this->attribute).'\' type=\'hidden\'>"'
					// 'htmlOptions' => array('id' => 'tbl-selected-item-$data->id'),
				),
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{remove}',
					// 'htmlOptions' => array('onclick'=>'$(this).parent().remove();',),
					'buttons'=>array(
			        	'remove'=>array(
			                'label'=>'Remover',
			                'icon' => 'icon-remove',
			                'url'=>'',
			                'options' => array('onclick'=>'$(this).parent().parent().remove();',)
			            ),
			        ),
				)),
            'htmlOptions' => array(
                'style'=>'padding-top: 0;',
            ),                   
            // 'selectionChanged'=>'js:function(id){ onSelectionChange_ld_'.$this->attribute.'(); }',
        ));
		
		echo ('
		<script type="text/javascript">
		function onSelectionChange_ld_'.$this->attribute.'()
		{
		        var keys = $("#lookup-m-dialog-'.$this->attribute.' div.keys > span");
		
		        $("#lookup-m-dialog-'.$this->attribute.' table tbody > tr").each(function(i)
		        {
		                if($(this).hasClass("selected"))
		                {
		                	var id = $(keys[i]).text();
		                	var name = $(this).children(":nth-child(1)").text();
		                	
		                	add_ld_'.$this->attribute.'(name, id);
		                }
		        });
				
				$("#'.$dialogId.'").dialog("close");
		}
		function add_ld_'.$this->attribute.'(name, id)
		{
		        var table_id = "#lookup-m-dialog-'.$this->attribute.'-tbl-selected table tbody";
							
				if (!($(table_id).find("input[value="+id+"]").length)) {
            	
            	$(table_id).append(
            		"<tr>" +
            			"<td>" + name +
            			"<input value=\""+id+"\" name=\"'.CHtml::activeName($this->model,$this->attribute).'[]\" id=\"'.CHtml::activeId($this->model,$this->attribute).'\" type=\"hidden\"></td>" + 
						"<td class=\"button-column\"><a onclick=\"$(this).parent().parent().remove();\" title=\"Remover\" rel=\"tooltip\"><i class=\"icon-remove\"></i></a>"+
						"</td></tr>");
				}
		}
		$("#'.$dialogId.'-btn").click(function(event) {
		    event.preventDefault();
		    $("#'.$dialogId.'").dialog("open");
			$("#'.$dialogId.' .filter-container input").focus();
		});
		</script>
		<style type="text/css">
			#lookup-m-dialog-'.$this->attribute.' table.items th, .table td {line-height: 10px;}
			#lookup-m-dialog-'.$this->attribute.' table.items tr:hover td {background: #eeeeee;}
			#lookup-m-dialog-'.$this->attribute.' table.items tr td {background-color: transparent;}
		</style>
		
		</div></div>
		');
		
		$this->form->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'lookup-m-dialog-'.$this->attribute,
            'options'=>array(
                'title'=>$this->title,
                'width' => 'auto',
                'autoOpen'=>false,
        		'modal'=>true,
        		'close'=>'$\'#'.$dialogId.'\').dialog(\'close\');' ,
            ),
        ));
		
        // $this->form->widget('zii.widgets.grid.CGridView', array(
        $this->form->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'lookup-m-dialog-'.$this->attribute.'-tbl',
			'dataProvider'=>$this->provider->search(),
			'filter'=>$this->provider,
            'columns' => $this->displayFields,
            'htmlOptions' => array(
                'style'=>'cursor: pointer;',
            ),                   
            'selectionChanged'=>'js:function(id){ onSelectionChange_ld_'.$this->attribute.'(); }',
        ));

        $this->form->endWidget('zii.widgets.jui.CJuiDialog');
    }
}