<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
	// jQuery.validator.addMethod(
	// 	"valid_price",
	// 	function(value, element) {
	// 		return new RegExp('[0-9]*\\.[0-9]{2}$').test(value);
	// 	},
	// 	"Please enter a valid dollar value"
	// );

	// add a validator function to check if an end date is on or after start date
	jQuery.validator.addMethod("afterDate", 
	function(value, element, params) {
		var startDate = $(params).val();

		if (!/Invalid|NaN/.test(new Date(value))) {
			return new Date(value) >= new Date(startDate);
		}

		return isNaN(value) && isNaN(startDate) 
			|| (Number(value) >= Number(startDate)); 
	},'Must come after Start Date.');

	// add a validator function to check if an end date is on or after start date
	jQuery.validator.addMethod("beforeDate", 
	function(value, element, params) {

		if (!/Invalid|NaN/.test(new Date(value))) {
			return new Date(value) < new Date();
		}

		return isNaN(value) || (Number(value)); 
	},'Must be in the past.');


	jQuery.validator.addMethod("afterTime", 
	function(value, element, params) {
		var startDate = $(params[0]).val()?$(params[0]).val().replaceAll('-',''):'',
			endDate = $(params[1]).val()?$(params[1]).val().replaceAll('-',''):'',
			startTime = $(params[2]).val()?$(params[2]).val().replace(':',''):'',
			endTime = value?value.replace(':',''):'';

		if(startDate === endDate && endTime < startTime){
			return false;
		}

		return true;
	},'Must come after Start Time.');

	// Setup our default properties for our validator
	jQuery.validator.setDefaults({ 
		ignore: [], // Validate hidden fields too
		// any other default options and/or rules
	});
</script>
