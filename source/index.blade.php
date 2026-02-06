@extends('_layouts.main')

@section('body')
    @foreach ($posts->where('date', true)->take(1) as $featuredPost)
        <div class="relative group grid grid-cols-1 lg:grid-cols-12 gap-0 mb-6 overflow-hidden bg-base-50 rounded-2xl shadow-md">

            {{-- Image Side --}}
            <div class="lg:col-span-7 h-64 lg:h-[450px] overflow-hidden">
                <img src="{{ $featuredPost->cover_image }}"
                     alt="{{ $featuredPost->cover_alt }}"
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
            </div>

            {{-- Content Side --}}
            <div class="lg:col-span-5 p-8 lg:p-12 flex flex-col justify-center">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-muted text-sm">
                    {{ $featuredPost->getDate()->format('M j, Y') }}
                </span>
                </div>

                <a href="{{ $featuredPost->getUrl() }}" class="group/link">
                    <h2 class="text-3xl lg:text-4xl font-black text-base-content leading-tight mb-4 transition-colors">
                        {{ $featuredPost->title }}
                    </h2>
                    <div class="text-muted line-clamp-3 mb-6 leading-relaxed">
                        {!! $featuredPost->getExcerpt() !!}
                    </div>
                </a>

                <div class="mt-auto">
                    <a href="{{ $featuredPost->getUrl() }}"
                       class="inline-flex items-center gap-2 transition-colors">
                        Read More &RightArrow;
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    <div class="grid md:grid-cols-2 gap-6">
    @foreach ($posts->where('date', true)->skip(1) as $post)
            @include('_components.post-preview-inline')
    @endforeach
    </div>
@stop
