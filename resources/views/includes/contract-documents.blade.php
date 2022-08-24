<table class="table table-striped table-hover">

	<thead style="font-size: 14px;">
		<th colspan="2" style="width: 100px;">
			Nombre
		</th>

		<th>
			Fecha de modificación
		</th>

		<th>
			Tipo
		</th>

		<th>
			Tamaño
		</th>
		<th>
		</th>
	</thead>

	<tbody>
		
	</tbody>
@forelse(App\Models\ContractDocument::where('type',$type)->get() as $key => $value)
	@php
		$ext = array_reverse(explode('.',$value->url))[0];
	@endphp
	<tr class="text-center document-row" data-name="{{$value->url}}" style="cursor: pointer;">
			
		<td onclick="window.open('{{url('uploads/contract-documents',$value->url)}}','_blank')">
			<img src="{{url('file-images/'.$ext.'.png')}}" onerror="this.src = '{{url('file-images/file.png')}}'" style="width: 30px;" alt="">
		</td>
		<td title="{{ substr($value->url, 14) }}" onclick="window.open('{{url('uploads/contract-documents',$value->url)}}','_blank')">
			<span style="
			text-overflow: ellipsis;
		    white-space: nowrap;
		    overflow: hidden;
			position: relative; top: 4px; display: block; width: 100%; text-align: left; font-size: 13px">{{ substr($value->url, 14,40) }} {{ strlen($value->url) > 54 ? '...' : '' }} </span>
		</td>

		<td>
			<span style="font-size: 13px;">{{$value->created_at->format('d-m-Y H:i')}}</span>
		</td>

		<td>
			<span style="font-size: 13px;">
			@switch($ext)
			    @case('csv')
			        Archivo separado por comas
			        @break
			    @case('doc')
			        Documento de Microsoft Word
			        @break
			    @case('docx')
			        Documento de Microsoft Word
			        @break
			    @case('html')
			        Archivo HTML
			        @break
			    @case('jpg')
			        Imagen JPG
			        @break
			    @case('mp3')
			        Archivo de audio MP3
			        @break
			    @case('mp4')
			        Archivo de video MP4
			        @break
			    @case('pdf')
			        Archivo PDF
			        @break
			    @case('png')
			        Imagen PNG
			        @break
			    @case('ppt')
			        Presentación de Microsoft Power Point
			        @break
			    @case('pptx')
			        Presentación de Microsoft Power Point
			        @break
			    @case('rar')
			        Archivo comprimido en RAR
			        @break
			    @case('txt')
			        Archivo de Texto
			        @break
			    @case('xls')
			        <span style="color: lightblue" onclick="loadDocument('{{url('uploads/contract-documents',$value->url)}}',{{$value->type}})"> Hoja de Cálculo de Microsoft Excel </span>
			        @break
			    @case('xlsx')
			        <span style="color: lightblue" onclick="loadDocument('{{url('uploads/contract-documents',$value->url)}}',{{$value->type}})"> Hoja de Cálculo de Microsoft Excel </span>
			        @break
			    @case('xml')
			        Documento XML
			        @break
			    @case('zip')
			        Archivo comprimido en ZIP
			        @break			
			    @default
			    	Archivo
			        
			@endswitch
			</span>
			
		</td>

		<td>
			@php
				$fz = filesize(public_path().('/uploads/contract-documents/'.$value->url));
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
							¿Desea eliminar el documento seleccionado?
						</div>
						<div class="modal-footer">
							<a class="btn btn-sm btn-success" href="{{url('delete-contract-document',$value->id)}}">Si</a>
							<button class="btn btn-sm btn-danger">Cancelar</button>
						</div>
					</div>
				</div>
			</div>
		</td>
	</tr>
@empty
	<tr>
		<td colspan="6">
			<i>No hay documentos que mostrar...</i>
		</td>
	</tr>
@endforelse
</table>