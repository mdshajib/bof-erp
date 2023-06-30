<div>
	@foreach($image_section as $key => $value)
	<fieldset class="fieldset-border">
	<legend class="fieldset-border required">Image {{$key+1}}</legend>
		<div class="row" wire:key="image{{ $key }}" style="padding:10px;">
			<div class="col-11">
				<div class="row mb-4">
					<div class="col-lg-3">
						<div class="mb-3">

							<x-form.filepond
								wire:model.lazy="image_section.{{ $key }}.path"
								allowImagePreview
								imagePreviewMaxHeight="200"
								allowFileTypeValidation
								acceptedFileTypes="['image/*']"
								allowFileSizeValidation
								maxFileSize="2mb"
								allowImageValidateSize
							/>

							@error('image_section.'.$key.'.path') <span class="text-danger">{{ $message }}</span> @enderror
							<div wire:loading wire:target="image_section.{{ $key }}.path">Uploading...</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</fieldset>
	@endforeach
</div>
