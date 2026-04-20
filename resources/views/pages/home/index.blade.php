<x-layouts.app :settings="$settings">
    
    <x-sections.hero :settings="$settings" />

    <x-sections.program-list :programs="$programs" />

    <x-sections.about />

    <x-sections.stats />

    <x-sections.article-grid :articles="$articles" />

    @if(isset($testimonials) && $testimonials->count() > 0)
        <x-sections.testimonial :testimonials="$testimonials" />
    @endif

    <x-sections.gallery-grid :galleries="$galleries" />

</x-layouts.app>