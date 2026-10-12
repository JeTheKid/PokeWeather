<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <title>PokeWeather Adventure</title>
    <style>
        body {
            font-family: 'Press Start 2P', cursive;
        }

        .scanline::before {
            content: " ";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%);
            background-size: 100% 4px;
            pointer-events: none;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-slate-900 min-h-screen flex flex-col items-center py-10 px-4">

    <div class="max-w-2xl w-full text-center mb-10 text-white">
        <h1 class="text-2xl md:text-3xl text-yellow-400 mb-4 [text-shadow:4px_4px_0px_#ca8a04]">
            POKEWEATHER!
        </h1>
        <div class="bg-slate-800 border-4 border-dashed border-slate-600 p-4 inline-block">
            <p class="text-[8px] md:text-[10px] leading-loose text-slate-300 uppercase">
                Monitoring cuaca real-time & ekosistem pokemon <br>
                <span class="text-green-400 italic">"Analisis data cuaca untuk mendeteksi habitat pokemon."</span>
            </p>
        </div>
    </div>

    <div
        class="max-w-md w-full bg-[#E0E8D0] border-8 border-black p-6 shadow-[12px_12px_0px_0px_rgba(0,0,0,0.5)] mb-10">

        <div class="mb-6 border-b-4 border-black pb-4">
            <div class="flex justify-between items-end mb-2">
                <h1 class="text-lg text-black uppercase truncate mr-2">{{ $city }}</h1>
                <span class="text-[8px] bg-black text-white px-2 py-1 italic">LIVE DATA</span>
            </div>
            <div
                class="bg-white border-2 border-black p-2 flex items-center justify-between shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <span class="text-[7px] text-gray-500 uppercase">Weather:</span>
                <span
                    class="text-[8px] font-bold text-black uppercase">{{ $weather['weather'][0]['description'] }}</span>
            </div>
        </div>

        <div
            class="scanline {{ $pokemon['bg'] }} p-6 border-4 border-black text-white text-center mb-6 relative overflow-hidden shadow-[inset_0_0_20px_rgba(0,0,0,0.5)]">
            <div class="relative z-20">
                <h2
                    class="text-4xl mb-4 font-black {{ $pokemon['name'] == 'Pikachu' || $pokemon['name'] == 'Charmander' ? 'text-black' : 'text-white' }}">
                    {{ round($weather['main']['temp']) }}°C
                </h2>
                <img src="{{ $pokemon['sprite'] }}" class="w-24 h-24 mx-auto mb-2 animate-bounce">

                <div class="inline-block bg-black text-white text-[7px] px-3 py-1 border-2 border-white uppercase">
                    {{ $pokemon['name'] }} {{ $pokemon['desc'] ?? 'IS HERE!' }}
                </div>
            </div>
        </div>

        <div class="space-y-4 mb-8 p-4 bg-white border-4 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,0.2)]">
            <div>
                <div class="flex justify-between text-[8px] mb-1 font-bold text-blue-700 uppercase">
                    <span>Humidity [MP]</span>
                    <span>{{ $weather['main']['humidity'] }}%</span>
                </div>
                <div class="w-full h-4 border-2 border-black bg-gray-200">
                    <div class="bg-blue-500 h-full border-r-2 border-black"
                        style="width: {{ $weather['main']['humidity'] }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-[8px] mb-1 font-bold text-green-700 uppercase">
                    <span>Wind [HP]</span>
                    <span>{{ round($weather['wind']['speed']) }} M/S</span>
                </div>
                <div class="w-full h-4 border-2 border-black bg-gray-200">
                    <div class="bg-green-500 h-full border-r-2 border-black"
                        style="width: {{ min($weather['wind']['speed'] * 10, 100) }}%"></div>
                </div>
            </div>
        </div>

        <form action="/" method="GET">
            <div class="mb-4">
                <p class="text-[7px] mb-2 uppercase text-gray-700 font-bold">Search Location:</p>
                <input type="text" name="city" required
                    class="w-full border-4 border-black p-3 focus:outline-none text-xs uppercase bg-white"
                    placeholder="Enter City...">
            </div>
            <button type="submit"
                class="w-full bg-yellow-400 border-b-8 border-yellow-600 py-4 text-[10px] font-black hover:bg-yellow-300 active:border-b-0 active:translate-y-2 transition-all">
                ► GO ADVENTURE! ◄
            </button>
        </form>
    </div>

    <div class="max-w-md w-full bg-black text-green-500 p-4 border-2 border-green-500 text-[6px] leading-relaxed">
        <p>> INITIALIZING WEATHER MONITORING SYSTEM...</p>
        <p>> FETCHING DATA FROM OPENWEATHERMAP API...</p>
        <p>> SUCCESS: HABITAT ANALYSIS COMPLETE.</p>
    </div>

</body>

</html>
