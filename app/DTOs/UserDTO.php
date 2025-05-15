<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class UserDTO extends Request
{
    public string $name;
    public string $email;
    public ?string $password;
    public ?array $image;
    public ?string $address;
    public ?string $phone;

    public static function fromRequest(Request $request): self
    {
       $dto = new self();
       $dto->name = $request['name'];
       $dto->email = $request['email'];
       $dto->password = $request['password'];
       $dto->address = $request['address'];
       $dto->image = $request['image'];
       $dto->phone = $request['phone'];

       return $dto;
    }
}
