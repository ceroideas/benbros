<style>
	.edit-button, .delete-button, .status-button, .translate-button {
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

	.each-input:hover .status-button {
		display: inline-block;
	}
</style>
<div class="modal fade" id="builder-1">
	
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Inputs from Guarantee
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-sm-12">
						<div id="create-input"></div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-xs btn-info pull-right" onclick="addInput()">Crear input</button>
					</div>
					<div class="col-sm-12" id="all-inputs">

						<br>

						@foreach (App\Models\Input::where('table','land')->where('guarantee','!=',0)->orderBy('order','asc')->get() as $inp)

							<div class="mb-3 each-input">
								<label>{{$inp->title}}

									<i data-id="{{$inp->id}}" class="fas fa-edit edit-button"></i>

									<i data-target="#translate-{{$inp->id}}" data-toggle="modal" class="fas fa-flag translate-button"></i>

									{{-- <i class="fas fa-trash delete-button" data-toggle="modal" data-target="#delete-button{{$inp->id}}"></i>

									@if ($inp->status)
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

							<div class="modal fade translate-modal" id="translate-{{$inp->id}}">
								<div class="modal-dialog modal-sm">
									<form class="modal-content form-translate" method="POST" action="{{url('saveTranslation')}}">
										{{csrf_field()}}
										<div class="modal-header">{{trans('layout.translate_lands')}}</div>
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

							{{-- <div class="modal fade" id="delete-button{{$inp->id}}">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">Borrar el Campo seleccionado?</div>
										<div class="modal-footer">
											<a href="{{url('delete-input',$inp->id)}}" class="btn btn-success btn-xs">Borrar</a>
											<button data-dismiss="modal" class="btn btn-danger btn-xs">Cancelar</button>
										</div>
									</div>
								</div>
							</div> --}}

						@endforeach

					</div>
				</div>

			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>

</div>


<div class="modal fade" id="builder-2">
	
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Inputs from Guarantee
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

						@foreach (App\Models\Input::where('table','land')->where('guarantee','!=',0)->orderBy('order','asc')->get() as $inp)

							<div class="mb-3 each-input">
								<label>{{$inp->title}}

									{{-- <i data-id="{{$inp->id}}" class="fas fa-edit edit-button"></i>

									<i class="fas fa-trash delete-button" data-toggle="modal" data-target="#delete-button{{$inp->id}}"></i> --}}

									@if ($inp->status)
										<i data-id="{{$inp->id}}" class="fas fa-eye status-button"></i>
									@else
										<i data-id="{{$inp->id}}" class="fas fa-eye-slash status-button"></i>
									@endif

								</label>
								@if ($inp->type == 'select')
									@foreach ($inp->options as $opt)
										<li>{{$opt->option}}</li>
									@endforeach
								@endif
								@if ($inp->type == 'document')
								@endif
							</div>

							{{-- <div class="modal fade" id="delete-button{{$inp->id}}">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">Borrar el Campo seleccionado?</div>
										<div class="modal-footer">
											<a href="{{url('delete-input',$inp->id)}}" class="btn btn-success btn-xs">Borrar</a>
											<button data-dismiss="modal" class="btn btn-danger btn-xs">Cancelar</button>
										</div>
									</div>
								</div>
							</div> --}}

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
				Inputs from Guarantee
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

						@foreach (App\Models\Input::where('table','land')->where('guarantee','!=',0)->orderBy('order','asc')->get() as $inp)

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
	
	function changeType(elem) {

		var elem = $(elem);

		var html = "";
		
		if ($(elem).val() == 'checkbox' || $(elem).val() == 'radio' || $(elem).val() == 'select') {
			html += '<div class="form-group">\
				<label style="display:block; width: 100%; margin-bottom: 15px">Añadir opción <button type="button" onclick="addOption(this)" class="btn btn-xs btn-success pull-right" type=""><i class="fa fa-plus"></i></button></label>\
				<ul class="option-list" style="padding-left: 20px">\
					<li class="option-li">\
					<div class="input-group mb-3">';
						html+='<input type="text" name="options[]" required class="form-control" placeholder="Opción" />';
						html+='<div class="input-group-append">\
							<button onclick="removeOption(this)" type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>';
						html+='</div>\
					</div>';
					html+='</li>\
				</ul>\
				';

			html+= '</div>';
			// $(elem).parents('.creator').find('.show-subservice').removeClass('hide');
		}

		$(elem).parents('.creator').find('.input-list').html(html);
	}

	function addInput() {
		var v = $('#create-input').find('.create-input');
		if (v.length == 0) {
			$.get('{{url('getTemplate')}}', function(data) {

				$('#create-input').html(data);
				$('[name="guarantee"]').prop('checked',true);

				$('.saveInput').unbind('submit');
				$('.saveInput').submit(saveAjax);

			});
		}
	}

	$('.edit-button').click(function (e) {
		e.preventDefault();

		$.get('{{url('getTemplateEdit')}}/'+$(this).data('id'), function(data) {

			$('#create-input').html(data);
			$('[name="guarantee"]').prop('checked',true);

			$('.saveInput').unbind('submit');
			$('.saveInput').submit(saveAjax);
		});
	});

	function addOption(elem) {

		$(elem).parents('label').next('.option-list').append('<li class="option-li">\
			<div class="input-group mb-3">\
				<input type="text" name="options[]" required class="form-control" placeholder="Opción" />\
				<div class="input-group-btn">\
					<button onclick="removeOption(this)" type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>\
				</div>\
			</div>\
		</li>');
	}

	function removeOption(elem) {
		console.log(elem)
		$(elem).parents('.option-li').remove();
	}

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
		            title: "Completado",
		            text: "Se ha guardado el campo correctamente",
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

	$('.status-button').click(function (e) {
		e.preventDefault();

		let elem = $(this);

		$.get('{{url('change-status')}}/'+$(this).data('id'), function(data) {
			/*optional stuff to do after success */

			if (data[0] == 1) {
				elem.removeClass('fa-eye');
				elem.removeClass('fa-eye-slash');

				elem.addClass('fa-eye');
			}else{
				elem.removeClass('fa-eye');
				elem.removeClass('fa-eye-slash');

				elem.addClass('fa-eye-slash');
			}

			var notice = PNotify.success({
	            title: "Completado",
	            text: "Se ha cambiado el status",
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

			$('#example1').DataTable().destroy();

			$('#all-lands').html(data[1]);

			$('#header-changed').html(data[2]);
			$('#footer-changed').html(data[2]);

			$.each($('.filters th input'), function(index, val) {
			let ph = $(this).attr('placeholder');
			$(this).parent('th').text(ph);
			});

			initDatatable();
		});
	});

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