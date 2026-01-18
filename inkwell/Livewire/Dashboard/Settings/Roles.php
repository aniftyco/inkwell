<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Settings;

use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use NiftyCo\Inkwell\Models\Permission;
use NiftyCo\Inkwell\Models\Role;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Roles')]
class Roles extends Component
{
    public ?Role $editingRole = null;
    public string $name = '';
    public string $slug = '';
    public array $selectedPermissions = [];
    public bool $showCreate = false;

    public function edit(Role $role)
    {
        $this->editingRole = $role;
        $this->name = $role->name;
        $this->slug = $role->slug;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->showCreate = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,' . ($this->editingRole?->id ?? 'NULL'),
        ]);

        if ($this->editingRole) {
            $this->editingRole->update([
                'name' => $this->name,
                'slug' => $this->slug,
            ]);
            $this->editingRole->permissions()->sync($this->selectedPermissions);
            session()->flash('message', 'Role updated successfully.');
        } else {
            $role = Role::create([
                'name' => $this->name,
                'slug' => $this->slug,
            ]);
            $role->permissions()->sync($this->selectedPermissions);
            session()->flash('message', 'Role created successfully.');
        }

        $this->reset(['name', 'slug', 'selectedPermissions', 'editingRole', 'showCreate']);
    }

    public function updatedName()
    {
        if (! $this->editingRole) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function delete(Role $role)
    {
        $role->delete();
        session()->flash('message', 'Role deleted.');
    }

    public function cancel()
    {
        $this->reset(['name', 'slug', 'selectedPermissions', 'editingRole', 'showCreate']);
    }

    public function render()
    {
        return view('inkwell::dashboard.settings.roles', [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::all()->groupBy(fn ($p) => explode('.', $p->slug)[0]),
        ]);
    }
}
