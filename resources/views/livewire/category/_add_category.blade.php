<form wire:submit.prevent="submit">
    <x-modal :has-button="false" modal-id="categoryModal" on="openCategoryModal" title="Add New Category" size="lg">
        <div class="row" wire:key="add_category">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required" for="name">Category Name</label>
                        <input type="text" class="form-control" id="name"
                        wire:model.defer="name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required" for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug"
                        wire:model.defer="slug">
                        @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required" for="type">Type</label>
                        <select id="type" class="form-control" wire:model.defer="type">
                            <option value="ready-made">Ready Made</option>
                            <option value="made-in-house">Made In House</option>
                            <option value="raw-material">Raw Material</option>
                        </select>

                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <div wire:loading>
                        <i class="fas fa-spin fa-spinner mr-2"></i>
                    </div>
                    Save Category
                </button>
            </div>
        </div>
    </x-modal>
</form>
