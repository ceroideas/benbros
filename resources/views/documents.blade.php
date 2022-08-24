@extends('layout')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('documents.documents')}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
          <li class="breadcrumb-item">{{trans('documents.legal_structure')}}</li>
          <li class="breadcrumb-item active">{{trans('documents.documents')}}</li>
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

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" data-type="1"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="1"> </label> <span class="title-h3">{{trans('documents.types_1')}} </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Actas Consejos Administración...">

            	<button class="btn btn-light btn-sm pull-right search-in">
            		<i class="fa fa-search"></i>
            	</button>

            	<button class="btn btn-light btn-sm pull-right search-out" style="display: none;">
            		<i class="fa fa-times"></i>
            	</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="doc-1">
              	@php $type = 1; @endphp
                @include('includes.documents')

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" data-type="2"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="2"> </label> <span class="title-h3">{{trans('documents.types_2')}} </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Actas Juntas...">

                <button class="btn btn-light btn-sm pull-right search-in">
            		<i class="fa fa-search"></i>
            	</button>

            	<button class="btn btn-light btn-sm pull-right search-out" style="display: none;">
            		<i class="fa fa-times"></i>
            	</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="doc-2">
              	@php $type = 2; @endphp
                @include('includes.documents')

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" data-type="3"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="3"> </label> <span class="title-h3">{{trans('documents.types_3')}} </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Escrituras...">

                <button class="btn btn-light btn-sm pull-right search-in">
            		<i class="fa fa-search"></i>
            	</button>

            	<button class="btn btn-light btn-sm pull-right search-out" style="display: none;">
            		<i class="fa fa-times"></i>
            	</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="doc-3">
              	@php $type = 3; @endphp
                @include('includes.documents')

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" data-type="4"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="4"> </label> <span class="title-h3">{{trans('documents.types_4')}} </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Libros socios / Actas...">

                <button class="btn btn-light btn-sm pull-right search-in">
            		<i class="fa fa-search"></i>
            	</button>

            	<button class="btn btn-light btn-sm pull-right search-out" style="display: none;">
            		<i class="fa fa-times"></i>
            	</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="doc-4">
              	@php $type = 4; @endphp
                @include('includes.documents')

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" data-type="5"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="5"> </label> <span class="title-h3">{{trans('documents.types_5')}} </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Contratos Societarios...">

                <button class="btn btn-light btn-sm pull-right search-in">
            		<i class="fa fa-search"></i>
            	</button>

            	<button class="btn btn-light btn-sm pull-right search-out" style="display: none;">
            		<i class="fa fa-times"></i>
            	</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="doc-5">
              	@php $type = 5; @endphp
                @include('includes.documents')

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" data-type="6"><label class="btn btn-xs btn-info" style="width: 30px;"> + <input type="file" class="mydocument" data-type="6"> </label> <span class="title-h3">{{trans('documents.types_6')}} </span> </h3>

                <input type="text" class="form-control form-control-sm search-document" placeholder="Buscar en Otros...">

                <button class="btn btn-light btn-sm pull-right search-in">
            		<i class="fa fa-search"></i>
            	</button>

            	<button class="btn btn-light btn-sm pull-right search-out" style="display: none;">
            		<i class="fa fa-times"></i>
            	</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="doc-6">
              	@php $type = 6; @endphp
                @include('includes.documents')

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

@endsection

@section('scripts')

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
   			url: '{{url('saveDocument')}}',
   			contentType: false,
   			processData: false,
   			type: 'POST',
   			data: fd,
   		})
   		.done(function(data) {
   			$('#doc-'+type).html(data);
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
@endsection