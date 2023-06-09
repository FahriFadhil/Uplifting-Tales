@extends('layouts.app')

@section('content')
<div class="flex px-64 py-16 justify-between">

    <div class="w-7/12">
        <div class="flex border-b border-sky-700 w-full items-end gap-4 px-1 pb-2" style="overflow-x: scroll;" id="following_tags_bar">
            <a href="/home" class="text-sky-700 px-2 py-1 rounded transition whitespace-nowrap @unless(Request::has('query_tag')) bg-sky-50 @endif">For you</a>
            @foreach( $data_following_tags as $row )
            <form action="/home" method="get">
                <input type="hidden" name="query_tag" value="{{ $row->tag->body }}">
                <button type="submit" class="text-sky-700 px-2 py-1 rounded transition whitespace-nowrap @if(Request::query('query_tag') == $row->tag->body) bg-sky-50 @endif">{{ $row->tag->body }}</button>
            </form>
            @endforeach
        </div>

        <div class="flex flex-col">
            @foreach($data_story as $row)
            <div class="flex flex-col mt-12 pb-8 border-b">
                <div class="flex items-center gap-3">
                    @if( $row->user->pfp != null)
                    <div class="h-6 w-6 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{  $row->user->pfp }}')]"></div>
                    @else
                    <div class="h-6 w-6 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')]"></div>
                    @endif
                    <a href="/user/{{ $row->user->slug }}" class="text-sm font-semibold hover:underline">{{ $row->user->name }}</a>
                    <span>•</span>
                    <p class="text-xs opacity-50">{{ ($row->updated_at)->format('M d, Y') }}</p>
                </div>

                <a href="/story/{{ $row->slug }}" class="group">
                    <h2 class="group-hover:underline text-lg my-2 font-semibold leading-normal pe-8">{{ $row->title }}</h2>
                    <p class="text-sm pe-8">{!! implode(' ', array_slice(explode(' ', $row->body), 0, 40)) . (strlen($row->body) > 40 ? '...' : '') !!}</p>
                </a>

                <div class="flex items-end justify-between">
                    <div class="flex items-center gap-3 mt-5">
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs">{{ $row->readtime }}</span>
                        </div>
                        <span>•</span>
                        <div class="flex items-center gap-1">
                            <a href="/tag/{{ $row->tag->body }}" class="py-1 px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full text-xs">{{ $row->tag->body }}</a>
                        </div>
                    </div>

                    @if( $row->user_id == Auth::user()->id )
                    <a href="/story/edit/{{ $row->slug }}" class="flex items-center gap-2 py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 stroke-sky-700">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                        <span class="text-sm text-sky-700">Edit</span>
                    </a>
                    @else
                    <div class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-rose-500 hover:stroke-rose-500 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        @php
                        $isBookmarked = $data_story_bookmarked->contains('story_id', $row->id);
                        @endphp
                        <button onclick="toggleBookmark(dataset.storyId)" data-story-id="{{ $row->id }}" class="bookmark-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-orange-500 hover:stroke-orange-500 cursor-pointer {{ $isBookmarked ? 'fill-orange-500' : '' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                            </svg>
                        </button>
                    </div>
                    @endif


                </div>
            </div>
            @endforeach
            {{ $data_story->appends(request()->query())->links() }}

        </div>
    </div>

    <div class="w-4/12">
        <div class="sticky top-24">
            <h2 class="text-xl font-semibold mt-8">Random Story Selection</h2>

            <div class="flex-col">

                @foreach( $data_random_story as $row )
                <div class="flex flex-col pb-4 mt-8 border-b">
                    <div class="flex items-center gap-3">
                        @if( $row->user->pfp != null)
                        <div class="h-6 w-6 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{  $row->user->pfp }}')]"></div>
                        @else
                        <div class="h-6 w-6 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')]"></div>
                        @endif
                        <a href="/user/{{ $row->user->slug }}" class="text-sm font-semibold hover:underline">{{ $row->user->name }}</a>
                        <span>•</span>
                        <p class="text-xs opacity-50">{{ ($row->updated_at)->format('M d, Y') }}</p>
                    </div>

                    <a href="/story/{{ $row->slug }}" class="group">
                        <h2 class="group-hover:underline text-lg my-2 font-semibold leading-normal pe-8">{{ $row->title }}</h2>
                        <p class="text-sm pe-8">{!! implode(' ', array_slice(explode(' ', $row->body), 0, 16)) . (strlen($row->body) > 16 ? '...' : '') !!}</p>
                    </a>

                    <div class="flex items-end justify-between">
                        <div class="flex items-center gap-3 mt-5">
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs">{{ $row->readtime }}</span>
                            </div>
                            <span>•</span>
                            <div class="flex items-center gap-1">
                                <a href="/tag/{{ $row->tag->body }}" class="py-1 px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full text-xs">{{ $row->tag->body }}</a>
                            </div>
                        </div>

                        @if( $row->user_id == Auth::user()->id )
                        <a href="/story/edit/{{ $row->slug }}" class="flex items-center gap-2 py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 stroke-sky-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                            <span class="text-sm text-sky-700">Edit</span>
                        </a>
                        @else
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-rose-500 hover:stroke-rose-500 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            @php
                            $isBookmarked = $data_story_bookmarked->contains('story_id', $row->id);
                            @endphp
                            <button onclick="toggleBookmark(dataset.storyId)" data-story-id="{{ $row->id }}" class="bookmark-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-orange-500 hover:stroke-orange-500 cursor-pointer {{ $isBookmarked ? 'fill-orange-500' : '' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                </svg>
                            </button>
                        </div>
                        @endif

                    </div>
                </div>
                @endforeach

            </div>

            <h2 class="text-xl font-semibold mt-8">Random Tag Selection</h2>
            <div class="flex flex-wrap items-center gap-2 mt-4">
                @foreach($data_random_tag as $row)
                <a href="" class="py-[6px] px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full">{{ $row->body }}</a>
                @endforeach
            </div>

            <h2 class="text-xl font-semibold mt-8">Follow the Developer</h2>

            <div class="flex items-center justify-between shadow px-4 rounded-lg mt-2">
                <a href="/user/{{ $data_developer->slug }}" class="flex gap-4 items-center py-4 group">
                    @if( $data_developer->pfp != null)
                    <div class="h-8 w-8 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{  $data_developer->pfp }}')]"></div>
                    @else
                    <div class="h-8 w-8 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')]"></div>
                    @endif
                    <p class="text-lg group-hover:underline">{{ $data_developer->name }}</p>
                </a>
            </div>
        </div>
    </div>
    @endsection

    @section('style')
    <style>
        #following_tags_bar::-webkit-scrollbar {
            display: none;
        }
    </style>
    @endsection