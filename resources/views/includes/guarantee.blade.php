@foreach (App\Models\Endorsement::all() as $aval)
  <tr class="table-row" data-id="{{$aval->id}}">
    <td><input onchange="saveRow('{{$aval->id}}')" class="inline-fields main-fields" name="type" value="{{$aval->type}}" type="text"></td>
    <td>{{ $aval->land->name }}</td>

    @foreach ($inputs as $inp)
	    <td>
        <span style="display: none;">
          @if ($inp->type == 'select' || $inp->type == 'provinces')
          selected{{$aval->land->checkField($inp->id)}}
          @else
          {{$aval->land->checkField($inp->id)}}
          @endif
        </span>
        @if ($inp->type == 'textarea')
           <textarea style="min-width: 190px; width: 190px" onchange="saveRow('{{$aval->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" rows="2">{{$aval->land->checkField($inp->id)}}</textarea>
        @endif

        @if ($inp->type == 'text')
           <input onchange="saveRow('{{$aval->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" type="text" value="{{$aval->land->checkField($inp->id)}}">
        @endif

        @if ($inp->type == 'number')
           <input onchange="saveRow('{{$aval->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" type="number" value="{{$aval->land->checkField($inp->id)}}">
        @endif

        @if ($inp->type == 'select')
           <select onchange="saveRow('{{$aval->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}">
            <option value="" selected disabled></option>
            @foreach ($inp->options as $op)
              <option {{$aval->land->checkField($inp->id) == $op->option ? 'selected' : ''}}>{{$op->option}}</option>
            @endforeach
          </select>
        @endif 
        @if ($inp->type == 'provinces')
           <select onchange="saveRow('{{$aval->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}">
            <option value="" selected disabled></option>
            {{-- <option value="">Elige Provincia</option> --}}
            <option value="Álava/Araba" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Álava/Araba') ? 'selected' : ''}}>Álava/Araba</option>
            <option value="Albacete" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Albacete') ? 'selected' : ''}}>Albacete</option>
            <option value="Alicante" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Alicante') ? 'selected' : ''}}>Alicante</option>
            <option value="Almería" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Almería') ? 'selected' : ''}}>Almería</option>
            <option value="Asturias" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Asturias') ? 'selected' : ''}}>Asturias</option>
            <option value="Ávila" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Ávila') ? 'selected' : ''}}>Ávila</option>
            <option value="Badajoz" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Badajoz') ? 'selected' : ''}}>Badajoz</option>
            <option value="Baleares" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Baleares') ? 'selected' : ''}}>Baleares</option>
            <option value="Barcelona" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Barcelona') ? 'selected' : ''}}>Barcelona</option>
            <option value="Burgos" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Burgos') ? 'selected' : ''}}>Burgos</option>
            <option value="Cáceres" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Cáceres') ? 'selected' : ''}}>Cáceres</option>
            <option value="Cádiz" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Cádiz') ? 'selected' : ''}}>Cádiz</option>
            <option value="Cantabria" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Cantabria') ? 'selected' : ''}}>Cantabria</option>
            <option value="Castellón" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Castellón') ? 'selected' : ''}}>Castellón</option>
            <option value="Ceuta" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Ceuta') ? 'selected' : ''}}>Ceuta</option>
            <option value="Ciudad Real" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Ciudad Real') ? 'selected' : ''}}>Ciudad Real</option>
            <option value="Córdoba" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Córdoba') ? 'selected' : ''}}>Córdoba</option>
            <option value="Cuenca" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Cuenca') ? 'selected' : ''}}>Cuenca</option>
            <option value="Gerona/Girona" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Gerona/Girona') ? 'selected' : ''}}>Gerona/Girona</option>
            <option value="Granada" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Granada') ? 'selected' : ''}}>Granada</option>
            <option value="Guadalajara" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Guadalajara') ? 'selected' : ''}}>Guadalajara</option>
            <option value="Guipúzcoa/Gipuzkoa" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Guipúzcoa/Gipuzkoa') ? 'selected' : ''}}>Guipúzcoa/Gipuzkoa</option>
            <option value="Huelva" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Huelva') ? 'selected' : ''}}>Huelva</option>
            <option value="Huesca" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Huesca') ? 'selected' : ''}}>Huesca</option>
            <option value="Jaén" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Jaén') ? 'selected' : ''}}>Jaén</option>
            <option value="La Coruña/A Coruña" {{strtolower($aval->land->checkField($inp->id)) == strtolower('La Coruña/A Coruña') ? 'selected' : ''}}>La Coruña/A Coruña</option>
            <option value="La Rioja" {{strtolower($aval->land->checkField($inp->id)) == strtolower('La Rioja') ? 'selected' : ''}}>La Rioja</option>
            <option value="Las Palmas" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Las Palmas') ? 'selected' : ''}}>Las Palmas</option>
            <option value="León" {{strtolower($aval->land->checkField($inp->id)) == strtolower('León') ? 'selected' : ''}}>León</option>
            <option value="Lérida/Lleida" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Lérida/Lleida') ? 'selected' : ''}}>Lérida/Lleida</option>
            <option value="Lugo" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Lugo') ? 'selected' : ''}}>Lugo</option>
            <option value="Madrid" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Madrid') ? 'selected' : ''}}>Madrid</option>
            <option value="Málaga" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Málaga') ? 'selected' : ''}}>Málaga</option>
            <option value="Melilla" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Melilla') ? 'selected' : ''}}>Melilla</option>
            <option value="Murcia" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Murcia') ? 'selected' : ''}}>Murcia</option>
            <option value="Navarra" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Navarra') ? 'selected' : ''}}>Navarra</option>
            <option value="Orense/Ourense" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Orense/Ourense') ? 'selected' : ''}}>Orense/Ourense</option>
            <option value="Palencia" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Palencia') ? 'selected' : ''}}>Palencia</option>
            <option value="Pontevedra" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Pontevedra') ? 'selected' : ''}}>Pontevedra</option>
            <option value="Salamanca" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Salamanca') ? 'selected' : ''}}>Salamanca</option>
            <option value="Segovia" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Segovia') ? 'selected' : ''}}>Segovia</option>
            <option value="Sevilla" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Sevilla') ? 'selected' : ''}}>Sevilla</option>
            <option value="Soria" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Soria') ? 'selected' : ''}}>Soria</option>
            <option value="Tarragona" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Tarragona') ? 'selected' : ''}}>Tarragona</option>
            <option value="Tenerife" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Tenerife') ? 'selected' : ''}}>Tenerife</option>
            <option value="Teruel" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Teruel') ? 'selected' : ''}}>Teruel</option>
            <option value="Toledo" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Toledo') ? 'selected' : ''}}>Toledo</option>
            <option value="Valencia" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Valencia') ? 'selected' : ''}}>Valencia</option>
            <option value="Valladolid" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Valladolid') ? 'selected' : ''}}>Valladolid</option>
            <option value="Vizcaya/Bizkaia" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Vizcaya/Bizkaia') ? 'selected' : ''}}>Vizcaya/Bizkaia</option>
            <option value="Zamora" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Zamora') ? 'selected' : ''}}>Zamora</option>
            <option value="Zaragoza" {{strtolower($aval->land->checkField($inp->id)) == strtolower('Zaragoza') ? 'selected' : ''}}>Zaragoza</option>
            {{-- @foreach ($inp->options as $op)
              <option >{{$op->option}}</option>
            @endforeach --}}
          </select>
        @endif 

        @if ($inp->type == 'document')
           <input onchange="saveRow('{{$aval->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" type="file">
        @endif 
      </td>
    @endforeach

    {{-- @foreach ($inputs as $inp)
      <td>
      	<input onchange="saveRow('{{$aval->id}}')" class="inline-fields extra-fields" name="type" value="{{$aval->land->checkField($inp->id)}}" type="text">
      </td>
    @endforeach --}}
    <td>
    	<span style="display: none;">selected{{ @App\Models\Status::find($aval->guarantee_status)->name }}</span>
    	<select onchange="saveRow('{{$aval->id}}')" class="inline-fields main-fields" name="guarantee_status">
	      <option value="" selected></option>
	      @foreach (App\Models\Status::where('type','guarantee')->get() as $st)
	      	<option {{$aval->guarantee_status == $st->id ? 'selected' : ''}} value="{{$st->id}}">{{$st->name}}</option>
	      @endforeach
	      {{-- <option {{$aval->guarantee_status == 1 ? 'selected' : ''}} value="1">Validated</option>
	      <option {{$aval->guarantee_status == 2 ? 'selected' : ''}} value="2">Pending Validation</option>
	      <option {{$aval->guarantee_status == 3 ? 'selected' : ''}} value="3">Cancelled</option>
	      <option {{$aval->guarantee_status == 4 ? 'selected' : ''}} value="4">Pending Cancelation</option> --}}
	    </select>
    </td>
    <td>
    	<span style="display: none;">selected{{ @App\Models\Status::find($aval->request_status)->name }}</span>
    	<select onchange="saveRow('{{$aval->id}}')" class="inline-fields main-fields" name="request_status">
	      <option value="" selected></option>
	      @foreach (App\Models\Status::where('type','request')->get() as $st)
	      	<option {{$aval->request_status == $st->id ? 'selected' : ''}} value="{{$st->id}}">{{$st->name}}</option>
	      @endforeach
	      {{-- <option {{$aval->request_status == 1 ? 'selected' : ''}} value="1">Requested</option>
	      <option {{$aval->request_status == 2 ? 'selected' : ''}} value="2">Granted</option>
	      <option {{$aval->request_status == 3 ? 'selected' : ''}} value="3">Denied</option> --}}
	    </select>
    </td>
    <td>
      <input onchange="saveRowLand('{{$aval->land->id}}','{{$aval->id}}')" class="inline-fields land-main-fields" name="mwn" value="{{$aval->land->mwn}}" type="text">
    </td>
    <td>
    	<span style="display: none;">{{ $aval->ammount }}</span>
    	<input onchange="saveRow('{{$aval->id}}')" class="inline-fields main-fields" name="ammount" value="{{$aval->ammount}}" type="text"></td>
    <td>
        {{-- <button class="btn btn-sm btn-success" onclick="saveRow('{{$l->id}}')">Save</button> --}}
        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$aval->id}}">Delete</button>

      </td>
  </tr>
  <div class="modal fade" id="delete-row{{$aval->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">Delete this row?</div>
        <div class="modal-footer">
          <a href="{{url('deleteGuarantee',$aval->id)}}" class="btn btn-sm btn-success">Yes, Delete</a>
          <button class="btn btn-sm btn-warning" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  </tr>
@endforeach