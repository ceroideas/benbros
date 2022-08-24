<style>
	.img-top-central {
		margin: auto;
		position: relative;
		display: block;
		height: 40px;
		margin-bottom: 12px;
	}

	.page_break { page-break-before: always; }

	.info-box-text {
		font-family: helvetica;
		padding: 8px;
		display: block;
		border-radius: 8px;
		margin: 4px 0;
	}

	.bg-primary {
		background-color: lightblue !important;
	}

	.bg-default {
		background-color: #f1f1f1;
	}

	table td {
		vertical-align: top;
	}

	main {
	  margin: 0;
	  margin-top: 0;
	  line-height: 36px;
	}

	main div {
	  padding-left: 8px;
	}

	.header {
    position: fixed;
    top: -150px;
    left: -60px;
    right: 0px;
    /* height: 50px; */
    font-size: 20px !important;

    /** Extra personal styles **/
    background-color: #fff;
    color: white;
    text-align: center;
    line-height: 35px;
  }

  @page {
    margin-top: 150px;
    font-family: Arial, Helvetica, sans-serif;
	}
	.left-title {
	    text-align: center;
	    background-color: #2a3963;
	    color: #fff;
	    padding: 20px;
	    width: 400px;
	    height: 60px;
	}
	.left-title h1 {
	    /* margin: 0 !important; */
	    margin-top: 15px;
	    margin-bottom: 0;
	}
</style>

<div class="header">
    <div class="left-title">
        <h1>Map Report</h1>

        {{-- <small></small> --}}
    </div>
    <img src="./1.png" alt="" style="float: right; position: absolute; top: 20px; right: 100px; width: 250px">
</div>

{{-- <h2 style="font-family: helvetica;">Reporte de mapa</h2> --}}

<img style="width: 100vw; height: 550px;" src="https://maps.googleapis.com/maps/api/staticmap?center={{$r->center}}
&zoom={{$r->zoom ? $r->zoom : 13}}
&size=640x400
&scale=2
&maptype=roadmap
@foreach (App\Models\Technology::all() as $tech)
	@if ($r['T_'.$tech->id])
		@foreach (App\Models\Land::where('analisys_state',1)->where('contract_state',2)->where('technology',$tech->id)->get() as $l)
			@if ($l->lat && $l->lng)
			  &markers=color:{{$tech->report_color}}%7Clabel:F%7C{{$l->lat}},{{$l->lng}}
			@endif
		@endforeach
	@endif
@endforeach
&key=AIzaSyCysLSKrqHKdBaYLdEP6wqmBFNR-85sMHs" alt="">

<div>
	<br>
	<table style="width: 100%;">
		<tbody>
			<tr>
				@foreach (App\Models\Technology::all() as $tech)
				<td style="float: left; width: 25%">
					<img src="{{ $tech->map_marker }}" style="width: 24px;" alt="">
					<span style="font-size: 12px;">{{(App::getLocale() == 'es' ? $tech->name : $tech->name_en)}}</span>
				</td>
				@endforeach

			</tr>
		</tbody>
	</table>
	<div style="clear: both;"></div>
</div>


<div class="page_break"></div>

<table style="width: 100%;">
	
	<tr>
		@foreach (App\Models\Technology::all() as $tech)
			@if ($r['T_'.$tech->id])
				<td width="25%">
					<div class="col-sm-3">
			
					    <!-- Info Boxes Style 2 -->
					    <div class="info-box mb-3 bg-primary small-box">
					      {{-- <span class="info-box-icon"><i class="fas fa-tag"></i></span> --}}

					      <div class="info-box-content">
					        <span class="info-box-text"><span>{{trans('layout.summary')}} {{(App::getLocale() == 'es' ? $tech->name : $tech->name_en)}}</span> </span>
					      </div>
					      <!-- /.info-box-content -->
					    </div>

					    @if($tech->n_project == 1) <div class="info-box mb-3 bg-default small-box">
					      {{-- <span class="info-box-icon"><i class="fas fa-tag"></i></span> --}}

					      <div class="info-box-content">
					        <span class="info-box-text">{{trans('layout.n_proj')}} <span class="info-box-number-2" style="margin: 0;">{{App\Models\Land::where('technology',$tech->id)->count()}}</span> </span>
					      </div>
					      <!-- /.info-box-content -->
					    </div>
					    @endif
					    <!-- /.info-box -->

					    @if($tech->n_mwn == 1) <div class="info-box mb-3 bg-default small-box">
					      {{-- <span class="info-box-icon"><i class="far fa-heart"></i></span> --}}

					      <div class="info-box-content">
					        <span class="info-box-text">{{trans('layout.n_mwp')}} <span class="info-box-number-2" style="margin: 0;">
					          {{App\Models\Land::where('technology',$tech->id)->sum('mwp')}}
					        </span> </span>
					      </div>
					      <!-- /.info-box-content -->
					    </div>
					    @endif
					    <!-- /.info-box -->

					    @if($tech->n_mwp == 1) <div class="info-box mb-3 bg-default small-box">
					      {{-- <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span> --}}

					      <div class="info-box-content">
					        <span class="info-box-text">{{trans('layout.n_mwn')}} <span class="info-box-number-2" style="margin: 0;">
					          {{App\Models\Land::where('technology',$tech->id)->sum('mwn')}}
					        </span> </span>
					      </div>
					      <!-- /.info-box-content -->
					    </div>
					    @endif
					    <!-- /.info-box -->

					    @if($tech->tenders == 1) <div class="info-box mb-3 bg-default small-box">
					      {{-- <span class="info-box-icon"><i class="far fa-comment"></i></span> --}}

					      <div class="info-box-content">
					        <span class="info-box-text">{{trans('layout.conc')}} <span class="info-box-number-2" style="margin: 0;">
					          {{App\Models\Land::where('technology',$tech->id)->whereExists(function($q){
					            $q->from('permissions')
					              ->whereRaw('permissions.land_id = lands.id')
					              ->whereRaw('permissions.tramitation_type = "Concurso"');
					          })->count()}}
					        </span> </span>
					      </div>
					      <!-- /.info-box-content -->
					    </div>
					    @endif

					    <!-- /.info-box -->
					    @if($tech->ac_req == 1) <div class="info-box mb-3 bg-default small-box">
					      {{-- <span class="info-box-icon"><i class="far fa-heart"></i></span> --}}

					      <div class="info-box-content">
					        <span class="info-box-text">{{trans('layout.solic')}} <span class="info-box-number-2" style="margin: 0;">
					          {{App\Models\Land::where('technology',$tech->id)->whereExists(function($q){
					            $q->from('permissions')
					              ->whereRaw('permissions.land_id = lands.id')
					              ->whereRaw('permissions.tramitation_type = "Solicitud AyC"');
					          })->count()}}
					        </span> </span>
					      </div>
					      <!-- /.info-box-content -->
					    </div>
					    @endif
					    <!-- /.card -->
					</div>
				</td>
			@endif
		@endforeach
	</tr>

</table>




			

			

			