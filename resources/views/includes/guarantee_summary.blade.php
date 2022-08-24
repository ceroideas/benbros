<div class="row">
	<div class="col-sm-4">
		<table class="table table-bordered">
			<thead>
				<th>Guarantee Status</th>
				<th>Amount</th>
				<th>MWn</th>
			</thead>

			@php
				$total_amount = 0;
				$total_mwn = 0;
			@endphp
			
			@foreach (App\Models\Status::where('type','guarantee')->get() as $st)
				<tr>
					<td>Total {{$st->name}}</td>
					<td>
						@php
							$sub_ttl_am = App\Models\Endorsement::where('guarantee_status',$st->id)->sum('ammount');
							$total_amount += $sub_ttl_am;
							echo number_format($sub_ttl_am,2).'€'
						@endphp
					</td>
					<td>
						@php
							$sub_ttl_mwn = App\Models\Land::whereExists(function($q) use($st){
								$q->from('endorsements')
								  ->whereRaw('endorsements.guarantee_status = '.$st->id)
								  ->whereRaw('endorsements.land_id = lands.id');
							})->sum('mwn');
							$total_mwn += $sub_ttl_mwn;
							echo number_format($sub_ttl_mwn,2);
						@endphp	
					</td>
				</tr>
			@endforeach

			<tfoot>
				<tr>
					<th>Total Guarantees</th>
					<th>{{ number_format($total_amount,2) }}€</th>
					<th>{{ number_format($total_mwn,2) }}</th>
				</tr>
			</tfoot>

			{{-- <tr>
				<td>Total Pending Validation</td>
				<td>{{ number_format(App\Models\Endorsement::where('guarantee_status',2)->sum('ammount'),2) }}€</td>
				<td>{{ App\Models\Land::whereExists(function($q){
					$q->from('endorsements')
					  ->whereRaw('endorsements.guarantee_status = 2')
					  ->whereRaw('endorsements.land_id = lands.id');
				})->sum('mwn') }}</td>
			</tr>

			<tr>
				<td>Total Cancelled</td>
				<td>{{ number_format(App\Models\Endorsement::where('guarantee_status',3)->sum('ammount'),2) }}€</td>
				<td>{{ App\Models\Land::whereExists(function($q){
					$q->from('endorsements')
					  ->whereRaw('endorsements.guarantee_status = 3')
					  ->whereRaw('endorsements.land_id = lands.id');
				})->sum('mwn') }}</td>
			</tr>

			<tr>
				<td>Total Pending Cancellation</td>
				<td>{{ number_format(App\Models\Endorsement::where('guarantee_status',4)->sum('ammount'),2) }}€</td>
				<td>{{ App\Models\Land::whereExists(function($q){
					$q->from('endorsements')
					  ->whereRaw('endorsements.guarantee_status = 4')
					  ->whereRaw('endorsements.land_id = lands.id');
				})->sum('mwn') }}</td>
			</tr> --}}

		</table>
	</div>

	<div class="col-sm-4">
		<table class="table table-bordered">

			<thead>
				<th>Request status</th>
				<th>Amount</th>
				<th>MWn</th>
			</thead>
				
			@foreach (App\Models\Status::where('type','request')->get() as $st)
				<tr>
					<td>Total {{$st->name}}</td>
					<td>{{ number_format(App\Models\Endorsement::where('request_status',$st->id)->sum('ammount'),2) }}€</td>
					<td>{{ App\Models\Land::whereExists(function($q) use($st){
						$q->from('endorsements')
						  ->whereRaw('endorsements.request_status = '.$st->id)
						  ->whereRaw('endorsements.land_id = lands.id');
					})->sum('mwn') }}</td>
				</tr>
			@endforeach               	

			{{-- <tr>
				<td>Total Granted</td>
				<td>{{ number_format(App\Models\Endorsement::where('request_status',2)->sum('ammount'),2) }}€</td>
				<td>{{ App\Models\Land::whereExists(function($q){
					$q->from('endorsements')
					  ->whereRaw('endorsements.request_status = 2')
					  ->whereRaw('endorsements.land_id = lands.id');
				})->sum('mwn') }}</td>
			</tr>

			<tr>
				<td>Total Denied</td>
				<td>{{ number_format(App\Models\Endorsement::where('request_status',3)->sum('ammount'),2) }}€</td>
				<td>{{ App\Models\Land::whereExists(function($q){
					$q->from('endorsements')
					  ->whereRaw('endorsements.request_status = 3')
					  ->whereRaw('endorsements.land_id = lands.id');
				})->sum('mwn') }}</td>
			</tr> --}}

		</table>
	</div>
</div>