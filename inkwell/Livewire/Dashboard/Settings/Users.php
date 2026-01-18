<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Settings;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use NiftyCo\Inkwell\Models\Role;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Users')]
class Users extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showCreate = false;

    // Create form
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public array $selectedRoles = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $userModel = config('auth.providers.users.model');
        $user = $userModel::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        if (! empty($this->selectedRoles) && method_exists($user, 'roles')) {
            $user->roles()->sync($this->selectedRoles);
        }

        $this->reset(['name', 'email', 'password', 'selectedRoles', 'showCreate']);
        session()->flash('message', 'User created successfully.');
    }

    public function delete($userId)
    {
        $userModel = config('auth.providers.users.model');
        $userModel::find($userId)?->delete();
        session()->flash('message', 'User deleted.');
    }

    public function render()
    {
        $userModel = config('auth.providers.users.model');

        $users = $userModel::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(15);

        return view('inkwell::dashboard.settings.users', [
            'users' => $users,
            'roles' => Role::all(),
        ]);
    }
}
