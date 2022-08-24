@forelse (App\Models\Permission::whereExists(function($q){
  $q->from('lands')
  ->whereRaw('permissions.land_id = lands.id');
})->get() as $p)
<tr data-id="{{$p->id}}" class="table-row">
	<td style="min-width: 150px;"><a href="{{url('project',$p->id)}}">{{$p->land->name}}</a></td>
	<td>
    @if($p->land->technology)
      @php
        $t = App\Models\Technology::find($p->land->technology);
        if ($t) {
          echo (App::getLocale() == 'es' ? $t->name : $t->name_en);
        }
      @endphp
    @endif
	</td>
	<td>
    <span style="display: none">{{$p->tramitation_type}}</span>
    <select onchange="saveRow('{{$p->id}}')" class="inline-fields main-fields" name="tramitation_type">
        <option value="" selected disabled></option>
        <option value="Concurso" {{$p->tramitation_type == 'Concurso' ? 'selected' : ''}}>{{trans('layout.conc')}}</option>
        <option value="Solicitud AyC" {{$p->tramitation_type == 'Solicitud AyC' ? 'selected' : ''}}>{{trans('layout.solic')}}</option>
    </select>
  </td>
  <td>
    <div class="input-group" style="min-width: 300px;">
      <input id="file-1{{$p->id}}" type="file" name="file" class="document form-control" required>

      <button type="button" onclick="uploadFile(this)" data-action="{{url('uploadFileProject')}}" data-type="1" data-id="{{$p->id}}" class="btn btn-info">Save</button>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#documents-1-{{$p->id}}"><i class="fa far fa-eye"></i></button>
    </div>
    <div class="modal fade" id="documents-1-{{$p->id}}" style="font-weight: normal !important;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">{{trans('projects.documents_1')}}</div>
          <div class="modal-body">
            @include('includes.table-documents', ['documents' => App\Models\ProjectDocument::where('permission_id',$p->id)->where('type',1)->get()])
          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-sm btn-success">OK</button>
          </div>
        </div>
      </div>
    </div>
    {{-- @foreach (App\Models\ProjectDocument::where('permission_id',$p->id)->where('type',1)->get() as $pd)
      <li style="list-style: disc; font-size: 12px; display: block; text-overflow: ellipsis; white-space: nowrap; font-weight: normal !important; overflow: hidden;"> <a target="_blank" href="{{url('uploads/documents/permissions',$pd->url)}}">{{$pd->url}}</a> </li>
    @endforeach --}}
  </td>

  <td>
    <div class="input-group" style="min-width: 300px;">
      <input id="file-2{{$p->id}}" type="file" name="file" class="document form-control" required>

      <button type="button" onclick="uploadFile(this)" data-action="{{url('uploadFileProject')}}" data-type="2" data-id="{{$p->id}}" class="btn btn-info">Save</button>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#documents-2-{{$p->id}}"><i class="fa far fa-eye"></i></button>
    </div>
    <div class="modal fade" id="documents-2-{{$p->id}}" style="font-weight: normal !important;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">{{trans('projects.documents_2')}}</div>
          <div class="modal-body">
            @include('includes.table-documents', ['documents' => App\Models\ProjectDocument::where('permission_id',$p->id)->where('type',2)->get()])
          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-sm btn-success">OK</button>
          </div>
        </div>
      </div>
    </div>
    {{-- @foreach (App\Models\ProjectDocument::where('permission_id',$p->id)->where('type',2)->get() as $pd)
      <li style="list-style: disc; font-size: 12px; display: block; text-overflow: ellipsis; white-space: nowrap; font-weight: normal !important; overflow: hidden;"> <a target="_blank" href="{{url('uploads/documents/permissions',$pd->url)}}">{{$pd->url}}</a> </li>
    @endforeach --}}
  </td>
	@foreach ($sections as $sect)
    @if ($sect->inputs)
        @foreach ($sect->inputs as $inp)
          <td style="min-width: 120px;">
            @if ($inp->sameAsActivity())
              {{$p->checkField($inp->id)}}
              <input type="hidden" class="inline-fields extra-fields" name="{{$inp->id}}" value="{{$p->checkField($inp->id)}}">
            @else
              <select onchange="saveRow('{{$p->id}}')" class="inline-fields extra-fields" name="{{$inp->id}}">
                <option value="" selected disabled></option>
                @foreach ($inp->options as $op)
                  <option {{$p->checkField($inp->id) == $op->option ? 'selected' : ''}}>{{$op->option}}</option>
                @endforeach
              </select>
            @endif
          </td>
        @endforeach
    @endif
  @endforeach
	<td>
        {{-- <button class="btn btn-sm btn-success" onchange="saveRow('{{$p->id}}')">Save</button> --}}
        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$p->id}}">Delete</button>
    </td>
  </tr>
  <div class="modal fade" id="delete-row{{$p->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">Delete this row?</div>
        <div class="modal-footer">
          <a href="{{url('deleteProject',$p->id)}}" class="btn btn-sm btn-success">Yes, Delete</a>
          <button class="btn btn-sm btn-warning" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@empty
  <tr>
    <td colspan="{{ (App\Models\Input::where('type','project')->count())+4}}">Empty list...</td>
  </tr>
@endforelse