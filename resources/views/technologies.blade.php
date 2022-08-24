@extends('layout')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('layout.technologies')}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('layout.technologies')}}</li>
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
		/*max-height: 253px;*/
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

<div class="content">
	
	<div class="row">
		
		<div class="col-3">
			
		@if (isset($tech))
		  <form action="{{url('update-technology')}}" method="POST" enctype="multipart/form-data">
		    <input type="hidden" name="id" value="{{$tech->id}}">
		@else
		  <form action="{{url('save-technology')}}" method="POST" enctype="multipart/form-data">
		@endif
		  {{csrf_field()}}
		      <div class="container-fluid">
		        <div class="row">


		          <div class="col-12">
		            <div class="card">
		              <div class="card-header">
		                <h3 class="card-title">{{trans('layout.form_technologies')}}</h3>
		              </div>
		              <div class="card-body" style="max-height: unset !important;">

		                <div class="row">

		                  <div class="col-12">
		                    <div class="form-group">
		                      <label>{{trans('layout.name')}}</label>
		                      <input type="text" class="form-control" name="name" value="{{ isset($tech) ? $tech->name : '' }}">
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <label>{{trans('layout.name_en')}}</label>
		                      <input type="text" class="form-control" name="name_en" value="{{ isset($tech) ? $tech->name_en : '' }}">
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <label>{{trans('layout.icon')}}</label>
		                      <input type="file" class="form-control" name="icon">
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <label>{{trans('layout.map_marker')}}</label>
		                      <input type="file" class="form-control" name="map_marker">
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <label>{{trans('layout.report_color')}}</label>
		                      <input type="text" class="form-control" name="report_color" value="{{ isset($tech) ? $tech->report_color : '' }}">
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <div class="checkbox">
		                      	<input type="checkbox" name="n_project" {{ isset($tech) ? ($tech->n_project == 1 ? 'checked' : '') : '' }}>
		                      	<label>{{trans('layout.n_project')}}</label>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <div class="checkbox">
		                      	<input type="checkbox" name="n_mwn" {{ isset($tech) ? ($tech->n_mwn == 1 ? 'checked' : '') : '' }}>
		                      	<label>{{trans('layout.n_mwn')}}</label>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <div class="checkbox">
		                      	<input type="checkbox" name="n_mwp" {{ isset($tech) ? ($tech->n_mwp == 1 ? 'checked' : '') : '' }}>
		                      	<label>{{trans('layout.n_mwp')}}</label>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <div class="checkbox">
		                      	<input type="checkbox" name="tenders" {{ isset($tech) ? ($tech->tenders == 1 ? 'checked' : '') : '' }}>
		                      	<label>{{trans('layout.tenders')}}</label>
		                      </div>
		                    </div>
		                  </div>

		                  <div class="col-12">
		                    <div class="form-group">
		                      <div class="checkbox">
		                      	<input type="checkbox" name="ac_req" {{ isset($tech) ? ($tech->ac_req == 1 ? 'checked' : '') : '' }}>
		                      	<label>{{trans('layout.ac_req')}}</label>
		                      </div>
		                    </div>
		                  </div>

		                </div>
		                

		              </div>
		            </div>
		          </div>

		        </div>
		        <!-- /.row -->

		        <button class="btn btn-success" style="margin-left: 4px;">{{trans('layout.save')}}</button>
		      </div>
		      <!-- /.container-fluid -->
		    </form>
		</div>

		<div class="col-9">

			<div class="card">
				<div class="card-header">
					<h3 class="card-title"></h3>
				</div>

				<div class="card-body">
					
                	<table id="example2" class="table table-bordered table-hover">
                		<thead>
                			<th>ID</th>
                			<th>Nombre</th>
                			<th>Icono</th>
                			<th>Marcador</th>
                			<th>Color Reporte</th>
                			<th></th>
                		</thead>

                		<tbody>
                			@foreach ($technologies as $t)
                				<tr>
                					<td>{{$t->id}}</td>
                					<td>{{$t->name}}</td>
                					<td><img src="{{$t->icon}}" style="height: 40px;" alt=""></td>
                					<td><img src="{{$t->map_marker}}" style="height: 40px;" alt=""></td>
                					<td><div style="width: 30px; height: 30px; background-color: {{$t->report_color}};"></div></td>
                					<td>
                						<a class="btn btn-sm btn-info" href="{{url('technologies',$t->id)}}">{{trans('layout.edit')}}</a>
                						<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-contact-{{$t->id}}">{{trans('layout.delete')}}</button>
								    </td>
								  </tr>

								  <div class="modal fade" id="delete-contact-{{$t->id}}">
								    <div class="modal-dialog">
								      <div class="modal-content">
								        <div class="modal-header">{{trans('layout.delete_prompt')}}</div>
								        <div class="modal-footer">
								          <a href="{{url('delete-technology',$t->id)}}" class="btn btn-sm btn-success">{{trans('layout.delete_confirm')}}</a>
								          <button class="btn btn-sm btn-warning" data-dismiss="modal">{{trans('layout.delete_cancel')}}</button>
								        </div>
								      </div>
								    </div>
								  </div>
                			@endforeach
                		</tbody>
                	</table>

				</div>
			</div>
			
		</div>

	</div>
</div>


@endsection

@section('scripts')

@endsection