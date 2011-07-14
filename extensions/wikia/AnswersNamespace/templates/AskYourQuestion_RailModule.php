<section class="AskYourQuestionModule module">
	<button class="wikia-button" data-loginToUse="<?= $loginToUse ? 'true' : 'false' ?>"><?= wfMsg('ask-button') ?></button>
	<div class="tally">
		<em><?= wfMsg('ask') ?></em>
		<span class="fixedwidth"><?= wfMsg('the-experts') ?></span>
	</div>
</section>

<style type="text/css">
.AskYourQuestionModule .tally em {
	text-transform: none;
}
.AskYourQuestionModule .tally span.fixedwidth {
	width: 85px;
}
</style>

<script type="text/javascript">/*<![CDATA[*/
var AnswersNamespace = {
    formQuestionField: false,

    init: function() {
        $('.AskYourQuestionModule button').click(AnswersNamespace.askBtnClick);
    },

    initModal: function() {
        AnswersNamespace.formQuestionField = $('#CreateQuestionForm input[name=question]');
        $('#CreateQuestionForm').submit(function() {
            return AnswersNamespace.formQuestionField.val().length > 0;
        });
        $('#cancelAskTheQuestion').click(function() {
            $('#ask-your-question-dialogWrapper').closeModal();
        });
        AnswersNamespace.formQuestionField.focus();
        $.loadJQueryAutocomplete(function() {
            AnswersNamespace.formQuestionField.autocomplete({
                serviceUrl: wgServer + wgScript + '?action=ajax&rs=getQuestionSuggest&format=json',
                appendTo: '#CreateQuestionForm',
                deferRequestBy: 250,
                maxHeight: 1000,
                selectedClass: 'selected',
                width: '270px'
            });
        });
    },

    showModal: function() {
        $().getModal(
            wgScript + '?action=ajax&rs=moduleProxy&moduleName=AskYourQuestion&actionName=ModalWindow&outputType=html',
            '#ask-your-question-dialog',
            { width: 400, showCloseButton: false, callback: AnswersNamespace.initModal }
	);
    },

    askBtnClick: function() {
	var loginToUse = $(this).attr('data-loginToUse') == 'true';
	if(loginToUse) {
            showComboAjaxForPlaceHolder(false, '', function() {
                AjaxLogin.doSuccess = function() {
                    $('#AjaxLoginBoxWrapper').closeModal();
                    AnswersNamespace.showModal();
                };
	    }, false, true);
	} else {
	    AnswersNamespace.showModal();
	}
    }
};

wgAfterContentAndJS.push(function() {
    AnswersNamespace.init();
});
/*]]>*/</script>
