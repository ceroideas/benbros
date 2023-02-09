@php
  $business = App\Models\Subcontractor::all();
@endphp
@forelse ($business as $p)
  <tr data-id="{{$p->id}}" class="table-row">
    <td>{{$p->id}}</td>
    <td> <span style="display: none">{{$p->name}}</span> <input class="inline-fields main-fields" name="name" type="text" value="{{$p->name}}"> </td>
    <td> <span style="display: none">{{$p->email}}</span> <input class="inline-fields main-fields" name="email" type="text" value="{{$p->email}}"> </td>
    <td> <span style="display: none">{{$p->phone}}</span> <input class="inline-fields main-fields" name="phone" type="text" value="{{$p->phone}}"> </td>
    <td> <span style="display: none">{{$p->address}}</span> <input class="inline-fields main-fields" name="address" type="text" value="{{$p->address}}"> </td>
	  <td>
	    <button class="btn btn-sm btn-success" onclick="saveRow('{{$p->id}}')">{{trans('extra.save')}}</button>
      <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#documents-row{{$p->id}}">{{trans('extra.contracts')}}</button>
	    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-row{{$p->id}}">{{trans('extra.delete')}}</button>

      <div class="modal fade" id="documents-row{{$p->id}}" style="font-weight: normal !important;">
        <div class="modal-dialog modal-lg" style="max-width: 1024px !important;">
          <div class="modal-content">
            <div class="modal-header">{{$p->name}} - {{trans('extra.contracts')}}</div>
            <div class="modal-body">

              <ul class="nav nav-pills mb-3">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="pill" href="#fact-{{$p->id}}" role="tab">{{trans('extra.invoices')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="pill" href="#offr-{{$p->id}}" role="tab">{{trans('extra.offers')}}</a>
                </li>
              </ul>

              <div class="tabbable">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="fact-{{$p->id}}">

                    <div id="docs-1-{{$p->id}}">
                      
                    @include('includes.table-documents_sub', ['documents' => App\Models\SubcontractorDocument::where('subcontractor_id',$p->id)->where('type',1)->get(), 'type' => 1])

                    </div>

                    <label class="btn btn-xs btn-info" style="width: 30px;"> +
                      <input type="file" class="mydocument" data-type="1" data-id="{{$p->id}}"> </label>
                  </div>
                  <div class="tab-pane" id="offr-{{$p->id}}">

                    <div id="docs-2-{{$p->id}}">
                      
                    @include('includes.table-documents_sub', ['documents' => App\Models\SubcontractorDocument::where('subcontractor_id',$p->id)->where('type',2)->get(), 'type' => 2])

                    </div>
                    
                    <label class="btn btn-xs btn-info" style="width: 30px;"> +
                      <input type="file" class="mydocument" data-type="2" data-id="{{$p->id}}"> </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button data-dismiss="modal" class="btn btn-sm btn-success">OK</button>
            </div>
          </div>
        </div>
      </div>

	  </td>
  </tr>
  <div class="modal fade" id="delete-row{{$p->id}}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">{{trans('extra.delete_prompt_1')}}</div>
        <div class="modal-footer">
          <a href="{{url('deleteSubcontractor',$p->id)}}" class="btn btn-sm btn-success">{{trans('extra.yes')}}</a>
          <button class="btn btn-sm btn-warning" data-dismiss="modal">{{trans('extra.no')}}</button>
        </div>
      </div>
    </div>
  </div>
@empty
  <tr>
    <td colspan="6">{{trans('extra.empty')}}</td>
  </tr>
@endforelse