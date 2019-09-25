<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UploadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
 
    public function testNewSeriesUpload()
    {
        Storage::fake('public');
        $video = UploadedFile::fake()->create('001jenifa.mp4', 500);
        $image = UploadedFile::fake()->image('jenifa.jpg');
        $response = $this->json('POST','http://localhost/uploader/newSeries', [
            'files'=> [ $video],
            'image001'=> $image,
            'data001'=>json_encode([ 
                        'quality'=> 'mp4',
                        'type'=>'naijaseries',
                        'seasonNumber'=>'1',
                        'episodeNumber'=>'1',
                        'desc'=>'jinifa ko, omotoson, swagger ole tun',
                        'imdbLink'=>'imdb.com/jenifa',
                        'tags'=>['action', 'suspense', 'romance'],
                        'runTime'=>'100mins',
                        'extLink' => 't.me',
                        'haveLink'=>true,
                        'trailerLink' => 'youtube.com',
                        'shouldpull' => false,
                        'shouldnotify' =>false

                    ])
           
        ]);
        $response->assertJson([['jenifa-mp4-S1-E1-(UdaraTv.com).me uploaded successfully']]);
    }
    
    public function testSeriesUpdate()
    {
        Storage::fake('public');
        $video = UploadedFile::fake()->create('002jenifa.mp4', 500);
        $response = $this->json('POST', 'http://localhost/uploader/updateSeries', [
            'age'=>'old',
            'files'=>[$video],
            'data002'=>json_encode([
                    'should_show'=> 1,
                    'quality'=>'HD',
                    'type'=>'naijaseries',
                    'seasonNumber'=> '1',
                    'seasonChanged'=>0,
                    'episodeNumber'=>'2',
                    'runTime'=>'100mins',
                    'extLink' => 't.me',
                    'haveLink'=>true,
                    'trailerLink' => 'youtube.com',
                    'shouldpull' => false,
                    'shouldnotify' =>false
                        ])
        ]);
        $response->assertJson([['jenifa-HD-S1-E2-(UdaraTv.com).me updated successfully']]);
    }
    public function testNewMovieUpload()
    {
        Storage::fake('public');
        $video = UploadedFile::fake()->create('001Avengers infinity war.mp4', 500);
        $image = UploadedFile::fake()->image('Avengers.jpg');
        $response = $this->json('POST', 'http://localhost/uploader/newMovie',[
            'age'=> 'new',
            'files'=>[$video],
            'image001'=> $image,
            'data001'=>json_encode([
                'quality'=> 'HD',       
                'type'=>'hollywoodmovies',
                'desc'=> 'thanos and his fuckery',
                'tags'=>['action', 'suspense', 'romance'],
                'imdblink'=>' imdb/thanos/thor', 
                'runTime'=>'100mins',
                'extLink' => 't.me',
                'haveLink'=>true,
                'trailerLink' => 'youtube.com',
                'shouldpull' => false,
                'shouldnotify' =>false
            ])

        ]);
        $response->assertJson([['avengers infinity war-HD-(UdaraTv.com).me uploaded successfully']]);
    }

    public function testMovieUpdate()
    {
        Storage::fake('public');
        $video = UploadedFile::fake()->create('001Avengers infinity war.mp4', 500);
        $response = $this->json('POST', 'http://localhost/uploader/updateMovie', [
            'age'=>'old',
            'files'=>[$video],
            'data001'=>json_encode([
                'quality'=> 'Mp4',
                'type'=>'hollywoodmovies',
                'should_show'=>1,
                'runTime'=>'100mins',
                'extLink' => 't.me',
                'haveLink'=>true,
                'trailerLink' => 'youtube.com',
                'shouldpull' => false,
                'shouldnotify' =>false
                    ])
        ]);
        $response->assertJson([['avengers infinity war-Mp4-(UdaraTv.com).me updated successfully']]);
    }

}
