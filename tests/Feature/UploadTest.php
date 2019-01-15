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
        $response = $this->json('POST', 'uploader/newSeries', [
            'age'=>'new',
            'files'=> [ $video],
            'data001'=>[ 
                    
                        'quality'=> 'mp4',
                        'type'=>'naijaseries',
                        'seasonNumber'=>'1',
                        'episodeNumber'=>'1',
                        'desc'=>'jinifa ko, omotoson, swagger ole tun',
                        'imdblink'=>'imdb.com/jenifa',
                        'image'=>$image       
                    ]
           
        ]);
        $response->assertJson([['jenifa.mp4.mp4 uploaded successfully']]);
    }
    

   
    public function testSeriesUpdate()
    {
        Storage::fake('public');
        $video = UploadedFile::fake()->create('002jenifa.mp4', 500);
        $response = $this->json('POST', 'uploader/updateSeries', [
            'age'=>'old',
            'files'=>[$video],
            'data002'=>[
                    'should_show'=> 1,
                    'quality'=>'HD',
                    'seasonNumber'=> '1',
                    'seasonChanged'=>0,
                    'episodeNumber'=>'2'
                        ]
        ]);
        $response->assertJson([['jenifa.mp4.mp4 updated successfully']]);
    }
    public function testNewMovieUpload()
    {
        Storage::fake('public');
        $video = UploadedFile::fake()->create('001Avengers infinity war.mp4', 500);
        $image = UploadedFile::fake()->image('Avengers.jpg');
        $response = $this->json('POST', 'uploader/newMovie',[
            'age'=> 'new',
            'files'=>[$video],
            'data001'=>[
                'quality'=> 'HD',
                'type'=>'hollywood',
                'desc'=> 'thanos and his fuckery',
                'tags'=>['action', 'suspense', 'romance'],
                'imdblink'=>' imdb/thanos/thor',
                'image'=>$image
            ]

        ]);
        $response->assertJson([['avengers infinity war.mp4.mp4 uploaded successfully']]);
    }
    public function testMovieUpdate()
    {
        Storage::fake('public');
        $video = UploadedFile::fake()->create('001Avengers infinity war.mp4', 500);
        $response = $this->json('POST', 'uploader/updateMovie', [
            'age'=>'old',
            'files'=>[$video],
            'data001'=>[
                'quality'=> 'Mp4',
                'type'=>'hollywood',
                'should_show'=>1
                    ]
        ]);
        $response->assertJson([['avengers infinity war.mp4.mp4 updated successfully']]);
    }
}
