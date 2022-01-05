<div>
    <x-slot name="header">{{ __('My Posts') }}</x-slot>

    <div class="space-y-4">
        <div>
            <div class="space-y-2">
                <header class="space-y-2">
                    <!-- top line -->
                    <div class="flex justify-between">
                        <!-- search title -->
                        <div class="w-1/4 flex items-center space-x-2">
                            <x-label for="filter-search" > <x-icon.search /> </x-label>

                            <x-input
                                wire:model="search"
                                type="text"
                                placeholder="Search title..."
                                id="filter-search"
                            />
                            <!-- dirty trick to load x-input.date javascript before Alpine.js initialize to avoid errors -->
                            <div style="display: none"><x-input.date /></div>
                        </div>
                        <!-- + New button -->
                        <div>
                            <x-button.primary type="button" wire:click="create">
                                <x-icon.plus /> New
                            </x-button.primary>
                        </div>
                    </div>

                    <!-- search -->
                    <div class="px-2">
                        <x-button.link wire:click="$toggle('showFilters')" class="font-bold">
                            {{ $showFilters ? 'Hide':'' }} Advanced Search...
                        </x-button.link>
                    </div>

                    <!-- advanced search -->
                    <div>
                        @if ($showFilters)
                            <div class="bg-slate-200 p-4 rounded shadow-inner sm:flex">
                                <!-- left side -->
                                <div class="sm:w-1/2 pr-2 space-y-4">
                                    <!-- category_id -->
                                    <div>
                                        <x-label for="filter-category_id" :value="__('Category')"/>

                                        <x-input.select wire:model="filters.category_id" id="filter-category_id" class="block my-1 w-full">
                                            @foreach (App\Models\Category::getSelectDropDownFilterOptions() as $key => $label)
                                                <option value="{{ $key }}" wire:key="{{ $loop->index }}f">
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </x-input.select>
                                    </div>

                                    <!-- status -->
                                    <div>
                                        <x-label for="filter-status" :value="__('Status')"/>

                                        <x-input.select wire:model="filters.status" id="filter-status" class="block my-1 w-full">
                                            @foreach (App\Helpers\Status::getSelectDropDownFilterOptions() as $key => $label)
                                                <option value="{{ $key }}" wire:key="{{ $loop->index }}s">
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </x-input.select>
                                    </div>
                                </div>

                                <!-- right side -->
                                <div class="sm:w-1/2 pr-2 space-y-4">
                                    <!-- Minimum Created at -->
                                    <div>
                                        <x-label for="filter-cr-min" :value="__('Minimum Created at')"/>

                                        <x-input.date wire:model="filters.created_at-min" id="filter-cr-min" placeholder="yyyy-mm-dd" />
                                    </div>

                                    <!-- Maximum Created at -->
                                    <div>
                                        <x-label for="filter-cr-max" :value="__('Maximum Created at')"/>

                                        <x-input.date wire:model="filters.created_at-max" id="filter-cr-max" placeholder="yyyy-mm-dd" />
                                    </div>

                                    <div class="border-b-2 border-gray-500"></div>

                                    <!-- Minimum Published at -->
                                    <div>
                                        <x-label for="filter-pb-min" :value="__('Minimum Published at')"/>

                                        <x-input.date wire:model="filters.published_at-min" id="filter-pb-min" placeholder="yyyy-mm-dd" />
                                    </div>

                                    <!-- Maximum Published at -->
                                    <div>
                                        <x-label for="filter-pb-max" :value="__('Maximum Published at')"/>

                                        <x-input.date wire:model="filters.published_at-max" id="filter-pb-max" placeholder="yyyy-mm-dd" />
                                    </div>

                                    <!-- resetFilters button -->
                                    <div class="text-right">
                                        <x-button.link wire:click="resetFilters" class="font-bold">Reset Filters</x-button.link>
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>
                </header>


                <!-- Posts table -->
                <div
                    wire:loading.class.delay="opacity-50"
                    class="flex flex-col space-y-4"
                >
                    <x-table>
                        <x-slot name="head">
                            <x-table.heading sortable wire:click="orderByColumn('id')" :direction="$sortField == 'id' ? $sortDirection : null">id</x-table.heading>
                            <x-table.heading sortable wire:click="orderByColumn('title')" :direction="$sortField == 'title' ? $sortDirection : null" class="w-full">Title</x-table.heading>
                            <x-table.heading sortable wire:click="orderByColumn('categories.name')" :direction="$sortField == 'categories.name' ? $sortDirection : null">Category</x-table.heading>
                            <x-table.heading sortable wire:click="sortBy('status')" :direction="$sortField == 'status' ? $sortDirection : null">Status</x-table.heading>
                            <x-table.heading sortable wire:click="orderByColumn('created_at')" :direction="$sortField == 'created_at' ? $sortDirection : null">Created at</x-table.heading>
                            <x-table.heading sortable wire:click="orderByColumn('published_at')" :direction="$sortField == 'published_at' ? $sortDirection : null">published at</x-table.heading>
                            <x-table.heading>Actions</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            @forelse($posts as $post)
                                <x-table.row>
                                    <!-- id -->
                                    <x-table.cell>
                                        <span>{{ $post->id }}</span>
                                    </x-table.cell>

                                    <!-- title -->
                                    <x-table.cell>
                                        <span>{{ $post->title }}</span>
                                    </x-table.cell>

                                    <!-- category -->
                                    <x-table.cell>
                                        <span>{{ $post->category->name }}</span>
                                    </x-table.cell>

                                    <!-- status -->
                                    <x-table.cell>
                                        <x-status-laber :status="$post->status" />
                                    </x-table.cell>

                                    <!-- created_at -->
                                    <x-table.cell class="text-xs">
                                        <span>{{ $post->created_at }}</span>
                                    </x-table.cell>

                                    <!-- published_at -->
                                    <x-table.cell class="text-xs">
                                        <span>{{ $post->published_at_for_display }}</span>
                                    </x-table.cell>

                                    <!-- actions -->
                                    <x-table.cell class="text-xs">
                                        <x-button.link wire:click="edit({{ $post->id }})">Edit</x-button.link>
                                    </x-table.cell>
                                </x-table.row>
                            @empty
                                <x-table.row>
                                    <x-table.cell colspan="6">
                                        <div class="flex justify-center items-center space-x-1">
                                            <x-icon.inbox class="h-7 w-7 text-gray-500" />
                                            <span class="font-bold py-4 text-gray-500 text-xl"> No posts found...</span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>

                            @endforelse
                        </x-slot>
                    </x-table>

                    <div>{{ $posts->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ---------------------------------------------- MODALS -------------------------------------------------- -->

    <!-- Save Post Modal -->
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model="showEditModal" max-width="3xl">
            <x-slot name="title">
                {{ !$this->editing->getKey() ? 'Create Post' : 'Edit Post' }}
            </x-slot>
            <x-slot name="content">
                <x-error error="editing.user_id"/>

                <!-- title -->
                <div>
                    <x-label for="title" :value="__('Title')"/>

                    <x-input wire:model.lazy="editing.title" id="title" class="block my-1 w-full" type="text"/>

                    <x-error error="editing.title"/>
                </div>

                <!-- slug -->
                <div>
                    <x-label for="slug" :value="__('Slug')"/>

                    <x-input wire:model.defer="editing.slug" id="slug" class="block my-1 w-full" type="text"/>

                    <x-error error="editing.slug"/>
                </div>

                <!-- thumbnail -->
                <div>
                    <x-label for="upload" :value="__('Thumbnail (3:2)')"/>

                    <div class="mt-1 sm:flex sm:space-x-6">
                    <!--
                    Memo:
                    Solved: Facade\Ignition\Exceptions\ViewException : This driver does not support creating temporary URLs.
                    Use "$upload?->isPreviewable()" with if statement in blade views, or the file tests will fail with the message above. Only images has temporaryUrl() methods, which means only images is reviewable.
                    -->
                        <div>
                            <img class="h-28 p-1.5 border border-2 border-gray-300 rounded-lg hover:shadow-md hover:shadow-blue-600/75"
                                 src="{{ $upload?->isPreviewable() ? $upload->temporaryUrl() : $editing->thumbnail_url }}"
                                 alt="thumbnail"
                            >
                        </div>

                        <div class="flex-1">
                            <x-filepond
                                wire:model="upload"
                                acceptedFileTypes="['image/jpeg','image/jpg','image/png']"
                                maxfilesize="{{$maxfilesize*4}}"
                                allowImagePreview
                                imageResizeTargetWidth="720"
                                imageCropAspectRatio="'3:2'"
                            />
                        </div>
                    </div>

                    <x-error error="upload"/>
                </div>

                <!-- content -->
                <div>
                    <x-label for="content" :value="__('Content')"/>

                    <x-input.rich-text wire:model.defer="editing.content" id="about" />

                    <x-error error="editing.content"/>
                </div>

                <!-- category_id -->
                <div>
                    <x-label for="category_id" :value="__('Category')"/>

                    <x-input.select wire:model.defer="editing.category_id" id="category_id" class="block my-1 w-full">
                        @foreach (App\Models\Category::getSelectDropDownOptions() as $key => $label)
                            <option value="{{ $key }}" wire:key="{{ $loop->index }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </x-input.select>

                    <x-error error="editing.category_id"/>
                </div>

                <!-- published_at -->
                <div>
                    <x-label for="published_at" :value="__('Published at')" />

                    <x-input wire:model.lazy="editing.published_at_for_editing"
                             id="published_at"
                             type="text"
                             class="block my-1 w-full"
                             placeholder="yyyy-mm-dd hh:mm:ss"
                    />

                    <x-error error="editing.published_at_for_editing" />
                </div>
            </x-slot>

            <x-slot name="footer">

                <div class="w-full flex justify-between">
                    <div>
                        @if ($this->editing->getKey())
                            @if (!$this->editing->deleted_at)
                                <x-button.danger wire:click="$set('showDeleteModal', true)">Delete</x-button.danger>
                            @else
                                <x-button.secondary wire:click="restore">Restore</x-button.secondary>
                            @endif
                        @endif
                    </div>

                    <div>
                        <x-button.secondary wire:click="$set('showEditModal', false)">Cancel</x-button.secondary>

                        <x-button.primary>Save</x-button.primary>

                    </div>
                </div>

            </x-slot>
        </x-modal.dialog>
    </form>

    <!-- Delete Transactions Modal -->
    <form wire:submit.prevent="delete">
        <x-modal.confirmation wire:model.defer="showDeleteModal">
            <x-slot name="title">Delete Post</x-slot>

            <x-slot name="content">
                <div class="py-2 text-gray-700">
                    <p>Are you sure you?</p>
                    <p>This action will archive the post. You can restore it any time.</p>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showDeleteModal', false)">Cancel</x-button.secondary>

                <x-button.danger type="submit">Delete</x-button.danger>
            </x-slot>
        </x-modal.confirmation>
    </form>

</div>
