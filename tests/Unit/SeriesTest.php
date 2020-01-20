<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use App\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeriesTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_series_can_get_image_path() {
        $series = factory(Series::class)->create([
            'image_url' => 'series/series-slug.png'
        ]);

        $imagePath = $series->image_path;
        $this->assertEquals(asset('storage/series/series-slug.png'), $imagePath);
    }
}
