@extends('_layouts.master')

@section('body')
    @foreach ($posts->where('date', true)->take(1) as $featuredPost)
        <div class="bg-white rounded-2xl shadow-md mb-6 overflow-hidden">
            <img src="{{ $featuredPost->cover_image }}" alt="{{ $featuredPost->cover_alt }}"
                 class="w-full h-64 object-cover"/>
            <div class="p-6">
                <p class="text-sm text-gray-500 mb-1">{{ $featuredPost->getDate()->format('F j, Y') }}</p>
                <a href="{{ $featuredPost->getUrl() }}">
                    <h1 class="text-3xl font-bold mb-2">{{ $featuredPost->title }}</h1>
                    <p class="mb-4 text-gray-600">{!! $featuredPost->getExcerpt() !!}</p>
                </a>
                <a href="{{ $featuredPost->getUrl() }}" class="text-blue-600 font-semibold hover:underline">Read More →</a>
            </div>
        </div>
    @endforeach
    <div class="grid md:grid-cols-2 gap-6">
    @foreach ($posts->where('date', true)->skip(1) as $post)
            @include('_components.post-preview-inline')
    @endforeach
    </div>
@stop
