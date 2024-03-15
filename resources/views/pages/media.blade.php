<x-app-layout>
    <x-slot name="header">
        <div class="media">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Media') }}
            </h2>

            <button id="btn-media-show-add" class="add-media inline-block px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + add
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">

                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Search media') }}
                            </h2>
                        </header>
                        <form method="POST" action="{{ route('media.index') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('GET')

                            <div>
                                <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <x-primary-button>{{ __('search') }}</x-primary-button>
                            <a href="{{ route('media.index') }}" class="inline-block px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                Show all
                            </a>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

{{--    <div id="media-add-form" class="py-12" style="display: none;">--}}
    <div id="media-add-form" class="py-12 media-add hidden-block">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">

                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Upload image') }}
                            </h2>
                        </header>

                        <form method="POST" action="{{ route('media.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('POST')

                            <div>
                                <x-input-label for="image" :value="__('Please select the images')" />
                                <input id="image" name="image" type="file" accept="image/png, image/jpeg, image/jpg" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('files')" />

                                <input type="hidden" name="folder" value="{{ $currentFolder }}">
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('upload') }}</x-primary-button>

                                <button id="btn-media-cancel" class="inline-block px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                    cancel
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('upload.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @if ($medias->count() > 0)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="media-list">

                            <div class="media-item folder">
                                <a href="{{ route('media.index') }}?folder={{$subFolder}}">
                                <div class="media-file">
                                    <svg height="64" viewBox="0 0 512 512" width="64" xmlns="http://www.w3.org/2000/svg"><title/><polyline points="112 160 48 224 112 288" style="fill:none;stroke:#000;stroke-linecap:square;stroke-miterlimit:10;stroke-width:32px"/><polyline points="64 224 464 224 464 352" style="fill:none;stroke:#000;stroke-linecap:square;stroke-miterlimit:10;stroke-width:32px"/></svg>
                                </div>
                                <div class="media-name">
                                    <span>return</span>
                                </div>
                                </a>
                            </div>

                            @foreach($medias as $media)
                                @if ($media['type'] == 'folder')
                                    <div class="media-item folder">
                                        <a href="{{ route('media.index') }}?folder={{$currentFolderPath}}{{ $media['name'] }}">
                                        <div class="media-file">
                                                <svg height="60.001px" id="Layer_1" style="enable-background:new 0 0 64 60.001;" version="1.1" viewBox="0 0 64 60.001" width="64px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Folder"><g><path d="M60,4.001H24C24,1.792,22.209,0,20,0H4    C1.791,0,0,1.792,0,4.001V8v6.001v2c0,2.209,1.791,4,4,4h56c2.209,0,4-1.791,4-4V8C64,5.791,62.209,4.001,60,4.001z" style="fill-rule:evenodd;clip-rule:evenodd;fill:#CCA352;"/></g></g><g id="File_1_"><g><path d="M56,8H8c-2.209,0-4,1.791-4,4.001v4c0,2.209,1.791,4,4,4h48c2.209,0,4-1.791,4-4v-4    C60,9.791,58.209,8,56,8z" style="fill:#FFFFFF;"/></g></g><g id="Folder_1_"><g><path d="M60,12.001H4c-2.209,0-4,1.791-4,4v40c0,2.209,1.791,4,4,4h56c2.209,0,4-1.791,4-4v-40    C64,13.792,62.209,12.001,60,12.001z" style="fill:#FFCC66;"/></g></g><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/></svg>
                                        </div>
                                        <div class="media-name">
                                            <span>{{ $media['name'] }}</span>
                                        </div>
                                        </a>
                                    </div>
                                @endif
                                @if ($media['type'] == 'file')
                                    <div class="media-item">
                                        <div class="media-file">
                                            <img alt="{{ $media['name'] }}" src="{{ $media['url'] }}" />
                                        </div>
                                        <div class="media-name">
                                            <span>{{ $media['name'] }}</span>
                                        </div>
                                        <div class="media-delete">
                                            @php
                                                $media['fileFolder'] = false;
                                                $media['fileFolder'] = str_replace(env('CDN_API_URL') . 'file/test/', '', $media['url']);
                                                $media['fileFolder'] = str_replace('/' . $media['name'], '', $media['fileFolder']);
                                                $media['fileFolder'] = str_replace($media['name'], '', $media['fileFolder']);
                                            @endphp

                                            <a href="{{ route('media.destroy') }}?fileName={{ $media['name'] }}&folder={{ $media['fileFolder'] }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">delete</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
