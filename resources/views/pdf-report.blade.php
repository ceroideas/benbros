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
                <h1>Project Name:</h1>

                <small>{{$l->name}}</small>
            </div>
            <img src="./1.png" alt="" style="float: right; position: absolute; top: 20px; right: 80px; width: 300px">
        </header>
        
        {{-- <footer>
            Copyright © <?php echo date("Y");?> 
        </footer> --}}
        
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>

            <br>
            <br>

            @if (in_array('1', $r['fields-report']))
            
            <label class="section-title">
                General Information
            </label>
            <br>

            <div>
                @if($r->pn)<b>Project Name:</b> {{$l->name}}<br> @endif
                @if($r->mt)<b>Month:</b> {{$l->month}}<br> @endif
                @if($r->wk)<b>Week:</b> {{$l->week}}<br> @endif
                @if($r->pt)<b>Partner:</b> {{ $l->partner ? $l->partner->name : ''}} <br> @endif
                @if($r->as)<b>Analisys State:</b>
                @switch($l->analisys_state)
                    @case(1) Accepted @break
                    @case(2) Rejected @break
                    @case(3) Under Study @break
                    @case(4) To Clarify @break
                    @case(5) For Positioning @break
                    @case(6) Accepted as Fictition @break
                @endswitch
                <br> @endif
            </div>

            <br>

            @endif

            @if (in_array('2', $r['fields-report']))

                <label class="section-title">
                    Contract Information
                </label>

                <div>
                    @if($r->cs) <b>Contract State:</b> 
                    @switch($l->contract_state)
                        @case(1) No Deal @break
                        @case(2) Signed @break
                        @case(3) In Negotia tion @break
                        @case(4) Advanced Negation @break
                        @case(5) Not Started @break
                    @endswitch
                    <br> @endif
                    @if($r->cn) <b>Contract Negotiaton:</b> {{$l->negotiator}}<br> @endif
                    @if($r->pi) <b>Partner Info:</b> {{$l->partner_info}}<br> @endif
                </div>
                <br>

            @endif

            @if (in_array('3', $r['fields-report']))

                <label class="section-title">
                    General Technical Conditions
                </label>
                <br>

                <div>
                    @if($r->tp) <b>Total Peak Power:</b> {{$l->mwp}}MW<br> @endif
                    @if($r->tr) <b>Total Power Rating:</b> {{$l->mwn}}MW<br> @endif
                    @if($r->ss) <b>Substation:</b> {{$l->substation}}<br> @endif
                    @if($r->ks) <b>KM Substation:</b> {{$l->substation_km}}<br> @endif
                    @if($r->tg) <b>Technology:</b> 
                    @switch($l->technology)
                        @case(1) FV @break
                        @case(2) Green Hydrogen @break
                        @case(3) Storage @break
                        @case(4) Hybrid @break
                    @endswitch
                    <br> @endif
                </div>

                <br>

            @endif

            @if (in_array('4', $r['fields-report']))

                <label class="section-title">
                    Aditional Information
                </label>
                <br>

                @php
                    $inputs = App\Models\Input::where('table','land')->orderBy('order','asc')->get();
                @endphp

                <div>
                    @foreach ($inputs as $inp)
                        @if ($r['i'.$inp->id])
                            <b>{{$inp->title}}:</b> {{$l->checkField($inp->id)}} <br>
                        @endif
                    @endforeach
                </div>

                <br>

            @endif

            @if (in_array('5', $r['fields-report']))

                @php
                    $aval = App\Models\Endorsement::where('land_id',$l->id)->first();
                @endphp

                @if ($aval)
                    <label class="section-title">
                        Guarantee
                    </label>
                    <br>
                    
                    <div>

                        @if($r->gs) <b>Guarantee Status:</b> {{ $aval->guarantee_status ? App\Models\Status::find($aval->guarantee_status)->name : '' }} <br> @endif
                        @if($r->rs) <b>Request Status:</b> {{ $aval->request_status ? App\Models\Status::find($aval->request_status)->name : '' }}<br> @endif
                        @if($r->mw) <b>MWn: </b> {{ $aval->land->mwn }} @endif
                        @if($r->am) <b>Amount €: </b> {{ $aval->ammount }} @endif
                    </div>

                    <br>
                @endif

            @endif

            @if (in_array('6', $r['fields-report']))

                @php
                    $p = App\Models\Permission::where('land_id',$l->id)->first();
                @endphp

                @if ($p)
                    <label class="section-title">
                        Project Information
                    </label>
                    <br>

                    @php
                        $sections = App\Models\Section::orderBy('id','asc')->get();
                    @endphp
                    
                    @foreach ($sections as $sect)
                        @if ($sect->inputs)
                        <div style="margin-bottom: 12px">
                            @if ($r['s'.$sect->id])
                                <b style="text-decoration: underline">{{$sect->name}}</b> <br>
                                @foreach ($sect->inputs as $inp)
                                <b>{{$inp->title}}</b>: {{$p->checkField($inp->id)}} <br>
                                @endforeach
                            @endif
                        </div>
                        @endif
                    @endforeach
                    
                @endif

            @endif

            <br>

            @if ($r->information)

            <label class="section-title">
                Observations / Aditional Information
            </label>
            <br>

            <p>
                {{$r->information}}
            </p>

            @endif

            @if ($r->dataUrl)

            <div class="page_break"></div>

            GANTT

            <div style="line-height: 38px;">
    
                <span style="display: inline-block; background-color: lightgreen; width: 20px; height: 20px; border-radius: 2px;"></span>

                <span style="display: inline-block; position: relative; top: 2px;">Completado</span> <br>

                <span style="display: inline-block; background-color: crimson; width: 20px; height: 20px; border-radius: 2px;"></span>

                <span style="display: inline-block; position: relative; top: 2px;">Incompleto</span> <br>

            </div>

            <img src="{{$r->dataUrl}}" alt="" style="width: 130%; height: 580px; border: none !important; transform: rotate(-90deg); margin-top: 180px; margin-left: -100px;">
            @endif

        </main>
    </body>
</html>