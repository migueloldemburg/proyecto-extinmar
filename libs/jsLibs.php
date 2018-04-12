<?php 
	if(!isset($ruta)){
		$ruta = "";
	}
?>
<script src="<?php echo $ruta ?>libs/jquery-2.2.4/jquery-2.2.4.js"></script>
<script src="<?php echo $ruta ?>libs/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo $ruta ?>libs/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo $ruta ?>libs/maskMoney/jquery.maskMoney.min.js"></script>
<script src="<?php echo $ruta ?>libs/phoneMask/phoneMask.js"></script>
<script src="<?php echo $ruta ?>libs/alertifyjs/alertify.min.js"></script>
<script src="<?php echo $ruta ?>js/functions.js?1.0.0"></script>
<script src="<?php echo $ruta ?>js/modals.js?1.0.0"></script>

<!-- //override defaults -->

<script type="text/javascript">
alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";
</script>

<script>
	function isNumber(text) {
		var nav4 = window.Event ? true : false;
		var key = nav4 ? text.which : text.keyCode;
		return (key == 8 || key == 127 || key == 0 || key == 13 ||  (key >= 48 && key <= 57));
	}
	function isDecimal(text) {
		var nav4 = window.Event ? true : false;
	    var key = nav4 ? text.which : text.keyCode;
	    return (key == 8 || key == 127 || key == 0 || key == 13 || key == 46 ||  (key >= 48 && key <= 57));
	}
	//validación de solo texto
	function isLetter(text) {
		var nav4 = window.Event ? true : false;
		var key = nav4 ? text.which : text.keyCode;
		return (key == 8 || key == 127 || key == 0 || key == 13 || (key >= 97 && key <= 122) 
				|| (key >= 65 && key <= 90) || key == 32 || key == 160 || key == 181 
				|| key == 130 || key == 144 || key == 161 || key == 214 || key == 162 || key == 224
				|| key == 163 || key == 233 || key == 164 || key == 165 || key == 239 || key == 225 
				|| key == 233 || key == 237 || key == 243 || key == 250 || key == 241 || key == 209);
	}
	function number_format(number, decimals, dec_point, thousands_sep) {
	    // Strip all characters but numerical ones.
	    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	    var n = !isFinite(+number) ? 0 : +number,
	    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    s = '',
	    toFixedFix = function (n, prec) {
	    	var k = Math.pow(10, prec);
	    	return '' + Math.round(n * k) / k;
	    };
	    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	    if (s[0].length > 3) {
	    	s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	    }
	    if ((s[1] || '').length < prec) {
	    	s[1] = s[1] || '';
	    	s[1] += new Array(prec - s[1].length + 1).join('0');
	    }
	    return s.join(dec);
	}
</script>