<?php

namespace App\Service\Database;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;

class UserService {
    public function index($filter = [])
    {
        $orderBy = $filter['order_by'] ?? 'DESC';
        $per_page = $filter['per_page'] ?? 999;
        $page = $filter['page'] ?? 1;
        $role = $filter['role'] ?? null;
        $name = $filter['name'] ?? null;
        $status = $filter['status'] ?? null;

        $query = User::orderBy('created_at', $orderBy);

        if ($role !== null) {
            $query->where('role', $role);
        }

        if ($name !== null) {
            $query->where('name', $name);
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        $users = $query->paginate($per_page, ['*'], 'page', $page);

        return $users->toArray();
    }

    public function detail($userId)
    {
        $user = User::findOrFail($userId);

        return $user->toArray();
    }

    public function create($payload)
    {
        $user = new User;
        $user->id = Uuid::uuid4()->toString();
        $user = $this->fill($user, $payload);
        $user->password = Hash::make($user->password);
        $user->save();

        return $user->toArray();
    }

    public function update($userId, $payload)
    {
        $user = User::findOrFail($userId);
        $user = $this->fill($user, $payload);
        $user->password = Hash::make($user->password);
        $user->save();

        return $user->toArray();
    }

    public function destroy($userId)
    {
        User::findOrFail($userId)->delete();

        return true;
    }

    private function fill(User $user, array $attributes)
    {

        foreach ($attributes as $key => $value) {
            $user->$key = $value;
        }

        Validator::make($user->toArray(), [
            'name' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'status' => 'required',
            'telp' => 'nullable',
            'role' => ['required', Rule::in(config('constant.user.roles'))],
        ])->validate();

        return $user;
    }
}
