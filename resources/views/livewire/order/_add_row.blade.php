@forelse($row_section as $key => $value)
<tr wire:key="{{ $key }}">
	<td>
	    <input type="text" class="form-control" wire:model="row_section.{{ $key }}.product" placeholder="Product name" readonly />
        @error('row_section.'.$key.'.product')<div class="text-danger order-table-height-22">   {{ $message }} </div>@enderror
	</td>
	<td>
	   <input type="number" class="form-control" wire:model.lazy="row_section.{{ $key }}.quantity" placeholder="Quantity" >
        @error('row_section.'.$key.'.quantity')<div class="text-danger order-table-height-22"> {{ $message }} </div> @enderror
	</td>
	<td>
	   <input type="number" class="form-control" wire:model.lazy="row_section.{{ $key }}.unit_price" placeholder="Unit price" readonly>
        @error('row_section.'.$key.'.unit_price') <div class="text-danger order-table-height-22"> {{ $message }} </div> @enderror
	</td>
	<td>
		<input type="number" class="form-control" wire:model.lazy="row_section.{{ $key }}.discount" placeholder="Product discount" readonly>
        @error('row_section.'.$key.'.discount') <div class="text-danger order-table-height-22"> {{ $message }} </div> @enderror
    </td>
    <td>
        <input type="number" class="form-control" wire:model.lazy="row_section.{{ $key }}.total_discount" placeholder="Product discount"  readonly>
        @error('row_section.'.$key.'.total_discount') <div class="text-danger order-table-height-22"> {{ $message }} </div> @enderror
    </td>
	<td>
        {{ number_format($row_section[$key]['total'] ,2) }}
	</td>
	<td>
		@if(count($row_section) > 1)
		<button class="btn btn-link" wire:click.prevent="removeRow({{ $key }}, {{ $value['id'] }})"><i class="fa fa-trash"></i></button>
		@endif
	</td>
</tr>
@empty
    <tr>
        <td colspan="7"> <span class="text-danger mt-3">Product not added !!</span></td>
    </tr>
@endforelse
