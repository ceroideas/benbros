@php
  $sections = App\Models\Section::orderBy('id','asc')->get();
@endphp
<style>
  th {
    background-color: #2a3963;
    color: #fff;
  }
</style>
<table id="example2" class="table table-bordered table-striped table-hover" style="width: 100%;">
<thead>
  <tr>
    <th colspan="3">
      
    </th>
    @foreach ($sections as $sect)
      @if ($sect->inputs->count())
      <th colspan="{{$sect->inputs->count()}}">
        {{$sect->name}}
      </th>
      @endif
    @endforeach
  </tr>
{{-- </thead>
<thead> --}}
<tr>
  <th>Project</th>
  <th>Technology</th>
  <th>Processing type</th>
  @foreach ($sections as $sect)
    @foreach ($sect->inputs as $inp)
      <th>{{$inp->title}}</th>
    @endforeach
  @endforeach
</tr>
</thead>
<tbody>
  @include('includes.projects-excel')
</tbody>
</table>