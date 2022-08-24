@foreach (App\Models\Status::orderBy('id','desc')->get() as $s)
  <tr class="table-row" data-id="{{$s->id}}">
    <td>{{$s->id}}</td>
    <td>
      <select onchange="saveRow2('{{$s->id}}')" class="inline-fields main-fields2" name="type">
        <option value="" selected disabled></option>
        <option {{$s->type == 'guarantee' ? 'selected' : ''}} value="guarantee">{{trans('guarantee.guaran')}}</option>
        <option {{$s->type == 'request' ? 'selected' : ''}} value="request">{{trans('guarantee.request')}}</option>
      </select>
    </td>
    <td><input onchange="saveRow2('{{$s->id}}')" class="inline-fields main-fields2" name="name" value="{{$s->name}}" type="text"></td>
    <td>
    	<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-status-{{$s->id}}">{{trans('guarantee.delete')}}</button>
    </td>
  </tr>

  <div class="modal fade" id="delete-status-{{$s->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">{{trans('guarantee.delete_prompt')}}</div>
        <div class="modal-footer">
          <a href="{{url('deleteStatus',$s->id)}}" class="btn btn-sm btn-success">{{trans('guarantee.yes')}}</a>
          <button class="btn btn-sm btn-warning" data-dismiss="modal">{{trans('guarantee.cancel')}}</button>
        </div>
      </div>
    </div>
  </div>
@endforeach