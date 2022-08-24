@php
	$lands = App\Models\Land::orderBy('id','desc')->get();
  $partners = App\Models\Partner::all();
  $inputs = App\Models\Input::where('table','land')->where('status',1)->orderBy('order','asc')->get();
@endphp
@forelse ($lands as $l)
  <tr data-id="{{$l->id}}" class="table-row">
    <td>{{$l->id}}

      {{-- <span style="display: none;">
      @switch($l->analisys_state)
          @case(1) Accepted @break
          @case(2) Rejected @break
          @case(3) Under Study @break
          @case(4) To Clarify @break
          @case(5) For Positioning @break
          @case(6) Accepted as Fictition @break
      @endswitch
      @switch($l->contract_state)
          @case(1) No Deal @break
          @case(2) Signed @break
          @case(3) In Negotia tion @break
          @case(4) Advanced Negation @break
          @case(5) Not Started @break
      @endswitch
      @switch($l->technology)
          @case(1) FV @break
          @case(2) Green Hydrogen @break
          @case(3) Storage @break
          @case(4) Hybrid @break
      @endswitch

      @if ($l->partner_id)
        {{App\Models\Partner::find($l->partner_id)->name}}
      @endif
      </span> --}}

    </td>
    <td> 
      <span style="display: none;">selected{{ $partners ? @$partners->where('id',$l->partner_id)->first()->name : '' }}</span>
      <select onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="partner_id">
        <option value="" selected disabled></option>
        @foreach ($partners as $p)
          <option {{$l->partner_id == $p->id ? 'selected' : ''}} value="{{$p->id}}">{{$p->name}}</option>
        @endforeach
      </select>
    </td>
    <td> <span style="display: none">{{$l->month}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="month" type="text" value="{{$l->month}}"> </td>
    <td> <span style="display: none">{{$l->week}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="week" type="text" value="{{$l->week}}"> </td>
    <td> <span style="display: none">{{$l->name}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="name" type="text" value="{{$l->name}}"> </td>
    <td>
      <span style="display: none;">
        @switch($l->analisys_state)
          @case(1) selectedAccepted @break
          @case(2) selectedRejected @break
          @case(3) selectedUnder Study @break
          @case(4) selectedTo Clarify @break
          @case(5) selectedFor Positioning @break
          @case(6) selectedAccepted as Fictition @break
        @endswitch
      </span>
      <select onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="analisys_state">
    	<option value="" selected disabled></option>
     	<option value="1" {{$l->analisys_state == 1 ? 'selected' : ''}}>Accepted</option>
    	<option value="2" {{$l->analisys_state == 2 ? 'selected' : ''}}>Rejected</option>
    	<option value="3" {{$l->analisys_state == 3 ? 'selected' : ''}}>Under Study</option>
    	<option value="4" {{$l->analisys_state == 4 ? 'selected' : ''}}>To Clarify</option>
    	<option value="5" {{$l->analisys_state == 5 ? 'selected' : ''}}>For Positioning</option>
    	<option value="6" {{$l->analisys_state == 6 ? 'selected' : ''}}>Accepted as Fictition</option>
    </select> </td>
    <td>
      <span style="display: none;">
        @switch($l->contract_state)
          @case(1) selectedNo Deal @break
          @case(2) selectedSigned @break
          @case(3) selectedIn Negotia tion @break
          @case(4) selectedAdvanced Negation @break
          @case(5) selectedNot Started @break
        @endswitch
      </span> 
      <select onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="contract_state">
    	<option value="" selected disabled></option>
     	<option value="1" {{$l->contract_state == 1 ? 'selected' : ''}}>No Deal</option>
      <option value="2" {{$l->contract_state == 2 ? 'selected' : ''}}>Signed</option>
    	<option value="3" {{$l->contract_state == 3 ? 'selected' : ''}}>In Negotiation</option>
    	<option value="4" {{$l->contract_state == 4 ? 'selected' : ''}}>Advanced Negotiation</option>
    	<option value="5" {{$l->contract_state == 5 ? 'selected' : ''}}>Not Started</option>
    </select> </td>
    <td> <span style="display: none">{{$l->negotiator}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="negotiator" type="text" value="{{$l->negotiator}}"> </td>
    <td> <span style="display: none">{{$l->partner_info}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="partner_info" type="text" value="{{$l->partner_info}}"> </td>

    {{-- <td> <span style="display: none">{{$l->becoming_date}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="becoming_date" type="date" value="{{$l->becoming_date}}"> </td> --}}

    <td> <span style="display: none">{{$l->mwp}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="mwp" type="text" value="{{$l->mwp}}"> </td>
    <td> <span style="display: none">{{$l->mwn}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="mwn" type="text" value="{{$l->mwn}}"> </td>
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
    <td> <span style="display: none">{{$l->substation}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="substation" type="text" value="{{$l->substation}}"> </td>
    <td> <span style="display: none">{{$l->substation_km}}</span> <input onchange="saveRow('{{$l->id}}')" class="inline-fields main-fields" name="substation_km" type="text" value="{{$l->substation_km}}"> </td>
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
            <option value="" selected disabled></option>
            @foreach ($inp->options as $op)
              <option {{$l->checkField($inp->id) == $op->option ? 'selected' : ''}}>{{$op->option}}</option>
            @endforeach
          </select>
        @endif 
        @if ($inp->type == 'provinces')
           <select onchange="saveRow('{{$l->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}">
            <option value="" selected disabled></option>
            {{-- <option value="">Elige Provincia</option> --}}
            <option value="Álava/Araba" {{strtolower($l->checkField($inp->id)) == strtolower('Álava/Araba') ? 'selected' : ''}}>Álava/Araba</option>
            <option value="Albacete" {{strtolower($l->checkField($inp->id)) == strtolower('Albacete') ? 'selected' : ''}}>Albacete</option>
            <option value="Alicante" {{strtolower($l->checkField($inp->id)) == strtolower('Alicante') ? 'selected' : ''}}>Alicante</option>
            <option value="Almería" {{strtolower($l->checkField($inp->id)) == strtolower('Almería') ? 'selected' : ''}}>Almería</option>
            <option value="Asturias" {{strtolower($l->checkField($inp->id)) == strtolower('Asturias') ? 'selected' : ''}}>Asturias</option>
            <option value="Ávila" {{strtolower($l->checkField($inp->id)) == strtolower('Ávila') ? 'selected' : ''}}>Ávila</option>
            <option value="Badajoz" {{strtolower($l->checkField($inp->id)) == strtolower('Badajoz') ? 'selected' : ''}}>Badajoz</option>
            <option value="Baleares" {{strtolower($l->checkField($inp->id)) == strtolower('Baleares') ? 'selected' : ''}}>Baleares</option>
            <option value="Barcelona" {{strtolower($l->checkField($inp->id)) == strtolower('Barcelona') ? 'selected' : ''}}>Barcelona</option>
            <option value="Burgos" {{strtolower($l->checkField($inp->id)) == strtolower('Burgos') ? 'selected' : ''}}>Burgos</option>
            <option value="Cáceres" {{strtolower($l->checkField($inp->id)) == strtolower('Cáceres') ? 'selected' : ''}}>Cáceres</option>
            <option value="Cádiz" {{strtolower($l->checkField($inp->id)) == strtolower('Cádiz') ? 'selected' : ''}}>Cádiz</option>
            <option value="Cantabria" {{strtolower($l->checkField($inp->id)) == strtolower('Cantabria') ? 'selected' : ''}}>Cantabria</option>
            <option value="Castellón" {{strtolower($l->checkField($inp->id)) == strtolower('Castellón') ? 'selected' : ''}}>Castellón</option>
            <option value="Ceuta" {{strtolower($l->checkField($inp->id)) == strtolower('Ceuta') ? 'selected' : ''}}>Ceuta</option>
            <option value="Ciudad Real" {{strtolower($l->checkField($inp->id)) == strtolower('Ciudad Real') ? 'selected' : ''}}>Ciudad Real</option>
            <option value="Córdoba" {{strtolower($l->checkField($inp->id)) == strtolower('Córdoba') ? 'selected' : ''}}>Córdoba</option>
            <option value="Cuenca" {{strtolower($l->checkField($inp->id)) == strtolower('Cuenca') ? 'selected' : ''}}>Cuenca</option>
            <option value="Gerona/Girona" {{strtolower($l->checkField($inp->id)) == strtolower('Gerona/Girona') ? 'selected' : ''}}>Gerona/Girona</option>
            <option value="Granada" {{strtolower($l->checkField($inp->id)) == strtolower('Granada') ? 'selected' : ''}}>Granada</option>
            <option value="Guadalajara" {{strtolower($l->checkField($inp->id)) == strtolower('Guadalajara') ? 'selected' : ''}}>Guadalajara</option>
            <option value="Guipúzcoa/Gipuzkoa" {{strtolower($l->checkField($inp->id)) == strtolower('Guipúzcoa/Gipuzkoa') ? 'selected' : ''}}>Guipúzcoa/Gipuzkoa</option>
            <option value="Huelva" {{strtolower($l->checkField($inp->id)) == strtolower('Huelva') ? 'selected' : ''}}>Huelva</option>
            <option value="Huesca" {{strtolower($l->checkField($inp->id)) == strtolower('Huesca') ? 'selected' : ''}}>Huesca</option>
            <option value="Jaén" {{strtolower($l->checkField($inp->id)) == strtolower('Jaén') ? 'selected' : ''}}>Jaén</option>
            <option value="La Coruña/A Coruña" {{strtolower($l->checkField($inp->id)) == strtolower('La Coruña/A Coruña') ? 'selected' : ''}}>La Coruña/A Coruña</option>
            <option value="La Rioja" {{strtolower($l->checkField($inp->id)) == strtolower('La Rioja') ? 'selected' : ''}}>La Rioja</option>
            <option value="Las Palmas" {{strtolower($l->checkField($inp->id)) == strtolower('Las Palmas') ? 'selected' : ''}}>Las Palmas</option>
            <option value="León" {{strtolower($l->checkField($inp->id)) == strtolower('León') ? 'selected' : ''}}>León</option>
            <option value="Lérida/Lleida" {{strtolower($l->checkField($inp->id)) == strtolower('Lérida/Lleida') ? 'selected' : ''}}>Lérida/Lleida</option>
            <option value="Lugo" {{strtolower($l->checkField($inp->id)) == strtolower('Lugo') ? 'selected' : ''}}>Lugo</option>
            <option value="Madrid" {{strtolower($l->checkField($inp->id)) == strtolower('Madrid') ? 'selected' : ''}}>Madrid</option>
            <option value="Málaga" {{strtolower($l->checkField($inp->id)) == strtolower('Málaga') ? 'selected' : ''}}>Málaga</option>
            <option value="Melilla" {{strtolower($l->checkField($inp->id)) == strtolower('Melilla') ? 'selected' : ''}}>Melilla</option>
            <option value="Murcia" {{strtolower($l->checkField($inp->id)) == strtolower('Murcia') ? 'selected' : ''}}>Murcia</option>
            <option value="Navarra" {{strtolower($l->checkField($inp->id)) == strtolower('Navarra') ? 'selected' : ''}}>Navarra</option>
            <option value="Orense/Ourense" {{strtolower($l->checkField($inp->id)) == strtolower('Orense/Ourense') ? 'selected' : ''}}>Orense/Ourense</option>
            <option value="Palencia" {{strtolower($l->checkField($inp->id)) == strtolower('Palencia') ? 'selected' : ''}}>Palencia</option>
            <option value="Pontevedra" {{strtolower($l->checkField($inp->id)) == strtolower('Pontevedra') ? 'selected' : ''}}>Pontevedra</option>
            <option value="Salamanca" {{strtolower($l->checkField($inp->id)) == strtolower('Salamanca') ? 'selected' : ''}}>Salamanca</option>
            <option value="Segovia" {{strtolower($l->checkField($inp->id)) == strtolower('Segovia') ? 'selected' : ''}}>Segovia</option>
            <option value="Sevilla" {{strtolower($l->checkField($inp->id)) == strtolower('Sevilla') ? 'selected' : ''}}>Sevilla</option>
            <option value="Soria" {{strtolower($l->checkField($inp->id)) == strtolower('Soria') ? 'selected' : ''}}>Soria</option>
            <option value="Tarragona" {{strtolower($l->checkField($inp->id)) == strtolower('Tarragona') ? 'selected' : ''}}>Tarragona</option>
            <option value="Tenerife" {{strtolower($l->checkField($inp->id)) == strtolower('Tenerife') ? 'selected' : ''}}>Tenerife</option>
            <option value="Teruel" {{strtolower($l->checkField($inp->id)) == strtolower('Teruel') ? 'selected' : ''}}>Teruel</option>
            <option value="Toledo" {{strtolower($l->checkField($inp->id)) == strtolower('Toledo') ? 'selected' : ''}}>Toledo</option>
            <option value="Valencia" {{strtolower($l->checkField($inp->id)) == strtolower('Valencia') ? 'selected' : ''}}>Valencia</option>
            <option value="Valladolid" {{strtolower($l->checkField($inp->id)) == strtolower('Valladolid') ? 'selected' : ''}}>Valladolid</option>
            <option value="Vizcaya/Bizkaia" {{strtolower($l->checkField($inp->id)) == strtolower('Vizcaya/Bizkaia') ? 'selected' : ''}}>Vizcaya/Bizkaia</option>
            <option value="Zamora" {{strtolower($l->checkField($inp->id)) == strtolower('Zamora') ? 'selected' : ''}}>Zamora</option>
            <option value="Zaragoza" {{strtolower($l->checkField($inp->id)) == strtolower('Zaragoza') ? 'selected' : ''}}>Zaragoza</option>
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
        <button class="btn btn-sm btn-success mb-3" onclick="downloadKML('{{$l->id}}')">DownloadKML</button>
        <a class="btn btn-sm btn-info" data-toggle="modal" href="#report-{{$l->id}}">Report</a>
      </td>
      <td>
        {{-- <button class="btn btn-sm btn-success" onclick="saveRow('{{$l->id}}')">Save</button> --}}
        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$l->id}}">Delete</button>

      </td>
  </tr>

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
@empty
  <tr>
    <td colspan="{{ count($inputs)+10}}">{{trans('lands.empty')}}</td>
  </tr>
@endforelse