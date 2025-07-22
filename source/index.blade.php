@extends('_layouts.main')

@section('body')
    @foreach ($posts->where('date', true)->take(1) as $featuredPost)
        <div class="bg-bg-main rounded-2xl shadow-md mb-6 overflow-hidden">
            <img src="{{ $featuredPost->cover_image }}" alt="{{ $featuredPost->cover_alt }}"
                 class="w-full h-64 object-cover"/>
            <div class="p-6">
                <p class="text-sm text-text mb-1">{{ $featuredPost->getDate()->format('F j, Y') }}</p>
                <a href="{{ $featuredPost->getUrl() }}">
                    <h2 class="text-3xl font-bold mb-2">{{ $featuredPost->title }}</h2>
                    <p class="mb-4 text-text">{!! $featuredPost->getExcerpt() !!}</p>
                </a>
                <a href="{{ $featuredPost->getUrl() }}" class="text-link font-semibold hover:underline">Read More →</a>
            </div>
        </div>
    @endforeach
    <div class="grid md:grid-cols-2 gap-6">
    @foreach ($posts->where('date', true)->skip(1) as $post)
            @include('_components.post-preview-inline')
    @endforeach
    </div>
@stop
