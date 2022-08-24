@php
	$lands = App\Models\Land::orderBy('id','desc')->get();
  $partners = App\Models\Partner::all();
  $inputs = App\Models\Input::where('table','land')->orderBy('order','asc')->get();
@endphp
@forelse ($lands as $l)
  <tr data-id="{{$l->id}}" class="table-row">
    <td>{{$l->id}}
    </td>
    <td> 
      {{$l->partner ? $l->partner->name : ''}}
    </td>
    <td> {{$l->month}}</td>
    <td> {{$l->week}}</td>
    <td> {{$l->name}}</td>
    <td>
        @switch($l->analisys_state)
          @case(1) selectedAccepted @break
          @case(2) selectedRejected @break
          @case(3) selectedUnder Study @break
          @case(4) selectedTo Clarify @break
          @case(5) selectedFor Positioning @break
          @case(6) selectedAccepted as Fictition @break
        @endswitch </td>
    <td>
        @switch($l->contract_state)
          @case(1) selectedNo Deal @break
          @case(2) selectedSigned @break
          @case(3) selectedIn Negotia tion @break
          @case(4) selectedAdvanced Negation @break
          @case(5) selectedNot Started @break
        @endswitch </td>
    <td> {{$l->negotiator}} </td>
    <td> {{$l->partner_info}} </td>
    <td> {{$l->mwp}}</td>
    <td> {{$l->mwn}}</td>
    <td>
        @switch($l->technology)
          @case(1) selectedFV @break
          @case(2) selectedGreen Hydrogen @break
          @case(3) selectedStorage @break
          @case(4) selectedHybrid @break
        @endswitch
    </td>
    <td> {{$l->substation}} </td>
    <td> {{$l->substation_km}} </td>
    @foreach ($inputs as $inp)
	    <td>
        {{$l->checkField($inp->id)}}

        {{-- @if ($inp->type == 'document')
           <input onchange="saveRow('{{$l->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" type="file">
        @endif  --}}
      </td>
      @endforeach
  </tr>
@empty
  <tr>
    <td colspan="{{ count($inputs)+10}}">Empty list...</td>
  </tr>
@endforelse