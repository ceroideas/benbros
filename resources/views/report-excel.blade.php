@php
	$inputs = App\Models\Input::where('table','land')->whereIn('id',$ids)->orderBy('order','asc')->get();
@endphp
<style>
  th {
    background-color: #2a3963;
    color: #fff;
  }
</style>
<table id="example1" class="table table-bordered table-hover table-striped">
<thead>
<tr class="filters">
  <th class="no-filter">Id</th>
  <th>Partner</th>
  <th>Month</th>
  <th>Week</th>
  <th>Project Name</th>
  <th>Analisys State</th>
  <th>Contract State</th>
  <th>Contract Negotiator</th>
  <th>Partner info</th>
  <th>MWp</th>
  <th>MWn</th>
  <th>Technology</th>
  <th>SET</th>
  <th>KM SET</th>

  @foreach ($inputs as $inp)
    <th>{{$inp->title}} {{-- $inp->id --}}</th>
  @endforeach
</tr>
</thead>
<tbody id="all-lands">
  @include('includes.lands-excel')
</tbody>
</table>