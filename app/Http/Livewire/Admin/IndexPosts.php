<?php

namespace App\Http\Livewire\Admin;

use App\Helpers\CollectionHelper;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class IndexPosts extends Component
{
    use WithPagination, WithFileUploads;


    public $pageSize = 9;

    public $sortField = 'id';
    public $sortDirection = 'desc';

    //Advanced search
    public $showFilters = false;
    public $search = '';
    public $filters = [
        'category_id' => null,
        'created_at-min' => null,
        'created_at-max' => null,
        'published_at-min' => null,
        'published_at-max' => null,
        'status' => null,
    ];

    public $showEditModal = false;
    public $showDeleteModal = false;

    public Post $editing;
    public $upload = null;
    public $maxfilesize = 2048; //KB

    protected $queryString = [
        'sortField',
        'sortDirection',
        'search' => ['except' => ''],
        ];

    protected function rules()
    {
        return [
            'editing.user_id' => ['required', Rule::exists('users','id'), Rule::in( auth()->id() )],
            'editing.title' => 'required|max:255',
            'editing.slug' => ['required', 'max:255', Rule::unique('posts', 'slug')->ignore($this->editing)
                ->where(function (QueryBuilder $query) {
                    $query->where('user_id', auth()->id()); // A slug can be only usable once PER user.
                })],
            'editing.content' => 'required|max:10240',
            'editing.category_id' => 'required|exists:categories,id',
            'editing.published_at_for_editing' => ['sometimes', 'nullable'],
            'upload' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg,png', "max:{$this->maxfilesize}"],
        ];
    }

    /** Livecycle hooks */
    public function mount(){ $this->editing = $this->makeBlankPost(); }

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilters() { $this->resetPage(); }

    public function updatedEditingTitle($title)
    {
        // Memo: Use this package if you need better slug
        // https://github.com/cviebrock/eloquent-sluggable
        $this->editing->slug = Str::slug($title);
    }

    public function updatingEditingPublishedAtForEditing($date)
    {
        $this->withValidator(function (Validator $validator) use ($date) {
            $validator->after(function ($validator) use ($date) {
                try {
                    Carbon::parse($date);
                } catch (\Exception $e) {
                    $validator->errors()->add('editing.published_at_for_editing', 'Date cannot be parsed!');
                }
            });
        })->validate();
    }

    /** Custom Methods */
    protected function makeBlankPost()
    {
        return auth()->user()->posts()->make();
    }

    public function resetFilters() { $this->reset('filters'); }

    protected function resetUploadInputs(): void {
        $this->reset('upload');
        $this->dispatchBrowserEvent('pond-reset');
    }

    public function orderByColumn($filed)
    {
        if ($this->sortField == $filed) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $filed;
    }

    public function sortBy($filed) {
        return $this->orderByColumn($filed);
    }

    public function create()
    {
        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankPost();

            $this->resetErrorBag();
            $this->resetUploadInputs();
        }

        $this->showEditModal = true;
    }

    public function edit($id)
    {
        $post = auth()->user()->posts()->withTrashed()->find($id);

        if ( is_null($post) ) { return(false); } //fail gracefully

        if ($this->editing->isNot($post)) {
            $this->editing = $post;

            $this->resetErrorBag();
            $this->resetUploadInputs();
        }

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [];

        if ( !empty($this->upload)) {
            $id = $this->editing->getKey() ? $this->editing->id : (Post::latest()->first()?->id+1);

            $slug = substr($this->editing->slug,0,16);

            $filename = sprintf("%s-%s.%s", $id, $slug, $this->upload->extension()); //1-foobar.jpg

            $this->upload->storeAs("{$this->editing->user_id}",$filename,'thumbnails');

            $data['thumbnail'] = $filename;
        }

        $this->editing->fill($data)->save();

        $this->showEditModal = false;

        $this->dispatchBrowserEvent('pond-reset');
        $this->dispatchBrowserEvent('notify', 'Changes saved!');
    }

    public function delete()
    {
        $this->editing->delete();

        $this->showDeleteModal = false;
        $this->showEditModal = false;

        $this->dispatchBrowserEvent('notify', 'Post deleted!');
    }

    public function restore()
    {
        $this->editing->restore();

        $this->showEditModal = false;

        $this->dispatchBrowserEvent('notify', 'Post restored!');
    }

    public function render()
    {

        $posts = auth()->user()->posts()
            // categories name
            ->when(str_contains($this->sortField,'categories.'), function (EloquentBuilder $query) {
                $query->join('categories','posts.category_id', '=', 'categories.id');
            })
            //order by
            ->when($this->sortField !== 'status', function (EloquentBuilder $query){
                $query->orderBy($this->sortField, $this->sortDirection);
            })
            //Search
            ->when($this->search, function (EloquentBuilder $query, $title){
                $query->where('title','like','%'.$title.'%');
            })
            //Advanced search
                //category
            ->when($this->filters['category_id'], function (EloquentBuilder $query, $category){
                $query->where('category_id',$category);
            })
                //created at
            ->when($this->filters['created_at-min'], function (EloquentBuilder $query, $date){
                $query->where('created_at','>=', Carbon::parse($date)->startOfDay());
            })
            ->when($this->filters['created_at-max'], function (EloquentBuilder $query, $date){
                $query->where('created_at','<', Carbon::parse($date)->endOfDay());
            })
                //published at
            ->when($this->filters['published_at-min'], function (EloquentBuilder $query, $date){
                $query->where('published_at','>=', Carbon::parse($date)->startOfDay());
            })
            ->when($this->filters['published_at-max'], function (EloquentBuilder $query, $date){
                $query->where('published_at','<', Carbon::parse($date)->endOfDay());
            })
            ->withTrashed()
            ->get()
            ->when($this->filters['status'], function ( \Illuminate\Support\Collection $c, $status) {
                return $c->filter(function ($item) use ($status){
                    return $item->status == $status;
                });
            })
            //sort by
            ->when($this->sortField == 'status', function ( \Illuminate\Support\Collection $c) {
                return $c->sortBy($this->sortField, descending:(bool)($this->sortDirection == 'desc'));
            });




        // Manual Pagination
        // https://sam-ngu.medium.com/laravel-how-to-paginate-collection-8cb4b281bc55
        $paginatedPosts = CollectionHelper::paginate($posts, $this->pageSize);

        return view('livewire.admin.index-posts',[
            'posts' => $paginatedPosts
        ]);
    }

}
