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

  <th class="no-filter"></th>
  <th class="no-filter">Options</th>
</tr>