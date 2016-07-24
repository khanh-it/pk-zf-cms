
/**
 * jQuery: ho tro co ban tinh nang chuyen doi ngon ngu.
 * 
 * @author Mr.Khanh
 * @since *16.09.2013*
 */
(function($){
	//	Bien (cuc bo): dung luu tru du lieu ngon ngu.
	var _phrases = window.ITRANSLATE_PHRASES || {};
	
	//	Khoi tao: doi tuong ho tro chuyen doi ngon ngu.
	if (!$.iTranslate) {
		/**
		 * Chuyen doi tu ngu. 
		 * @param String txt
		 * @return String 
		 */
		$.iTranslate = function(phrase){
			return (phrase in _phrases) ? _phrases[phrase] : phrase;
		};
		
		/**
		 * Lay thong tin tu ngu chuyen doi. 
		 * @return Object
		 */
		$.iTranslate.getPhrases = function(){
			return _phrases;
		};
		/**
		 * Lay thong tin tu ngu chuyen doi. 
		 * @return void
		 */
		$.iTranslate.setPhrases = function(phrases){
			$.extend(_phrases, phrases);
		};
	}
})(jQuery);