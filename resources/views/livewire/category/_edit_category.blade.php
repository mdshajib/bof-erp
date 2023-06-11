<form wire:submit.prevent="updateCategory">
    <x-modal :has-button="false" modal-id="CategoryEditModal" on="openEditCategoryModal" title="Edit Category" size="lg">
    <div class="row" wire:key="update_category">

        @if($categoryid)
        <div class="mb-3 d-none">
                <label class="form-label" for="categoryid">Id</label>
                <input type="text" class="form-control" id="categoryid" value="{{$categoryid}}" placeholder="Category ID"
                    wire:model="categoryid">
                @error('categoryid') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
           @if($categoryid)
            <div class="mb-3">
                <label class="form-label" for="parent_id">Parent Category</label>
                <select class="form-select" name="parent_id" id="parent_id" wire:model="parent_id">
                    <option>Select</option>
                    @foreach($this->categories as $category)
                    <option value="{{$category->id}}" >{{$category->name}}</option>
                    @endforeach
                </select>
                @error('parent_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required" for="name_de">Category Name DE</label>
                <input type="text" class="form-control" id="name_de"  placeholder="Category de name here"
                wire:model.defer="name_de">
                @error('name_de') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required" for="name">Category Name EN</label>
                <input type="text" class="form-control" id="name"  placeholder="Category en name here"
                wire:model.defer="name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="display_name_de">Display Name DE</label>
                <input type="text" class="form-control" id="display_name_de" placeholder="Enter de display name here"
                wire:model.defer="display_name_de">
                @error('display_name_de') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="display_name">Display Name EN</label>
                <input type="text" class="form-control" id="display_name" placeholder="Enter en display name here"
                wire:model.defer="display_name">
                @error('display_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div> -->
		<div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required" for="slug_de">Slug DE</label>
                <input type="text" class="form-control" id="slug_de" placeholder="Enter de slug here"
                wire:model.defer="slug_de">
                @error('slug_de') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required" for="slug">Slug EN</label>
                <input type="text" class="form-control" id="slug" placeholder="Enter en slug here"
                wire:model.defer="slug">
                @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required" for="taxcode">Tax Code</label>
                <select class="form-select" name="taxcode" id="taxcode" wire:model.defer="taxcode">
                    <option value="">Select</option>
                    <option value="520">2.5% (Tax code 520)</option>
                    <option value="510">7.7% (Tax code 510)</option>
                    <option value="700">0% (Tax Code 700)</option>
                    <option value="920">0% (Tax Code 920)</option>
                 
                </select>
                @error('vat') <span class="text-danger">{{ $message }}</span> @enderror
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
