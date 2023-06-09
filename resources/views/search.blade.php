@extends('layouts.app')

@section('content')

<div class="px-64 py-16 flex flex-col items-center">
  <h1 class="text-4xl font-semibold">Telusuri Cerita</h1>
  <form action="/search" method="get" class="my-6 w-6/12">
    <input name="query_search" value="{{ Request::get('query_search') }}" class="py-3 px-6 bg-sky-50 rounded-full shadow focus:outline outline-sky-700 w-full active:bg-sky-100 transition" type="text" placeholder="Anak Sukses berkat Ibu yang Hebat…">
  </form>

  @if( $data_story == false )

  <div class="flex items-center gap-2 border-b pb-16">
    <h2>Random Suggestion :</h2>
    <div class="flex items-center gap-1">
      @foreach($data_random_tag as $row)
      <a href="/tag/{{ $row->body }}" class="py-[6px] px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full">{{ $row->body }}</a>
      @endforeach
    </div>
  </div>

  <h2 class="text-2xl font-semibold mt-8">Browse All Tags</h2>
  <div class="flex flex-wrap justify-center gap-3 w-8/12 mt-4">
    @foreach($data_tag as $row)
    <a href="/tag/{{ $row->body }}" class="py-[6px] px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full">{{ $row->body }}</a>
    @endforeach
  </div>

  <div class="fixed bottom-12 left-0 right-0 flex justify-center">
    @if( Auth::user()->authorization != 'admin' )
    <a href="" class="py-4 px-8 rounded-full bg-sky-100/50 hover:bg-sky-100 transition">Have Additional Tag Suggestions? Give Suggestions Here!</a>
    @else
    <form action="/tag/store" method="post" class="flex gap-4 items-center bg-sky-100/50 py-3 px-6 rounded-full">
      @csrf
      <input type="text" name="body" class="py-2 px-4 rounded-lg outline-none w-64" placeholder="Add New Tag…">
      <button type="submit" class="p-2 border hover:shadow rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
      </button>
    </form>
    @endif
  </div>

  @elseif( $data_story->count() == 0 )

  <div class="flex flex-col items-center gap-1 mt-8">
    <h2 class="text-lg">Sorry, results for "{{ Request::get('query search') }}" were not found</h2>
    <p class="text-sm text-sky-700">Try searching with other keywords!</p>
  </div>

  @else

  <div class="grid grid-cols-2 gap-x-12">
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
        <p class="text-sm pe-8">{!! implode(' ', array_slice(explode(' ', $row->body), 0, 30)) . (strlen($row->body) > 30 ? '...' : '') !!}</p>
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
            <a href="tag/{{ $row->tag->body }}" class="py-1 px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full text-xs">{{ $row->tag->body }}</a>
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
  {{ $data_story->appends(request()->query())->links() }}

  @endif

</div>


@endsection