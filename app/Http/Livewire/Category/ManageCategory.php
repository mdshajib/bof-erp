<?php

namespace App\Http\Livewire\Category;

use App\Http\Livewire\BaseComponent;
use App\Models\Category;
use App\Traits\WithBulkActions;
use App\Traits\WithCachedRows;
use App\Traits\WithPerPagePagination;
use App\Traits\WithSorting;

class ManageCategory extends BaseComponent
{
    use WithPerPagePagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkActions;

    protected $listeners = ['deleteConfirm' => 'categoryDelete', 'deleteCancel'=> 'categoryDeleteCancel'];

    public $category_id;

    public $categoryIdBeingRemoved=null;

    public $filter = [
        'name'          => ''
    ];
    public $name;
    public $slug;

    public function render()
    {
        $data['category_list'] = $this->rows;
        return $this->view('livewire.category.manage-category', $data);
    }

    public function getRowsQueryProperty()
    {
        $query = Category::query()
            ->when(
                $this->filter['name'],
                fn ($q, $name) => $q->where('name', 'like', "%{$name}%")
                    ->orWhere('name_de', 'like', "%$name%")
            );

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function openNewCategoryModal()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('openCategoryModal');
    }

    public function submit()
    {
        $rules = [
            'name'            => 'required|unique:categories,name',
            'slug'            => 'required|unique:categories,slug',
        ];

        $messages = [
            'name.required'           => 'The name is required',
            'slug.required'           => 'A Slug is required',
            'slug.unique'             => 'Slug must be different',
        ];

        $validatedData = $this->validate($rules, $messages);

        Category::create($validatedData);
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'title' => 'Active',  'message' => 'New category created successfully']);
        $this->reset();
        $this->hideModal();
    }

    public function openCategoryEditModal($category_id)
    {
        $this->resetErrorBag();
        $category                 = Category::find($category_id);
        $this->category_id        = $category->id;
        $this->name               = $category->name;
        $this->slug               = $category->slug;

//        $this->initAttribute($category->id);
        $this->dispatchBrowserEvent('openEditCategoryModal');
    }


    public function CategoryconfirmDelete($category_id)
    {
        $this->categoryIdBeingRemoved = $category_id;
        $this->dispatchBrowserEvent('show-delete-notification');
    }

    public function categoryDeleteCancel()
    {
        $this->categoryIdBeingRemoved = null;
    }

    public function categoryDelete()
    {
        if ($this->categoryIdBeingRemoved != null) {
            $category               = Category::findorFail($this->categoryIdBeingRemoved);
            $category->delete();
            $this->dispatchBrowserEvent('deleted', ['message'=>'Category deleted successfully']);

            return redirect()->back();
        }
    }

    public function search()
    {
        $this->hideOffCanvas();
        $this->resetPage();

        return $this->rows;
    }

    public function resetSearch()
    {
        $this->reset('filter');
        $this->hideOffCanvas();
    }
}
