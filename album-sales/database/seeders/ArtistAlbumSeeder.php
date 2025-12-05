<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;
use App\Models\Album;
use League\Csv\Reader;
use Faker\Factory as Faker;

class ArtistAlbumSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $csv = Reader::createFromPath(database_path('seeders\data\artists_albums.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            $artist = Artist::firstOrCreate(
            ['name' => $record['Artist']]
        );


         Album::create([
            'artist_code' => $artist->code,
            'name'        => $record['Album'],
            'year'        => $faker->numberBetween(1990, (int) date('Y')),
            'sales'       => $record['2022 Sales'],
            'cover'       => $record['Cover'] ?? null,
        ]);

        }
    }
}
