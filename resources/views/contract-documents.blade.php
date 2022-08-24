@extends('layout')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Documentos de contratos</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item">Contratos</li>
          <li class="breadcrumb-item active">Documentos</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<style>
	.title-h3 {
		position: relative;
		/*top: 2px;*/
		margin-left: 8px;
	}
	.mydocument {
		display: none;
	}

	.document-row:hover {
		background-color: #eee;
	}

	.pull-right {
		float: right;
	}
	.pull-right:after {
		content: "";
		clear: both;
	}

	.card-title {
		opacity: 1;
		transition: all 200ms;
	}

	.search-document {
		position: absolute;
		opacity: 0;
		transition: all 200ms;
		width: 0;

		/*width: calc(100% - 80px);*/
	}

	.input-large {
		width: calc(100% - 80px) !important;
	}

	.card-body {
		max-height: 253px;
		overflow: auto;
	}

  .table-hover tbody tr:hover {
    color: initial !important;
    font-weight: normal !important;
  }

  .btn {
    z-index: 2;
    position: relative;
  }

  table {
    width: 100% !important;
  }

  .becoming {
    color: lightgreen;
  }
</style>

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="1"> </label> <span class="title-h3"> Benbros Solar </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Documentos Benbros Solar...">

                <button class="btn btn-light btn-sm pull-right search-in">
            		<i class="fa fa-search"></i>
            	</button>

            	<button class="btn btn-light btn-sm pull-right search-out" style="display: none;">
            		<i class="fa fa-times"></i>
            	</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="docs-1">
              	@php $type = 1; @endphp
                @include('includes.contract-documents')

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="2"> </label> <span class="title-h3"> Benbros Energy </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Documentos Benbros Energy...">

                <button class="btn btn-light btn-sm pull-right search-in">
            		<i class="fa fa-search"></i>
            	</button>

            	<button class="btn btn-light btn-sm pull-right search-out" style="display: none;">
            		<i class="fa fa-times"></i>
            	</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="docs-2">
              	@php $type = 2; @endphp
                @include('includes.contract-documents')

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <!-- /.row -->

        <input type="file" id="excel_file" style="display: none"/>

        <div id="excel_data" class="mt-5 table-responsive"></div>
      </div>


@endsection

@section('scripts')

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script>

  $(function () {
   	$('.mydocument').change(function (e) {
   		e.preventDefault();

   		let type = $(this).data('type');
   		let fd = new FormData();

   		fd.append('document',$(this)[0].files[0]);
   		fd.append('_token','{{csrf_token()}}');
   		fd.append('type',type);

   		$.ajax({
   			url: '{{url('saveContractDocument')}}',
   			contentType: false,
   			processData: false,
   			type: 'POST',
   			data: fd,
   		})
   		.done(function(data) {
   			$('#docs-'+type).html(data);
   		})
   		.fail(function() {
   			console.log("error");
   		})
   		.always(function() {
   			console.log("complete");
   		});
   		
   	});

   	$('.search-in').click(function (e) {
   		e.preventDefault();

   		$(this).parent().find('.card-title').css('opacity', 0);
   		$(this).parent().find('.search-document').css('opacity',1);
   		$(this).parent().find('.search-document').addClass('input-large');
   		$(this).parent().find('.search-out').show();
   		$(this).hide();
   	});

   	$('.search-out').click(function (e) {
   		e.preventDefault();

   		$(this).parent().find('.card-title').css('opacity', 1);
   		$(this).parent().find('.search-document').css('opacity',0);
   		$(this).parent().find('.search-document').removeClass('input-large');
   		$(this).parent().find('.search-in').show();
   		$(this).hide();

   		$(this).parent().next().find('.document-row').show();
   	});
  });

  $('.search-document').on('keyup', function(event) {
  	event.preventDefault();

  	let name = $(this).val().toLowerCase();

  	$.each($(this).parent().next().find('.document-row'), function(index, val) {
  		// console.log($(this),$(this).data('name').indexOf(name));
  		if ($(this).data('name').toLowerCase().indexOf(name) >= 0) {
  			$(this).show();
  		}else{
  			$(this).hide();
  		}
  	});
  
  });
</script>

