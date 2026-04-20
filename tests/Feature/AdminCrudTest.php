<?php

use App\Models\User;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Facility;
use App\Models\ClassProgram;
use App\Models\Brochure;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Livewire\livewire;

uses(DatabaseTransactions::class);

beforeEach(function () {
    Storage::fake('public');
    
    // Gunakan firstOrCreate agar tidak bentrok jika bot dijalankan berulang kali
    $this->admin = User::firstOrCreate(
        ['email' => 'admin_bot_tester@gmail.com'],
        [
            'name' => 'Admin Test',
            'password' => bcrypt('password'),
            'role' => 'ADMIN',
        ]
    );
    
    $this->actingAs($this->admin);
});

// TEST 1: Rendering Halaman (Tidak boleh 403 atau 500)
it('dapat memuat halaman index dan create semua resource', function (string $resource) {
    $this->get($resource::getUrl('index'))->assertSuccessful();
    if ($resource::canCreate()) {
        $this->get($resource::getUrl('create'))->assertSuccessful();
    }
})->with([
    \App\Filament\Resources\Articles\ArticleResource::class,
    \App\Filament\Resources\Galleries\GalleryResource::class,
    \App\Filament\Resources\Facilities\FacilityResource::class,
    \App\Filament\Resources\ClassPrograms\ClassProgramResource::class,
    \App\Filament\Resources\Brochures\BrochureResource::class,
    \App\Filament\Resources\Testimonials\TestimonialResource::class,
    \App\Filament\Resources\SiteSettings\SiteSettingResource::class,
]);

// TEST 2: Artikel
it('dapat melakukan crud penuh pada article', function () {
    livewire(\App\Filament\Resources\Articles\Pages\CreateArticle::class)
        ->fillForm([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'is_published' => true,
            'author_id' => $this->admin->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    $this->assertDatabaseHas('articles', ['slug' => 'test-article']);

    $article = Article::where('slug', 'test-article')->first();
    livewire(\App\Filament\Resources\Articles\Pages\EditArticle::class, ['record' => $article->getRouteKey()])
        ->fillForm(['title' => 'Test Article Updated'])
        ->call('save')
        ->assertHasNoFormErrors();

    livewire(\App\Filament\Resources\Articles\Pages\EditArticle::class, ['record' => $article->getRouteKey()])
        ->callAction('delete');
    $this->assertModelMissing($article);
});

// TEST 3: Galeri
it('dapat melakukan crud penuh pada gallery', function () {
    $image = UploadedFile::fake()->image('gallery.jpg');
    
    livewire(\App\Filament\Resources\Galleries\Pages\CreateGallery::class)
        ->fillForm([
            'title' => 'Test Gallery',
            'description' => 'Desc',
            'image_url' => $image,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    $this->assertDatabaseHas('galleries', ['title' => 'Test Gallery']);

    $gallery = Gallery::where('title', 'Test Gallery')->first();
    livewire(\App\Filament\Resources\Galleries\Pages\EditGallery::class, ['record' => $gallery->getRouteKey()])
        ->callAction('delete');
    $this->assertModelMissing($gallery);
});

// TEST 4: Fasilitas
it('dapat melakukan crud penuh pada facility', function () {
    livewire(\App\Filament\Resources\Facilities\Pages\CreateFacility::class)
        ->fillForm([
            'name' => 'Test Facility',
            'description' => 'Desc',
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    $this->assertDatabaseHas('facilities', ['name' => 'Test Facility']);

    $facility = Facility::where('name', 'Test Facility')->first();
    livewire(\App\Filament\Resources\Facilities\Pages\EditFacility::class, ['record' => $facility->getRouteKey()])
        ->callAction('delete');
    $this->assertModelMissing($facility);
});

// TEST 5: Program Kelas
it('dapat melakukan crud penuh pada class program', function () {
    livewire(\App\Filament\Resources\ClassPrograms\Pages\CreateClassProgram::class)
        ->fillForm([
            'name' => 'Test Class',
            'description' => 'Desc',
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    $this->assertDatabaseHas('class_programs', ['name' => 'Test Class']);

    $class = ClassProgram::where('name', 'Test Class')->first();
    livewire(\App\Filament\Resources\ClassPrograms\Pages\EditClassProgram::class, ['record' => $class->getRouteKey()])
        ->callAction('delete');
    $this->assertModelMissing($class);
});

// TEST 6: Brosur
it('dapat melakukan crud penuh pada brochure', function () {
    $pdf = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');
    
    livewire(\App\Filament\Resources\Brochures\Pages\CreateBrochure::class)
        ->fillForm([
            'title' => 'Test Brochure',
            'version' => '1.0',
            'file_url' => $pdf,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    $this->assertDatabaseHas('brochures', ['title' => 'Test Brochure']);

    $brochure = Brochure::where('title', 'Test Brochure')->first();
    livewire(\App\Filament\Resources\Brochures\Pages\EditBrochure::class, ['record' => $brochure->getRouteKey()])
        ->callAction('delete');
    $this->assertModelMissing($brochure);
});

// TEST 7: Testimonial
it('dapat melakukan crud penuh pada testimonial', function () {
    livewire(\App\Filament\Resources\Testimonials\Pages\CreateTestimonial::class)
        ->fillForm([
            'name' => 'Test Testimonial',
            'role' => 'Alumni',
            'message' => 'Pesan test',
            'is_active' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    $this->assertDatabaseHas('testimonials', ['name' => 'Test Testimonial']);

    $testimonial = Testimonial::where('name', 'Test Testimonial')->first();
    livewire(\App\Filament\Resources\Testimonials\Pages\EditTestimonial::class, ['record' => $testimonial->getRouteKey()])
        ->callAction('delete');
    $this->assertModelMissing($testimonial);
});

// TEST 8: Site Setting
it('dapat melakukan crud penuh pada site setting', function () {
    livewire(\App\Filament\Resources\SiteSettings\Pages\CreateSiteSetting::class)
        ->fillForm([
            'key' => 'test_key',
            'value' => 'test_value',
            'description' => 'desc',
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    $this->assertDatabaseHas('site_settings', ['key' => 'test_key']);

    $setting = SiteSetting::where('key', 'test_key')->first();
    livewire(\App\Filament\Resources\SiteSettings\Pages\EditSiteSetting::class, ['record' => $setting->getRouteKey()])
        ->callAction('delete');
    $this->assertModelMissing($setting);
});