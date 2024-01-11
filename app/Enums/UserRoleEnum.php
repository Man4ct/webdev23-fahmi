<?php

namespace App\Enums;

enum UserRoleEnum:string {
    case Administrator = 'admin';
    case Author = 'author';
    case Viewer = 'viewer';
}
