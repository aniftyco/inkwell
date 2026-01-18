<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Settings;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use NiftyCo\Inkwell\Support\Settings;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Settings')]
class General extends Component
{
    public string $site_name = '';
    public string $site_description = '';
    public int $posts_per_page = 10;
    public bool $allow_comments = true;
    public bool $require_confirmation = true;

    public function mount()
    {
        $this->site_name = Settings::get('site_name', 'My Blog');
        $this->site_description = Settings::get('site_description', '');
        $this->posts_per_page = Settings::get('posts_per_page', 10);
        $this->allow_comments = Settings::get('allow_comments', true);
        $this->require_confirmation = Settings::get('require_confirmation', true);
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'posts_per_page' => 'required|integer|min:1|max:100',
        ]);

        Settings::save([
            'site_name' => $this->site_name,
            'site_description' => $this->site_description,
            'posts_per_page' => $this->posts_per_page,
            'allow_comments' => $this->allow_comments,
            'require_confirmation' => $this->require_confirmation,
        ]);

        session()->flash('message', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('inkwell::dashboard.settings.general');
    }
}
