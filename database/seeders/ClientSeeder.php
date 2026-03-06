<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'firstname' => 'Kofi',
                'lastname' => 'Mensah',
                'pseudo' => 'kofi_m',
                'email' => 'kofi.mensah@example.com',
                'phone_number' => '97000001',
                'country' => 'BJ',
                'description' => 'Passionné de design et de technologie.',
                'avatar' => 'av1',
                'specialite' => 'uidesign',
                'plan' => 'gratuit',
                'role' => 'client',
                'isAuth' => true,
                'password' => Hash::make('ClientPass@1'),
            ],
            [
                'firstname' => 'Amina',
                'lastname' => 'Traoré',
                'pseudo' => 'amina_t',
                'email' => 'amina.traore@example.com',
                'phone_number' => '97000002',
                'country' => 'BJ',
                'description' => 'Entrepreneuse digitale, fan de contenu créatif.',
                'avatar' => 'av2',
                'specialite' => 'dev',
                'plan' => 'gratuit',
                'role' => 'client',
                'isAuth' => true,
                'password' => Hash::make('ClientPass@2'),
            ],
            [
                'firstname' => 'Yao',
                'lastname' => 'Balogun',
                'pseudo' => 'yao_b',
                'email' => 'yao.balogun@example.com',
                'phone_number' => '97000003',
                'country' => 'BJ',
                'description' => "Développeur freelance en quête d'outils créatifs.",
                'avatar' => 'av3',
                'specialite' => 'dev',
                'plan' => 'gratuit',
                'role' => 'client',
                'isAuth' => true,
                'password' => Hash::make('ClientPass@3'),
            ],
            [
                'firstname' => 'Fatou',
                'lastname' => 'Diallo',
                'pseudo' => 'fatou_d',
                'email' => 'fatou.diallo@example.com',
                'phone_number' => '97000004',
                'country' => 'BJ',
                'description' => 'Illustratrice indépendante cherchant des ressources.',
                'avatar' => 'av4',
                'specialite' => 'illustration',
                'plan' => 'gratuit',
                'role' => 'client',
                'isAuth' => true,
                'password' => Hash::make('ClientPass@4'),
            ],
            [
                'firstname' => 'Segun',
                'lastname' => 'Adesanya',
                'pseudo' => 'segun_a',
                'email' => 'segun.adesanya@example.com',
                'phone_number' => '97000005',
                'country' => 'BJ',
                'description' => 'Motion designer et vidéaste passionné.',
                'avatar' => 'av5',
                'specialite' => 'motion',
                'plan' => 'gratuit',
                'role' => 'client',
                'isAuth' => true,
                'password' => Hash::make('ClientPass@5'),
            ],

            [
                'firstname' => 'Light',
                'lastname' => 'YAGAMI',
                'pseudo' => 'l_ight',
                'email' => 'lightyagami@gmail.com',
                'phone_number' => '64000001',
                'country' => 'BJ',
                'description' => 'Motion designer et vidéaste passionné.',
                'avatar' => 'av5',
                'specialite' => 'motion',
                'plan' => 'gratuit',
                'role' => 'client',
                'isAuth' => true,
                'password' => Hash::make('ClientPass@6'),
            ],


        ];

        foreach ($clients as $client) {
            User::updateOrCreate(['email' => $client['email']], $client);
        }
    }
}
