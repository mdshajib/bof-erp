<form wire:submit.prevent="updateCategory">
    <x-modal :has-button="false" modal-id="CategoryEditModal" on="openEditCategoryModal" title="Edit Category" size="lg">
    <div class="row" wire:key="update_category">
        <div class="row">
            @if($category_id)
            <div class="mb-3 d-none">
                    <label class="form-label" for="category_id">Id</label>
                    <input type="text" class="form-control" id="category_id" value="{{$category_id}}" placeholder="Category ID"
                        wire:model="category_id">
                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            @endif
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label required" for="name">Category Name</label>
                    <input type="text" class="form-control" id="name"  placeholder="Category en name here"
                    wire:model.defer="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label required" for="slug">Slug</label>
                    <input type="text" class="form-control" id="slug" placeholder="Enter en slug here"
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
                Update Category
            </button>
        </div>
</div>
    </x-modal>
</form>
