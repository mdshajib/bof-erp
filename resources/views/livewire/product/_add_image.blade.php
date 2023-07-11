<div>
	<fieldset class="fieldset-border">
	<legend class="fieldset-border required">Image</legend>
		<div class="row" style="padding:10px;">
			<div class="col-11">
				<div class="row mb-4">
                    @if($product_info['path'] !=null)
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="path" class="form-label">{{ __('Current Image') }}</label>
                                <img src="{{$product_info['path']}}" alt="product-image" class="me-1 d-block" height="111">
                            </div>
                        </div>
                    @endif

					<div class="col-lg-3">
						<div class="mb-3">

							<x-form.filepond
								wire:model.lazy="image_section.path"
								allowImagePreview
								imagePreviewMaxHeight="200"
								allowFileTypeValidation
								acceptedFileTypes="['image/*']"
								allowFileSizeValidation
								maxFileSize="2mb"
								allowImageValidateSize
							/>

							@error('image_section.path') <span class="text-danger">{{ $message }}</span> @enderror
							<div wire:loading wire:target="image_section.path">Uploading...</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</fieldset>
</div>
