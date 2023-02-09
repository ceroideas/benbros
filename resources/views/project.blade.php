@extends('layout')

@section('content')

<style>
  td {
    vertical-align: middle !important;
  }

  .no-hover {
    background-color: #fcfcfc !important;
    font-weight: normal !important;
  }
</style>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{trans('projects.dev_project')}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">{{trans('projects.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('projects.project')}}</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
      <div class="container-fluid">

      	<div class="row">
	      <div class="col-12 col-sm-6 col-md-3">
	        <div class="info-box">
	          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-industry"></i></span>

	          <div class="info-box-content">
	            <span class="info-box-number">
	              {{trans('projects.project_name')}}
	              {{-- <small>%</small> --}}
	            </span>
	            <span class="info-box-text">
                <input class="inline-fields main-fields-2" name="name" data-id="{{$p->land->id}}" type="text" value="{{$p->land->name}}">
              </span>
	          </div>
	          <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	      </div>
	      <!-- /.col -->
	      <div class="col-12 col-sm-6 col-md-3">
	        <div class="info-box">
	          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-book"></i></span>

	          <div class="info-box-content">
	            <span class="info-box-number">
	              {{trans('projects.subs_name')}}
	              {{-- <small>%</small> --}}
	            </span>
	            <span class="info-box-text">
                <input class="inline-fields main-fields-2" name="substation" data-id="{{$p->land->id}}" type="text" value="{{$p->land->substation}}">
              </span>
	          </div>
	          <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	      </div>
	      <!-- /.col -->
	      <div class="col-12 col-sm-6 col-md-3">
	        <div class="info-box">
	          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-desktop"></i></span>

	          <div class="info-box-content">
	            <span class="info-box-number">
	              {{trans('projects.mwpn')}}
	              {{-- <small>%</small> --}}
	            </span>
	            <span class="info-box-text">
                <input style="min-width: 80px; width: 80px;" class="inline-fields main-fields-2" name="mwp" data-id="{{$p->land->id}}" type="text" value="{{$p->land->mwp}}">
                 / 
                <input style="min-width: 80px; width: 80px;" class="inline-fields main-fields-2" name="mwn" data-id="{{$p->land->id}}" type="text" value="{{$p->land->mwn}}">
              </span>
	          </div>
	          <!-- /.info-box-content -->
	        </div>
	        <!-- /.info-box -->
	      </div>
	      <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-map-marker"></i></span>

            <div class="info-box-content">
              <span class="info-box-number">
                {{trans('projects.km_subs')}}
                {{-- <small>%</small> --}}
              </span>
              <span class="info-box-text">
                <input class="inline-fields main-fields-2" name="substation_km" data-id="{{$p->land->id}}" type="text" value="{{$p->land->substation_km}}">
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
	    </div>


        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('projects.activities')}}</h3>
                <form action="{{url('uploadExcelProject')}}" method="POST" enctype="multipart/form-data" style="float: right;">
                  {{csrf_field()}}
                  <input type="hidden" name="id" value="{{$p->id}}">
                  <label class="btn btn-success btn-sm">{{trans('projects.import_activities')}} <input type="file" name="file" style="display: none;"></label>
                </form>

                <button class="btn btn-info btn-sm" style="float: right; margin-right: 8px ;" data-toggle="modal" data-target="#report-modal">{{trans('projects.generate_report')}} </button>

                <button class="btn btn-warning btn-sm" id="export-gantt" style="float: right; margin-right: 8px ;"> Descargar Imagen Gantt </button>

                <div class="modal fade" id="report-modal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">{{trans('projects.sel_sections')}}</div>
                      <div class="modal-body">
                        <form action="{{url('downloadPDF',$p->land_id)}}" class="form" method="POST">
                          {{csrf_field()}}
                          <div class="row">
                            <div class="col-sm-6">

                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="fields-report[]" value="1" checked>
                                  {{trans('projects.generel_info')}}
                                </label>
                                  <ul>
                                    <li style="list-style: none;">
                                      <label><input type="checkbox" checked name="pn">Project Name</label> <br>
                                      <label><input type="checkbox" checked name="mt">Month</label> <br>
                                      <label><input type="checkbox" checked name="wk">Week</label> <br>
                                      <label><input type="checkbox" checked name="pt">Partner</label> <br>
                                      <label><input type="checkbox" checked name="as">Analisys State</label> <br>
                                    </li>
                                  </ul> 
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="fields-report[]" value="2" checked>
                                  {{trans('projects.contract_info')}}
                                </label>
                                <ul>
                                  <li style="list-style: none;">
                                    <label><input type="checkbox" checked name="cs">Contract State</label> <br>
                                    <label><input type="checkbox" checked name="cn">Contract Negotiaton</label> <br>
                                    <label><input type="checkbox" checked name="pi">Partner Info</label> <br>
                                  </li>
                                </ul>
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="fields-report[]" value="3" checked>
                                  {{trans('projects.gen_tech_cond')}}
                                </label>
                                <ul>
                                  <li style="list-style: none;">
                                    <label><input type="checkbox" checked name="tp">Total Peak Power</label> <br>
                                    <label><input type="checkbox" checked name="tr">Total Power Rating</label> <br>
                                    <label><input type="checkbox" checked name="ss">Substation</label> <br>
                                    <label><input type="checkbox" checked name="ks">KM Substation</label> <br>
                                    <label><input type="checkbox" checked name="tg">Technology</label> <br>
                                  </li>
                                </ul>
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="fields-report[]" value="4" checked>
                                  {{trans('projects.aditional_info')}}
                                </label>
                                <ul>
                                  <li style="list-style: none;">
                                    @php
                                      $inputs = App\Models\Input::where('table','land')->orderBy('order','asc')->get();
                                    @endphp

                                    <div>
                                        @foreach ($inputs as $inp)
                                          <label><input type="checkbox" checked name="i{{$inp->id}}">{{$inp->title}}</label> <br>
                                        @endforeach
                                    </div>
                                  </li>
                                </ul>
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="fields-report[]" value="5" checked>
                                  {{trans('projects.guarantee')}}
                                </label>
                                <ul>
                                  <li style="list-style: none;">
                                    <label><input type="checkbox" checked name="gs">Guarantee Status</label> <br>
                                    <label><input type="checkbox" checked name="rs">Request Status</label> <br>
                                    <label><input type="checkbox" checked name="mw">MWn</label> <br>
                                    <label><input type="checkbox" checked name="am">Amount €</label> <br>
                                  </li>
                                </ul>
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="fields-report[]" value="6" checked>
                                  {{trans('projects.project_info')}}
                                </label>
                                <ul>
                                  <li style="list-style: none;">

                                    @php
                                      $sections = App\Models\Section::orderBy('id','asc')->get();
                                    @endphp
                                    
                                    @foreach ($sections as $sect)
                                        @if ($sect->inputs)
                                        <div style="margin-bottom: 12px">
                                            {{-- <b style="text-decoration: underline">{{$sect->name}}</b> <br> --}}
                                            <label><input type="checkbox" checked name="s{{$sect->id}}">{{$sect->name}}</label> <br>
                                            @foreach ($sect->inputs as $inp)
                                            {{-- <label><input type="checkbox" checked name="">{{$inp->title}}</label> <br> --}}
                                            @endforeach
                                        </div>
                                        @endif
                                    @endforeach
                                    
                                  </li>
                                </ul>
                              </div>
                            </div>



                            <div class="col-sm-12">
                              
                              <textarea name="information" class="form-control" rows="4"></textarea>


                            </div>
                          </div>

                          <input type="hidden" id="dataUrl" name="dataUrl">

                          <br>

                          <button type="submit" id="generate_btn" class="btn btn-sm btn-success">{{trans('projects.generate_report')}}</button>
                          <button type="button" class="btn btn-sm btn-danger">{{trans('projects.cancel')}}</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <div style="clear: both;"></div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="table-responsive">
                  <table id="example21" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th></th>
                      <th>{{trans('projects.activity_name')}}</th>
                      <th>{{trans('projects.docs')}}</th>
                      <th>{{trans('projects.progress')}}</th>
                      <th>{{trans('projects.start')}}</th>
                      <th>{{trans('projects.finish')}}</th>
                      <th>{{trans('projects.responsable_benb')}}</th>
                      <th>{{trans('projects.external_resp')}}</th>
                      <th>{{trans('projects.administrative_organ')}}</th>
                      <th>{{trans('projects.comments')}}</th>
                      {{-- <th>Status</th> --}}
                      <th>{{trans('projects.options')}}</th>
                    </tr>
                    </thead>
                    <tbody id="all-activities">
                      @include('permissions.activities')
                    </tbody>
                    <tfoot>
                    <tr>
                      <th></th>
                      <th>Activity Name</th>
                      <th>Docs</th>
                      <th>Progress</th>
                      <th>Start Date</th>
                      <th>Finish Date</th>
                      <th>Responsable Benbros</th>
                      <th>Responsable Externo</th>
                      <th>Órgano administración</th>
                      <th>Comentarios</th>
                      {{-- <th>Status</th> --}}
                      <th>Options</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>

                <br>

                <button class="btn btn-primary" id="add-section">{{trans('projects.add_new_section')}}</button>
                <button class="btn btn-success" data-toggle="modal" data-target="#builder-2" style="margin-left: 4px;">{{trans('projects.add_new_activity')}}</button>
                {{-- <button class="btn btn-danger" style="margin-left: 4px;">Delete Row/Column</button> --}}

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{trans('projects.gantt_proj')}}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="gantt">
                @include('includes.gantt')
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

    <div class="modal fade" id="builder-2">
      <div class="modal-dialog">
        <form class="modal-content" id="create-activity" action="{{url('createActivity')}}" method="POST">
          {{csrf_field()}}
          <div class="modal-header">
            {{trans('projects.create_new_activity')}}
          </div>
          <div class="modal-body">
            
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  
                  <label>Section</label>

                  <select name="activity_section_id" class="form-control" required>
                    <option value="" selected disabled></option>
                    @foreach (App\Models\ActivitySection::where('permission_id',$p->id)->get() as $s)

                        <option value="{{$s->id}}">{{$s->name}}</option>
                      
                    @endforeach
                    </select>

                </div>

                <div class="form-group">
                  <label>{{trans('projects.activity_name')}}</label>
                  <input type="text" name="name" class="form-control" required />
                </div>

              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-success">{{trans('projects.accept')}}</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('projects.cancel')}}</button>
          </div>
        </form>
      </div>
    </div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{url('/')}}/jscharting.js"></script>
