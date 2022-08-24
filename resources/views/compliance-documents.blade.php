@extends('layout')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('documents.compliance_documents')}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
          <li class="breadcrumb-item">{{trans('documents.contracts')}}</li>
          <li class="breadcrumb-item active">{{trans('documents.compliance')}}</li>
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
</style>

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="1"> </label> <span class="title-h3"> {{trans('documents.compliance')}} </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Documentos Cumplimiento...">

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
                @include('includes.compliance-documents')

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
   			url: '{{url('saveComplianceDocument')}}',
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

  async function loadDocument(url)
  {
    let response = await fetch(url);
    let data = await response.blob();
    let metadata = {
      type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    };
    let file = new File([data], "file.xlsx", metadata);

    console.log(file);

    viewXLSX(file);
  }

  function viewXLSX(file)
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

          var work_book = XLSX.read(data, {type:'array'});

          var sheet_name = work_book.SheetNames;

          var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});

          if(sheet_data.length > 0)
          {
              var table_output = '<table class="table table-striped table-bordered">';

              for(var row = 0; row < sheet_data.length; row++)
              {

                  table_output += '<tr>';

                  for(var cell = 0; cell < sheet_data[row].length; cell++)
                  {

                      if(row == 0)
                      {

                          table_output += '<th>'+(typeof sheet_data[row][cell] != 'undefined' ? sheet_data[row][cell] : '')+'</th>';

                      }
                      else
                      {

                          table_output += '<td>'+(typeof sheet_data[row][cell] != 'undefined' ? sheet_data[row][cell] : '')+'</td>';

                      }

                  }

                  table_output += '</tr>';

              }

              table_output += '</table>';

              document.getElementById('excel_data').innerHTML = table_output;
          }

          excel_file.value = '';

      }
  }

</script>
@endsection