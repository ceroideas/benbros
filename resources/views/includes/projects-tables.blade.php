<style>
	.img-top-central {
		margin: auto;
		position: relative;
		display: block;
		height: 70px;
		margin-bottom: 12px;
	}
</style>

<div class="col-md-12">
	<div class="row">
		@foreach (App\Models\Technology::all() as $tech)
			<div class="col-sm-3">

				<img src="{{$tech->icon}}" alt="" class="img-top-central">
				
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
		@endforeach
    </div>
</div>