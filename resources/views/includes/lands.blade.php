@php
  $partners = App\Models\Partner::all();
  $inputs = App\Models\Input::where('table','land')->where('status',1)->orderBy('order','asc')->get();

  function stripAccents($str) {
      return strtolower(trim(strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ/'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY-')));
  }

@endphp
@forelse ($lands as $l)
  <tr data-id="{{$l->id}}" class="table-row">
    <td>{{$l->id}}
    <td>{{$l->carpeta}}
    </td>
    <td> <span style="display: none">{{$l->substation}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="substation" type="text" value="{{$l->substation}}"> </td>
    <td> <span style="display: none">{{$l->mwn}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="mwn" type="text" value="{{$l->mwn}}"> </td>
    <td> <span style="display: none">{{$l->substation_km}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="substation_km" type="text" value="{{$l->substation_km}}"> </td>
    <td> 
      <span style="display: none;">selected{{ $partners ? @$partners->where('id',$l->partner_id)->first()->name : '' }}</span>
      <select onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="partner_id">
        <option value="" selected disabled></option>
        @foreach ($partners as $p)
          <option {{$l->partner_id == $p->id ? 'selected' : ''}} value="{{$p->id}}">{{$p->name}}</option>
        @endforeach
      </select>
    </td>
    {{-- <td> <span style="display: none">{{$l->month}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="month" type="text" value="{{$l->month}}"> </td>
    <td> <span style="display: none">{{$l->week}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="week" type="text" value="{{$l->week}}"> </td> --}}
    <td> <span style="display: none">{{$l->name}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="name" type="text" value="{{$l->name}}"> </td>
    <td>
      {{$l->aval ? (App\Models\Status::where('type','guarantee')->where('id',$l->aval->guarantee_status)->first() ? App\Models\Status::where('type','guarantee')->where('id',$l->aval->guarantee_status)->first()->name : '') : ''}}
    </td>
    <td>
      {{$l->aval ? (App\Models\Status::where('type','request')->where('id',$l->aval->request_status)->first() ? App\Models\Status::where('type','request')->where('id',$l->aval->request_status)->first()->name : '') : ''}}
    </td>
    
    <td>
      <span style="display: none;">
        @switch($l->analisys_state)
          @case(1) selectedAceptada Ficticio @break
          @case(2) selectedEn Estudio @break
          @case(3) selectedAceptada @break
          @case(4) selectedDescartada @break
          @case(5) selectedPara Aclarar @break
          @case(6) selectedPara Posicionamiento @break
          @case(7) selectedAceptada Ficticio 5 @break
          @case(8) selectedTramitación @break
          @case(9) selectedPosicionar con mas Terrenos @break
          @case(10) selectedAceptada 5 MW Real@break
          @case(11) selectedPrioridad concurso/distribución @break
          @case(12) selectedPendiente de Oferta @break
          @case(13) selectedSin Terreno @break
        @endswitch
      </span>
      <select onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="analisys_state">
    	<option value="" selected disabled></option>
     	<option value="1" {{$l->analisys_state == 1 ? 'selected' : ''}}>Aceptada Ficticio</option>
    	<option value="2" {{$l->analisys_state == 2 ? 'selected' : ''}}>En Estudio</option>
    	<option value="3" {{$l->analisys_state == 3 ? 'selected' : ''}}>Aceptada</option>
    	<option value="4" {{$l->analisys_state == 4 ? 'selected' : ''}}>Descartada</option>
    	<option value="5" {{$l->analisys_state == 5 ? 'selected' : ''}}>Para Aclarar</option>
    	<option value="6" {{$l->analisys_state == 6 ? 'selected' : ''}}>Para Posicionamiento</option>
      <option value="7" {{$l->analisys_state == 7 ? 'selected' : ''}}>Aceptada Ficticio 5</option>
      <option value="8" {{$l->analisys_state == 8 ? 'selected' : ''}}>Tramitación</option>
      <option value="9" {{$l->analisys_state == 9 ? 'selected' : ''}}>Posicionar con mas Terrenos</option>
      <option value="10" {{$l->analisys_state == 10 ? 'selected' : ''}}>Aceptada 5 MW Real</option>
      <option value="11" {{$l->analisys_state == 11 ? 'selected' : ''}}>Prioridad concurso/distribución</option>
      <option value="12" {{$l->analisys_state == 12 ? 'selected' : ''}}>Pendiente de Oferta</option>
      <option value="13" {{$l->analisys_state == 13 ? 'selected' : ''}}>Sin Terreno</option>
    </select> </td>
    <td>
      <span style="display: none;">
        @switch($l->contract_state)
          @case(1) selectedSin identificar @break
          @case(2) selectedPTE Contrato Propiedad @break
          @case(3) selectedNegociación @break
          @case(4) selectedNegoc. Avanzada @break
          @case(5) selectedSin Acuerdo @break
          @case(6) selectedFirmado @break
          @case(7) selectedNo Posible @break
          @case(8) selectedFirmado Solar @break
        @endswitch
      </span> 
      <select onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="contract_state">
    	<option value="" selected disabled></option>
     	<option value="1" {{$l->contract_state == 1 ? 'selected' : ''}}>Sin identificar</option>
      <option value="2" {{$l->contract_state == 2 ? 'selected' : ''}}>PTE Contrato Propiedad</option>
    	<option value="3" {{$l->contract_state == 3 ? 'selected' : ''}}>Negociación</option>
    	<option value="4" {{$l->contract_state == 4 ? 'selected' : ''}}>Negoc. Avanzada</option>
    	<option value="5" {{$l->contract_state == 5 ? 'selected' : ''}}>Sin Acuerdo</option>
      <option value="6" {{$l->contract_state == 6 ? 'selected' : ''}}>Firmado</option>
      <option value="7" {{$l->contract_state == 7 ? 'selected' : ''}}>No Posible</option>
      <option value="8" {{$l->contract_state == 8 ? 'selected' : ''}}>Firmado Solar</option>
    </select> </td>
    <td> <span style="display: none">{{$l->negotiator}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="negotiator" type="text" value="{{$l->negotiator}}"> </td>
    <td> <span style="display: none">{{$l->partner_info}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="partner_info" type="text" value="{{$l->partner_info}}"> </td>

    {{-- <td> <span style="display: none">{{$l->becoming_date}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="becoming_date" type="date" value="{{$l->becoming_date}}"> </td> --}}

    <td> <span style="display: none">{{$l->mwp}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="mwp" type="text" value="{{$l->mwp}}"> </td>
    <td>
      <span style="display: none;">
        @if($l->technology)
          @php
            $t = App\Models\Technology::find($l->technology);
            if ($t) {
              echo 'selected'.(App::getLocale() == 'es' ? $t->name : $t->name_en);
            }
          @endphp
        @endif
      </span>
      <select onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="technology">
      <option value="" selected disabled></option>
      @foreach (App\Models\Technology::all() as $tech)
        <option value="{{$tech->id}}" {{$l->technology == $tech->id ? 'selected' : ''}}>
          {{ App::getLocale() == 'es' ? $tech->name : $tech->name_en }}
        </option>
      @endforeach
      {{-- <option value="2" {{$l->technology == 2 ? 'selected' : ''}}>Green Hydrogen</option>
      <option value="3" {{$l->technology == 3 ? 'selected' : ''}}>Storage</option>
      <option value="4" {{$l->technology == 4 ? 'selected' : ''}}>Data Center</option> --}}
    </select>
    </td>
    @foreach ($inputs as $inp)
	    <td>
        <span style="display: none;">
          @if ($inp->type == 'select' || $inp->type == 'provinces')
          selected{{$l->checkField($inp->id)}}
          @else
          {{$l->checkField($inp->id)}}
          @endif
        </span>
        @if ($inp->type == 'textarea')
           <textarea style="min-width: 190px; width: 190px" onchange="saveRow('{{$l->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" rows="2">{{$l->checkField($inp->id)}}</textarea>
        @endif

        @if ($inp->type == 'text')
           <input onchange="saveRow('{{$l->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" type="text" value="{{$l->checkField($inp->id)}}">
        @endif

        @if ($inp->type == 'number')
           <input onchange="saveRow('{{$l->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" type="number" value="{{$l->checkField($inp->id)}}">
        @endif

        @if ($inp->type == 'select')
           <select onchange="saveRow('{{$l->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}">
            <option value="" selected></option>
            @foreach ($inp->options as $op)
              <option {{stripAccents($l->checkField($inp->id)) == stripAccents($op->option) ? 'selected' : ''}}>{{$op->option}}
              </option>
            @endforeach
          </select>
        @endif 
        @if ($inp->type == 'provinces')
           <select onchange="saveRow('{{$l->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}">
            <option value="" selected disabled></option>
            {{-- <option value="">Elige Provincia</option> --}}
            <option value="Álava/Araba" {{stripAccents($l->checkField($inp->id)) == stripAccents('Álava/Araba') ? 'selected' : ''}}>Álava/Araba</option>
            <option value="Albacete" {{stripAccents($l->checkField($inp->id)) == stripAccents('Albacete') ? 'selected' : ''}}>Albacete</option>
            <option value="Alicante" {{stripAccents($l->checkField($inp->id)) == stripAccents('Alicante') ? 'selected' : ''}}>Alicante</option>
            <option value="Almería" {{stripAccents($l->checkField($inp->id)) == stripAccents('Almería') ? 'selected' : ''}}>Almería</option>
            <option value="Asturias" {{stripAccents($l->checkField($inp->id)) == stripAccents('Asturias') ? 'selected' : ''}}>Asturias</option>
            <option value="Ávila" {{stripAccents($l->checkField($inp->id)) == stripAccents('Ávila') ? 'selected' : ''}}>Ávila</option>
            <option value="Badajoz" {{stripAccents($l->checkField($inp->id)) == stripAccents('Badajoz') ? 'selected' : ''}}>Badajoz</option>
            <option value="Baleares" {{stripAccents($l->checkField($inp->id)) == stripAccents('Baleares') ? 'selected' : ''}}>Baleares</option>
            <option value="Barcelona" {{stripAccents($l->checkField($inp->id)) == stripAccents('Barcelona') ? 'selected' : ''}}>Barcelona</option>
            <option value="Burgos" {{stripAccents($l->checkField($inp->id)) == stripAccents('Burgos') ? 'selected' : ''}}>Burgos</option>
            <option value="Cáceres" {{stripAccents($l->checkField($inp->id)) == stripAccents('Cáceres') ? 'selected' : ''}}>Cáceres</option>
            <option value="Cádiz" {{stripAccents($l->checkField($inp->id)) == stripAccents('Cádiz') ? 'selected' : ''}}>Cádiz</option>
            <option value="Cantabria" {{stripAccents($l->checkField($inp->id)) == stripAccents('Cantabria') ? 'selected' : ''}}>Cantabria</option>
            <option value="Castellón" {{stripAccents($l->checkField($inp->id)) == stripAccents('Castellón') ? 'selected' : ''}}>Castellón</option>
            <option value="Ceuta" {{stripAccents($l->checkField($inp->id)) == stripAccents('Ceuta') ? 'selected' : ''}}>Ceuta</option>
            <option value="Ciudad Real" {{stripAccents($l->checkField($inp->id)) == stripAccents('Ciudad Real') ? 'selected' : ''}}>Ciudad Real</option>
            <option value="Córdoba" {{stripAccents($l->checkField($inp->id)) == stripAccents('Córdoba') ? 'selected' : ''}}>Córdoba</option>
            <option value="Cuenca" {{stripAccents($l->checkField($inp->id)) == stripAccents('Cuenca') ? 'selected' : ''}}>Cuenca</option>
            <option value="Gerona/Girona" {{stripAccents($l->checkField($inp->id)) == stripAccents('Gerona/Girona') ? 'selected' : ''}}>Gerona/Girona</option>
            <option value="Granada" {{stripAccents($l->checkField($inp->id)) == stripAccents('Granada') ? 'selected' : ''}}>Granada</option>
            <option value="Guadalajara" {{stripAccents($l->checkField($inp->id)) == stripAccents('Guadalajara') ? 'selected' : ''}}>Guadalajara</option>
            <option value="Guipúzcoa/Gipuzkoa" {{stripAccents($l->checkField($inp->id)) == stripAccents('Guipúzcoa/Gipuzkoa') ? 'selected' : ''}}>Guipúzcoa/Gipuzkoa</option>
            <option value="Huelva" {{stripAccents($l->checkField($inp->id)) == stripAccents('Huelva') ? 'selected' : ''}}>Huelva</option>
            <option value="Huesca" {{stripAccents($l->checkField($inp->id)) == stripAccents('Huesca') ? 'selected' : ''}}>Huesca</option>
            <option value="Jaén" {{stripAccents($l->checkField($inp->id)) == stripAccents('Jaén') ? 'selected' : ''}}>Jaén</option>
            <option value="La Coruña/A Coruña" {{stripAccents($l->checkField($inp->id)) == stripAccents('La Coruña/A Coruña') ? 'selected' : ''}}>La Coruña/A Coruña</option>
            <option value="La Rioja" {{stripAccents($l->checkField($inp->id)) == stripAccents('La Rioja') ? 'selected' : ''}}>La Rioja</option>
            <option value="Las Palmas" {{stripAccents($l->checkField($inp->id)) == stripAccents('Las Palmas') ? 'selected' : ''}}>Las Palmas</option>
            <option value="León" {{stripAccents($l->checkField($inp->id)) == stripAccents('León') ? 'selected' : ''}}>León</option>
            <option value="Lérida/Lleida" {{stripAccents($l->checkField($inp->id)) == stripAccents('Lérida/Lleida') ? 'selected' : ''}}>Lérida/Lleida</option>
            <option value="Lugo" {{stripAccents($l->checkField($inp->id)) == stripAccents('Lugo') ? 'selected' : ''}}>Lugo</option>
            <option value="Madrid" {{stripAccents($l->checkField($inp->id)) == stripAccents('Madrid') ? 'selected' : ''}}>Madrid</option>
            <option value="Málaga" {{stripAccents($l->checkField($inp->id)) == stripAccents('Málaga') ? 'selected' : ''}}>Málaga</option>
            <option value="Melilla" {{stripAccents($l->checkField($inp->id)) == stripAccents('Melilla') ? 'selected' : ''}}>Melilla</option>
            <option value="Murcia" {{stripAccents($l->checkField($inp->id)) == stripAccents('Murcia') ? 'selected' : ''}}>Murcia</option>
            <option value="Navarra" {{stripAccents($l->checkField($inp->id)) == stripAccents('Navarra') ? 'selected' : ''}}>Navarra</option>
            <option value="Orense/Ourense" {{stripAccents($l->checkField($inp->id)) == stripAccents('Orense/Ourense') ? 'selected' : ''}}>Orense/Ourense</option>
            <option value="Palencia" {{stripAccents($l->checkField($inp->id)) == stripAccents('Palencia') ? 'selected' : ''}}>Palencia</option>
            <option value="Pontevedra" {{stripAccents($l->checkField($inp->id)) == stripAccents('Pontevedra') ? 'selected' : ''}}>Pontevedra</option>
            <option value="Salamanca" {{stripAccents($l->checkField($inp->id)) == stripAccents('Salamanca') ? 'selected' : ''}}>Salamanca</option>
            <option value="Segovia" {{stripAccents($l->checkField($inp->id)) == stripAccents('Segovia') ? 'selected' : ''}}>Segovia</option>
            <option value="Sevilla" {{stripAccents($l->checkField($inp->id)) == stripAccents('Sevilla') ? 'selected' : ''}}>Sevilla</option>
            <option value="Soria" {{stripAccents($l->checkField($inp->id)) == stripAccents('Soria') ? 'selected' : ''}}>Soria</option>
            <option value="Tarragona" {{stripAccents($l->checkField($inp->id)) == stripAccents('Tarragona') ? 'selected' : ''}}>Tarragona</option>
            <option value="Tenerife" {{stripAccents($l->checkField($inp->id)) == stripAccents('Tenerife') ? 'selected' : ''}}>Tenerife</option>
            <option value="Teruel" {{stripAccents($l->checkField($inp->id)) == stripAccents('Teruel') ? 'selected' : ''}}>Teruel</option>
            <option value="Toledo" {{stripAccents($l->checkField($inp->id)) == stripAccents('Toledo') ? 'selected' : ''}}>Toledo</option>
            <option value="Valencia" {{stripAccents($l->checkField($inp->id)) == stripAccents('Valencia') ? 'selected' : ''}}>Valencia</option>
            <option value="Valladolid" {{stripAccents($l->checkField($inp->id)) == stripAccents('Valladolid') ? 'selected' : ''}}>Valladolid</option>
            <option value="Vizcaya/Bizkaia" {{stripAccents($l->checkField($inp->id)) == stripAccents('Vizcaya/Bizkaia') ? 'selected' : ''}}>Vizcaya/Bizkaia</option>
            <option value="Zamora" {{stripAccents($l->checkField($inp->id)) == stripAccents('Zamora') ? 'selected' : ''}}>Zamora</option>
            <option value="Zaragoza" {{stripAccents($l->checkField($inp->id)) == stripAccents('Zaragoza') ? 'selected' : ''}}>Zaragoza</option>
            {{-- @foreach ($inp->options as $op)
              <option >{{$op->option}}</option>
            @endforeach --}}
          </select>
        @endif 

        @if ($inp->type == 'document')
           <input onchange="saveRow('{{$l->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}" type="file">
        @endif 
      </td>
      @endforeach
      <td>
        <select onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="main">
          <option value="" >No</option>
          <option value="1" {{$l->main == 1 ? 'selected' : ''}}>Si</option>
        </select>
      </td>
      <td>
        {{-- <button class="btn btn-sm btn-success mb-3" onclick="downloadKML('{{$l->id}}')">DownloadKML</button> --}}
        <button class="btn btn-sm btn-success mb-3" onclick="downloadKMLModal('{{$l->id}}')">DownloadKML</button>

        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#report-{{$l->id}}">Report</button>
      </td>
      <td>
        {{-- <button class="btn btn-sm btn-success" onclick="saveRow('{{$l->id}}')">Save</button> --}}
        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$l->id}}">Delete</button>


        <div class="modal fade" id="report-{{$l->id}}">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">{{trans('projects.sel_sections')}}</div>
              <div class="modal-body">
                <form action="{{url('downloadPDF',$l->id)}}" class="form" method="POST">
                  {{csrf_field()}}
                  <div class="row">
                    <div class="col-sm-6">

                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="fields-report[]" value="1" checked>
                          {{trans('projects.generel_info')}}
                        </label>
                          <ul>
                            <li style="list-style: none;">
                              <label><input type="checkbox" checked name="pn">Project Name</label> <br>
                              <label><input type="checkbox" checked name="mt">Month</label> <br>
                              <label><input type="checkbox" checked name="wk">Week</label> <br>
                              <label><input type="checkbox" checked name="pt">Partner</label> <br>
                              <label><input type="checkbox" checked name="as">Analisys State</label> <br>
                            </li>
                          </ul> 
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="fields-report[]" value="2" checked>
                          {{trans('projects.contract_info')}}
                        </label>
                        <ul>
                          <li style="list-style: none;">
                            <label><input type="checkbox" checked name="cs">Contract State</label> <br>
                            <label><input type="checkbox" checked name="cn">Contract Negotiaton</label> <br>
                            <label><input type="checkbox" checked name="pi">Partner Info</label> <br>
                          </li>
                        </ul>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="fields-report[]" value="3" checked>
                          {{trans('projects.gen_tech_cond')}}
                        </label>
                        <ul>
                          <li style="list-style: none;">
                            <label><input type="checkbox" checked name="tp">Total Peak Power</label> <br>
                            <label><input type="checkbox" checked name="tr">Total Power Rating</label> <br>
                            <label><input type="checkbox" checked name="ss">Substation</label> <br>
                            <label><input type="checkbox" checked name="ks">KM Substation</label> <br>
                            <label><input type="checkbox" checked name="tg">Technology</label> <br>
                          </li>
                        </ul>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="fields-report[]" value="4" checked>
                          {{trans('projects.aditional_info')}}
                        </label>
                        <ul>
                          <li style="list-style: none;">
                            @php
                              $inputs_2 = App\Models\Input::where('table','land')->orderBy('order','asc')->get();
                            @endphp

                            <div>
                                @foreach ($inputs_2 as $inp)
                                  <label><input type="checkbox" checked name="i{{$inp->id}}">{{$inp->title}}</label> <br>
                                @endforeach
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="fields-report[]" value="5" checked>
                          {{trans('projects.guarantee')}}
                        </label>
                        <ul>
                          <li style="list-style: none;">
                            <label><input type="checkbox" checked name="gs">Guarantee Status</label> <br>
                            <label><input type="checkbox" checked name="rs">Request Status</label> <br>
                            <label><input type="checkbox" checked name="mw">MWn</label> <br>
                            <label><input type="checkbox" checked name="am">Amount €</label> <br>
                          </li>
                        </ul>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="fields-report[]" value="6" checked>
                          {{trans('projects.project_info')}}
                        </label>
                        <ul>
                          <li style="list-style: none;">

                            @php
                              $sections = App\Models\Section::orderBy('id','asc')->get();
                            @endphp
                            
                            @foreach ($sections as $sect)
                                @if ($sect->inputs)
                                <div style="margin-bottom: 12px">
                                    {{-- <b style="text-decoration: underline">{{$sect->name}}</b> <br> --}}
                                    <label><input type="checkbox" checked name="s{{$sect->id}}">{{$sect->name}}</label> <br>
                                    @foreach ($sect->inputs as $inp)
                                    {{-- <label><input type="checkbox" checked name="">{{$inp->title}}</label> <br> --}}
                                    @endforeach
                                </div>
                                @endif
                            @endforeach
                            
                          </li>
                        </ul>
                      </div>
                    </div>



                    <div class="col-sm-12">
                      
                      <textarea name="information" class="form-control" rows="4"></textarea>


                    </div>
                  </div>

                  <br>

                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="changeParent">

                      Descargar en WORD
                    </label>
                  </div>

                  <br>

                  <button type="submit" class="btn btn-sm btn-success">{{trans('projects.generate_report')}}</button>
                  <button type="button" class="btn btn-sm btn-danger">{{trans('projects.cancel')}}</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="delete-row{{$l->id}}">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">{{trans('lands.delete')}}</div>
              <div class="modal-footer">
                <a href="{{url('deleteLand',$l->id)}}" class="btn btn-sm btn-success">{{trans('lands.yes')}}</a>
                <button class="btn btn-sm btn-warning" data-dismiss="modal">{{trans('lands.cancel')}}</button>
              </div>
            </div>
          </div>
        </div>

      </td>
  </tr>

@empty
  <tr>
    <td colspan="{{ count($inputs)+10}}">{{trans('lands.empty')}}</td>
  </tr>
@endforelse
  


  <div class="modal fade" id="kml">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">KML List</div>
        <div class="modal-body" id="kml-body"></div>
        <div class="modal-footer">
          <button class="btn btn-sm btn-warning" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>