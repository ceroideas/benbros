<header style="
        /* height: 50px; */
        font-size: 20px !important;

        /** Extra personal styles **/
        background-color: #fff;
        color: white;
        text-align: center;
        line-height: 35px;">
    <div class="left-title" style="text-align: center;
        background-color: #2a3963;
        color: #fff;
        padding: 20px;
        width: 400px;
        height: 100px;">
        <h1 style="margin-top: 10px;
        margin-bottom: 0;">{{trans('lands.project_name')}}:</h1>

        <small>{{$l->name}}</small>
    </div>
</header>

<main style="line-height: 36px;">


    @if (in_array('1', $r['fields-report']))

    <br/>
    
    <label class="section-title" style="border-radius: 8px;">
        {{trans('lands.general_info')}}
    </label>
    <br/>

    <div style="padding: 12px; background-color: #f1f1f1; padding-left: 8px;">
        @if($r->pn)<b>{{trans('lands.project_name')}}:</b> {{$l->name}} @endif
        {{-- @if($r->mt)<b>{{trans('lands.month')}}:</b> {{$l->month}} @endif
        @if($r->wk)<b>{{trans('lands.week')}}:</b> {{$l->week}} @endif --}}
        @if($r->pt)<b>{{trans('lands.partner')}}:</b> {{ $l->partner ? $l->partner->name : ''}}  @endif
        @if($r->as)<b>{{trans('lands.analysis_state')}}:</b>@switch($l->analisys_state)
          @case(1) Aceptada Ficticio @break
          @case(2) En Estudio @break
          @case(3) Aceptada @break
          @case(4) Descartada @break
          @case(5) Para Aclarar @break
          @case(6) Para Posicionamiento @break
          @case(7) Aceptada Ficticio 5 @break
          @case(8) Tramitación @break
          @case(9) Posicionar con mas Terrenos @break
          @case(10) Aceptada 5 MW Real@break
          @case(11) Prioridad concurso/distribución @break
          @case(12) Pendiente de Oferta @break
          @case(13) Sin Terreno @break
        @endswitch
         @endif
    </div>

    @endif

    @if (in_array('2', $r['fields-report']))

    <br/>

        <label class="section-title" style="        border: 4px solid #2a3963;">
            {{trans('lands.contract_info')}}
        </label>

        <div style="padding: 12px; background-color: #f1f1f1;">
            @if($r->cs) <b>{{trans('lands.contract_state')}}:</b> 
            @switch($l->contract_state)
              @case(1) Sin identificar @break
              @case(2) PTE Contrato Propiedad @break
              @case(3) Negociación @break
              @case(4) Negoc. Avanzada @break
              @case(5) Sin Acuerdo @break
              @case(6) Firmado @break
              @case(7) No Posible @break
              @case(8) Firmado Solar @break
            @endswitch
            <br/> @endif
            @if($r->cn) <b>{{trans('lands.contract_negotiator')}}:</b> {{$l->negotiator}}<br/> @endif
            @if($r->pi) <b>{{trans('lands.partner_info')}}:</b> {{$l->partner_info}}<br/> @endif
        </div>

    @endif

    @if (in_array('3', $r['fields-report']))

        <label class="section-title" style="        padding: 2px 8px;">
            {{trans('lands.general_tech_conditions')}}
        </label>
        <br/>

        <ul style="padding: 12px; background-color: #f1f1f1;">
            @if($r->tp) <li><b>Total {{trans('lands.mwp')}}:</b> {{$l->mwp}}MW </li> @endif
            @if($r->tr) <li><b>Total {{trans('lands.mwn')}}:</b> {{$l->mwn}}MW </li> @endif
            @if($r->ss) <li><b>{{trans('lands.set')}}:</b> {{$l->substation}} </li> @endif
            @if($r->ks) <li><b>{{trans('lands.km_set')}}:</b> {{$l->substation_km}} </li> @endif
            @if($r->tg) <li><b>{{trans('lands.technology')}}:</b>@php 
            $t = App\Models\Technology::find($l->technology); @endphp {{$t ? $t->name : '--'}}
            </li> @endif
        </ul>

        <br/>

    @endif

    @if (in_array('4', $r['fields-report']))

        <label class="section-title" style="        color: #000;">
            {{trans('lands.aditional_info')}}
        </label>
        <br/>

        @php
            $inputs = App\Models\Input::where('table','land')->orderBy('order','asc')->get();
        @endphp

        <ul style="padding: 12px; background-color: #f1f1f1;">
            @foreach ($inputs as $inp)
                @if ($r['i'.$inp->id])
                    <li><b>{{$inp->title}}:</b> {{$l->checkField($inp->id)}} </li>
                @endif
            @endforeach
        </ul>

        <br/>

    @endif

    @if (in_array('5', $r['fields-report']))

        @php
            $aval = App\Models\Endorsement::where('land_id',$l->id)->first();
        @endphp

        @if ($aval)
            <label class="section-title" style="        display: inline-block;">
                {{trans('lands.guarantee')}}
            </label>
            <br/>
            
            <ul style="padding: 12px; background-color: #f1f1f1;">

                @if($r->gs) <li><b>{{trans('guarantee.guarantee_status')}}:</b> {{ $aval->guarantee_status ? App\Models\Status::find($aval->guarantee_status)->name : '' }} </li> @endif
                @if($r->rs) <li><b>{{trans('guarantee.request_status')}}:</b> {{ $aval->request_status ? App\Models\Status::find($aval->request_status)->name : '' }} </li> @endif
                @if($r->mw) <li><b>{{trans('guarantee.mwn')}}: </b> {{ $aval->land->mwn }} </li> @endif
                @if($r->am) <li><b>{{trans('guarantee.amount')}}: </b> {{ $aval->ammount }} </li> @endif
            </ul>

            <br/>
        @endif

    @endif

    @if (in_array('6', $r['fields-report']))

        @php
            $p = App\Models\Permission::where('land_id',$l->id)->first();
        @endphp

        @if ($p)
            <label class="section-title" style="        font-size: 20px;">
                {{trans('lands.project_info')}}
            </label>
            <br/>

            @php
                $sections = App\Models\Section::orderBy('id','asc')->get();
            @endphp
            
            <div style="padding: 12px; background-color: #f1f1f1;">
            @foreach ($sections as $sect)
                @if ($sect->inputs)
                <div style="margin-bottom: 12px">
                    @if ($r['s'.$sect->id])
                        <div style="display: block; width: 100%; background-color: lightblue; border-bottom: 2px solid #000;">
                            <b style="text-decoration: underline">{{$sect->name}}</b>
                        </div>
                        @foreach ($sect->inputs as $inp)
                            <li><b>{{$inp->title}}</b>:
                            @switch($p->checkField($inp->id))
                                @case('Si')
                                    {{App::getLocale() == 'es' ? 'Si' : 'Yes'}}
                                    @break

                                @case('No')
                                    {{App::getLocale() == 'es' ? 'No' : 'No'}}
                                    @break

                                @case('En progreso')
                                    {{App::getLocale() == 'es' ? 'En progreso' : 'In progress'}}
                                    @break
                            
                                @default
                                    {{$p->checkField($inp->id)}}
                                    @break
                            @endswitch
                            </li>

                            @php
                                $a = App\Models\Activity::where('name',$inp->title)->whereExists(function($q) use($p){
                                    $q->from('activity_sections')
                                    ->whereRaw('activity_sections.id = activities.activity_section_id')
                                    ->whereRaw('activity_sections.permission_id = '.$p->id);
                                })->first();
                            @endphp
                            @if ($a)
                                <i style="padding-left: 40px">{{trans('projects.comments')}}</i>:
                                {{ $a && $a->commentary != "" ? $a->commentary : '--' }} <br/>
                            @endif
                        @endforeach
                    @endif
                </div>
                @endif
            @endforeach
            </div> 
            
        @endif

    @endif
    

    <br/>

    @if ($r->information)

    <label class="section-title" style="        line-height: 20px;">
        {{trans('lands.obs_aditional_info')}}
    </label>
    <br/>

    <p>
        {{$r->information}}
    </p>

    @endif

    @if ($r->dataUrl)

    GANTT

    <div style="line-height: 38px;">

        <span style="display: inline-block; background-color: lightgreen; width: 20px; height: 20px; border-radius: 2px;"></span>

        <span style="display: inline-block; position: relative; top: 2px;">Completado</span> <br/>

        <span style="display: inline-block; background-color: crimson; width: 20px; height: 20px; border-radius: 2px;"></span>

        <span style="display: inline-block; position: relative; top: 2px;">Incompleto</span> <br/>

    </div>

    <img src="{{$r->dataUrl}}" alt="" style="width: 130%; height: 580px; border: none !important; transform: rotate(-90deg); margin-top: 180px; margin-left: -100px;" />
    @endif

</main>