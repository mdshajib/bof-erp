@foreach($variation_section as $key => $value)
    <fieldset class="fieldset-border">
        <legend class="fieldset-border">Variation {{$key+1}}</legend>
        <div class="row" wire:key="{{ $key }}" style="padding:10px;">
            <div class="col-11 col-md-11 col-lg-11">
                <div class="row mb-1">
                    <div class="col-md-3 col-lg-3">
                        <div class="mb-2">
                            <label for="variation_name{{ $key }}" class="form-label required">{{ __('Variation Name') }}</label>
                            <x-form.input  type="text" wire:model.defer="variation_section.{{ $key }}.variation_name" placeholder="{{ __('Enter Variation Name') }}" id="variation_name{{ $key }}" />
                            @error('variation_section.'.$key.'.variation_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="mb-2">
                            <label for="low_quantity_alert{{ $key }}" class="form-label required">{{ __('Low Quantity Alert') }}</label>
                            <x-form.input  type="number" wire:model.defer="variation_section.{{ $key }}.low_quantity_alert" placeholder="{{ __('Enter low quantity lert') }}" id="low_quantity_alert{{ $key }}" />
                            @error('variation_section.'.$key.'.low_quantity_alert') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="path{{ $key }}" class="form-label">{{ __('Variation Image') }}</label>
                                <x-form.filepond
                                    wire:model.lazy="variation_section.{{ $key }}.path"
                                    allowFileTypeValidation
                                    acceptedFileTypes="['image/*']"
                                    allowImagePreview
                                    imagePreviewMaxHeight="200"
                                    allowFileSizeValidation
                                    maxFileSize="2mb"
                                />

                                @error('variation_section.'.$key.'.path') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>


                </div>
            </div>
            <div class="col-1 col-md-1 col-lg-1 mt-4">
                @if(!$loop->first)
                    <button class="btn btn-link" wire:click.prevent="removeVariationSection({{ $key }}, {{ $value['id'] }})"><i class="fa fa-trash logo-color"></i></button>
                @endif
            </div>
        </div>
    </fieldset>
    @if($loop->last)
        <div class="col-lg-12 mb-2">
            <button type="button" wire:click.prevent="addVariationSection" class="btn btn-link logo-color">{{ __('Add Another Variation') }}</button>
        </div>
    @endif
@endforeach
