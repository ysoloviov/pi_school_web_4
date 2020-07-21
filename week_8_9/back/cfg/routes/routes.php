<?php

declare(strict_types=1);

namespace App\Controller;

use Routing\RouteCollection;

$rc = new RouteCollection;
$rc->get("/auth/info", new Authentication\UserInfoController);
$rc->post("/auth/password", new Authentication\PasswordAuthenticationController);
$rc->post("/register", new RegistrationController);

return $rc;
