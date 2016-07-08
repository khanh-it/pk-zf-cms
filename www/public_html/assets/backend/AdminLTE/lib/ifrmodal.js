/**
 * jQuery bootstrap addon iframe modal.
 * @author Mr.Khanh
 * @since *26.11.2013*
 * @version 1.0.0
 * @copyright: (c)copyleft.
 */
(function($){
	// 	Kiem tra xem da co thu vien modal cua bootstrap?
	if ($.fn.modal) {
		// 	Bien: dung luu tru cau html (template) tao dialog.
		var modalTmpl_Dialog 	= '<div class="modal-dialog">'
				+ '<div class="modal-content">'
					+ '<div class="modal-header" style="padding: 4px 10px;">'
						+ '<button type="button" class="close" data-dismiss="modal"></button>'
						+ '<h5 class="modal-title"></h5>'
					+ '</div>'
					+ '<div class="modal-body" style="padding:0;overflow:auto;-webkit-overflow-scrolling:touch;background:url(data:image/gif;base64,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) no-repeat scroll center center transparent;"></div>'
					+ '<div class="modal-footer" style="margin: 0; padding: 4px 10px;">'
						+ ' <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal"></button>' 
					+ '</div>'
				+ '</div>' // <!-- /.content -->
			+ '</div>'; // <!-- /.dialog -->

		// 	 Bien: dung luu doi tuong dialog (modal).
		var ifrmodal 			= $('<div id="ifrmodal" class="modal fade" role="dialog" aria-hidden="true"></div>')
			//	Tao noi dung cho dialog.
			.html(modalTmpl_Dialog)
		;
		// 	Bien: dung luu doi tuong dialog.
		var ifrmodal_Dialog 	= ifrmodal.find('div.modal-dialog').eq(0);
		// 	Bien: dung luu doi tuong header cua dialog.
		var ifrmodal_Header 	= ifrmodal_Dialog.find('div.modal-header').eq(0);
		//	Bien: dung luu doi tuong body cua dialog.
		var ifrmodal_Body 		= ifrmodal_Dialog.find('div.modal-body').eq(0);
		// 	Bien dung luu doi tuong footer cua dialog.
		var ifrmodal_Footer 	= ifrmodal_Dialog.find('div.modal-footer').eq(0);
		var button = $('<button class="btn btn-xs btn-primary" type="button">Default</button>');
		// 	Bien: dung luu element iframe.
		var modalIframe = $('<iframe></iframe>')
			//	Khoi tao: attributes cho iframe.
			.attr({frameborder: 0, width: '100%', height: '100%', allowTransparency: 'true'})
			//	Khoi tao: classes cho iframe.
			.css({border: 'none 0', width: '100%', height: '99%', display: 'none'})
			// 	Dua iframe vao dialog.
			.appendTo(ifrmodal_Body)
		;
		
		// 	Khoi tao ham, xu ly.
		$.ifrmodal = $.ifrmodal || function(option){
			// 	Replace tham so truyen vao (neu co) voi tham so mac dinh.
			option = $.extend({
				//////////////////
				// 	Inline CSS: //
				//////////////////
				css: {zIndex:'2345'},
				//////////////////
				// 	Options: 	//
				//////////////////
				//  [+] Chieu rong, chieu cao cua dialog.
				width: '', height: 400,
				//  [+] Tieu de cua dialog.
				title: '&nbsp;',
				//  [+] Bieu tuong nut dong dialog.
				clsSymbol: '&times;',
				//  [+] Text dung hien thi nut 'close' duoi footer cua dialog.
				clsText: '<span class="glyphicon glyphicon-remove"></span>',
				//	[+] Duong link (src) den trang ma iframe se hien thi.
				src: '',
				'buttons': null,
				//	[+] An giao dien?
				hideLayoutComponents: false,
				//////////////
				//	Events: //
				//////////////
				// 	--- Su kien se duoc goi truoc khi hien thi dialog.
				show: null,
				// 	--- Su kien se duoc goi sau khi hien thi dialog.
				shown: null,
				// 	--- Su kien se duoc goi truoc khi an dialog.
				hide: null,
				// 	--- Su kien se duoc goi sau khi an dialog.
				hidden: null
			}, option);
			
			// 	Khoi tao modal.
			ifrmodal.removeAttr('style').css(option.css).modal({backdrop: 'static', show: false});
			
			// 	XL: set tham so len dialog dua vao du lieu nhan duoc.
			// 	--- Chieu rong, chieu cao.
			ifrmodal_Dialog.css({width: option.width});
			ifrmodal_Body.css({height: option.height});
			// 	--- --- Bien co: dung de kiem tra xem gia tri truyen vao co phai cao '%'.
			var isOptHeightPercent = false;
			if (option.height) {
				isOptHeightPercent = (option.height.toString().indexOf('%') >= 0);
			}
			
			// 	--- Tieu de,
			ifrmodal_Header.find('h5').html(option.title)
			// 	--- Nut dong dialog tren tieu de.
			var jHeaderDismissBtn = ifrmodal_Header.find('button[data-dismiss="modal"]').hide();
			if (option.clsSymbol) {
				jHeaderDismissBtn.html(option.clsSymbol).show();
			}
			// 	--- Nut dong dialog ben duoi.
			var jFooterDismissBtn = ifrmodal_Footer.find('button[data-dismiss="modal"]').hide();
			if (option.clsText) {
				jFooterDismissBtn.html(option.clsText).show();
			}
			
			// 	XL: hien thi thong tin trong iframe.
			//	--- Ham: dung de dang ky cho su kien load cua iframe.
			modalIframe
				// 	Dang ky ham vao su kien load cua iframe. 
				.off('load').bind('load', function(evt){
					// 	Get document.
					var self = this, win = self.contentWindow;
					//	An iframe truoc khi dong window cua iframe.
					$(win).on('beforeunload', function(evt){
						$(self).css('display', 'none'); 
					});
					// 	An layout.
					if (option.hideLayoutComponents 
							&& (typeof(win.hideLayoutComponents) == 'function')
					) {
						win.hideLayoutComponents(option.hideLayoutComponents);
					}
					// 	--- Cho hien thi iframe.	
					$(this).css('display', '');
				})
				// 	Set duong dan den trang can load vao iframe.
				.attr('src', option.src)
			;
			
			// 	XL: hien thi dialog.
			ifrmodal
				//	--- Bind events.
				// 	--- --- Truoc khi hien thi dialog.
				.unbind('show.bs.modal').on('show.bs.modal', function(){
					//	Khoi tao danh sach button
					if( option.buttons ){
						$.each( option.buttons, function(key, val){
							/**
							 * Val:
							 *   + text: Ten button
							 *   + handler: Su kien khi click vao button
							 *   + attr: {style:'abc;def', title: 'abc', data-customer: 'abc',...}
							 */
							//	Tao button
							if(val){
								//	Copy button mau
								var cloneBtn = button.clone();
								cloneBtn.text(val.text);
								//	Dang ky su kien
								if( typeof(val.click) != ''){
									var eventClick = 'var event = ' + val.click;
									eval(eventClick);
									if( typeof(event) == 'function')
										cloneBtn.unbind("click tap").bind("click tap", function(){	
											event.apply(cloneBtn);
										});
								}
								//	attribute
								if( val.attr && typeof(val.attr) == 'object' ){
									// add them class
									if(val.attr.class){
										var bClass = val.attr.class;
										delete val.attr.class;
										cloneBtn.addClass(bClass);
									}
									// 
									cloneBtn.attr(val.attr);
								}
								//	Dua vao modal
								ifrmodal_Footer.prepend(cloneBtn);
							}
						});
					}
					// 	Fire registered show event.
					if (typeof(option.show) == 'function') { option.show.apply(ifrmodal); }
				})
				// 	--- --- Sau khi hien thi dialog.
				.unbind('shown.bs.modal').on('shown.bs.modal', function(){
					// 	Xu ly: chieu cao 100%.
					if (isOptHeightPercent) {
						var winHeight 		= $(window).height() - 4,
							iDialogHeight 	= parseInt((parseFloat(option.height) / 100) * winHeight),
							iDialogPadTop 	= Math.abs(parseInt((winHeight - iDialogHeight) / 2))
							iBodyHeight 	= iDialogHeight 
								- ifrmodal_Header.outerHeight() 
								- ifrmodal_Footer.outerHeight()
						;
						// 	Dinh chieu cao cho dialog element.
						ifrmodal_Dialog.css({
							'padding-top': iDialogPadTop, 
							'padding-bottom': 0,
							margin: '0 auto',
							height: iDialogHeight
						});
						// 	Dinh chieu cho content ben trong -> hien thi.
						ifrmodal_Body.animate({height: iBodyHeight}, 'fast');
					}
					// 	Fire registered shown event.
					if (typeof(option.shown) == 'function') { option.shown.apply(ifrmodal); }
				})
				// 	--- --- Truoc khi an dialog.
				.unbind('hide.bs.modal')
				.on('hide.bs.modal', function(){
					// 	Fire registered hide event.
					if (typeof(option.hide) == 'function') { option.hide.apply(ifrmodal); }
				})
				// 	--- --- Sau khi an dialog.
				.unbind('hidden.bs.modal')
				.on('hidden.bs.modal', function(){
					// 	Xu ly: chieu cao 100%.
					if (isOptHeightPercent) {
						// 	Dinh chieu cao cho dialog element.
						ifrmodal_Dialog.css({'padding-top': '', 'padding-bottom': '', height: ''});
					} 	
					//	An iframe.
					modalIframe.css('display', 'none');
					//  Empty du lieu.
					ifrmodal_Footer.find("button").not(jFooterDismissBtn).remove();
					// 	Fire registered hide event. 	 	
					if (typeof(option.hidden) == 'function') { option.hidden.apply(ifrmodal); }
				})
				// --- Show dialog.
				.modal('show')
			;
			// Return;
			return ifrmodal;
		}
		
		/**
		 * Thu vien: ho tro hien thi dialog cho them nhanh du lieu.
		 * @author Mr.Khanh
		 * @since *01.12.2013*
		 */
		$(function(){
			// 	Khoi tao parser.
			$(document.body).on('click', 'a[data-qi-src], span[data-qi-src]', function(evt){
				//	Bien: dung luu lai tham chieu den element goi dialog. 
				var self 		= this,
					selectEle 	= $(this).parent().find('select:last'),
					selectEle 	= (!selectEle.size() 
						? $(this).parent().parent().find('select:last') : selectEle),
					selectEle 	= selectEle ? selectEle : false 
				;
				
				// 	Khoi tao ham, ho tro nhan gia tri tra ve (neu co) tu iframe tren dialog.
				window.QIRespone = function(data) {
					// 	Fire su kien `QIRespone` tren element.  
					$(self).trigger('QIRespone', [data]);
					//	Self destroy.
					window.QIRespone = undefined;
				}
				
				// 	XL: tao dialog, nhan tham so -> cho hien thi.
				var dataQIOption = $.trim($(self).attr('data-qi-option'));
				if (dataQIOption) {
					try {
						dataQIOption = eval('(' + dataQIOption + ');');	
					} catch (e) {
						if (console) console.log(e.message);
					}
				}
				var ifrmodalOpts = $.extend(dataQIOption, {
					// 	URL den trang them nhanh du lieu.
					src: $(self).attr('data-qi-src')
				});
				// 	Ho tro: bat su kien an dialog -> lay du lieu tu checkbox
				//	dua vao select.
				if (selectEle && !ifrmodalOpts.hidden) {
					ifrmodalOpts.hidden = function(){
						//	Chi thuc hien neu co ton tai select element.
						if (selectEle) {
							var iframeE = $('iframe', this).get(0),
								// 	Document element cua iframe;
								docE = (iframeE.contentWindow && iframeE.contentWindow.document) || iframeE.contentDocument,
								// 	Tim tat cac checkbox dang co trong iframe co name = 'id[]';
								// 	Vi hien tai tren phan mem dang thong nhat theo cach nay.
								jCkbIdArr = $('input[type="checkbox"][name^="id"]:checked', docE.body).not(':disabled')
							;
							// 	Kiem tra du lieu tra ve.
							try {
								// 	Do du lieu vao select.
								if (jCkbIdArr.size()) {
									var dataQiOpts = {};
									// 	XL: tao moi cac option -> mac dinh chon 1 gia tri tren du lieu da dua vao.
									jCkbIdArr.each(function(index){
										var value = $(this).attr('data-qi-value'),
											label = dataQiOpts[value] = $(this).attr('data-qi-label')
										;
										selectEle.append(
											$('<option></option>').val(value).text(label)
										).val(value);
									});
									// 	Tinh nang bo sung: kiem tra neu select co su dung plugin combobox -> sync du lieu.
									if (selectEle.is(":data('ui-combobox')")) {
										selectEle.parent().find('input[type="text"]').trigger("sync");
									}
									// 	Trigger su kien (custom event).
									selectEle.trigger('data-qi-onchange', [dataQiOpts]);
								}
							} catch (e) {
								if (console) console.log(e.message);
							}
						}
					}
				}
				// 	Hien thi dialog.
				$.ifrmodal(ifrmodalOpts);
				
				//	Prevent default.
				evt.preventDefault();
			});
		});
	}
})(jQuery);