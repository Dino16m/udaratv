<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class categoryTest extends TestCase
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
    public function testIndex()
    {
        $response= $this->get('/');
        $response->assertStatus(500);
    }

    
    public function testCatIndex()
    {
        $response = $this->get('categories/naijaseries/jkl');
       // $response->assertViewHas('jenifa.mp4');
        $response->assertJsonStructure([
            'jenifa.mp4'=>[
                        'name','link', 'paginator' 
                          ]
                ]);
    }

   
    public function testMovieIndex()
    {
        $response = $this->get('movies/hollywood/avengers_infinity_war.mp4');
        $response->assertJsonStructure([
            '*'=>[
                'name', 'id', 'link', 'parent_id'
                 ]
        ]);
    }
    public function testSeasonIndex()
    {
        $response = $this->get('series/naijaseries/jenifa.mp4');
        $response->assertJsonStructure([
            'current_page', 'data'
        ]);

    }
    public function testEpisodeIndex()
    {
        $response = $this->get('series/19/jenifa.mp4/1');
        $response->assertJsonStructure([
            '*'=>['episode', 'link']
        ]);
    }
    
    public function testGetEpisode()
    {
        $response = $this->get('seriesepisodes/jenifa.mp4/19');
        $response->assertJsonStructure([
            ['id', 'series_id']
        ]);

    }
     public function testDownload()
    {
        $response = $this->get('download/series/19?file=/videos/series/jenifa.mp4/jenifa.mp4.mp4');
        $this->assertEquals(preg_match('/(error|notice)/i', $response->getContent()), false);
        $this->assertEquals($response->getStatusCode(), 200);
    }
}
