@extends('layout')

@section('content')

{{-- <link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('projects.projects')}} <img src="{{url('inf.png')}}" style="width: 20px;position: relative;top: -3px;" data-toggle="popover" data-content="En este apartado se visualiza el avance en el desarrollo de los proyectos aceptados y firmados. Se indica el tipo de tramitación a seguir según se solicite <b>Acceso y Conexión (AyC)</b> directamente a la distribuidora/REE o bien se presente el proyecto a un <b>concurso de capacidad</b>. Para ver el detalle de desarrollo, haga click en el nombre del proyecto." alt=""></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('projects.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('projects.projects')}}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('projects.develop')}}</h3>

                <a href="{{url('projects-report')}}" class="btn btn-xs btn-info" style="position: relative; float: right;">{{trans('projects.generate_report')}}</a>
              </div>
              <!-- /.card-header -->
              @php
                $sections = App\Models\Section::orderBy('id','asc')->get();
              @endphp
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example2" class="table table-bordered table-striped table-hover" style="width: 100%;">
                    <thead>
                      <tr>
                        <th colspan="4">
                          
                        </th>
                        @foreach ($sections as $key => $sect)
                          @if ($sect->inputs->count())
                          <th colspan="{{ $key == 0 ? $sect->inputs->count()+1 : $sect->inputs->count() }}">
                            {{$sect->name}}
                          </th>
                          @endif
                        @endforeach
                        <th></th>
                      </tr>
                    {{-- </thead>
                    <thead> --}}
                    <tr>
                      <th style="min-width: 150px;">{{trans('projects.project')}}</th>
                      <th>{{trans('projects.tech')}}</th>
                      <th>{{trans('projects.processing_type')}}</th>
                      <th>{{trans('projects.financial_model')}}</th>
                      <th>{{trans('projects.prev_proposal')}}</th>
                      @foreach ($sections as $sect)
                        @foreach ($sect->inputs as $inp)
                          <th>{{$inp->title}}</th>
                        @endforeach
                      @endforeach
                      <th>{{trans('projects.options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                      @include('includes.projects')
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>{{trans('projects.project')}}</th>
                      <th>{{trans('projects.tech')}}</th>
                      <th>{{trans('projects.processing_type')}}</th>
                      <th>{{trans('projects.financial_model')}}</th>
                      <th>{{trans('projects.prev_proposal')}}</th>
                      @foreach ($sections as $sect)
                        @foreach ($sect->inputs as $inp)
                          <th>{{$inp->title}}</th>
                        @endforeach
                      @endforeach
                      <th>{{trans('projects.options')}}</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>

                <br>

                <button class="btn btn-primary" data-toggle="modal" data-target="#builder-2">{{trans('projects.add_new_proj')}}</button>
                <button class="btn btn-success" data-toggle="modal" data-target="#builder-1" style="margin-left: 4px;">{{trans('projects.add_new_column')}}</button>
                <button class="btn btn-danger" style="margin-left: 4px;">{{trans('projects.delete_column')}}</button>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

    @include('permissions.builder')

@endsection

@section('scripts')

{{-- <script src="{{url('adminlte')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{url('adminlte')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{url('adminlte')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{url('adminlte')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}

<script>
  $(function () {

    $('#example2').DataTable({
      "scrollX": true,
      "fixedColumns": {
        left: 3
      },
    });
  });

  function saveRow(id)
  {
    console.log('hola')
    var formData = new FormData();
    var extra = [];

    $.each($('.table-row[data-id="'+id+'"] .main-fields'), function(index, val) {
       formData.append($(this).attr('name'),$(this).val());
    });

    $.each($('.table-row[data-id="'+id+'"] .extra-fields'), function(index, val) {
       extra.push({id:$(this).attr('name'),value:$(this).val()});
    });

    formData.append('extras',JSON.stringify(extra));
    formData.append('id',id);
    formData.append('_token','{{csrf_token()}}');

    $.ajax({
      url: '{{url('saveLandPermission')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      console.log(data);

      // var notice = PNotify.success({
      //       title: "Completado",
      //       text: "Se ha guardado el proyecto correctamente",
      //       textTrusted: true,
      //       modules: {
      //         Buttons: {
      //           closer: false,
      //           sticker: false,
      //         }
      //       }
      //     })
      // notice.on('click', function() {
      //   notice.close();
      // });
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    


  }

  $(function () {
    $('[data-toggle="popover"]').popover({
      html: true,
      container: 'body'
    })
  })



  /**/


  function uploadFile(t)
  {
    let id = $(t).data('id');
    let type = $(t).data('type');
    let action = $(t).data('action');

    let file = $('#file-'+type+id)[0].files;

    if (file.length == 0) {
      return false;
    }

    let formData = new FormData();
    formData.append('id',id);
    formData.append('type',type);
    formData.append('_token','{{csrf_token()}}');
    formData.append('file',file[0]);

    $.ajax({
      url: action,
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      console.log("success");
      location.reload();
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    
    console.log(id,action,img);
  }
</script>
@endsection