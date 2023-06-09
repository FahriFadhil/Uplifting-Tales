@extends('layouts.app')

@section('content')

<div class="px-64 py-16 flex flex-col">
  <div class="flex items-start gap-4 mb-4">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 p-2 rounded-full bg-sky-50">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
    </svg>
    <h1 class="text-4xl">Tag {{ $data_tag->body }}</h1>
  </div>

  <div class="flex items-center gap-4">

    @if( $data_tag_followed == false )
    <form action="/tag/add" method="POST" class="block mt-2">
      @csrf
      <input type="hidden" name="tag_id" value="{{ $data_tag->id }}">
      <button type="submit" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 transition rounded-full shadow">Follow Tag</button>
    </form>
    @else
    <form action="/tag/remove/{{ $data_tag->id }}" method="POST" class="block mt-2">
      @csrf
      {{ method_field('DELETE') }}
      <button type="submit" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 transition rounded-full shadow">Unfollow Tag</button>
    </form>
    @endif
    @if( Auth::user()->authorization == 'admin' )
    <form action="/tag/destroy/{{ $data_tag->id }}" method="post" class="block mt-2">
      @csrf
      {{ method_field('DELETE') }}
      <button type="submit" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 transition rounded-full shadow text-red-500">Destroy Tag</button>
    </form>
    @endif
  </div>



  @if( $data_story->count() == 0 )

  <div class="flex flex-col items-center gap-1 mt-8">
    <h2 class="text-lg">Sorry, there is no data for the tag "{{ $data_tag->body }}" yet</h2>
    <p class="text-sm text-sky-700">Let's make a story with this theme!</p>
  </div>

  @else
  <div class="grid grid-cols-2 gap-x-12">
    @foreach($data_story as $row)
    <div class="flex flex-col mt-12 pb-8 border-b">
      <div class="flex items-center gap-3">
        <img class="w-6 h-6 rounded-full shadow" src="https://source.unsplash.com/80x80?profile" alt="...">
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
            <a href="" class="py-1 px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full text-xs">{{ $row->tag->body }}</a>
          </div>
        </div>
        @if( $row->user_id == Auth::user()->id )
        <a href="" class="flex items-center gap-2 py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full">
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
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-orange-500 hover:stroke-orange-500 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
          </svg>
        </div>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  @endif

</div>

@endsection