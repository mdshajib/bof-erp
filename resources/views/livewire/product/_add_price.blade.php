<div>
	@foreach($price_section as $key => $price)
	<fieldset class="fieldset-border">
		<legend class="fieldset-border">{{$price['variation_name']}}</legend>
		<div class="row" wire:key="key{{ $key }}" style="padding:10px;">
			<div class="col-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="variant_name{{ $key }}" class="form-label">{{ __('Variant Name') }}</label>
                            <x-form.input wire:model.defer="price_section.{{ $key }}.variation_name" placeholder="{{ __('Product varient name') }}" id="variant_name{{ $key }}" readonly/>
                            @error('price_section.'.$key.'.variation_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-2">
                            <label for="cogs_price{{ $key }}" class="form-label required">{{ __('COGS Price') }}</label>
                            <x-form.input  type="number" wire:model.defer="price_section.{{ $key }}.cogs_price" placeholder="{{ __('Enter COGS Price') }}" id="cogs_price{{ $key }}" />
                            @error('price_section.'.$key.'.cogs_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-2">
                            <label for="selling_price{{ $key }}" class="form-label required">{{ __('Selling Price') }}</label>
                            <x-form.input  type="number" wire:model.defer="price_section.{{ $key }}.selling_price" placeholder="{{ __('Enter Selling Price') }}" id="selling_price{{ $key }}" />
                            @error('price_section.'.$key.'.selling_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>
			</div>
		</div>
	</fieldset>
	@endforeach
</div>
