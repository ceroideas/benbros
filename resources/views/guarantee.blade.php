@extends('layout')

@section('content')

{{-- <link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}

<style>
  .dataTable {
    width: 100% !important;
  }
</style>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('guarantee.guarantee')}} <img src="{{url('inf.png')}}" style="width: 20px;position: relative;top: -3px;" data-toggle="popover" data-content="En este apartado se visualiza el estado de los avales emitidos para solicitar acceso y conexión. Para añadir o modificar un estado en el desplegable, pulse en la pestaña “status”. Para descargar la tabla en .excel o .pdf pulse en “Generate report”." alt=""></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('layout.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('guarantee.guarantee')}}</li>
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
                <h3 class="card-title"></h3>

                <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#statuses" style="position: relative; float: right; margin-left: 8px">{{trans('guarantee.status')}}</button>

                {{-- <button class="btn btn-xs btn-info" style="position: relative; float: right;">Generate Report</button> --}}

                <form action="{{url('uploadExcel2')}}" method="POST" enctype="multipart/form-data" style="float: right;">
                  {{csrf_field()}}
                  <label style="margin-right: 8px" class="btn btn-warning btn-xs" data-target="#delete-guarantee" data-toggle="modal">{{trans('guarantee.clear_table')}}</label>
                  <label class="btn btn-success btn-xs">{{trans('guarantee.import')}}<input type="file" name="file" style="display: none;"></label>
                </form>
                <div style="clear: both;"></div>

              </div>
              <!-- /.card-header -->
              @php
                $inputs = App\Models\Input::where('table','land')->where('guarantee',1)->orderBy('order','asc')->get();
              @endphp
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr class="filters">
                    <th>{{trans('guarantee.type')}}</th>
                    <th>{{trans('guarantee.project')}}</th>

                    @foreach ($inputs as $inp)
                      <th>{{$inp->title}}</th>
                    @endforeach
                    <th>{{trans('guarantee.guarantee_status')}}</th>
                    <th>{{trans('guarantee.request_status')}}</th>
                    <th>{{trans('guarantee.mwn')}}</th>
                    <th>{{trans('guarantee.amount')}}</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody id="maintable">
                    @include('includes.guarantee')
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>{{trans('guarantee.type')}}</th>
                    <th>{{trans('guarantee.project')}}</th>

                    @foreach ($inputs as $inp)
                      <th>{{$inp->title}}</th>
                    @endforeach
                    <th>{{trans('guarantee.guarantee_status')}}</th>
                    <th>{{trans('guarantee.request_status')}}</th>
                    <th>{{trans('guarantee.mwn')}}</th>
                    <th>{{trans('guarantee.amount')}}</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>

                <br>

                {{-- <button class="btn btn-danger float-right" style="margin-left: 4px;">Delete Row/Column</button> --}}
                <button class="btn btn-success float-right" data-toggle="modal" data-target="#builder-guarantee" style="margin-left: 4px;">{{trans('guarantee.add_new_project')}}</button>

                <button class="btn btn-success" data-toggle="modal" data-target="#builder-1" style="margin-left: 4px;">{{trans('lands.add_new_column')}}</button>
                {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#builder-2" style="margin-left: 4px;">{{trans('lands.show_hide_column')}}</button> --}}
                <button class="btn btn-danger" data-toggle="modal" data-target="#builder-3" style="margin-left: 4px;">{{trans('lands.delete_column')}}</button>


                <br>
                <br>

                <img src="{{url('inf.png')}}" style="width: 20px;position: relative;top: -3px;" data-toggle="popover" data-content="{{trans('guarantee.popover')}}" alt="">

                <br>

                <h3>{{trans('guarantee.guarantee_summary_title_benbros_solar')}}</h3>

                <div id="summary">
		              @include('includes.guarantee_summary', ['id' => '197', 'soc' => 'solar'])
                </div>


                <br>



                <h3>{{trans('guarantee.guarantee_summary_title_benbros_energy')}}</h3>

                <div id="summary">
                  @include('includes.guarantee_summary', ['id' => '197', 'soc' => 'energy'])
                </div>

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

    <div class="modal fade" id="delete-guarantee">
  
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            {{trans('guarantee.delete_guarantees')}}
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="{{url('truncate-guarantees')}}">{{trans('guarantee.yes')}}</a>
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('guarantee.no')}}</button>
          </div>
        </div>
      </div>

    </div>


    <div class="modal fade" id="builder-guarantee">
  
      <div class="modal-dialog">
        <form class="modal-content" action="{{url('addNewGuarantee')}}" method="POST">
          {{csrf_field()}}
          <div class="modal-header">
            {{trans('guarantee.all_statuses')}}
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                        <label>{{trans('guarantee.project')}}</label>

                  <select name="land_id" class="form-control" required>
                    @foreach (App\Models\Land::whereNotExists(function($q){
                      $q->from('endorsements')
                        ->whereRaw('endorsements.land_id = lands.id');
                    })->where('name','!=','')->get() as $land)

                              <option value="{{$land->id}}">{{$land->name}}</option>
                      
                    @endforeach
                        </select>

                      </div>

              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-success">{{trans('guarantee.accept')}}</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('guarantee.cancel')}}</button>
          </div>
        </form>
      </div>

    </div>

    <div class="modal fade" id="statuses">
  
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          {{csrf_field()}}
          <div class="modal-header">
            {{trans('guarantee.select_proj')}}
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-sm-12">
                
                <table class="table table-hover">
                  <thead>
                    <th>ID</th>
                    <th>{{trans('guarantee.type')}}</th>
                    <th>{{trans('guarantee.name_status')}}</th>
                    <th></th>
                  </thead>
                  <tbody id="statustable">
                    @include('includes.statuses')
                  </tbody>
                </table>

              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" id="add-status">{{trans('guarantee.add_status')}}</button>
            {{-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button> --}}
          </div>
        </div>
      </div>

    </div>

    @include('modals.builder-2')

