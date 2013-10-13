<?php
	$attribute='content';
	$options = array(
		'attribute'=>'content',
    	'buttons'=>array(
            'formatting', '|', 'bold', 'italic', 'deleted', '|',
            'unorderedlist', 'orderedlist', 
            'image', 'video', 'link',
        ),
        'fileUpload'=>Yii::app()->createUrl('api/fileUpload',array(
            'attr'=>$attribute
        )),
        'fileUploadErrorCallback'=>new CJavaScriptExpression(
            'function(obj,json) { alert(json.error); }'
        ),
        'imageUpload'=>Yii::app()->createUrl('api/imageUpload',array(
            'attr'=>$attribute
        )),
        'clipboardUploadUrl'=>Yii::app()->createUrl('api/fileUpload',array(
            'attr'=>$attribute
        )),
        'imageGetJson'=>Yii::app()->createUrl('api/imageList',array(
            'attr'=>$attribute
        )),
        'imageUploadErrorCallback'=>new CJavaScriptExpression(
            'function(obj,json) { alert(json.error); }'
        ),
        // 'focusCallback'=>new CJavaScriptExpression(
        // 	'function(e) {var str = this.get().removeChild(document.getElementById("intro")); alert(str);}'
        // ),
        //var str = ($.strRemove("intro", this.get())); 
        // 'air' => true,
        // 'paragraphy' => false,
        'changeCallback' => new CJavaScriptExpression('function(html){scope.updateArray();}'),
        'initCallback' => new CJavaScriptExpression('function(html){scope.redactorInit();}'),
        // 'focusCallback' => new CJavaScriptExpression("function(e){if(this.get() == '<span style=\"color:#BBB;\">Answer</span><br>');this.set('<br>');}"),
        'linebreaks' => true,
        'air' => true,
	);
	
	$this->widget('ImperaviRedactorWidget', array(
	    // The textarea selector
	    'selector' => '#mem',
	    // Some options, see http://imperavi.com/redactor/docs/
	    'options' => $options,

	));

	$this->widget('ImperaviRedactorWidget', array(
	    // The textarea selector
	    'selector' => '#answera',
	    // Some options, see http://imperavi.com/redactor/docs/
	    'options' => $options,
	));
?>