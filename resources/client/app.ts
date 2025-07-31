import focus from '@alpinejs/focus';
import axios from 'axios';
import { Livewire, Alpine } from '@vendor/livewire/livewire/dist/livewire.esm';

import.meta.glob(['../images/**']);

declare global {
  interface Window {
    axios: typeof axios;
    Livewire: typeof Livewire;
    Alpine: typeof Alpine;
  }
}

window.axios = axios;
window.Livewire = Livewire;
window.Alpine = Alpine;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Alpine.plugin(focus);

Livewire.start();
