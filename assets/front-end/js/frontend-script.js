(function($){
jQuery(document).ready(function(){

	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}

	// Form AJAX Submission
	jQuery(document).on('click', '.sf-form .submit-btn', function(e){
		e.preventDefault();

		let $this = jQuery(this);
		let formWrapper = jQuery(this).closest('.sf-form');

		let validForm = false;
		let fieldsInfo = {};

		formWrapper.find('.form_field').each(function(){
			let field = jQuery(this);
			let fieldVal = field.val();
			let fieldWrapper = jQuery(this).closest('.input-field');

			if(fieldVal == '') {
				validForm = false;
				fieldWrapper.find('.frm-invalid').remove();
				if(!fieldWrapper.find('.frm-error').length){
					jQuery('<span class="frm-error"></span>').insertAfter(field);
					fieldWrapper.find('.frm-error').html(emptyFieldMsg);
				}
			} else {
				if(!isEmail(fieldVal) && field.hasClass('email')) {
					validForm = false;
					if(!fieldWrapper.find('.frm-invalid').length){
						if(field.hasClass('frm-error')) {
							fieldWrapper.find('.frm-error').addClass('.frm-invalid').html(invalidEmailMsg);
						} else {
							fieldWrapper.find('.frm-error').remove();
							jQuery('<span class="frm-error frm-invalid"></span>').insertAfter(field);
							fieldWrapper.find('.frm-invalid').html(invalidEmailMsg);
						}
					}
				} else {
					fieldWrapper.find('.frm-error').remove();
					
					if(field.hasClass('first_name')) {
						fieldsInfo['fname'] = fieldVal;
					}
					if(field.hasClass('last_name')) {
						fieldsInfo['lname'] = fieldVal;
					}
					if(field.hasClass('email')) {
						fieldsInfo['email'] = fieldVal;
					}
					if(field.hasClass('subject')) {
						fieldsInfo['subject'] = fieldVal;
					}
					if(field.hasClass('message')) {
						fieldsInfo['message'] = fieldVal;
					}
				}
			}
		});

		if(jQuery(this).closest('.sf-form').find('.frm-error').length == 0) {
			validForm = true;
		}

		if(validForm) {

		    $.ajax({
				url: ajaxurl,
				type: 'post',
				dataType: 'json',
				data: {
					action 	: 'simple-form-entry-submission',
					fieldsInfo : fieldsInfo
				},
				beforeSend: function () {
				},
				success: function (data) {
					$this.closest('.sf-form-wrapper').html(data.success_msg);
				},
				error: function (errorThrown) {
					console.log(errorThrown);
				}
			});

		}

	});

    // Add a listener/callback for the pagination clicks.
	jQuery(document).on('click', '.sf_pagination a', function(e){
		e.preventDefault();

		let $this = jQuery(this);

	    var paged = /[\?&]sf_page=(\d+)/.test( this.href ) && RegExp.$1;
	    console.log(paged);

	    $.ajax({
			url: ajaxurl,
			type: 'post',
			dataType: 'json',
			data: {
				action 	: 'simple-form-entry-display',
				page : paged
			},
			beforeSend: function () {
			},
			success: function (data) {
				$this.closest('.sf-entry-table-box').find('tr:not(.sf-table-heading)').remove();
				jQuery(data.res).insertAfter( $this.closest('.sf-entry-table-box').find('tr.sf-table-heading') );

				$this.closest('.sf-entry-table-box').find('.sf_pagination').html(data.pagination_text);
			},
			error: function(xhr, ajaxOptions, thrownError) {
			  // For debugging, console log any errors. In production, do something different.
			  console.log(xhr.status);
			  console.log(thrownError);
			}
		});

	});

});
})(jQuery);