@endsection

@section('scripts')

{{-- <link rel="stylesheet" href="{{url('datatables/datatables.min.css')}}"> --}}
{{-- <script src="{{url('datatables/datatables.min.js')}}"></script> --}}

<script>
  // $.each($('.content select'), function(index, val) {
  //   $(this)[0].selectedIndex = Math.floor(Math.random() * ($(this).find('option').length - 0) -1);
  // });

  function initDatatable() 
  {
    $("#example2").DataTable({

      "ordering": false,
      "sorting": false,

      "scrollX": true, "scrollCollapse": true,
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

  initDatatable();

  setTimeout(()=>{
    $('.filters .inline-fields:first').trigger('keyup');
  },100);

  /*$(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "scrollX": true, "scrollCollapse": true,
      "paging": true,
      // "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      // "responsive": true,
    });
  });*/

  $('#add-status').click(function (e) {
    e.preventDefault();

    console.log('add-status');

    $.get('{{url('addStatus')}}', function(data, textStatus) {
      $('#statustable').html(data);
    });
  });

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
      url: '{{url('saveGuarantee')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      $('#summary').html(data);
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }

  function saveRow2(id)
  {
    var formData = new FormData();
    var extra = [];

    $.each($('.table-row[data-id="'+id+'"] .main-fields2'), function(index, val) {
       formData.append($(this).attr('name'),$(this).val());
    });

    // $.each($('.table-row[data-id="'+id+'"] .extra-fields'), function(index, val) {
    //    extra.push({id:$(this).attr('name'),value:$(this).val()});
    // });

    // formData.append('extras',JSON.stringify(extra));
    formData.append('id',id);
    formData.append('_token','{{csrf_token()}}');

    $.ajax({
      url: '{{url('saveStatus')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      // $('#summary').html(data);
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }

  function saveRowLand(id,aval)
  {
    var formData = new FormData();
    var extra = [];

    $.each($('.table-row[data-id="'+aval+'"] .land-main-fields'), function(index, val) {
       formData.append($(this).attr('name'),$(this).val());
    });

    formData.append('id',id);
    formData.append('_token','{{csrf_token()}}');

    $.ajax({
      url: '{{url('saveDataLand')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      // $('#summary').html(data);
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  }

  $('[name="file"]').on('change', function(event) {
    event.preventDefault();
    $(this).parents('form').submit();
  });

  $(function () {
    $('[data-toggle="popover"]').popover({
      html: true,
      container: 'body'
    })
  })

  @if (session('msj'))
    
    var notice = PNotify.success({
          title: "Éxito",
          text: "{{session('msj')}}",
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

  @endif
</script>
@endsection