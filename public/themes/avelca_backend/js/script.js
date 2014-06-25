
$().ready(function(){

	/* Toogle Sidebar */
	$('#toggle_sidebar').click(function()
	{
		if($(this).attr('hide') == 'N')
		{
			$('.navbar-static-side').hide();
			$('#page-wrapper').css('margin','0');
			$('.table').width('100%');
			$(this).attr('hide','Y');
		}
		else
		{
			$('.navbar-static-side').show();
			$('#page-wrapper').css('margin','0 0 0 250px');	
			$(this).attr('hide','N');
		}	
	}
	);

	/* Select Picker */
	$('.selectpicker').each(function(){
		$(this).selectpicker({
			'liveSearch': true
		});
	});

	/* Page */
	$( "#new_button" ).click(function() {

		var btn_text = $(this).text().trim();

		if(btn_text == 'Create New')
		{
			$(this).html('<i class="fa fa-list fa-fw"></i> Back to List')
		}
		else
		{
			$(this).html('<i class="fa fa-plus fa-fw"></i> Create New');
		}

		$( "#list_page" ).toggle();
		$( "#create_page" ).toggle();

		var text = $('.page-header small').text();

		if(text == 'List')
		{
			$('.page-header small').text('Create');
		}
		else
		{
			$('.page-header small').text('List');
		}
	});

	/* Datepicker */
	$('.datepicker').each(function(){
		$(this).datetimepicker({
			pickTime: false,
			useCurrent: true
		});
	});

	/* Timepicker */
	$('.timepicker').each(function(){
		$(this).datetimepicker({
			pickDate: false,
			useCurrent: true,
			useSeconds: false
		});
	});

	/* DateTimePicker */
	$('.datetimepicker').each(function(){
		$(this).datetimepicker({
			useCurrent: true,
			sideBySide: true
		});
	});

	/* Toogle Filter */
	$( "#filter" ).click(function() {
		$( ".well" ).slideToggle('fast');
	});

	/* Sidemenu */
	$('#side-menu').metisMenu();

	$(window).bind("load", function() {
		console.log($(this).width())
		if ($(this).width() < 768) {
			$('div.sidebar-collapse').addClass('collapse')
		} else {
			$('div.sidebar-collapse').removeClass('collapse')
		}
	});

	$(window).bind("resize", function() {
		console.log($(this).width())
		if ($(this).width() < 768) {
			$('div.sidebar-collapse').addClass('collapse')
		} else {
			$('div.sidebar-collapse').removeClass('collapse')
		}
	});

	/* General Tabs */
	$('#tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	/* Colorpicker */
	$('#colorpicker').each(function(){
		$(this).colorpicker();
	});

	/* CKEditor */
	$('textarea#editor').each(function(){
		$(this).ckeditor();
	});

	$('textarea#basic_editor').each(function(){
		$(this).ckeditor({
			toolbar: [
			[ 'Source', '-', 'Bold', 'Italic', 'Underline', '-', 'Link', 'Unlink', '-', 'HorizontalRule']
			]
		});
	});

});
