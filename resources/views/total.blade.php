@extends('layout')

@section('content')

<style>
  .dataTable {
    width: 100% !important;
  }
</style>

<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('summary.summary')}} <img src="{{url('inf.png')}}" style="width: 20px;position: relative;top: -3px;" data-toggle="popover" data-content="En este apartado se visualiza el total de proyectos <b>aceptados</b> tras hacer el análisis de viabilidad técnica, ambiental y urbanística y cuyos terrenos han sido <b>firmados</b>." alt=""></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('summary.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('summary.summary')}}</li>
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
                <h3 class="card-title">{{trans('summary.datatable')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @php
                  $inputs = App\Models\Input::where('table','land')->where('summary',1)->orderBy('order','asc')->get()
                @endphp
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>{{trans('summary.partnet')}}</th>
                    <th>{{trans('summary.project')}}</th>
                    <th>{{trans('summary.set')}}</th>
                    <th>{{trans('summary.km_set')}}</th>
                    <th>{{trans('summary.mwp')}}</th>
                    <th>{{trans('summary.mwn')}}</th>
                    <th>{{trans('summary.tech')}}</th>
                    @foreach ($inputs as $inp)
                      <th>{{$inp->title}}</th>
                    @endforeach

                    {{-- <th>Options</th> --}}
                  </tr>
                  </thead>
                  <tbody>
                    @foreach (App\Models\Land::where('analisys_state',1)->where('contract_state',2)->get() as $l)
                      <tr data-id="{{$l->id}}" class="table-row">
                        <td>{{App\Models\Partner::find($l->partner_id) ? App\Models\Partner::find($l->partner_id)->name : ''}}</td>
                        <td>{{$l->name}}</td>
                        <td>{{$l->substation}}{{--  <span style="display: none">{{$l->substation}}</span> <input class="inline-fields main-fields" name="substation" type="text" value="{{$l->substation}}"> --}} </td>
                        <td>{{$l->substation_km}}{{--  <span style="display: none">{{$l->substation_km}}</span> <input class="inline-fields main-fields" name="substation_km" type="text" value="{{$l->substation_km}}"> --}} </td>
                        <td>{{$l->mwp}}</td>
                        <td>{{$l->mwn}}</td>
                        <td>
                          @switch($l->technology)
                              @case(1) FV @break
                              @case(2) Green Hydrogen @break
                              @case(3) Storage @break
                              @case(4) Hybrid @break
                          @endswitch
                        </td>
                        @foreach ($inputs as $inp)
                        <td>
                          @if ($inp->type == 'provinces')
                             {{$l->checkField($inp->id)}}
                          @endif
                          @if ($inp->type == 'text')
                             {{-- <input class="inline-fields extra-fields" name="{{$inp->id}}" type="text" value="{{$l->checkField($inp->id)}}"> --}}
                             {{$l->checkField($inp->id)}}
                          @endif

                          @if ($inp->type == 'number')
                             {{-- <input class="inline-fields extra-fields" name="{{$inp->id}}" type="number" value="{{$l->checkField($inp->id)}}"> --}}
                             {{$l->checkField($inp->id)}}
                          @endif

                          @if ($inp->type == 'select')
                             {{-- <select class="inline-fields extra-fields" name="{{$inp->id}}">
                              <option value="" selected disabled></option>
                              @foreach ($inp->options as $op)
                                <option {{$l->checkField($inp->id) == $op->option ? 'selected' : ''}}>{{$op->option}}</option>
                              @endforeach
                            </select> --}}
                            {{$l->checkField($inp->id)}}
                          @endif 

                          @if ($inp->type == 'document')
                             {{-- <input class="inline-fields extra-fields" name="{{$inp->id}}" type="file"> --}}
                             --
                          @endif 
                        </td>
                        @endforeach
                        {{-- <td>
                          <button class="btn btn-sm btn-success" onclick="saveRow('{{$l->id}}')">Save</button>
                          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$l->id}}">Delete</button>

                        </td> --}}
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Partner</th>
                    <th>Project</th>
                    <th>SET</th>
                    <th>KM Set</th>
                    <th>MWp</th>
                    <th>MWn</th>
                    <th>Technology</th>
                    @foreach ($inputs as $inp)
                      <th>{{$inp->title}}</th>
                    @endforeach

                    {{-- <th>Options</th> --}}
                  </tr>
                  </tfoot>
                </table>
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

@endsection

@section('scripts')

<script src="{{url('adminlte')}}/plugins/datatables/jquery.dataTables.min.js"></script>
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
<script src="{{url('adminlte')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $.each($('.content select'), function(index, val) {
    $(this)[0].selectedIndex = Math.floor(Math.random() * ($(this).find('option').length - 0) -1);
  });

  $(function () {
    /*$("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');*/
    $('#example2').DataTable({
      "scrollX": true, "scrollCollapse": true,
      "fixedColumns": {
        left: 3
      },
      // "ordering": false,
      // "sorting": false,
      orderCellsTop: true,
      fixedHeader: true,
      /*"paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,*/
    });
  });

  function saveRow(id)
  {
    var formData = new FormData();
    var extra = [];

    $.each($('.table-row[data-id="'+id+'"] .main-fields'), function(index, val) {
       formData.append($(this).attr('name'),$(this).val());
    });

    // $.each($('.table-row[data-id="'+id+'"] .extra-fields'), function(index, val) {
    //    extra.push({id:$(this).attr('name'),value:$(this).val()});
    // });

    // formData.append('extras',JSON.stringify(extra));
    formData.append('id',id);
    formData.append('_token','{{csrf_token()}}');

    $.ajax({
      url: '{{url('saveLand')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      console.log(data);

      var notice = PNotify.success({
            title: "Completado",
            text: "Se ha guardado el terreno correctamente",
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
</script>
@endsection