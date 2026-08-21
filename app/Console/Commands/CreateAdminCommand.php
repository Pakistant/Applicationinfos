<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-command
                            {--email= : Adresse email du super administrateur}
                            {--name= : Nom du super administrateur}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer ou mettre à jour un super administrateur';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->option('email') ?: $this->ask('Email du super administrateur', 'superadmin@example.com');
        $name = $this->option('name') ?: $this->ask('Nom du super administrateur', 'Super Admin');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('L’adresse email est invalide.');

            return self::FAILURE;
        }

        $password = $this->secret('Mot de passe');
        $passwordConfirmation = $this->secret('Confirmer le mot de passe');

        if (! $password || $password !== $passwordConfirmation) {
            $this->error('Les mots de passe sont vides ou différents.');

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => strtolower($email)],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->info("Super administrateur prêt : {$email}");

        return self::SUCCESS;
    }
}
