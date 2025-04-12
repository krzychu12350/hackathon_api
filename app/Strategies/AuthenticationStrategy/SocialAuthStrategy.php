<?php

namespace App\Strategies\AuthenticationStrategy;

use App\Enums\FileType;
use App\Enums\UserRole;
use App\Models\File;
use App\Models\User;
use App\Models\LinkedSocialAccount;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\User as ProviderUser;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthStrategy implements AuthStrategy
{
    /**
     * Handle the social registration process.
     *
     * @param array $data
     * @return array
     */
    public function register(array $data): ?User
    {
        try {
            $accessToken = $data['access_token'];
            $provider = $data['provider'];

            // Get the user information from the provider using the access token
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);

        } catch (\Exception $exception) {
            throw new \Exception('Social registration failed: ' . $exception->getMessage());
        }

        // Check if the user already exists based on their social account info or create a new user
        $user = $this->findOrCreate($providerUser, $provider);

        // Generate a new authentication token for the registered user
        return $user;
    }

    /**
     * Handle the social login process.
     *
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): ?User
    {
        try {
            $accessToken = $credentials['access_token'];
            $provider = $credentials['provider'];

            // Get the user information from the provider using the access token
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);

        } catch (\Exception $exception) {
            throw new \Exception('Social login failed: ' . $exception->getMessage());
        }

        // Find or create user based on the social account info
        $user = $this->findOrCreate($providerUser, $provider);

        return $user;
    }

    /**
     * Find or create a user based on social provider info.
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     * @return User
     */
    protected function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        // Check if the social account is already linked to a user
        $linkedSocialAccount = LinkedSocialAccount::query()
            ->where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($linkedSocialAccount) {
            // If the social account is already linked, return the associated user
            return $linkedSocialAccount->user;
        } else {
            // If no user is linked, create a new user
            $user = User::query()->create([

                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => bcrypt(Str::random(16)),  // Generate a random password for the user
                'role' =>  UserRole::USER,
            ]);

//            $file = File::create([
//                'url' => $providerUser->getAvatar(),
//                'type' => FileType::IMAGE,
//            ]);
//
//            $user->photos()->attach($file);
//
//            // Mark the email as verified (you can modify this depending on your email verification logic)
//            $user->markEmailAsVerified();

            // Link the social account to the user
            $user->linkedSocialAccounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;
        }
    }
}
