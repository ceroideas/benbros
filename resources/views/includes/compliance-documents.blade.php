<table class="table table-striped table-hover">

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

	{{-- <tbody>
		
	</tbody> --}}
@forelse(App\Models\ComplianceDocument::orderBy('order','asc')->get() as $key => $value)
	@php
		$ext = array_reverse(explode('.',$value->document))[0];
	@endphp
	<tr class="text-center document-row" data-name="{{$value->document}}" style="cursor: pointer;">
			
		<td onclick="window.open('{{url('uploads/compliance-documents',$value->document)}}','_blank')">
			<img src="{{url('file-images/'.$ext.'.png')}}" onerror="this.src = '{{url('file-images/file.png')}}'" style="width: 30px;" alt="">
		</td>
		<td title="{{ substr($value->document, 14) }}" onclick="window.open('{{url('uploads/compliance-documents',$value->document)}}','_blank')">
			<span style="
			text-overflow: ellipsis;
		    white-space: nowrap;
		    overflow: hidden;
			position: relative; top: 4px; display: block; width: 100%; text-align: left; font-size: 13px">{{ substr($value->document, 14,40) }} {{ strlen($value->document) > 54 ? '...' : '' }} </span>
		</td>

		<td>
			<span style="font-size: 13px;">{{$value->created_at->format('d-m-Y H:i')}}</span>
		</td>

		<td>
			<span style="font-size: 13px;">
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

		<td>
			@php
				$fz = filesize(public_path().('/uploads/compliance-documents/'.$value->document));
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
		<td>
			<button class="btn btn-danger btn-sm" data-target="#delete-{{$value->id}}" data-toggle="modal"><i class="fa fa-trash"></i></button>

			<div class="modal fade" id="delete-{{$value->id}}">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							{{trans('documents.delete')}}
						</div>
						<div class="modal-footer">
							<a class="btn btn-sm btn-success" href="{{url('delete-compliance-document',$value->id)}}">{{trans('documents.yes')}}</a>
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