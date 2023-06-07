<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contato';
$this->breadcrumbs=array(
	'Contato',
);
?>

<h1>Contate-nos</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('contact'),
    )); ?>

<?php else: ?>

<p>
Se você tver dúvidadas ou sugestões, entre em contato
</p>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'name'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

    <?php echo $form->textFieldRow($model,'subject',array('size'=>60,'maxlength'=>128)); ?>

    <?php echo $form->textAreaRow($model,'body',array('rows'=>6, 'class'=>'span8')); ?>

	<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(
            'hint'=>'Digite as letras que aparecem na imagen acima.<br/>Nào diferenciam-se maiúsculas e minúsculas.',
        )); ?>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',array(
            // 'buttonType'=>'buttom',
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Enviar',
            'id'=>'btn-send',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<!--script language="JavaScript">
$('#btn-send').click(function() {
	mail('tarlis@limao.com.br', 'Hi!', "What's been going on lately?");
});

function mail (to, subject, message, additional_headers, additional_parameters) {
  // http://kevin.vanzonneveld.net
  // +   original by: Brett Zamir (http://brett-zamir.me)
  // %          note 1: Currently only works if the SSJS SendMail method is available
  // %          note 1: and also depends on the ini having been set for 'sendmail_from';
  // %          note 1: There currently is no CommonJS email API: http://wiki.commonjs.org/wiki/Email
  // %          note 2: 'additional_parameters' argument is not supported
  // *     example 1: mail('you@example.com', 'Hi!', "What's been going on lately?");
  // *     returns 1: true
  // *     example 2: mail("jack@example.com, barry@example.net", 'ok subj', 'my message',
  // *     example 2:           'From: jack@example.com\r\n'+'Organization : Example Corp\r\n'+
  // *     example 2:           'Content-type: text/html;charset=utf8');
  // *     returns 2: true
  var _append = function (sm, prop, value) {
    if (!sm[prop]) { // Ok?
      sm[prop] = '';
      sm[prop] += value;
    } else {
      sm[prop] += ',' + value;
    }
  };

  if (this.window.SendMail) { // See http://web.archive.org/web/20070219200401/http://research.nihonsoft.org/javascript/ServerReferenceJS12/sendmail.htm
    var sm = new this.window.SendMail();
    var from = this.php_js && this.php_js.ini && this.php_js.ini.sendmail_from && this.php_js.ini.sendmail_from.local_value;
    sm.To = to;
    sm.Subject = subject;
    sm.Body = message;
    sm.From = from;
    if (additional_headers) {
      var headers = additional_headers.trim().split(/\r?\n/);
      for (var i = 0; i < headers.length; i++) {
        var header = headers[i];
        var colonPos = header.indexOf(':');
        if (colonPos === -1) {
          throw new Error('Malformed headers');
        }
        var prop = header.slice(0, colonPos).trim();
        var value = header.slice(colonPos + 1).trim();
        switch (prop) {
          // Todo: Add any others to this top fall-through which can allow multiple headers
          //                via commas; will otherwise be overwritten (Errorsto, Replyto?)
        case 'Bcc':
          // Fall-through
        case 'Cc':
          // Fall-through
        case 'To':
          // Apparently appendable with additional headers per PHP examples
          _append(sm, prop, value);
          break;
        case 'Subject':
          // Overridable in additional headers?
          break;
        case 'Body':
          // Overridable in additional headers?
          break;
        case 'From':
          // Default, though can be overridden
          /* Fall-through */
        default:
          //  Errorsto, Organization, Replyto, Smtpserver
          sm[prop] = value;
          break;
        }
      }
    }
    if (!sm.From) {
      throw new Error('Warning: mail(): "sendmail_from" not set in php.ini');
    }
    return sm.send();
  }
  return false;
}
	
</script-->

<?php endif; ?>