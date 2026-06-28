import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('disclosure', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    },
}));

Alpine.start();
