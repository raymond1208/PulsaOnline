<script type="text/javascript">
$(document).ready(function(){

	$('.datatable').each(function(){
		$(this).dataTable({
			"sPaginationType": "bs_full",
			"sDom": 'lfrtip<"clear spacer">T',
			"oTableTools": {
				"sSwfPath": "<?php echo URL::to(Theme::asset('swf/copy_csv_xls_pdf.swf')); ?>",
				"aButtons": [
				{
					"sExtends": "print",
					"fnClick": function( nButton, oConfig ) {
						$('td#actionColumn,th#actionColumn').hide();
						$('tfoot').hide();
						$('.navbar-static-side').hide();
						$('#page-wrapper').css('margin','0');
						$('.table').width('100%');
						this.fnPrint( true, oConfig );
						window.print();
					},
					"fnComplete": function ( nButton, oConfig, oFlash, sFlash ) {
						alert( 'Press escape to go back after printing.' );
					}
				}
				]
			}

		}).columnFilter(
		{ 	
			"aoColumns": [
			<?php $x = 1; foreach($indexFields as $field => $structure): ?>

			<?php if($structure['type'] == 'datepicker'): ?>
			{ type: "date-range" , sSelector: '#<?php echo $field; ?>_filter' }
			<?php elseif($structure['type'] == 'number'): ?>
			{ type: "number-range" , sSelector: '#<?php echo $field; ?>_filter' }
			<?php else: ?>
			{ type: "select", sSelector: '#<?php echo $field; ?>_filter'  }
			<?php endif; ?>

			<?php
			if($x != count($indexFields) )
			{
				echo ',';
			}
			?>
			
			<?php $x++; endforeach; ?>
			]
		}
		);

		var search_input = $(this).closest('.dataTables_wrapper').find('div[id$=_filter] input');
		search_input.attr('placeholder', 'Search');
		search_input.addClass('form-control input-sm');

		var length_sel = $(this).closest('.dataTables_wrapper').find('div[id$=_length] select');
		length_sel.addClass('form-control input-sm');

	});

$.datepicker.regional[""].dateFormat = 'yy-mm-dd';
$.datepicker.setDefaults($.datepicker.regional['']);

$('span.filter_column.filter_number_range.form-control').attr('class','filter_column filter_number_range');

});
</script>