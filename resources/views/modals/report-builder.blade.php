<div class="modal fade" id="report-builder">
	
	<div class="modal-dialog modal-lg">
		<form class="modal-content" method="POST" action="{{url('generate-report')}}">
			{{csrf_field()}}
			<input type="hidden" name="id" value="0">
			<div class="modal-header">
				Create new Report
			</div>
			<div class="modal-body">

				<div class="row">
					{{-- <div class="col-sm-12">
						<div class="form-group">
							<label>Report Name</label>
							<input type="text" class="form-control" name="title">

						</div>
					</div> --}}
					<div class="col-sm-12" id="all-inputs">

						<br>

						<label>Select columns to Report</label>

						<div class="row">
							@foreach (App\Models\Input::where('table','land')->orderBy('order','asc')->get() as $inp)

								<div class="mb-3 each-checkbox col-sm-4">

									<div class="checkbox">
										<label>
											<input type="checkbox" name="ids[]" value="{{$inp->id}}" checked>
											{{$inp->title}}

										</label>
									</div>
									{{-- @if ($inp->type == 'select')
										@foreach ($inp->options as $opt)
											<li>{{$opt->option}}</li>
										@endforeach
									@endif --}}
								</div>

							@endforeach
						</div>

					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button class="btn btn-succss" id="generate-report">Generate Report</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</form>
	</div>

</div>

@section('scripts2')

<script>
	
	/*$('#generate-report').click(function (e) {
		e.preventDefault();

		let ids = [];

		$.each($('.each-checkbox [type="checkbox"]:checked'), function(index, val) {
			ids.push($(this).val());
		});

		$.post('{{url('generate-report')}}', {_token: '{{csrf_token()}}', ids: ids, id: 0}, function(data, textStatus, xhr) {
			console.log(data);
			// window.open('{{url('exports/lands-export.xlsx')}}','_blank');
			window.open('{{storage_path('app/public')}}/lands-export.xlsx','_blank');
		});

		$('#report-builder').modal('hide');
	});*/

</script>

@endsection