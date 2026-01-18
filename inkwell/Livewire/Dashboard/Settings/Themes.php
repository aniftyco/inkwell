<?php

namespace NiftyCo\Inkwell\Livewire\Dashboard\Settings;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use NiftyCo\Inkwell\Support\ThemeManager;

#[Layout('inkwell::layouts.dashboard')]
#[Title('Themes')]
class Themes extends Component
{
    public string $activeTheme = '';

    public function mount()
    {
        $this->activeTheme = app(ThemeManager::class)->activeSlug();
    }

    public function activate(string $slug)
    {
        $themeManager = app(ThemeManager::class);

        if ($themeManager->setActive($slug)) {
            $this->activeTheme = $slug;
            session()->flash('message', 'Theme activated successfully.');
        } else {
            session()->flash('error', 'Theme not found.');
        }
    }

    public function render()
    {
        $themeManager = app(ThemeManager::class);

        return view('inkwell::dashboard.settings.themes', [
            'themes' => $themeManager->all(),
        ]);
    }
}
