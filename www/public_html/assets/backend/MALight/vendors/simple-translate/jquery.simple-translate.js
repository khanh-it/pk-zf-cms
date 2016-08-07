/**
 * jQuery: simple translator
 * @author Mr.Khanh
 */
(function($){
	//	Bien (cuc bo): dung luu tru du lieu ngon ngu.
	var _phrases = window.ITRANSLATE_PHRASES || {};
	
	//	Khoi tao: doi tuong ho tro chuyen doi ngon ngu.
	if (!$.simpleTranslate) {
		/**
		 * Chuyen doi tu ngu. 
		 * @param String txt
		 * @return String 
		 */
		$.simpleTranslate = function(phrase){
			return (phrase in _phrases) ? _phrases[phrase] : phrase;
		};
		
		/**
		 * Lay thong tin tu ngu chuyen doi. 
		 * @return Object
		 */
		$.simpleTranslate.getPhrases = function(){
			return _phrases;
		};
		/**
		 * Lay thong tin tu ngu chuyen doi. 
		 * @return void
		 */
		$.simpleTranslate.setPhrases = function(phrases){
			$.extend(_phrases, phrases);
		};
	}
})(jQuery);