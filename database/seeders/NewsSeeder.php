<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::create([
            'title' => 'Dzień Otwarty Schroniska – zapraszamy w niedzielę!',
            'content' => 'Zapraszamy wszystkich miłośników zwierząt na nasz doroczny Dzień Otwarty. W programie zwiedzanie schroniska, możliwość poznania naszych podopiecznych oraz liczne atrakcje dla dzieci. Nie zabraknie również pysznego domowego ciasta i lemoniady. To doskonała okazja, żeby dowiedzieć się więcej o adopcji i wolontariacie. Do zobaczenia!',
            'author_id' => 1,
            'is_published' => true,
            'published_at' => now()->subDays(2),
        ]);

        News::create([
            'title' => 'Pilnie poszukujemy karmy dla kociąt!',
            'content' => 'W związku z trwającym "sezonem na kocięta", do naszego Azylu trafia coraz więcej maluchów potrzebujących specjalistycznej opieki. Pilnie potrzebujemy karmy mokrej i suchej typu "kitten" (najlepiej marek premium, takich jak animonda, feringa, czy macs), a także podkładów higienicznych. Każda puszka jest na wagę złota!',
            'author_id' => 1,
            'is_published' => true,
            'published_at' => now()->subDays(5),
        ]);

        News::create([
            'title' => 'Szkolenie dla nowych wolontariuszy',
            'content' => 'Chcesz dołączyć do naszej drużyny i pomagać zwierzakom na co dzień? Zapraszamy na obowiązkowe szkolenie wprowadzające dla nowych wolontariuszy, które odbędzie się w przyszłą sobotę o godzinie 10:00. Opowiemy o zasadach bezpieczeństwa, procedurach spacerowych i sposobach pracy z psami lękowymi. Zgłoszenia przyjmujemy mailowo.',
            'author_id' => 1,
            'is_published' => true,
            'published_at' => now()->subDays(10),
        ]);
    }
}
