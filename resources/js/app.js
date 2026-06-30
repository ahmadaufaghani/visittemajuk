import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

window.Alpine = Alpine;
window.Livewire = Livewire;

Alpine.data('mobileMenu', () => ({
    open: false,

    init() {
        this.$watch('open', (open) => {
            document.body.classList.toggle('menu-open', open);
        });
    },

    destroy() {
        document.body.classList.remove('menu-open');
    },

    toggle() {
        this.open = !this.open;
    },

    close() {
        this.open = false;
    },

    closeFromLink(event) {
        if (event.target.closest('a')) {
            this.close();
        }
    },
}));

Alpine.data('publicCarousel', () => ({
    atEnd: false,
    atStart: true,
    current: 1,
    motionTimer: null,
    resizeHandler: null,
    total: 1,

    init() {
        this.resizeHandler = () => this.update();
        window.addEventListener('resize', this.resizeHandler);
        this.$nextTick(() => this.update());
    },

    destroy() {
        window.removeEventListener('resize', this.resizeHandler);
        window.clearTimeout(this.motionTimer);
    },

    get status() {
        return `${this.current} / ${this.total}`;
    },

    slides() {
        return Array.from(this.$root.querySelectorAll('.carousel-slide'));
    },

    stepSize() {
        const track = this.$refs.track;
        const first = this.slides()[0];

        if (!track || !first) {
            return 0;
        }

        const gap = parseFloat(getComputedStyle(track).columnGap || '0');

        return first.getBoundingClientRect().width + gap;
    },

    update() {
        const track = this.$refs.track;
        const slides = this.slides();

        if (!track || slides.length === 0) {
            this.current = 1;
            this.total = 1;
            this.atStart = true;
            this.atEnd = true;

            return;
        }

        const step = this.stepSize();

        this.total = slides.length;
        this.atStart = track.scrollLeft <= 4;
        this.atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
        this.current =
            this.atEnd && !this.atStart
                ? this.total
                : step
                  ? Math.min(this.total, Math.max(1, Math.round(track.scrollLeft / step) + 1))
                  : 1;
    },

    scheduleUpdate() {
        window.requestAnimationFrame(() => this.update());
    },

    scroll(direction) {
        const track = this.$refs.track;
        const step = this.stepSize();

        if (!track || !step) {
            return;
        }

        this.$root.dataset.motionDir = direction > 0 ? 'next' : 'prev';
        this.$root.classList.add('is-animating');
        window.clearTimeout(this.motionTimer);
        track.scrollBy({
            behavior: prefersReducedMotion() ? 'auto' : 'smooth',
            left: direction * step,
        });
        this.motionTimer = window.setTimeout(
            () => {
                this.$root.classList.remove('is-animating');
                delete this.$root.dataset.motionDir;
                this.update();
            },
            prefersReducedMotion() ? 0 : 560,
        );
    },
}));

Alpine.data('publicPagination', (config = {}) => ({
    current: 1,
    items: [],
    resizeHandler: null,
    total: 1,

    init() {
        this.items = Array.from(this.$refs.items?.children ?? []);
        this.resizeHandler = () => this.update();
        window.addEventListener('resize', this.resizeHandler);
        this.update();
    },

    destroy() {
        window.removeEventListener('resize', this.resizeHandler);
    },

    get status() {
        return `Page ${this.current} of ${this.total}`;
    },

    get isFirstPage() {
        return this.current === 1;
    },

    get isLastPage() {
        return this.current === this.total;
    },

    pageSize() {
        if (window.matchMedia('(max-width: 720px)').matches && config.pageSizeMobile) {
            return Number(config.pageSizeMobile);
        }

        if (window.matchMedia('(max-width: 1100px)').matches && config.pageSizeTablet) {
            return Number(config.pageSizeTablet);
        }

        if (config.pageSizeDesktop) {
            return Number(config.pageSizeDesktop);
        }

        return Number(config.pageSize || 6);
    },

    update() {
        const pageSize = Math.max(1, this.pageSize());

        this.total = Math.max(1, Math.ceil(this.items.length / pageSize));
        this.current = Math.min(this.current, this.total);

        this.items.forEach((item, index) => {
            item.hidden = index < (this.current - 1) * pageSize || index >= this.current * pageSize;
        });
    },

    previous() {
        this.current = Math.max(1, this.current - 1);
        this.update();
    },

    next() {
        this.current = Math.min(this.total, this.current + 1);
        this.update();
    },
}));

Alpine.data('publicAccordion', (config = {}) => ({
    openItem: config.defaultOpen || null,

    isOpen(item) {
        return this.openItem === item;
    },

    setOpen(item) {
        this.openItem = item;
    },

    toggle(item) {
        this.openItem = this.isOpen(item) ? null : item;
    },
}));

Alpine.data('revealMotion', () => ({
    visible: false,

    init() {
        if (!('IntersectionObserver' in window) || prefersReducedMotion()) {
            this.visible = true;

            return;
        }

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (!entry?.isIntersecting) {
                    return;
                }

                this.visible = true;
                observer.disconnect();
            },
            { threshold: 0.12 },
        );

        observer.observe(this.$el);
    },
}));

Livewire.start();
