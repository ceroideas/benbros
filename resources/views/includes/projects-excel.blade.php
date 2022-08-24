@forelse (App\Models\Permission::whereExists(function($q){
  $q->from('lands')
  ->whereRaw('permissions.land_id = lands.id');
})->get() as $p)
<tr data-id="{{$p->id}}" class="table-row">
	<td><a href="{{url('project',$p->id)}}">{{$p->land->name}}</a></td>
	<td>
		@switch($p->land->technology)
          @case(1) FV @break
          @case(2) Green Hydrogen @break
          @case(3) Storage @break
          @case(4) Hybrid @break
      @endswitch
	</td>
	<td>
    {{$p->tramitation_type}}
  </td>
	@foreach ($sections as $sect)
    @if ($sect->inputs)
        @foreach ($sect->inputs as $inp)
          <td style="min-width: 120px;">
            {{$p->checkField($inp->id)}}
          </td>
        @endforeach
    @endif
  @endforeach
  </tr>
@empty
  <tr>
    <td colspan="{{ (App\Models\Input::where('type','project')->count())+4}}">Empty list...</td>
  </tr>
@endforelse