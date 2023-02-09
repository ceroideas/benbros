@extends('layout')

@section('content')

{{-- <link rel="stylesheet" href="{{url('datatables/datatables.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('adminlte')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> --}}

<style>
  .no-filter input {
    /*display: none;*/
  }
  .dataTable {
    width: 100% !important;
  }
  .relative svg {
    width: 20px !important;
  }
  .flex.justify-between.flex-1
  {
    display: none;
  }

  #pagination span > span > span {
    background-color: silver !important;
  }

  #example1 tbody tr > td:nth-child(-n+3) {
    background-color: red;
    position: sticky;
    left: 0;
    background-color: #f1f1f1;
  }
  progress::-moz-progress-bar { background: blue; }
  progress::-webkit-progress-value { background: blue; }
  progress { color: blue; }
</style>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><img src="{{url('map.png')}}" style="width: 50px;position: relative;top: -3px;" alt=""> Land Summary <img src="{{url('inf.png')}}" style="width: 20px;position: relative;top: -3px;" data-toggle="popover" data-content="{{trans('popovers.2')}}" alt=""></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('lands.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('lands.land_summary')}}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <img src="{{url('inf.png')}}" style="width: 20px;position: relative;top: -3px;" data-toggle="popover" data-content="{{trans('popovers.3')}}" alt="">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <label class="checkbox">
                    {{trans('lands.only_main')}}
                    <input style="scale: 1.3;margin-left: 4px;top: 2px;position: relative;" type="checkbox" {{session()->has('mainProjects') ? 'checked' : ''}} onclick="changeMainProjectsProperty()">
                  </label>
                </h3>
                <form action="{{url('uploadExcel')}}" method="POST" enctype="multipart/form-data" style="float: right;">
                  {{csrf_field()}}
                  <label class="btn btn-warning" data-toggle="modal" data-target="#clean-lands"> Clean Lands </label>
                  <label class="btn btn-success">{{trans('lands.import_lands')}} <input type="file" name="file" style="display: none;"></label>
                </form>
                <div style="clear: both;"></div>
              </div>
              <!-- /.card-header -->
              @php
                $inputs = App\Models\Input::where('table','land')->where('status',1)->orderBy('order','asc')->get();
              @endphp
              <div class="card-body">

                <div class="table-responsive">
                  
                  <table id="example1" class="table table-bordered table-hover table-striped">
                    <thead id="header-changed">
                    <tr class="filters">
                      <th class="no-filter">{{trans('lands.id')}}</th>
                      <th>{{trans('lands.binder')}}</th>
                      <th> <input type="text" class="inline-fields filter" data-filter="substation" placeholder="{{trans('lands.set')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="mwn" placeholder="{{trans('lands.mwn')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="substation_km" placeholder="{{trans('lands.km_set')}}"></th>
                      <th> <input style="width: 250px" type="text" class="inline-fields filter" data-filter="partner_id" placeholder="{{trans('lands.partner')}}"></th>
                      {{-- <th> <input type="text" class="inline-fields filter" data-filter="month" placeholder="{{trans('lands.month')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="week" placeholder="{{trans('lands.week')}}"></th> --}}
                      <th> <input style="width: 250px" type="text" class="inline-fields filter" data-filter="name" placeholder="{{trans('lands.project_name')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="guarantee_status" placeholder="{{trans('lands.status_guarantee')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="request_status" placeholder="{{trans('lands.status_request')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="analisys_state" placeholder="{{trans('lands.analysis_state')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="contract_state" placeholder="{{trans('lands.contract_state')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="negotiator" placeholder="{{trans('lands.contract_negotiator')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="partner_info" placeholder="{{trans('lands.partner_info')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="mwp" placeholder="{{trans('lands.mwp')}}"></th>
                      <th> <input type="text" class="inline-fields filter" data-filter="technology" placeholder="{{trans('lands.technology')}}"></th>

                      @foreach ($inputs as $inp)
                        <th> <input type="text" class="inline-fields filter" data-extrafilter="{{$inp->id}}" placeholder="{{$inp->title}}"> {{-- $inp->id --}}</th>
                      @endforeach

                      <th class="no-filter">{{trans('lands.main')}}</th>
                      <th class="no-filter"></th>
                      <th class="no-filter">{{trans('lands.options')}}</th>
                    </tr>
                    </thead>
                    <tbody id="all-lands">
                      @php
                        $lands = App\Models\Land::orderBy('id','desc')->whereNotNull('carpeta')
                        ->where(function($q){
                          if (session()->has('mainProjects')) {
                            $q->where('main',1);
                          }
                        })
                        ->paginate(10);
                      @endphp
                      @include('includes.lands', ['lands' => $lands])
                    </tbody>
                    <tfoot id="footer-changed">
                    <tr>
                      <th>{{trans('lands.id')}}</th>
                      <th>{{trans('lands.binder')}}</th>
                      <th>{{trans('lands.set')}}</th>
                      <th>{{trans('lands.mwn')}}</th>
                      <th>{{trans('lands.km_set')}}</th>
                      <th>{{trans('lands.partner')}}</th>
                      {{-- <th>{{trans('lands.month')}}</th>
                      <th>{{trans('lands.week')}}</th> --}}
                      <th>{{trans('lands.project_name')}}</th>
                      <th>{{trans('lands.status_guarantee')}}</th>
                      <th>{{trans('lands.status_request')}}</th>
                      <th>{{trans('lands.analysis_state')}}</th>
                      <th>{{trans('lands.contract_state')}}</th>
                      <th>{{trans('lands.contract_negotiator')}}</th>
                      <th>{{trans('lands.partner_info')}}</th>
                      <th>{{trans('lands.mwp')}}</th>
                      <th>{{trans('lands.technology')}}</th>
                      
                      @foreach ($inputs as $inp)
                        <th>{{$inp->title}}</th>
                      @endforeach

                      <th>{{trans('lands.main')}}</th>
                      <th></th>
                      <th>{{trans('lands.options')}}</th>
                    </tr>
                    </tfoot>
                  </table>

                </div>

                <div id="pagination">
                  {{$lands->links()}}
                </div>

                <br>

                <button class="btn btn-primary" id="add-land">{{trans('lands.add_new_land')}}</button>
                <button class="btn btn-success" data-toggle="modal" data-target="#builder-1" style="margin-left: 4px;">{{trans('lands.add_new_column')}}</button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#builder-2" style="margin-left: 4px;">{{trans('lands.show_hide_column')}}</button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#builder-3" style="margin-left: 4px;">{{trans('lands.delete_column')}}</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('lands.table_land_summary')}}</h3>

                <div class="dropdown" style="position: relative; float: right;">
                  <button class="btn btn-xs btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{trans('lands.generate_report')}}
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{url('summary-report')}}">{{trans('lands.summary_report')}}</a>
                    <div class="dropdown-divider"></div>
                    {{-- <div class="dropdown-divider"></div> --}}
                    <a class="dropdown-item" href="#report-builder" data-toggle="modal">{{trans('lands.new_report')}}</a>
                  </div>
                </div>
              </div>

              @include('modals.report-builder')
              <!-- /.card-header -->
              @php
                $inputs = App\Models\Input::where('table','land')->where('summary',1)->orderBy('order','asc')->get();
              @endphp
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover" style="width: 100%;">
                  <thead>
                  <tr>
                    <th>{{trans('lands.partner')}}</th>
                    {{-- @foreach ($inputs as $inp)
                      <th>{{$inp->title}}</th>
                    @endforeach --}}
                    <th>{{trans('lands.total_rec')}}</th>
                    <th>{{trans('lands.total_acc')}}</th>
                    <th>{{trans('lands.total_rej')}}</th>
                    <th>{{trans('lands.success')}}</th>
                  </tr>
                  </thead>
                  <tbody>

                    @foreach (App\Models\Partner::whereExists(function($q){
                      $q->from('lands')
                        ->whereRaw('lands.partner_id = partners.id');
                    })->get() as $p)
                      <tr>
                        <td>{{$p->name}}</td>
                        {{-- @foreach ($inputs as $inp)
                          <td></td>
                        @endforeach --}}
                        <td>{{ App\Models\Land::where('partner_id',$p->id)->count() }}</td>
                        <td>{{ App\Models\Land::where('partner_id',$p->id)->whereIn('analisys_state',[1,3,7,10])->whereIn('contract_state',[6,8])->count() }}</td>
                        <td>{{ App\Models\Land::where('partner_id',$p->id)->where('analisys_state',4)->count() }}</td>
                        <td>@php
                          
                              $per = App\Models\Land::count() ? number_format((App\Models\Land::where('partner_id',$p->id)
                              ->whereIn('analisys_state',[1,3,7,10])->whereIn('contract_state',[6,8])->count() * 100) / App\Models\Land::count(),2) : 0 
                            @endphp 
                            {{-- <progress value="{{$per}}" max="100"></progress> --}}
                            {{$per}}%
                        </td>
                      </tr>
                    @endforeach
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>{{trans('lands.partner')}}</th>
                    {{-- @foreach ($inputs as $inp)
                      <th>{{$inp->title}}</th>
                    @endforeach --}}
                    <th>{{trans('lands.total_rec')}}</th>
                    <th>{{trans('lands.total_acc')}}</th>
                    <th>{{trans('lands.total_rej')}}</th>
                    <th>{{trans('lands.success')}}</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>


            <div id="chartDiv" style="max-width: 100%;height: 400px;margin: 0px auto"></div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

    @include('modals.builder')

    <div class="modal fade" id="clean-lands">

      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            Are you sure you want to delete all Lands? This action will clear Development, Guarantee, and Other tables.
          </div>
          <div class="modal-footer">
            <a href="{{url('truncateAll')}}" class="btn btn-success btn-xs">{{trans('layout.accept')}}</a>
            <button type="button" data-dismiss="modal" class="btn btn-danger btn-xs">{{trans('layout.cancel')}}</button>
          </div>
        </div>
      </div>
      
    </div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{url('/')}}/jscharting.js"></script>

{{-- <script src="{{url('datatables/datatables.min.js')}}"></script> --}}

<script>
  var chart;

  var data = [];

  @foreach (App\Models\Partner::whereExists(function($q){
      $q->from('lands')
        ->whereRaw('lands.partner_id = partners.id');
    })->get() as $p)
        @php
          $p->name;
          $scs = App\Models\Land::where('partner_id',$p->id)->whereIn('analisys_state',[1,3,7,10])->whereIn('contract_state',[6,8])->count();
          $per = App\Models\Land::count() ? number_format((App\Models\Land::where('partner_id',$p->id)
          ->whereIn('analisys_state',[1,3,7,10])->whereIn('contract_state',[6,8])->count() * 100) / App\Models\Land::count(),2) : 0 
        @endphp

      data.push({name: '{{$p->name}}}', percent: {{$per}},success: {{$scs}} });
  @endforeach

  function renderChart(series) {
    return JSC.chart('chartDiv', { 
      title_label_text: 
        '% de éxito de los diferentes socios', 
      debug: true, 
      type: 'column solid', 
      legend_visible: false, 
      palette: ['#cb0303'], 
      defaultPoint: { 
        tooltip: 
          '<b>%xValue</b> <br>Percent: <b>%yValue</b><br><b>%complete</b> of success</b>', 
        complete: { 
          fill: 'rgba(255,255,255,.3)', 
          hatch_style: 'none'
        }, 
        label: { 
          text: '%complete',
          align: 'center', 
          verticalAlign: 'bottom', 
          autoHide: false, 
          style_fontSize: '15px'
        } 
      }, 
      series: series 
    });
  }

  function makeSeries(data) { 
    return [ 
      { 
        points: data.map(function(item) { 
          return { 
            x: item.name, 
            y: item.success, 
            complete: item.percent / 100 
          }; 
        }) 
      } 
    ]; 
  }

  chart = renderChart(makeSeries(data));

  $('#pagination a').click(applyPagination);


  function applyPagination (e) {
    e.preventDefault();

    let href = $(this).attr('href');
    let page = href.split('?page=')[1];

    $.get('{{url('loadPagination')}}?page='+page, function(data) {
      $('#all-lands').html(data[0]);
      $('#pagination').html(data[1]);

      $('#pagination a').click(applyPagination);
      // $('.inline-fields').keyup(_.debounce(applyData,1000));
    });
  }


  $(function () {
    // $('#example1 thead tr')
    //     .clone(true)
    //     .addClass('filters')
    //     .appendTo('#example1 thead');
    /*.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)')*/;

    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": false,
      "scrollX": true
    });

    initDatatable();

    // setTimeout(()=>{
    //   $('.filters .inline-fields:first').trigger('keyup');
    // },100);

    $(window).resize(function(event) {
      $('.sorting:first-of-type').trigger('click');
      $('.sorting:first-of-type').trigger('click');
    });
  });

  function initDatatable() 
  {
    /*$("#example1").DataTable({

      "ordering": false,
      "sorting": false,

      "pageLength" : 5,
      "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],

      "scrollX": true, "scrollCollapse": true,
      "fixedColumns": {
        left: 5
      },
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      // 'columnDefs'        : [         // see https://datatables.net/reference/option/columns.searchable
      //       { 
      //           'searchable'    : false, 
      //           'targets'       : [1,4,5],
      //       }
      //   ],

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
    });*/
  }

  $('#add-land').click(function (e) {
    e.preventDefault();

    console.log('add-land');

    $.get('{{url('addLand')}}', function(data, textStatus) {
      
      $('#example1').DataTable().destroy();

      $('#all-lands').html(data[0]);
      $('#pagination').html(data[1]);

      $('#pagination a').click(applyPagination);
      // $('.inline-fields').keyup(_.debounce(applyData,1000));

      // $.each($('.filters th input'), function(index, val) {
      //   let ph = $(this).attr('placeholder');
      //   $(this).parent('th').text(ph);
      // });

      // initDatatable();
    });
  });

  function changeMainProjectsProperty()
  {
    $.get('{{url('changeMainProjectsProperty')}}', function(data) {
      location.reload();
    });
  }


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
      url: '{{url('saveLand')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      console.log(data);

      // var notice = PNotify.success({
      //       title: "Completado",
      //       text: "Se ha guardado el terreno correctamente",
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

  function downloadKML(id)
  {
    console.log(id);
    $.get('{{url('prepareKML')}}/'+id, function(data, textStatus) {
      window.open(data,'_blank');
    }).fail(function(e){
      alert('No se ha recuperado la referencia catastral')
    });
  }

  function downloadKMLModal(id)
  {
    $('#kml-body').html("");

    $.get('{{url('getKML')}}/'+id, function(data){

      let html = "";

      $.each(data, function(index, val) {
        
        html+= `
         <li><a href="https://ovc.catastro.meh.es/Cartografia/WMS/BuscarParcelaGoogle3D.aspx?refcat=${val}&tipo=3d" title="">${val}</a></li>
        `
      });

      $('#kml-body').html(html);

      $('#kml').modal('show');

    })

    // console.log(id);
    // $.get('{{url('prepareKML')}}/'+id, function(data, textStatus) {
    //   window.open(data,'_blank');
    // }).fail(function(e){
    //   alert('No se ha recuperado la referencia catastral')
    // });
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


  $('.inline-fields').keyup(_.debounce(applyData,1000));


  function applyData(event) {
    
    let f = $(this).data('filter');
    let ef = $(this).data('extrafilter');
    let type;
    let name;
    let value;

    console.log($(this).data());

    if (f/* && $(this).val()*/) {
      type = 'normal';
      name = f;
      value = $(this).val();
    }

    if (ef/* && $(this).val()*/) {
      type = 'extra';
      name = ef;
      value = $(this).val();
    }

    console.log(type,name,value);

    // if (value) {
      $.post('{{url('saveSessionFilters')}}', {_token: '{{csrf_token()}}', type:type, name: name, value: value}, function(data, textStatus, xhr) {
        $('#all-lands').html(data[0]);
        $('#pagination').html(data[1]);

        $('#pagination a').click(applyPagination);
        // $('.inline-fields').keyup(_.debounce(applyData,1000));
      });
    // }

  }

  $('.changeParent').click(function (e) {
    let action = $(this).parents('form').attr('action');
    if ($(this).is(':checked')) {
      action = action.replace('downloadPDF','exportWord');
    }else{
      action = action.replace('exportWord','downloadPDF');
    }
    $(this).parents('form').attr('action', action);
    console.log(action);
  });
</script>
@endsection