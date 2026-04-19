<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->input('city', 'Surabaya');
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::withoutVerifying()->get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'units' => 'metric',
            'appid' => $apiKey
        ]);

        if ($response->successful()) {
            $weather = $response->json();
            $condition = strtolower($weather['weather'][0]['main']);
            $temp = $weather['main']['temp'];

            // Logika Penentuan Pokemon (Suhu + Kondisi)
            $pokemon = match (true) {
                // 1. Kondisi Hujan
                str_contains($condition, 'rain')
                => ['name' => 'Squirtle', 'sprite' => 'https://img.pokemondb.net/sprites/black-white/anim/normal/squirtle.gif', 'bg' => 'bg-blue-900', 'desc' => 'LOVES THE RAIN!'],

                // 2. Kondisi Dingin
                $temp <= 18
                => ['name' => 'Swinub', 'sprite' => 'https://img.pokemondb.net/sprites/black-white/anim/normal/swinub.gif', 'bg' => 'bg-cyan-600', 'desc' => 'CHILLING IN THE COLD!'],

                // 3. Kondisi Sejuk/Mendung
                str_contains($condition, 'cloud')
                => ['name' => 'Pidgey', 'sprite' => 'https://img.pokemondb.net/sprites/black-white/anim/normal/pidgey.gif', 'bg' => 'bg-slate-500', 'desc' => 'FLYING IN CLOUDY SKIES!'],

                // 4. Kondisi Panas & Cerah (Cuma muncul kalau suhu diatas 18C dan langit clear)
                str_contains($condition, 'clear') && $temp > 18
                => ['name' => 'Charmander', 'sprite' => 'https://img.pokemondb.net/sprites/black-white/anim/normal/charmander.gif', 'bg' => 'bg-orange-400', 'desc' => 'ENJOYING THE SUN!'],

                // Default kalau tidak ada yang cocok
                default => ['name' => 'Pikachu', 'sprite' => 'https://img.pokemondb.net/sprites/black-white/anim/normal/pikachu.gif', 'bg' => 'bg-yellow-400', 'desc' => 'READY FOR ADVENTURE!'],
            };

            return view('pokeweather', compact('weather', 'pokemon', 'city'));
        }

        // Pesan error jika API gagal
        return response()->json([
            'error' => 'Gagal mengambil data cuaca',
            'status' => $response->status(),
            'detail' => $response->json()
        ]);
    }
}
