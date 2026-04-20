import './bootstrap';
import Alpine from 'alpinejs';
import Swup from 'swup';

window.Alpine = Alpine;
Alpine.start();

const swup = new Swup({
    animationSelector: '[class*="transition-"]',
    cache: true,
});