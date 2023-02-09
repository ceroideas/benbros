@php
  function stripAccents($str) {
      return strtolower(trim(strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ/'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY-')));
  }
@endphp
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
              <option {{stripAccents($aval->land->checkField($inp->id)) == stripAccents($op->option) ? 'selected' : ''}}>{{$op->option}}</option>
            @endforeach
          </select>
        @endif 
        @if ($inp->type == 'provinces')
           <select onchange="saveRow('{{$aval->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}">
            <option value="" selected disabled></option>
            {{-- <option value="">Elige Provincia</option> --}}
            <option value="Álava/Araba" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Álava/Araba') ? 'selected' : ''}}>Álava/Araba</option>
            <option value="Albacete" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Albacete') ? 'selected' : ''}}>Albacete</option>
            <option value="Alicante" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Alicante') ? 'selected' : ''}}>Alicante</option>
            <option value="Almería" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Almería') ? 'selected' : ''}}>Almería</option>
            <option value="Asturias" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Asturias') ? 'selected' : ''}}>Asturias</option>
            <option value="Ávila" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Ávila') ? 'selected' : ''}}>Ávila</option>
            <option value="Badajoz" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Badajoz') ? 'selected' : ''}}>Badajoz</option>
            <option value="Baleares" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Baleares') ? 'selected' : ''}}>Baleares</option>
            <option value="Barcelona" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Barcelona') ? 'selected' : ''}}>Barcelona</option>
            <option value="Burgos" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Burgos') ? 'selected' : ''}}>Burgos</option>
            <option value="Cáceres" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Cáceres') ? 'selected' : ''}}>Cáceres</option>
            <option value="Cádiz" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Cádiz') ? 'selected' : ''}}>Cádiz</option>
            <option value="Cantabria" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Cantabria') ? 'selected' : ''}}>Cantabria</option>
            <option value="Castellón" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Castellón') ? 'selected' : ''}}>Castellón</option>
            <option value="Ceuta" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Ceuta') ? 'selected' : ''}}>Ceuta</option>
            <option value="Ciudad Real" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Ciudad Real') ? 'selected' : ''}}>Ciudad Real</option>
            <option value="Córdoba" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Córdoba') ? 'selected' : ''}}>Córdoba</option>
            <option value="Cuenca" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Cuenca') ? 'selected' : ''}}>Cuenca</option>
            <option value="Gerona/Girona" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Gerona/Girona') ? 'selected' : ''}}>Gerona/Girona</option>
            <option value="Granada" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Granada') ? 'selected' : ''}}>Granada</option>
            <option value="Guadalajara" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Guadalajara') ? 'selected' : ''}}>Guadalajara</option>
            <option value="Guipúzcoa/Gipuzkoa" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Guipúzcoa/Gipuzkoa') ? 'selected' : ''}}>Guipúzcoa/Gipuzkoa</option>
            <option value="Huelva" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Huelva') ? 'selected' : ''}}>Huelva</option>
            <option value="Huesca" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Huesca') ? 'selected' : ''}}>Huesca</option>
            <option value="Jaén" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Jaén') ? 'selected' : ''}}>Jaén</option>
            <option value="La Coruña/A Coruña" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('La Coruña/A Coruña') ? 'selected' : ''}}>La Coruña/A Coruña</option>
            <option value="La Rioja" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('La Rioja') ? 'selected' : ''}}>La Rioja</option>
            <option value="Las Palmas" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Las Palmas') ? 'selected' : ''}}>Las Palmas</option>
            <option value="León" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('León') ? 'selected' : ''}}>León</option>
            <option value="Lérida/Lleida" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Lérida/Lleida') ? 'selected' : ''}}>Lérida/Lleida</option>
            <option value="Lugo" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Lugo') ? 'selected' : ''}}>Lugo</option>
            <option value="Madrid" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Madrid') ? 'selected' : ''}}>Madrid</option>
            <option value="Málaga" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Málaga') ? 'selected' : ''}}>Málaga</option>
            <option value="Melilla" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Melilla') ? 'selected' : ''}}>Melilla</option>
            <option value="Murcia" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Murcia') ? 'selected' : ''}}>Murcia</option>
            <option value="Navarra" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Navarra') ? 'selected' : ''}}>Navarra</option>
            <option value="Orense/Ourense" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Orense/Ourense') ? 'selected' : ''}}>Orense/Ourense</option>
            <option value="Palencia" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Palencia') ? 'selected' : ''}}>Palencia</option>
            <option value="Pontevedra" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Pontevedra') ? 'selected' : ''}}>Pontevedra</option>
            <option value="Salamanca" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Salamanca') ? 'selected' : ''}}>Salamanca</option>
            <option value="Segovia" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Segovia') ? 'selected' : ''}}>Segovia</option>
            <option value="Sevilla" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Sevilla') ? 'selected' : ''}}>Sevilla</option>
            <option value="Soria" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Soria') ? 'selected' : ''}}>Soria</option>
            <option value="Tarragona" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Tarragona') ? 'selected' : ''}}>Tarragona</option>
            <option value="Tenerife" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Tenerife') ? 'selected' : ''}}>Tenerife</option>
            <option value="Teruel" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Teruel') ? 'selected' : ''}}>Teruel</option>
            <option value="Toledo" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Toledo') ? 'selected' : ''}}>Toledo</option>
            <option value="Valencia" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Valencia') ? 'selected' : ''}}>Valencia</option>
            <option value="Valladolid" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Valladolid') ? 'selected' : ''}}>Valladolid</option>
            <option value="Vizcaya/Bizkaia" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Vizcaya/Bizkaia') ? 'selected' : ''}}>Vizcaya/Bizkaia</option>
            <option value="Zamora" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Zamora') ? 'selected' : ''}}>Zamora</option>
            <option value="Zaragoza" {{stripAccents($aval->land->checkField($inp->id)) == stripAccents('Zaragoza') ? 'selected' : ''}}>Zaragoza</option>
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