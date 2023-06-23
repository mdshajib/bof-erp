@forelse($row_section as $key => $value)
<tr wire:key="{{ $key }}">
	<td>
        {{ $row_section[$key]['product'] }}
	</td>
	<td>
	   <input type="number" class="form-control" wire:model.lazy="row_section.{{ $key }}.quantity" placeholder="Quantity" >
        @error('row_section.'.$key.'.quantity')<div class="text-danger order-table-height-22"> {{ $message }} </div> @enderror
	</td>
	<td>
        {{ $row_section[$key]['unit_price'] }}
	</td>
	<td>
        {{ $row_section[$key]['discount'] }}
    </td>
    <td>
        {{ $row_section[$key]['total_discount'] }}
    </td>
	<td>
        {{ number_format($row_section[$key]['total'] ,2) }}
	</td>
    <td>
        {{ $row_section[$key]['stock'] }}
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
