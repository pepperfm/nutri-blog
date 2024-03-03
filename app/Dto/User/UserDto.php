<?php

declare(strict_types=1);

namespace App\Dto\User;

use App\Dto\BaseDto;

class UserDto extends BaseDto
{
    public string $instanceId;

    public string $id;

    public string $aud;

    public string $role;

    public string $email;

    public string $invitedAt;

    public string $lastSignInAt;

    public array $rawAppMetaData;

    public array $rawUserMetaData;

    public bool $isSuperAdmin;

    public string $createdAt;

    public string $phone;

    public string $confirmedAt;

    public string $emailChangeTokenCurrent;

    public int $emailChangeConfirmStatus;

    public string $bannedUntil;

    public string $reauthenticationToken;

    public bool $isSsoUser;

    public function casts(): array
    {
        return [
            'raw_app_meta_data' => 'array',
            'raw_user_meta_data' => 'array',
        ];
    }
}
