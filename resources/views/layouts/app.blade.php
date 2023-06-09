<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <script src="{{ asset('js/tailwind.js') }}"></script>

    <!-- Quill Text Editor -->
    <!-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script> -->

    <!-- CK Editor Text Editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

    <!-- AXIOS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        ul.pagination {
            display: flex;
            align-items: center;
            min-width: 25vw;
            gap: .25rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
            font-size: 1.25rem;
        }

        ul.pagination .page-item {
            cursor: pointer;
            transition: .3s;
        }

        ul.pagination .page-item:first-child {
            margin-right: auto;
            padding: .25rem .95rem;
            border-radius: 100%;
            background-color: #f0f9ff;
        }

        ul.pagination .page-item:hover {
            background-color: #e0f2fe;
        }

        ul.pagination .page-item:last-child {
            margin-left: auto;
            padding: .25rem .95rem;
            border-radius: 100%;
            background-color: #f0f9ff;
        }

        ul.pagination .disabled {
            visibility: hidden;
        }

        ul.pagination .active {
            background-color: #e0f2fe;
        }

        ul.pagination .page-item:not(:first-child, :last-child) {
            border-radius: 100%;
            padding: .25rem .9rem;
        }
    </style>
    @yield('style')
</head>

<body>
    <div id="app">

        <nav class="border-b-2 border-sky-100 bg-sky-50 fixed top-0 w-full z-50">
            <div class="px-4 md:px-16 flex justify-between items-center">
                <div class="flex gap-8 items-end">

                    <a href="/home" class="text-xl md:text-2xl text-sky-700">Uplifting Tales</a>

                    @if( Request::path() != 'search' )
                    <a href="/search" class="flex items-center gap-2 py-1 px-2 rounded-full bg-slate-50 border border-sky-700 group pe-16 hover:opacity-100 opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-sky-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <span class="text-sm text-sky-700">Search…</span>
                    </a>
                    @endif

                </div>

                @auth
                <div class="flex gap-5 items-center">

                    @if( Request::path() != 'story/create' )
                    <a href="/story/create" class="group flex flex-col gap-1 items-center hover:opacity-100 opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-sky-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                        <span class="text-xs text-sky-700">Write</span>
                    </a>
                    @endif
                    @if( Request::path() != 'notification' )
                    <a href="/notification" class="group flex flex-col gap-1 items-center hover:opacity-100 opacity-75">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-sky-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <span class="text-xs text-sky-700">Notif</span>
                    </a>
                    @endif

                    <div class="h-8 w-px bg-sky-700 mx-2 opacity-50"></div>

                    <div class="flex items-center gap-2 transition group relative py-3">

                        @if(Auth::user()->pfp != null)
                        <div class="h-8 w-8 shadow me-2 rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{ Auth::user()->pfp }}')]"></div>
                        @else
                        <div class="h-8 w-8 shadow me-2 rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')]"></div>
                        @endif

                        <span class="text-sm text-sky-700 group-hover:opacity-100 opacity-75">{{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 stroke-sky-700 group-hover:opacity-100 opacity-75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>

                        <div class="hidden group-hover:block flex-col absolute top-14 right-[-40px] bg-sky-50 rounded-lg border border-sky-700 flex flex-col">
                            <a href="/user/{{ Auth::user()->slug }}" class="text-sm text-sky-700 flex items-center gap-3 py-2 px-5 hover:bg-sky-100 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span>Profile</span>
                            </a>
                            <a href="/user/bookmark/{{ Auth::user()->slug }}" class="text-sm text-sky-700 flex items-center gap-3 py-2 px-5 hover:bg-sky-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                </svg>
                                <span>Bookmark</span>
                            </a>
                            <!-- <a href="/user/settings" class="text-sm text-sky-700 flex items-center gap-3 py-2 px-5 hover:bg-sky-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <span>Settings</span>
                            </a> -->
                            <div class="h-px w-full bg-sky-700 opacity-50 my-1"></div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-sky-700 flex items-center gap-3 py-2 px-5 hover:bg-sky-100 rounded-b-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                <span>Logout</span>
                            </a>
                            <p class="text-xs text-sky-700 pb-2 pt-1 px-3">{{ Auth::user()->email }}</p>
                        </div>

                    </div>
                </div>
                @endauth
                @guest
                <div class="flex items-center gap-1 md:gap-2 py-3">
                    <a href="/login" class="px-4 py-2 text-sm border border-sky-700 bg-sky-700 text-slate-50 rounded-lg hover:bg-slate-50 hover:text-sky-700 transition">Masuk</a>
                    <a href="/register" class="px-4 py-2 text-sm border border-sky-700 text-sky-700 rounded-lg">Daftar</a>
                </div>
                @endguest

            </div>
        </nav>

        <div class="fixed-clear bg-sky-50" style="height: 56px;"></div>

        <main>
            @yield('content')
        </main>

        @auth
        @if( Auth::user()->authorization == 'admin' )
        <div class="py-2 px-4 bg-sky-50 fixed bottom-8 left-8 rounded-full hover:bg-sky-100">
            <p>You're the {{ ucwords(Auth::user()->authorization) }}</p>
        </div>
        @endif
        @endauth

        <!-- Alert Bookmarks -->

    </div>

    <script>
        function toggleBookmark(storyId) {
            axios.post('/bookmark/toggle/' + storyId)
                .then(function(response) {
                    const el = document.querySelectorAll(`.bookmark-btn[data-story-id="${ storyId }"]`);
                    el.forEach(el2 => {
                        el2.firstElementChild.classList.toggle('fill-orange-500')
                    })
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    </script>
    @yield('script')
</body>

</html>