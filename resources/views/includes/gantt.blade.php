<div id="chartDiv" style="height: 800px; margin: 0px auto;"></div>

<div>

  <br>
    
  <div style="line-height: 38px;">
    
    <span style="display: inline-block; background-color: lightgreen; width: 20px; height: 20px; border-radius: 2px;"></span>

    <span style="display: inline-block; position: relative; top: -4px;">Completado</span> <br>

    <span style="display: inline-block; background-color: crimson; width: 20px; height: 20px; border-radius: 2px;"></span>

    <span style="display: inline-block; position: relative; top: -4px;">Incompleto</span> <br>

  </div>

</div>

@section('scripts1')

<script>
	/*
Gantt chart with axis markers.
Learn how to:

  - Create a gantt chart with axis markers.
*/
      // JS
      var chart = JSC.chart('chartDiv', {
        debug: true,
        defaultCultureName: 'es-ES',
        type: 'horizontal column',
        zAxisScaleType: 'stacked',
        yAxis_scale_type: 'time',
        xAxis_visible: false,
        title_label_text: '<span style="font-size: 20px; font-weight: bolder;">{{$p->land->name}}</span>',
        legend_visible: false,
        defaultPoint: {
          label_text: '<span style="font-size: 14px">%name</span>',
          tooltip: '<span style="font-size: 15px"><b>%name</b> <br/>%low - %high<br/>{days(%high-%low)} days</span>'
        },
        yAxis: {
          markers: [
            {
              value: '{{Carbon\Carbon::now()}}',
              color: '#b0be5f',
              label_text: 'Today'
            },
          ]
        },
        series: [
          {
            name: 'one',
            points: [
            @foreach (App\Models\ActivitySection::where('permission_id',$p->id)->get() as $as)
              @foreach ($as->activities as $act)
                @if ($act->start_date && $act->end_date)
                  {
                    name: '{{$act->name}}',
                    y: ['{{Carbon\Carbon::parse($act->start_date)}}', '{{Carbon\Carbon::parse($act->end_date)}}'],
                    color: ['{{ (Carbon\Carbon::parse($act->end_date) < Carbon\Carbon::now() && $act->progress != 100) ? 'crimson' : 'lightgreen' }}', 0.5],
                  },
                @endif
              @endforeach
            @endforeach
              // {
              //   name: 'Execution',
              //   y: ['3/15/2022', '4/20/2022']
              // },
              // { name: 'Cleanup', y: ['4/10/2022', '5/12/2022'] },
              // {
              //   name: 'Presentation',
              //   y: ['6/1/2022', '7/1/2022']
              // }
            ]
          }
        ]
      });

      var final_h = 100;

      @foreach (App\Models\ActivitySection::where('permission_id',$p->id)->get() as $as)
        @foreach ($as->activities as $act)
          @if ($act->start_date && $act->end_date)
            final_h+=40;
          @endif
        @endforeach
      @endforeach

      $('#chartDiv').css('height', final_h+'px');

      var imgchart = chart.toBase64Image();

      console.log(imgchart);
</script>

@endsection