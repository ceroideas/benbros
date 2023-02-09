<style>
	.edit-button, .translate-button, .delete-button {
		display: none;
		margin-left: 8px;
		cursor: pointer;
	}
	.each-input:hover .edit-button, .each-input:hover .translate-button {
		display: inline-block;
	}
	.each-input:hover .delete-button {
		display: inline-block;
	}
</style>
<div class="modal fade" id="builder-2">
	
	<div class="modal-dialog">
		<form class="modal-content" action="{{url('addNewProject')}}" method="POST">
			{{csrf_field()}}
			<div class="modal-header">
				{{trans('projects.select_proj')}}
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
	  	        			<label>{{trans('projects.project')}}</label>

							<select name="land_id" class="form-control" required>
								@foreach (App\Models\Land::whereNotExists(function($q){
									$q->from('permissions')
									  ->whereRaw('permissions.land_id = lands.id');
								})->where('name','!=','')->get() as $land)

				  	          		<option value="{{$land->id}}">{{$land->name}}</option>
									
								@endforeach
				  	        </select>

	  	        		</div>

	  	        		<div class="form-group">
	  	        			<label>{{trans('projects.tram_type')}}</label>

							<select name="tramitation_type" class="form-control">
				  	          	<option>{{trans('projects.conc')}}</option>
				  	          	<option>{{trans('projects.solic')}}</option>
				  	        </select>

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

<div class="modal fade" id="builder-1">
	
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				{{trans('projects.input')}}
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-sm-12">
						<div id="create-input">
							
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-xs btn-info pull-right" onclick="addInput()">{{trans('projects.create_inp')}}</button>
					</div>
					<div class="col-sm-12" id="all-inputs">

						<br>

						@foreach (App\Models\Section::all() as $sect)

							<h5>
								{{$sect->name}}	
							</h5>

								
							@foreach (App\Models\Input::where('table','project')->where('section_id',$sect->id)->orderBy('order','asc')->get() as $inp)
							<div class="mb-3 each-input" style="margin-left: 20px;">
								<label>{{$inp->title}} <i data-id="{{$inp->id}}" class="fas fa-edit edit-button"></i> </label>

								<i data-target="#translate-{{$inp->id}}" data-toggle="modal" class="fas fa-flag translate-button"></i>

								@foreach ($inp->options as $opt)
									<li>{{$opt->option}}</li>
								@endforeach

								<div class="modal fade translate-modal" id="translate-{{$inp->id}}">
									<div class="modal-dialog modal-sm">
										<form class="modal-content form-translate" method="POST" action="{{url('saveTranslation')}}">
											{{csrf_field()}}
											<div class="modal-header">{{trans('layout.translate_inputs')}}</div>
											<div class="modal-body">


												<input type="hidden" name="table" value="inputs">
												<input type="hidden" name="lang" value="en">
												<input type="hidden" name="ref_id" value="{{$inp->id}}">

												<div class="form-group">
													<label>English Translations</label>

													<input type="text" class="form-control mb-3" placeholder="Title" name="column[title]" value="{{$inp->getTranslation('title','en',true)}}"> 
													<input type="text" class="form-control mb-3" placeholder="Placeholder" name="column[placeholder]" value="{{$inp->getTranslation('placeholder','en',true)}}"> 
													<input type="text" class="form-control mb-3" placeholder="Information" name="column[information]" value="{{$inp->getTranslation('information','en',true)}}">
												</div>

											</div>
											<div class="modal-footer">
												<button class="btn btn-success btn-xs">{{trans('layout.accept')}}</button>
												<button type="button" data-dismiss="modal" class="btn btn-danger btn-xs">{{trans('layout.cancel')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							@endforeach
						@endforeach

					</div>
				</div>

			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>

</div>


<div class="modal fade" id="builder-3">
	
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Inputs from Lands
			</div>
			<div class="modal-body">

				{{-- <div class="row">
					<div class="col-sm-12">
						<div id="create-input"></div>
					</div>
				</div> --}}

				<div class="row">
					{{-- <div class="col-sm-12">
						<button class="btn btn-xs btn-info pull-right" onclick="addInput()">Crear input</button>
					</div> --}}
					<div class="col-sm-12" {{-- id="all-inputs" --}}>

						<br>

						@foreach (App\Models\Input::where('table','project')->orderBy('order','asc')->get() as $inp)

							<div class="mb-3 each-input">
								<label>{{$inp->title}}

									{{-- <i data-id="{{$inp->id}}" class="fas fa-edit edit-button"></i> --}}

									<i class="fas fa-trash delete-button" data-toggle="modal" data-target="#delete-button{{$inp->id}}"></i>

									{{-- @if ($inp->status)
										<i data-id="{{$inp->id}}" class="fas fa-eye status-button"></i>
									@else
										<i data-id="{{$inp->id}}" class="fas fa-eye-slash status-button"></i>
									@endif --}}

								</label>
								@if ($inp->type == 'select')
									@foreach ($inp->options as $opt)
										<li>{{$opt->option}}</li>
									@endforeach
								@endif
								@if ($inp->type == 'document')
								@endif
							</div>

							<div class="modal fade" id="delete-button{{$inp->id}}">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">Borrar el Campo seleccionado?</div>
										<div class="modal-footer">
											<a href="{{url('delete-input',$inp->id)}}" class="btn btn-success btn-xs">Borrar</a>
											<button data-dismiss="modal" class="btn btn-danger btn-xs">Cancelar</button>
										</div>
									</div>
								</div>
							</div>

						@endforeach

					</div>
				</div>

			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>

</div>

@section('scripts1')
<script>


	function addInput() {
		var v = $('#create-input').find('.create-input');
		if (v.length == 0) {
			$.get('{{url('api/getPermissionTemplate')}}', function(data) {

				$('#create-input').html(data);

				$('.saveInput').unbind('submit');
				$('.saveInput').submit(saveAjax);
			});
		}
	}

	$('.edit-button').click(function (e) {
		e.preventDefault();

		$.get('{{url('api/getTemplatePermissionEdit')}}/'+$(this).data('id'), function(data) {

			$('#create-input').html(data);

			$('.saveInput').unbind('submit');
			$('.saveInput').submit(saveAjax);
		});
	});

	function saveAjax(event) {
		event.preventDefault();
		var formData = new FormData(this);
		formData.append('_token','{{csrf_token()}}');

		$.ajax({
			url: $(this).attr('action'),
			type: $(this).attr('method'),
			data: formData,
    		cache:false,
            contentType: false,
            processData: false,
		})
		.done(function(data) {

			$('.modal').modal('hide');

			setTimeout(()=>{
				location.reload();
			},2000);
			setTimeout(()=>{ 
				// $('#forms').html(data.data);

				// $('#start-sorting').click(startSorting);
				// $('#stop-sorting').click(stopSorting);

				$('.add-input').click(addInput);

				var notice = PNotify.success({
		            title: "{{trans('projects.completed')}}",
		            text: "{{trans('projects.success')}}",
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
			},300);
		})
		.fail(function(e) {
			console.log(e);
			$.each(e.responseJSON.errors, function(index, val) {
				html+="- "+val+"<br>";
			});

			var notice = PNotify.error({
	            title: "Error",
	            text: html,
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
		.always(function() {
			// console.log("complete");
		});

	}

	$('.form-translate').submit(function(event) {
		/* Act on the event */
		event.preventDefault();

		$.post($(this).attr('action'), $(this).serializeArray(), function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			$('.translate-modal').modal('hide');
			var notice = PNotify.success({
	            title: "Traduccion guardada",
	            // text: html,
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
			console.log('hecho');
		});
	});

</script>
@endsection