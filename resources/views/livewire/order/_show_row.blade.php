@forelse($row_section as $key => $value)
<tr wire:key="{{ $key }}">
	<td>
        {{ $row_section[$key]['product'] }}
	</td>
	<td>
        {{ $row_section[$key]['quantity'] }}
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
        {{ number_format($row_section[$key]['gross_amount'] ,2) }}
	</td>
</tr>
@empty
    <tr>
        <td colspan="8"> <span class="text-danger mt-3 text">Product not added !!</span></td>
    </tr>
@endforelse
