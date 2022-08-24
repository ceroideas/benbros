@extends('layout')

@section('content')

<style>
  #map1, #map2 {height: 100%;}
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"> {{trans('layout.home')}} <img src="{{url('inf.png')}}" style="width: 20px;position: relative;top: -3px;" data-toggle="popover" data-content="{{ trans('popovers.1') }}" alt=""></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('adminlte')}}/#">{{trans('layout.home')}}</a></li>
          <li class="breadcrumb-item active">{{trans('layout.home')}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<section class="content">
  <div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>

          <div class="info-box-content">
            <span class="info-box-number">
              {{ App\Models\Land::whereExists(function($q){
                $q->from('endorsements')
                  ->whereRaw('endorsements.guarantee_status = 9')
                  ->whereRaw('endorsements.request_status = 6')
                  ->whereRaw('endorsements.land_id = lands.id');
              })->sum('mwn') }}
              {{-- <small>%</small> --}}
            </span>
            <span class="info-box-text">{{trans('layout.mw_accecpted')}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

          <div class="info-box-content">
            <span class="info-box-number">
              {{ App\Models\Land::whereExists(function($q){
                $q->from('endorsements')
                ->whereRaw('endorsements.guarantee_status = 9')
                  ->whereRaw('endorsements.request_status = 5')
                  ->whereRaw('endorsements.land_id = lands.id');
              })->sum('mwn') }}
              {{-- <small>%</small> --}}
            </span>
            <span class="info-box-text">{{trans('layout.mw_pending')}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>

          <div class="info-box-content">
            <span class="info-box-number">
              {{ App\Models\Land::whereExists(function($q){
                $q->from('endorsements')
                ->whereRaw('endorsements.guarantee_status = 9')
                  ->whereRaw('endorsements.request_status = 7')
                  ->whereRaw('endorsements.land_id = lands.id');
              })->sum('mwn') }}
              {{-- <small>%</small> --}}
            </span>
            <span class="info-box-text">{{trans('layout.mw_rejected')}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
      	{{-- <a target="_blank" href="https://docs.google.com/spreadsheets/d/1mppSKK5UhELfN0XhODamfI5N2IfbrMcMXvxkkQHHN30/edit?usp=sharing" class="btn btn-block btn-primary">{{trans('layout.budget')}}</a> --}}
        <a href="{{url('budget-documents')}}" class="btn btn-block btn-primary">{{trans('layout.budget')}}</a>
      	<a href="{{url('guarantee')}}" class="btn btn-block btn-info">{{trans('layout.guarantee')}}</a>
      </div>
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{trans('layout.map_general')}} <img src="{{url('inf.png')}}" style="width: 20px;position: relative;top: -3px;" data-toggle="popover" data-content="En este mapa se visualizan los proyectos que hay en desarrollo en cada municipio <b>(Portfolio)</b>. Se indica el tipo de tecnología, potencia, colaborador de terrenos, subestación y distancia a la subestación." alt=""></h3>

            <div class="card-tools">

              <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#reset-locations">
                {{trans('layout.reset_locations')}}
              </button>
              
              <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#select-map">
                {{trans('layout.map_report')}}
              </button>

              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="d-md-flex">
              <div class="p-1 flex-fill" style="overflow: hidden">
                <!-- Map will be created here -->
                <div id="world-map-markers" style="height: 665px; overflow: hidden">
                  <div id="map1"></div>
                </div>
              </div>
            </div><!-- /.d-md-flex -->
          </div>
          <!-- /.card-body -->
        </div>

        <!-- /.card -->
      </div>
      <!-- /.col -->

      @include('includes.projects-tables')

      <div class="modal fade" id="select-map">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              {{trans('layout.select_map')}}
            </div>
            <div class="modal-body">
              
              <form action="{{url('downloadPDFMaps')}}" class="form" method="POST">
                {{csrf_field()}}
                <div class="row">
                  <div class="col-sm-12">

                    @foreach (App\Models\Technology::all() as $tech)
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="T_{{$tech->id}}" value="1" checked>
                          {{App::getLocale() == 'es' ? $tech->name : $tech->name_en}}
                        </label>
                      </div>
                    @endforeach

                    {{-- <div class="checkbox">
                      <label>
                        <input type="checkbox" name="GH" value="1" checked>
                        {{trans('layout.gh_proj')}}
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="ST" value="1" checked>
                        {{trans('layout.st_proj')}}
                      </label>
                    </div>

                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="DC" value="1" checked>
                        {{trans('layout.dc_proj')}}
                      </label>
                    </div> --}}

                    <div class="form-group">

                      <label>{{trans('layout.zoom')}}</label>
                      <input type="number" class="form-control" name="zoom">

                    </div>

                    <div class="form-group">

                      <label>{{trans('layout.center')}}</label>
                      <input type="text" class="form-control" name="center">

                    </div>
                  </div>

                </div>

                <button class="btn btn-sm btn-success">{{trans('layout.generate')}}</button>

              </form>

            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="reset-locations">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              {{trans('layout.reset_locations_promt')}}
            </div>
            <div class="modal-footer">
              <a href="{{url('resetLocations')}}" class="btn btn-sm btn-success">{{trans('layout.accept')}}</a>
              <button class="btn btn-sm" data-dismiss="modal">{{trans('layout.cancel')}}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->

    <!-- Main row -->
    {{-- <div class="row">
      <!-- Left col -->
      <div class="col-md-2">
        <!-- Info Boxes Style 2 -->
        <div class="info-box mb-3 bg-default small-box">

          <div class="info-box-content">
            <span class="info-box-text">Nº de proyectos <span class="info-box-number-2" style="margin: 0;">{{App\Models\Land::where('technology',2)->count()}}</span> </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-default small-box">

          <div class="info-box-content">
            <span class="info-box-text">Nº de MWp <span class="info-box-number-2" style="margin: 0;">
              {{App\Models\Land::where('technology',2)->sum('mwp')}}
            </span> </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-default small-box">

          <div class="info-box-content">
            <span class="info-box-text">Nº de MWn <span class="info-box-number-2" style="margin: 0;">
              {{App\Models\Land::where('technology',2)->sum('mwn')}}
            </span> </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-default small-box">

          <div class="info-box-content">
            <span class="info-box-text">Concursos <span class="info-box-number-2" style="margin: 0;">
              {{App\Models\Land::where('technology',2)->whereExists(function($q){
                $q->from('permissions')
                  ->whereRaw('permissions.land_id = lands.id')
                  ->whereRaw('permissions.tramitation_type = "Concurso"');
              })->count()}}
            </span> </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 bg-default small-box">

          <div class="info-box-content">
            <span class="info-box-text">Solicitud AyC <span class="info-box-number-2" style="margin: 0;">
              {{App\Models\Land::where('technology',2)->whereExists(function($q){
                $q->from('permissions')
                  ->whereRaw('permissions.land_id = lands.id')
                  ->whereRaw('permissions.tramitation_type = "Solicitud AyC"');
              })->count()}}
            </span> </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->

      <div class="col-md-10">
        <!-- MAP & BOX PANE -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Summary Green Hydrogen Project</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="d-md-flex">
              <div class="p-1 flex-fill" style="overflow: hidden">
                <!-- Map will be created here -->
                <div id="world-map-markers2" style="height: 325px; overflow: hidden">
                  <div id="map2"></div>
                </div>
              </div>
            </div><!-- /.d-md-flex -->
          </div>
          <!-- /.card-body -->
        </div>

        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div> --}}
  </div><!--/. container-fluid -->
</section>

@endsection

@section('scripts')

<script>

  var map1;

  function initMap()
  {
    let latLng = new google.maps.LatLng(40.806872, -3.745686);

    let mapOptions = {
        center: latLng,
        zoom: 7,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        streetViewControl: false,
        rotateControl: false,
        zoomControl: false,
        fullscreenControl: false,
        /*styles: [
          {
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#212121"
              }
            ]
          },
          {
            "elementType": "labels.icon",
            "stylers": [
              {
                "visibility": "on"
              }
            ]
          },
          {
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#212121"
              }
            ]
          },
          {
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "featureType": "administrative.country",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#9e9e9e"
              }
            ]
          },
          {
            "featureType": "administrative.land_parcel",
            "stylers": [
              {
                "visibility": "on"
              }
            ]
          },
          {
            "featureType": "administrative.locality",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#bdbdbd"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#181818"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#616161"
              }
            ]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.stroke",
            "stylers": [
              {
                "color": "#1b1b1b"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [
              {
                "visibility": "on"
                // "color": "#2c2c2c"
              }
            ]
          },
          {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                // "color": "#8a8a8a",
                "visibility": "on"
              }
            ]
          },
          {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [
              {
                // "color": "#373737",
                "visibility": "on"
              }
            ]
          },
          {
            "featureType": "administrative",
            "elementType": "labels",
            "stylers": [
              { "visibility": "on" }
            ]
            },{
              "featureType": "poi",
              "elementType": "labels",
              "stylers": [
                { "visibility": "on" }
              ]
            },{
              "featureType": "water",
              "elementType": "labels",
              "stylers": [
                { "visibility": "on" }
              ]
            },{
              "featureType": "road",
              "elementType": "labels",
              "stylers": [
                { "visibility": "on" }
              ]
            },
          {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
              {
                // "color": "#3c3c3c"
                "visibility": "off"
              }
            ]
          },
          {
            "featureType": "road.highway.controlled_access",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#4e4e4e"
              }
            ]
          },
          {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#616161"
              }
            ]
          },
          {
            "featureType": "transit",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#757575"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
              {
                "color": "#000000"
              }
            ]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
              {
                "color": "#3d3d3d"
              }
            ]
          }
        ]*/
      }

      map1 = new google.maps.Map(document.getElementById('map1'), mapOptions);
      // const map2 = new google.maps.Map(document.getElementById('map2'), mapOptions);

      function fgetLocations(url,id,map)
      {
        console.log(url,id);
        $.post(url, [], function(data, textStatus, xhr) {
          if (data.status != "ZERO_RESULTS" && data.status != "OVER_QUERY_LIMIT" && data.status != "REQUEST_DENIED") {

            if (data.results[0]) {
              let l = data.results[0].geometry.location;

              $.post('{{'saveLatLng'}}/'+id, {_token: '{{csrf_token()}}', lat: l.lat, lng: l.lng}, function(data, textStatus, xhr) {
                console.log('saved data');

                var infowindow = new google.maps.InfoWindow({
                  content: `<div class="load-similars"><h6>{{trans('layout.loading')}}...</h6></div>`
                });

                new google.maps.Marker({
                  position: {lat: l.lat, lng: l.lng},
                  map: map
                });

                let marker = new google.maps.Marker({
                  position: {lat: l.lat, lng: l.lng},
                  map: map1
                });

                marker.addListener('click', function() {
                  infowindow.open(map, marker);
                  $('.load-similars').html(`<div style="text-align: center;">
                    <h6>{{trans('layout.loading')}}...</h6>
                  </div>`);
                  setTimeout(()=>{
                    $.post('{{url('findInformation')}}',{_token: '{{csrf_token()}}', lat: l.lat,lng: l.lng}, function(data) {
                      // console.log(data);
                      getInfoWindowInformation(data);
                    });
                  },200)
                });
                /**/
              });
            }
          }else{

            var message = "";
            if (data.status == "ZERO_RESULTS") {
              message = "No se ha podido determinar la posición";
              console.log(message);
            }else{
              message = "OVER_QUERY_LIMIT, debe esperar para enviar mas peticiones a la API";
              console.log(message);
              return false;
            }
          }
        });
      }

      map1.setZoom(8);
      let markers1 = [];
      let markers2 = [];

      let addresses1 = [];
      let addresses2 = [];

      @foreach (App\Models\Technology::all() as $tech)
        @foreach (App\Models\Land::where('analisys_state',1)->where('contract_state',2)->where('technology',$tech->id)->get() as $l)
          @if ($l->lat && $l->lng)
            markers1.push(['{{$l->lat}}', '{{$l->lng}}', '{{$tech->map_marker}}']);
          @else
            addresses1.push({id: {{$l->id}}, address: '{{$l->checkField(158)}}, {{$l->checkField(159)}}' });
          @endif
        @endforeach
      @endforeach

      {{--@foreach (App\Models\Land::where('analisys_state',1)->where('contract_state',2)->where('technology',2)->get() as $l)
      console.log('{{$l->checkField(158)}}')
        @if ($l->lat && $l->lng)
          markers1.push(['{{$l->lat}}', '{{$l->lng}}', '{{url('gh_marker.png')}}']);
        @else
          addresses1.push({id: {{$l->id}}, address: '{{$l->checkField(158)}}, {{$l->checkField(159)}}' });
        @endif
      @endforeach

      @foreach (App\Models\Land::where('analisys_state',1)->where('contract_state',2)->where('technology',3)->get() as $l)
      console.log('{{$l->checkField(158)}}')
        @if ($l->lat && $l->lng)
          markers1.push(['{{$l->lat}}', '{{$l->lng}}', '{{url('st_marker.png')}}']);
        @else
          addresses1.push({id: {{$l->id}}, address: '{{$l->checkField(158)}}, {{$l->checkField(159)}}' });
        @endif
      @endforeach

      @foreach (App\Models\Land::where('analisys_state',1)->where('contract_state',2)->where('technology',4)->get() as $l)
      console.log('{{$l->checkField(158)}}')
        @if ($l->lat && $l->lng)
          markers1.push(['{{$l->lat}}', '{{$l->lng}}', '{{url('dc_marker.png')}}']);
        @else
          addresses1.push({id: {{$l->id}}, address: '{{$l->checkField(158)}}, {{$l->checkField(159)}}' });
        @endif
      @endforeach--}}

      console.log(addresses1,addresses2);

      for (var i = 0; i < addresses1.length; i++) {
        let url = "https://maps.googleapis.com/maps/api/geocode/json?address="+addresses1[i].address+"&key=AIzaSyCysLSKrqHKdBaYLdEP6wqmBFNR-85sMHs"
        fgetLocations(url,addresses1[i].id,map1);
      }

      /*for (var i = 0; i < addresses2.length; i++) {
        let url = "https://maps.googleapis.com/maps/api/geocode/json?address="+addresses2[i].address+"&key=AIzaSyCysLSKrqHKdBaYLdEP6wqmBFNR-85sMHs"
        fgetLocations(url,addresses2[i].id,map1);
      }*/


      for(let i of markers1)
      {
        var infowindow = new google.maps.InfoWindow({
          content: `<div class="load-similars"><h6>Cargando...</h6></div>`
        });

        let marker = new google.maps.Marker({
          position: {lat: parseFloat(i[0]), lng: parseFloat(i[1])},
          icon: {url: i[2], scaledSize: new google.maps.Size(60, 60)},
          map: map1
        });

        marker.addListener('click', function() {
          infowindow.open(map1, marker);
          $('.load-similars').html(`<div style="text-align: center;">
            <h6>Cargando...</h6>
          </div>`);
          setTimeout(()=>{
            $.post('{{url('findInformation')}}',{_token: '{{csrf_token()}}', lat: i[0],lng: i[1]}, function(data) {
              // console.log(data);
              getInfoWindowInformation(data);
            });
          },200)
        });
      }

      /*for(let i of markers2)
      {
        var infowindow = new google.maps.InfoWindow({
          content: `<div class="load-similars"><h6>Cargando...</h6></div>`
        });

        let marker = new google.maps.Marker({
          position: {lat: parseFloat(i[0]), lng: parseFloat(i[1])},
          map: map1
        });

        marker.addListener('click', function() {
          infowindow.open(map1, marker);
          $('.load-similars').html(`<div style="text-align: center;">
            <h6>Cargando...</h6>
          </div>`);
          setTimeout(()=>{
            $.post('{{url('findInformation')}}',{_token: '{{csrf_token()}}', lat: i[0],lng: i[1]}, function(data) {
              // console.log(data);
              getInfoWindowInformation(data);
            });
          },200)
        });
      }*/
  }

  async function getInfoWindowInformation(data)
  {
    let html = `<div>`
    for (let n in data)
    {
      for(let m of data[n])
      {
        let tech = "";

        await $.get('{{url('getTechnology')}}/'+m.technology, function(data, textStatus) {
          tech = data;
        });

        html+=`<div style="line-height: 1.6">`
        html+=`<b>{{trans('layout.project_name')}}:</b> ${m.name} <br>`
        html+=`<b>{{trans('layout.tech')}}:</b> ${tech} <br>`
        html+=`<b>{{trans('layout.partner')}}:</b> ${m.partner.name} <br>`
        html+=`<b>{{trans('layout.set')}}:</b> ${m.substation} <br>`
        html+=`<b>{{trans('layout.km_set')}}:</b> ${m.substation_km} <br>`
        html+=`<b>{{trans('layout.mwpn')}}:</b> ${m.mwp || 0} / ${m.mwn || 0} <br> `
        html+=`<hr>`
        html+=`</div>`
      }
    }
    html+=`</div>`;

    $('.load-similars').html(html);
  }

  $(function () {
    $('[data-toggle="popover"]').popover({
      html: true,
      container: 'body'
    })
  })

  $('[data-target="#select-map"]').click(function(event) {
    /* Act on the event */
    $('[name="zoom"]').val(map1.getZoom());

    let center = map1.getCenter();


    $('[name="center"]').val(center.lat()+','+center.lng());
  });
  
</script>

<script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyCysLSKrqHKdBaYLdEP6wqmBFNR-85sMHs&libraries=places&callback=initMap'></script>

@endsection