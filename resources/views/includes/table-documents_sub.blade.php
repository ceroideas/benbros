<table class="table table-striped table-hover" style="font-weight: normal !important;">

	<thead style="font-size: 14px;">
		<th colspan="2" style="width: 100px;">
			{{trans('documents.name')}}
		</th>

		<th>
			{{trans('documents.date')}}
		</th>

		<th>
			{{trans('documents.type')}}
		</th>

		<th>
			{{trans('documents.size')}}
		</th>

		<th>
		</th>
	</thead>

	<tbody>
		
	</tbody>
@forelse($documents as $key => $value)
	@php
		$ext = array_reverse(explode('.',$value->url))[0];
	@endphp
	<tr class="text-center document-row" data-name="{{$value->url}}" style="cursor: pointer;">
			
		<td onclick="window.open('{{url('uploads/documents/subcontractors',$value->url)}}','_blank')">
			<img src="{{url('file-images/'.$ext.'.png')}}" onerror="this.src = '{{url('file-images/file.png')}}'" style="width: 30px;" alt="">
		</td>
		<td title="{{ substr($value->url, 0) }}" onclick="window.open('{{url('uploads/documents/subcontractors',$value->url)}}','_blank')">
			<span style="
			text-overflow: ellipsis;
		    white-space: nowrap;
		    overflow: hidden;
		    font-weight: normal !important;
			position: relative; top: 4px; display: block; width: 100%; text-align: left; font-size: 13px">{{ substr($value->url, 0) }} {{ strlen($value->url) > 54 ? '' : '' }} </span>
		</td>

		<td>
			<span style="font-size: 13px; font-weight: normal !important;">{{$value->created_at->format('d-m-Y H:i')}}</span>
		</td>

		<td>
			<span style="font-size: 13px; font-weight: normal !important;">
			@switch($ext)
			    @case('csv')
			        {{trans('documents.type_1')}}
			        @break
			    @case('doc')
			        {{trans('documents.type_2')}}
			        @break
			    @case('docx')
			        {{trans('documents.type_3')}}
			        @break
			    @case('html')
			        {{trans('documents.type_4')}}
			        @break
			    @case('jpg')
			        {{trans('documents.type_5')}}
			        @break
			    @case('mp3')
			        {{trans('documents.type_6')}}
			        @break
			    @case('mp4')
			        {{trans('documents.type_7')}}
			        @break
			    @case('pdf')
			        {{trans('documents.type_8')}}
			        @break
			    @case('png')
			        {{trans('documents.type_9')}}
			        @break
			    @case('ppt')
			        {{trans('documents.type_10')}}
			        @break
			    @case('pptx')
			        {{trans('documents.type_11')}}
			        @break
			    @case('rar')
			        {{trans('documents.type_12')}}
			        @break
			    @case('txt')
			        {{trans('documents.type_13')}}
			        @break
			    @case('xls')
			        {{trans('documents.type_14')}}
			        @break
			    @case('xlsx')
			        {{trans('documents.type_15')}}
			        @break
			    @case('xml')
			        {{trans('documents.type_16')}}
			        @break
			    @case('zip')
			        {{trans('documents.type_17')}}
			        @break			
			    @default
			    	{{trans('documents.type_18')}}
			        
			@endswitch
			</span>
			
		</td>

		<td style="font-weight: normal !important;">
			@php
				$fz = filesize(public_path().('/uploads/documents/subcontractors/'.$value->url));
			@endphp

			<span style="font-size: 13px;">
				@if ($fz < 1024)
					{{ number_format($fz,2) }} bytes
				@elseif($fz >= 1024)
					{{ number_format($fz/1024,2) }} kb
				@elseif($fz >= 125000)
					{{ number_format($fz/125000,2) }} mb
				@endif
			</span>
		</td>

		<td style="display: flex;">
			<select class="subcontractorStatus form-control form-control-sm" onchange="changeDocumentStatus({{$value->id}},this)" data-id="{{$value->id}}">
				<option value="" selected disabled></option>
				@if ($type == 1)
					<option {{$value->status == '1' ? 'selected' : ''}} value="1">Pendiente</option>
					<option {{$value->status == '2' ? 'selected' : ''}} value="2">Pagado</option>
				@else
					<option {{$value->status == '1' ? 'selected' : ''}} value="1">Firmado</option>
					<option {{$value->status == '2' ? 'selected' : ''}} value="2">No Firmado</option>
				@endif
			</select>

			<button class="btn btn-danger btn-sm" data-target="#delete-{{$value->id}}" data-toggle="modal"><i class="fa fa-trash"></i></button>

			<div class="modal fade" id="delete-{{$value->id}}">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							{{trans('documents.delete')}}
						</div>
						<div class="modal-footer">
							<a class="btn btn-sm btn-success" href="{{url('delete-subcontractor-document',$value->id)}}">{{trans('documents.yes')}}</a>
							<button class="btn btn-sm btn-danger">{{trans('documents.no')}}</button>
						</div>
					</div>
				</div>
			</div>
		</td>
	</tr>
@empty
	<tr>
		<td colspan="6">
			<i>{{trans('documents.empty')}}</i>
		</td>
	</tr>
@endforelse
</table>