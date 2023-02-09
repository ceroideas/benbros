<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin-top: 150px;
                font-family: Arial, Helvetica, sans-serif;
            }

            .page_break { page-break-before: always; }

            main {
                margin: 0;
                margin-top: 0;
                line-height: 36px;
            }

            main div {
                padding-left: 8px;
            }

            header {
                position: fixed;
                top: -150px;
                left: -60px;
                right: 0px;
                /* height: 50px; */
                font-size: 20px !important;

                /** Extra personal styles **/
                background-color: #fff;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
                font-size: 20px !important;

                /** Extra personal styles **/
                background-color: #fff;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            .left-title {
                text-align: center;
                background-color: #2a3963;
                color: #fff;
                padding: 20px;
                width: 400px;
                height: 100px;
            }
            .left-title h1 {
                /* margin: 0 !important; */
                margin-top: 10px;
                margin-bottom: 0;
            }
            .section-title {
                border-radius: 8px;
                border: 4px solid #2a3963;
                padding: 2px 8px;
                color: #000;
                display: inline-block;
                font-size: 20px;
                line-height: 20px;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <div class="left-title">
                <h1>{{trans('lands.project_name')}}:</h1>

                <small>{{$l->name}}</small>
            </div>
            <img src="./1.png" alt="" style="float: right; position: absolute; top: 20px; right: 80px; width: 300px" />
        </header>
        
        {{-- <footer>
            Copyright © <?php echo date("Y");?> 
        </footer> --}}
        
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>

            <br/>
            <br/>

            @if (in_array('1', $r['fields-report']))
            
            <label class="section-title">
                {{trans('lands.general_info')}}
            </label>
            <br/>

            <div style="padding: 12px; background-color: #f1f1f1;">
                @if($r->pn)<b>{{trans('lands.project_name')}}:</b> {{$l->name}}<br/> @endif
                {{-- @if($r->mt)<b>{{trans('lands.month')}}:</b> {{$l->month}}<br/> @endif
                @if($r->wk)<b>{{trans('lands.week')}}:</b> {{$l->week}}<br/> @endif --}}
                @if($r->pt)<b>{{trans('lands.partner')}}:</b> {{ $l->partner ? $l->partner->name : ''}} <br/> @endif
                @if($r->as)<b>{{trans('lands.analysis_state')}}:</b>
                @switch($l->analisys_state)
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
                <br/> @endif
            </div>

            <br/>

            @endif

            @if (in_array('2', $r['fields-report']))

                <label class="section-title">
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
                <br/>

            @endif

            @if (in_array('3', $r['fields-report']))

                <label class="section-title">
                    {{trans('lands.general_tech_conditions')}}
                </label>
                <br/>

                <div style="padding: 12px; background-color: #f1f1f1;">
                    @if($r->tp) <li><b>Total {{trans('lands.mwp')}}:</b> {{$l->mwp}}MW </li> @endif
                    @if($r->tr) <li><b>Total {{trans('lands.mwn')}}:</b> {{$l->mwn}}MW </li> @endif
                    @if($r->ss) <li><b>{{trans('lands.set')}}:</b> {{$l->substation}} </li> @endif
                    @if($r->ks) <li><b>{{trans('lands.km_set')}}:</b> {{$l->substation_km}} </li> @endif
                    @if($r->tg) <li><b>{{trans('lands.technology')}}:</b>
                    @php
                        $t = App\Models\Technology::find($l->technology);
                    @endphp

                    {{$t ? $t->name : '--'}}
                    </li> @endif
                </div>

                <br/>

            @endif

            @if (in_array('4', $r['fields-report']))

                <label class="section-title">
                    {{trans('lands.aditional_info')}}
                </label>
                <br/>

                @php
                    $inputs = App\Models\Input::where('table','land')->orderBy('order','asc')->get();
                @endphp

                <div style="padding: 12px; background-color: #f1f1f1;">
                    @foreach ($inputs as $inp)
                        @if ($r['i'.$inp->id])
                            <li><b>{{$inp->title}}:</b> {{$l->checkField($inp->id)}} </li>
                        @endif
                    @endforeach
                </div>

                <br/>

            @endif

            @if (in_array('5', $r['fields-report']))

                @php
                    $aval = App\Models\Endorsement::where('land_id',$l->id)->first();
                @endphp

                @if ($aval)
                    <label class="section-title">
                        {{trans('lands.guarantee')}}
                    </label>
                    <br/>
                    
                    <div style="padding: 12px; background-color: #f1f1f1;">

                        @if($r->gs) <li><b>{{trans('guarantee.guarantee_status')}}:</b> {{ $aval->guarantee_status ? App\Models\Status::find($aval->guarantee_status)->name : '' }} </li> @endif
                        @if($r->rs) <li><b>{{trans('guarantee.request_status')}}:</b> {{ $aval->request_status ? App\Models\Status::find($aval->request_status)->name : '' }} </li> @endif
                        @if($r->mw) <li><b>{{trans('guarantee.mwn')}}: </b> {{ $aval->land->mwn }} </li> @endif
                        @if($r->am) <li><b>{{trans('guarantee.amount')}}: </b> {{ $aval->ammount }} </li> @endif
                    </div>

                    <br/>
                @endif

            @endif

            @if (in_array('6', $r['fields-report']))

                @php
                    $p = App\Models\Permission::where('land_id',$l->id)->first();
                @endphp

                @if ($p)
                    <label class="section-title">
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

            <div class="page_break"></div>

            <label class="section-title">
                {{trans('lands.obs_aditional_info')}}
            </label>
            <br/>

            <p>
                {{$r->information}}
            </p>

            @endif

            @if ($r->dataUrl)

            <div class="page_break"></div>

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
    </body>
</html>