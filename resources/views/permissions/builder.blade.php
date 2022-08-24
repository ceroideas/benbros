<style>
	.edit-button {
		display: none;
		margin-left: 8px;
		cursor: pointer;
	}
	.each-input:hover .edit-button {
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
								@foreach ($inp->options as $opt)
									<li>{{$opt->option}}</li>
								@endforeach
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

</script>
@endsection