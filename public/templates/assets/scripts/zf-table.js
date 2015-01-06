(function(jQuery) {

	jQuery.fn.zfTable = function(url, options) {

		var initialized = false;

		var defaults = {

			beforeSend : function() {
			},
			
			success : function() {
			},
			
			error : function() {
			},
			
			complete : function() {
			},

			onInit : function() {
			},
			
			sendAdditionalParams : function() {
				return '';
			}

		};

		var options = $.extend(defaults, options);

		function strip(html) {
			var tmp = document.createElement("DIV");
			tmp.innerHTML = html;
			return tmp.textContent || tmp.innerText || "";
		}

		function init($obj) {
			options.onInit();
			ajax($obj);
		}
		
		function loadPlugins()
		{
			App.init();
		}
		
		function ajax($obj) {
			$obj.find('.dataTables_processing').show();
			jQuery.ajax({
				url : url,
				data : $obj.find(':input').serialize() + options.sendAdditionalParams(),
				type : 'POST',
				beforeSend : function(e) {
					options.beforeSend(e);
				},
				success : function(data) {
					$obj.html('');
					$obj.html(data);
					initNavigation($obj);
					$obj.find('.dataTables_processing').hide();
					loadPlugins();
					options.success();
				},
				error : function(e) {
					options.error(e)
				},
				complete : function(e) {
					options.complete(e)
				},

				dataType : 'html'
			});

		}
		
		function initNavigation($obj) {

			$obj.find('table th.sortable').on('click', function(e) {
				$obj.find('input[name="zfTableColumn"]').val(jQuery(this).data('column'));
				$obj.find('input[name="zfTableOrder"]').val(jQuery(this).data('order'));
				ajax($obj);
			});
			
			$obj.find('.pagination').find('a').on('click', function(e) {
				$obj.find('input[name="zfTablePage"]').val(jQuery(this).data('page'));
				e.preventDefault();
				ajax($obj);
			});
			
			$obj.find('.itemPerPage').on('change', function(e) {
				$obj.find('input[name="zfTableItemPerPage"]').val(jQuery(this).val());
				ajax($obj);
			});
			
			$obj.find('input.filter').on('keypress', function(e) {
				if (e.which === 13) {
					e.preventDefault();
					ajax($obj);
				}
			});
			
			$obj.find('select.filter').on('change', function(e) {
				e.preventDefault();
				ajax($obj);
			});
			
			$obj.find('.quick-search').on('keypress', function(e) {
				if (e.which === 13) {
					e.preventDefault();
					$obj.find('input[name="zfTableQuickSearch"]').val(jQuery(this).val());
					ajax($obj);
				}
			});
			
			$obj.find('.export-csv').on('click', function(e) {
				exportToCSV(jQuery(this), $obj);
			});
		}
		
		function exportToCSV(link, $table) {
			var data = new Array();
			$table.find("tr.zf-title , tr.zf-data-row").each(function(i, el) {
				var row = new Array();
				$(this).find('th, td').each(function(j, el2) {
					row[j] = strip($(this).html());
				});
				data[i] = row;
			});
			console.log(data);
			var csvHeader = "data:application/csv;charset=utf-8,";
			var csvData = '';
			data.forEach(function(infoArray, index) {
				dataString = infoArray.join(";");
				csvData += dataString + '\r\n';

			});
			link.attr({
				'download' : 'export-table.csv',
				'href' : csvHeader + encodeURIComponent(csvData),
				'target' : '_blank'
			});
		}

		return this.each(function() {
			var $this = jQuery(this);
			if (!initialized) {
				init($this);
			}

		});
	};

})(jQuery);