@extends('_layouts.main')

@section('body')
    @foreach ($posts->where('date', true)->take(1) as $featuredPost)
        <div class="relative group grid grid-cols-1 lg:grid-cols-12 gap-0 mb-6 overflow-hidden rounded-3xl bg-base border border-slate-100">

            {{-- Image Side --}}
            <div class="lg:col-span-7 h-64 lg:h-[450px] overflow-hidden">
                <img src="{{ $featuredPost->cover_image }}"
                     alt="{{ $featuredPost->cover_alt }}"
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
            </div>

            {{-- Content Side --}}
            <div class="lg:col-span-5 p-8 lg:p-12 flex flex-col justify-center">
                <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-widest rounded-full">
                    Latest Post
                </span>
                    <span class="text-slate-400 text-sm italic">
                    {{ $featuredPost->getDate()->format('M j, Y') }}
                </span>
                </div>

                <a href="{{ $featuredPost->getUrl() }}" class="group/link">
                    <h2 class="text-3xl lg:text-4xl text-base- leading-tight mb-4 group-hover/link:text-emerald-600 transition-colors">
                        {{ $featuredPost->title }}
                    </h2>
                    <div class="text-base-content line-clamp-3 mb-6 leading-relaxed">
                        {!! $featuredPost->getExcerpt() !!}
                    </div>
                </a>

                <div class="mt-auto">
                    <a href="{{ $featuredPost->getUrl() }}"
                       class="inline-flex items-center gap-2 font-bold text-base hover:text-emerald-600 transition-colors underline decoration-emerald-500/30 underline-offset-8 hover:decoration-emerald-500">
                        Read More
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
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
