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
                $inputs = App\Models\Input::where('table','land')->where('development',1)->orderBy('order','asc')->get();
              @endphp
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example2" class="table table-bordered table-striped table-hover" style="width: 100%;">
                    <thead>
                      <tr>
                        <th colspan="{{$inputs->count()+3}}">
                          
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
                    <tr class="filters">
                      <th style="min-width: 150px;">{{trans('projects.project')}}</th>
                      <th>{{trans('projects.tech')}}</th>
                      {{-- <th>{{trans('projects.processing_type')}}</th> --}}

                      @foreach ($inputs as $inp)
                        <th>{{$inp->title}}</th>
                      @endforeach

                      <th>{{trans('projects.financial_model')}}</th>
                      <th>{{trans('projects.prev_proposal')}}</th>
                      @foreach ($sections as $sect)
                        @foreach ($sect->inputs as $inp)
                          <th>{{$inp->title}}</th>
                        @endforeach
                      @endforeach
                      <th class="no-filter">{{trans('projects.options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                      @include('includes.projects')
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>{{trans('projects.project')}}</th>
                      <th>{{trans('projects.tech')}}</th>
                      {{-- <th>{{trans('projects.processing_type')}}</th> --}}

                      @foreach ($inputs as $inp)
                        <th>{{$inp->title}} hola</th>
                      @endforeach

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
                <button class="btn btn-danger" data-toggle="modal" data-target="#builder-3" style="margin-left: 4px;">{{trans('lands.delete_column')}}</button>

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
      "ordering": false,
      "sorting": false,
      "fixedColumns": {
        left: 3
      },
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
                      $(cell).addClass('sorting_disabled').html(`<label style="font-size: 12px;">${title}</label> <br> <input type="text" class="inline-fields" />`);
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
  });

  setTimeout(()=>{
    $('.filters .inline-fields:first').trigger('keyup');
  },100);

  function saveRow(id)
  {
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
  }

  function uploadFile2(t)
  {
    let input_id = $(t).data('input_id');
    let id = $(t).data('id');
    let action = $(t).data('action');

    console.log($(t),input_id,id,action);

    let file = $('#file-'+id+'-'+input_id)[0].files;

    if (file.length == 0) {
      return false;
    }

    let formData = new FormData();
    formData.append('id',id);
    formData.append('input_id',input_id);
    formData.append('_token','{{csrf_token()}}');
    formData.append('document',file[0]);

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
  }
</script>
@endsection