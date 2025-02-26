@extends('_layouts.master')

@section('body')
    @foreach ($posts->where('date', true)->take(1) as $featuredPost)
        <div class="w-full mb-6">

            @if ($featuredPost->cover_image)
                <div class="relative pb-2/6">
                    <img
                            src="{{ $featuredPost->cover_image }}"
                            alt="{{ $featuredPost->cover_alt }}"
                            class="absolute h-full w-full object-cover rounded-2xl"
                    >
                </div>
            @endif

            <date class="text-gray-700 font-medium my-2">
                {{ $featuredPost->getDate()->format('F j, Y') }}
            </date>

            <h2 class="text-3xl mt-0">
                <a
                        href="{{ $featuredPost->getUrl() }}"
                        title="Read {{ $featuredPost->title }}"
                        class="text-gray-900 font-extrabold"
                >
                    {{ $featuredPost->title }}
                </a>
            </h2>

            <p class="mt-0 mb-4">{!! $featuredPost->getExcerpt() !!}</p>

            <a href="{{ $featuredPost->getUrl() }}"
               title="Read - {{ $featuredPost->title }}"
               class="uppercase tracking-wide mb-4"
            >
                Read
            </a>
        </div>

        <hr class="border-b my-6">
    @endforeach

    @foreach ($posts->where('date', true)->skip(1)->chunk(2) as $row)
        <div class="flex flex-col md:flex-row md:-mx-6">
            @foreach ($row as $post)
                <div class="w-full md:w-1/2 md:mx-6">
                    @include('_components.post-preview-inline')
                </div>

                @if (! $loop->last)
                    <hr class="block md:hidden w-full border-b mt-2 mb-6">
                @endif
            @endforeach
        </div>

        @if (! $loop->last )
            <hr class="w-full border-b mt-2 mb-6">
        @endif
    @endforeach
@stop