<script type="text/javascript" src="{{url('/')}}/moment.min.js"></script>

<script type="text/javascript" src="{{url('/')}}/dom-to-image.js"></script>

<link rel="stylesheet" type="text/css" href="css/default.css" />

<script>
  $(function () {
    $('#example2').DataTable({
      "scrollX": true,
    });
  });

  $('#add-section').click(function (e) {
    e.preventDefault();

    console.log('add-section');

    $.get('{{url('addActivitySection',$p->id)}}', function(data, textStatus) {
      // $('#all-activities').html(data);
      location.reload();
    });
  });

  function saveSection(t)
  {
    $.post('{{url('saveActivitySection')}}', {_token: '{{csrf_token()}}', id:$(t).data('id'), name: $.trim($(t).text()) }, function(data, textStatus, xhr) {
      // $('#all-activities').html(data);
      // location.reload();
    });
  }

  $('#create-activity').submit(function(event) {
    event.preventDefault();

    $.post($(this).attr('action'), $(this).serializeArray(), function(data, textStatus, xhr) {

      $('#builder-2').modal('hide');

      $('[name="activity_section_id"]').val("");
      $('[name="name"]').val("");
      // $('#all-activities').html(data);
      location.reload();
    });
  });

  function saveRow(id)
  {
    var formData = new FormData();
    var extra = [];

    $.each($('.table-row[data-id="'+id+'"] .main-fields'), function(index, val) {
       formData.append($(this).attr('name'),$(this).val());
    });

    $.each($('.table-row[data-id="'+id+'"] .textarea'), function(index, val) {
       console.log($(this).val());
       formData.append($(this).attr('name'),$(this).val());
    });

    formData.append('id',id);
    formData.append('_token','{{csrf_token()}}');

    $.ajax({
      url: '{{url('saveActivity')}}',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
    })
    .done(function(data) {
      // console.log(data);

      let points = [{
              name: '',
              y: ['{{Carbon\Carbon::now()}}','{{Carbon\Carbon::now()}}'],
              color: ['white',0]
            }];

      var final_h = 100;

      $.each(data[1], function(index, val) {
         $.each(val.activities, function(index, act) {
            // console.log(act)
            if (act.start_date && act.end_date) {
              final_h+=40;

              var color = "";

              if (act.progress == 100)
              {
                color = 'lightgreen'
              }else{
                if (moment(act.end_date) < moment() && act.progress != 100)
                {
                  color = 'crimson'
                }

                if (moment(act.end_date) > moment() && act.progress != 100)
                {
                  color = 'lightblue'
                }
              }
              points.push({
                name: act.name ? act.name : '-',
                y: [moment(act.start_date).add(1,'day').format('Y-MM-DD'), moment(act.end_date).add(1,'day').format('Y-MM-DD')],
                color: [color,0.5]
              })
            }
         });
      });

      console.log(points);

      $('#chartDiv').css('height', final_h+'px');

      var chart = JSC.chart('chartDiv', {
        debug: true,
        defaultCultureName: 'es-ES',
        type: 'horizontal column',
        zAxisScaleType: 'stacked',
        yAxis_scale_type: 'time',
        xAxis_visible: false,
        title_label_text: '<span style="font-size: 20px; font-weight: bolder;">'+data[0].land.name+'</span>',
        legend_visible: false,
        defaultPoint: {
          label_text: '<span style="font-size: 14px">%name</span>',
          tooltip: '<span style="font-size: 15px"><b>%name</b> <br/>%low - %high<br/>{days(%high-%low)} days</span>'
        },
        yAxis: {
          markers: [
            {
              value: '{{Carbon\Carbon::now()}}',
              color: '#b0be5f',
              label_text: 'Today'
            },
          ]
        },
        series: [
          {
            name: 'one',
            points: points//[
              // {
              //   name: 'Execution',
              //   y: ['3/15/2022', '4/20/2022']
              // },
              // { name: 'Cleanup', y: ['4/10/2022', '5/12/2022'] },
              // {
              //   name: 'Presentation',
              //   y: ['6/1/2022', '7/1/2022']
              // }
            //]
          }
        ]
      });
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    


  }

      function uploadFile(t)
      {
        let id = $(t).data('id');
        let action = $(t).data('action');

        let file = $('#file-'+id)[0].files;

        if (file.length == 0) {
          return false;
        }

        let formData = new FormData();
        formData.append('id',id);
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

          // $('#all-activities').html(data);
          location.reload();

          var notice = PNotify.success({
              title: "{{trans('projects.completed')}}",
              text: "{{trans('projects.success2')}}",
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
        
        console.log(id,action,img);
      }

      $('.main-fields-2').change(function(event) {
        /* Act on the event */
        let id = $(this).data('id')
        let column = $(this).attr('name')
        let value = $(this).val();

        $.post('{{url('saveValueProject')}}', {id: id, column: column, value: value, _token: '{{csrf_token()}}'}, function(data, textStatus, xhr) {
          console.log('guardado')
        });
      });

      $('[name="file"]').on('change', function(event) {
        event.preventDefault();
        $(this).parents('form').submit();
      });

      function changeWidth(id,e)
      {
        $('#progress'+id).css('width', $('#range'+id).val()+'%');
        $('#prog'+id).text(e.target.value+'%');

        saveRow(id);
      }
      
      function showtr()
      {
        let id = $(this).data('id');
        $('#show-'+id).hide();
        $('.hide-'+id).show();
      }
      function hidetr()
      {
        let id = $(this).data('id');
        $('#show-'+id).show();
        $('.hide-'+id).hide();
      }

      $('.show-tr').click(showtr);
      $('.hide-tr').click(hidetr);


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

  $('[data-target="#report-modal"]').click(function (e) {
    e.preventDefault();
    $('#generate_btn').prop('disabled', 'true');

    // var el = $(this);

    // el.text('Espere un momento...');
    // el.attr('disabled', 'true');
    
    domtoimage.toJpeg(document.getElementById('chartDiv'), { quality: 0.95 })
    .then(function (dataUrl) {
      console.log(dataUrl);
      $('#dataUrl').val(dataUrl);
      $('#generate_btn').removeAttr('disabled');

    });

  });

  $('#export-gantt').click(function(event) {

    var el = $(this);

    el.text('Espere un momento...');
    el.attr('disabled', 'true');
    
    domtoimage.toJpeg(document.getElementById('chartDiv'), { quality: 0.95 })
    .then(function (dataUrl) {
        /*$.post('{{url('saveDataUrl')}}', {_token: '{{csrf_token()}}', dataUrl:dataUrl}, function(data, textStatus, xhr) {
          console.log('Ok');
          $('#generate_btn').removeAttr('disabled');
        });*/
        var link = document.createElement('a');
        link.download = 'gantt-project-{{$p->project_name}}-{{Carbon\Carbon::now()->format('d-m-Y_h:i:s')}}.jpeg';
        link.href = dataUrl;
        link.click();

        el.text('Descargar Imagen Gantt');
        el.removeAttr('disabled');
    });

  });

</script>
@endsection