/**
 * usage_widget
 *
 * Copyright (C) 2013 Andreas Nölke
 *
 * @package   usage_widget
 * @author    Andreas Nölke
 * @license
 * @copyright brothers-project 2013
 */

/**
* Open usage wizard in a modal window
* @param object
*/
Backend.openModalusageWidget = function(options) {
	var opt = options || {};
	var max = (window.getSize().y - 180).toInt();
	if (!opt.height || opt.height > max)
		opt.height = max;
	var M = new SimpleModal({
		'width': opt.width,
		'btn_ok': Contao.lang.close,
		'draggable': false,
		'overlayOpacity': .5,
		'onShow': function() {
			document.body.setStyle('overflow', 'hidden');
		},
		'onHide': function() {
			document.body.setStyle('overflow', 'auto');
			new Request.Contao({
				field: $('ctrl_' + opt.id),
				evalScripts: false,
				onRequest: AjaxRequest.displayBox(Contao.lang.loading + ' …'),
				onSuccess: function(txt, json) {
					$('ctrl_' + opt.id).getParent('div').set('html', json.content);
					json.javascript && Browser.exec(json.javascript);
					AjaxRequest.hideBox();
					window.fireEvent('ajax_change');
				}
			}).post({'action': 'reloadWidget', 'name': opt.id, 'value': $('ctrl_' + opt.id).value, 'widget': opt.type, 'REQUEST_TOKEN': Contao.request_token});
		}
	});
	M.show({
		'title': opt.title,
		'contents': '<iframe src="' + opt.url + '" name="simple-modal-iframe" width="100%" height="' + opt.height + '" frameborder="0"></iframe>',
		'model': 'modal'
	});
};
