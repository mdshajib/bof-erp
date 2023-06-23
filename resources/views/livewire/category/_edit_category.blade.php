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
                        <option value="ready made">Ready Made</option>
                        <option value="made in house">Made In House</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="row">
             <div class="col-xl-12">
			   <div class="card">
			        <div class="card-header">
						<h4 class="card-title mb-0">Select Variable Product Type Attributes</h4>
					</div>
					<div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"  value="weight" id="ck_select" wire:model="variable_attributes">
                                    <label class="form-check-label" for="formCheck1">
                                        Weight
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="color" id="ck_select"  wire:model="variable_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Color
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="size" id="ck_select"  wire:model="variable_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                       Size
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"  value="mahlgrad-bohnen" id="ck_select" wire:model="variable_attributes">
                                    <label class="form-check-label" for="formCheck1">
                                        Mahlgrad / Bohnen
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="motive" id="ck_select"  wire:model="variable_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Motive
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="worth" id="ck_select"  wire:model="variable_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Value
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
								<div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="deliveries" id="ck_select"  wire:model="variable_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Deliveries
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
								<div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="packaging" id="ck_select"  wire:model="variable_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Packaging
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			 </div>
             <div class="col-xl-12">
			   <div class="card">
			        <div class="card-header">
						<h4 class="card-title mb-0">Select Variable Subcription Product Type Attributes</h4>
					</div>
					<div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"  value="weight" id="ck_select" wire:model="variable_subcription_attributes">
                                    <label class="form-check-label" for="formCheck1">
                                        Weight
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="color" id="ck_select"  wire:model="variable_subcription_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Color
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="size" id="ck_select"  wire:model="variable_subcription_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                       Size
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"  value="mahlgrad-bohnen" id="ck_select" wire:model="variable_subcription_attributes">
                                    <label class="form-check-label" for="formCheck1">
                                        Mahlgrad / Bohnen
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
								<div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="motive" id="ck_select"  wire:model="variable_subcription_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Motive
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="frequency" id="ck_select"  wire:model="variable_subcription_attributes" checked disabled />
                                    <label class="form-check-label" for="formCheck2">
                                        Frequency
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="worth" id="ck_select"  wire:model="variable_subcription_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Value
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
								<div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="deliveries" id="ck_select"  wire:model="variable_subcription_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Deliveries
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
								<div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="packaging" id="ck_select"  wire:model="variable_subcription_attributes">
                                    <label class="form-check-label" for="formCheck2">
                                        Packaging
                                    </label>
                                    @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			 </div>
		  </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update Category</button>
        </div>
</div>
    </x-modal>
</form>
