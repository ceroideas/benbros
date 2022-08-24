<style>
  th {
    background-color: #2a3963;
    color: #fff;
  }
</style>
<table id="example2" class="table table-bordered table-hover" style="width: 100%;">
  <thead>
  <tr>
    <th>Partner</th>
    {{-- @foreach ($inputs as $inp)
      <th>{{$inp->title}}</th>
    @endforeach --}}
    <th>Total Received</th>
    <th>Total Accepted</th>
    <th>Total Rejected</th>
    <th>% Success</th>
  </tr>
  </thead>
  <tbody>

    @foreach (App\Models\Partner::whereExists(function($q){
      $q->from('lands')
        ->whereRaw('lands.partner_id = partners.id');
    })->get() as $p)
      <tr>
        <td>{{$p->name}}</td>
        {{-- @foreach ($inputs as $inp)
          <td></td>
        @endforeach --}}
        <td>{{ App\Models\Land::where('partner_id',$p->id)->count() }}</td>
        <td>{{ App\Models\Land::where('partner_id',$p->id)->where('analisys_state',1)->where('contract_state',2)->count() }}</td>
        <td>{{ App\Models\Land::where('partner_id',$p->id)->where('analisys_state',2)->count() }}</td>
        <td>{{ App\Models\Land::count() ? number_format((App\Models\Land::where('partner_id',$p->id)->where('analisys_state',1)->where('contract_state',2)->count() * 100) / App\Models\Land::count(),2) : 0 }}%</td>
      </tr>
    @endforeach
  
  </tbody>
</table>