<script>

  async function loadDocument(url,___type)
  {
    let response = await fetch(url);
    let data = await response.blob();
    let metadata = {
      type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    };
    let file = new File([data], "file.xlsx", metadata);

    console.log(file);

    viewXLSX(file,___type);
  }

  function viewXLSX(file,___type)
  {
    const excel_file = file;

    /*excel_file.addEventListener('change', (event) => {
    });*/

      // if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(event.target.files[0].type))
      /*if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(file))
      {
          document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';

          // excel_file.value = '';

          return false;
      }*/

      var reader = new FileReader();

      reader.readAsArrayBuffer(file);

      reader.onload = function(event){

          var data = new Uint8Array(reader.result);

          var work_book = XLSX.read(data, {type:'array',cellText:false,cellDates:true});

          var sheet_name = work_book.SheetNames;

          var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1, defval:""});

          var becoming = null;
          var project = null;
          var project_name = null;

          var all_notifications = [];
          var footer;

          if(sheet_data.length > 0)
          {
              var table_output = '<table class="table table-striped table-bordered" id="example1">';

              for(var row = 0; row < sheet_data.length; row++)
              {
                  if (row == 0) {
                    footer = sheet_data[row];
                    table_output += '<thead>';
                    table_output += '<tr class="filters">';
                  }else{
                    table_output += '<tr>';
                  }

                  for(var cell = 0; cell < sheet_data[row].length; cell++)
                  {
                      if(row == 0)
                      {
                        if (typeof sheet_data[row][cell] != 'undefined' && sheet_data[row][cell].toLowerCase() == 'fecha devengo prima') {
                          becoming = cell;
                        }
                        if (typeof sheet_data[row][cell] != 'undefined' && sheet_data[row][cell].toLowerCase() == 'nombre proyecto') {
                          project = cell;
                        }
                        table_output += '<th>'+(typeof sheet_data[row][cell] != 'undefined' ? sheet_data[row][cell] : '')+'</th>';

                      }
                      else
                      {

                        if (cell == project) {
                          project_name = sheet_data[row][cell];
                        }

                        if (cell == becoming && typeof sheet_data[row][cell] == 'object') {
                            all_notifications.push({'end': moment(sheet_data[row][cell]).add(6,'weeks').format('Y-MM-DD'),
                              'duration': "6 semanas",
                              'type':___type,
                              'project': project_name})

                            all_notifications.push({'end': moment(sheet_data[row][cell]).add(2,'weeks').format('Y-MM-DD'),
                              'duration': "2 semanas",
                              'type':___type,
                              'project': project_name})

                            all_notifications.push({'end': moment(sheet_data[row][cell]).add(1,'day').format('Y-MM-DD'),
                              'duration': "dia anterior",
                              'type':___type,
                              'project': project_name})

                            all_notifications.push({'end': moment(sheet_data[row][cell]).format('Y-MM-DD'),
                              'duration': "mismo dia",
                              'type':___type,
                              'project': project_name})
                        }


                        table_output += '<td>'+

                        ((cell == becoming && typeof sheet_data[row][cell] == 'object') ? '<span data-toggle="popover" data-content="Se ha generado un automatismo para fecha devengo prima." class="becoming">' : '') +(typeof sheet_data[row][cell] != 'undefined' ?
                          
                          (typeof sheet_data[row][cell] == 'object' ? moment(sheet_data[row][cell]).format('DD-MM-Y') : sheet_data[row][cell])

                        : '')+ (cell == becoming && (typeof sheet_data[row][cell] == 'object') ? '</span>' : '') +'</td>';

                      }

                  }

                  if (row == 0) {
                    table_output += '</thead>';
                  }

                  table_output += '</tr>';

              }

              table_output += '<tfoot>';
              table_output += '<tr>';

              for(var cell = 0; cell < footer.length; cell++){
                table_output += '<th>'+(typeof footer[cell] != 'undefined' ? footer[cell] : '')+'</th>';
              }

              table_output += '</tr>';
              table_output += '</tfoot>';

              table_output += '</table>';

              document.getElementById('excel_data').innerHTML = table_output;

              $('[data-toggle="popover"]').popover();

              $.post('{{url('api/generateNotifications')}}', {'notifications': all_notifications}, function(data, textStatus, xhr) {
                
                console.log('generadas notifications')

                var notice = PNotify.success({
                      title: "Completado",
                      text: "Se han generado las notificaciones para Fecha Devengo Prima",
                      textTrusted: true,
                      modules: {
                        Buttons: {
                          closer: false,
                          sticker: false,
                        }
                      }
                    })
                notice.on('click', function() {
                  notice.close();
                });
              });

              initDatatable();

              setTimeout(()=>{
                $('.filters .inline-fields:first').trigger('keyup');
              },100);
          }

          excel_file.value = '';

      }
  }

  function initDatatable() 
  {
    $("#example1").DataTable({

      "ordering": false,
      "sorting": false,

      "pageLength" : 5,
      "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],

      "scrollX": true,

      "scrollCollapse": true,

      /*"fixedColumns": {
        left: 5
      },*/

        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    if ($(cell).hasClass('no-filter')) {
                      $(cell).addClass('sorting_disabled').html(title);
                    }else{
                      $(cell).addClass('sorting_disabled').html('<input type="text" class="inline-fields" placeholder="' + title + '" />');
                    }
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value

                            // console.log(val.replace(/<select[\s\S]*?<\/select>/,''));
                            let wSelect = false;
                            $.each(api.column(colIdx).data(), function(index, val) {
                               if (val.indexOf('<select') == -1) {
                                wSelect = false;
                               }else{
                                wSelect = true;
                               }
                            });

                            // $.each(api
                            //     .column(colIdx).data(), function(index, val) {
                            //     console.log(val)
                            // });

                            api
                                .column(colIdx)
                                .search(

                                  (wSelect ?
                                      (this.value != ''
                                        ? regexr.replace('{search}', '(((selected' + this.value + ')))')
                                        : '')
                                    :
                                      (this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '')),

                                    this.value != '',
                                    this.value == ''
                                ).draw()
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        }
    });
  }

</script>
@endsection