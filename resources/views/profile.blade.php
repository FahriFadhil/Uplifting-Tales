@extends('layouts.app')

@section('content')
<div class="flex px-64 py-16 justify-between">
  <div class="w-4/12">
    <div class="flex flex-col items-start sticky top-24">
      @if($data_user->pfp != null)
      <div class="h-36 w-36 rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{ $data_user->pfp }}')]"></div>
      @else
      <div class="h-36 w-36 rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')]"></div>
      @endif
      <h1 class="mt-4 text-2xl">{{ $data_user->name }}</h1>
      <p class="mt-1 text-xl text-slate-500">{{ $data_user->email }}</p>
      <div class="flex items-center gap-4 mt-4 text-sm">
        <p>
          {{ $data_follower }} Follower
        </p>
        <div class="h-4 w-px bg-slate-800"></div>
        <p>
          {{ $data_following }} Following
        </p>
      </div>
      <p class="my-8 pe-8 opacity-75 text-sm">@if($data_user->bio == null) This user hasn't add their Bio yet. @else {{ $data_user->bio }} @endif</p>

      <div class="flex items-center gap-4">
        @if( $data_user->id != Auth::user()->id )
        @if( $data_user_followed == false )
        <form action="/follow/add" method="post">
          @csrf
          <input type="hidden" name="user_id" value="{{ $data_user->id }}">
          <button type="submit" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full transition inline">Follow</button>
        </form>
        @else
        <form action="/follow/remove/{{ $data_user->id }}" method="post">
          @csrf
          {{ method_field('DELETE') }}
          <button type="submit" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full transition inline">Unfollow</button>
        </form>
        @endif
        @else
        <div onclick="showModalEdit(dataset.id)" data-id="{{ $data_user->id }}" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full transition inline cursor-pointer">Edit Profile</div>
        @endif
        @if( Auth::user()->authorization == 'admin' )
        <form action="/user/destroy/{{ $data_user->id }}" method="post">
          @csrf
          {{ method_field('DELETE') }}
          <button type="submit" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full transition inline text-red-500">Delete Account</button>
        </form>
        @endif
      </div>
    </div>
  </div>
  <div class="w-7/12">
    @if($data_user_story->count() == 0)
    <div class="flex flex-col items-center gap-1 mt-8">
      <h2 class="text-lg">Sorry, this user haven't made any story yet.</h2>
    </div>
    @else
    <h2 class="text-4xl font-semibold">{{ $data_user->name }} Stories</h2>
    <div class="flex flex-col">
      @foreach($data_user_story as $row)
      <div class="flex flex-col mt-8 pb-8 border-b">

        <a href="/story/{{ $row->slug }}" class="group">
          <div class="flex items-center gap-4">
            <h2 class="group-hover:underline text-lg my-2 font-semibold leading-normal">{{ $row->title }}</h2>
            <span>•</span>
            <p class="text-xs opacity-50">{{ ($row->updated_at)->format('M d, Y') }}</p>
          </div>
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
      {{ $data_user_story->appends(request()->query())->links() }}
    </div>
    @endif
  </div>
</div>

@if( $data_user->id == Auth::user()->id )
<div id="modalEdit" class="hidden flex items-center justify-center fixed top-0 bottom-0 left-0 right-0 bg-slate-700/75 z-[100]">
  <form action="/user/update/{{ $data_user->id }}" method="post" enctype="multipart/form-data" class="w-full flex flex-col justify-center items-center max-w-prose py-8 px-16 bg-sky-50 shadow rounded-[1rem] shadow-lg">
    @csrf
    {{ method_field('PUT') }}
    <h1 class="text-2xl font-semibold mb-4"> Edit Profile </h1>
    <div class="relative group w-48 h-48 shadow-lg rounded-full mb-4">
      <div class="flex gap-2 absolute top-0 bottom-0 left-0 right-0 rounded-full justify-center items-center bg-slate-700/50 text-slate-200 group-hover:visible invisible transition z-[115] cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
        </svg>
      </div>
      @if($data_user->pfp != null)
      <div id="imagePreview" class="absolute top-0 bottom-0 left-0 right-0 rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{ $data_user->pfp }}')] z-[110] cursor-pointer"></div>
      @else
      <div id="imagePreview" class="absolute top-0 bottom-0 left-0 right-0 rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')] z-[110] cursor-pointer"></div>
      @endif
      <input id="image-input" name="pfp" type="file" class="absolute top-0 bottom-0 left-0 right-0 rounded-full opacity-0 cursor-pointer z-[120] ">
    </div>
    <input type="text" required name="name" class="w-full py-2 px-4 rounded-lg mt-4 outline-none focus:shadow" value="{{ $data_user->name }}" placeholder="Your Username">
    <textarea required name="bio" class="resize-none w-full py-2 px-4 rounded-lg mt-4 outline-none focus:shadow" placeholder="Add Your Bio…">{{ $data_user->bio }}</textarea>
    <div class="flex gap-4 justify-end mt-4">
      <div class="text-red-500 py-2 px-4 bg-white hover:bg-red-500 hover:text-white rounded-lg transition cursor-pointer" id="modalCloseBtn">
        Discard Changes
      </div>
      <button class="text-green-500 py-2 px-4 bg-white hover:bg-green-500 hover:text-white rounded-lg transition" type="submit">
        Update Profile
      </button>
    </div>
  </form>
</div>
@endif

@endsection

@section('script')
<script>
  function showModalEdit(id) {
    const modal = document.getElementById('modalEdit');
    modal.classList.remove('hidden');
    document.getElementById('modalCloseBtn').addEventListener('click', () => {
      modal.classList.add('hidden');
    })

  }
  document.getElementById('image-input').addEventListener('change', (ev) => {
    let reader = new FileReader()
    reader.readAsDataURL(ev.target.files[0])
    reader.onload = () => {
      document.getElementById('imagePreview').classList.add(`bg-[url('${reader.result}')]`)
    }
  })
</script>
@endsection