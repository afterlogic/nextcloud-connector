
$(function() {

	try
	{
		$('.afterlogic-ajax-form').each(function () {
			
			var
				oForm = $(this),
				sDataAjaxFile = oForm.data('ajax-file'),
				oSubmit = $('.afterlogic-save-button', oForm),
				oResult = $('.afterlogic-result', oForm)
			;

			if (sDataAjaxFile && oSubmit && oSubmit[0] && oResult && oResult[0] &&
				!oForm.data('form-inited'))
			{
				oForm.data('form-inited', true);
				oSubmit.click(function (oEvent) {

					oEvent.preventDefault();
					
					oForm
						.removeClass('afterlogic-error afterlogic-success')
						.addClass('afterlogic-ajax')
					;
					
					oResult.text('');
					oSubmit
						.data('ajax-button-original-value', oSubmit.val())
						.val(oSubmit.data('ajax-button-value'))
					;

					$.ajax({
						'type': 'POST',
						'async': true,
						'url': OC.filePath('afterlogic', 'ajax', sDataAjaxFile),
						'data': oForm.serialize(),
						'dataType': 'json',
						'global': true
					}).always(function (oData) {

						var bResult = false;

						oForm.removeClass('afterlogic-ajax');
						oSubmit.val(oSubmit.data('ajax-button-original-value'));

						if (oData)
						{
							bResult = 'success' === oData['status'];
							if (oData['Message'])
							{
								oResult.text(oData['Message']);
							}
						}

						if (bResult)
						{
							oForm.addClass('afterlogic-success');
						}
						else
						{
							oForm.addClass('afterlogic-error');
							if ('' === oResult.text())
							{
								oResult.text('Error');
							}
						}
					});
				});
			}
		});
	}
	catch(e) {}
});
