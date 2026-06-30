@props ([
    'brand' => __('Visit Temajuk'),
    'companyInfo' => __(
        'Temajuk Village is one of the main tourist destinations in Sambas Regency which also borders directly with Malaysia.'
    ),
    'contacts' => [__('+6281217741889'), __('Temajuk, Sambas Kalimantan'), __('Senin, 08:00 - Sabtu 18:00')],
    'partners' => [
        'Telkom University',
        'iCATS University College',
        'Politeknik Sambas',
        'Univ Panca Bhakti',
        'ICCS'
    ],
])

<footer class="site-footer">
    <div class="footer-glow" aria-hidden="true"></div>
    <div class="footer-grid container">
        <div>
            <a class="brand footer-brand" href="{{ route('home') }}">
                <span aria-hidden="true"></span>
                <strong>{{ $brand }}</strong>
            </a>
            <h3>{{ __('Company Info') }}</h3>
            <p>{{ $companyInfo }}</p>
        </div>

        <div>
            <h3>{{ __('Contacts') }}</h3>
            <ul class="footer-list">
                @foreach ($contacts as $contact)
                    <li>{{ $contact }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3>{{ __('ICCS Collaborated Program') }}</h3>
            <ul class="partner-grid">
                @foreach ($partners as $partner)
                    <li>{{ $partner }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        {{
            __(
                '(c) 2024 Visit Temajuk Village. All rights reserved.',
            )
        }}
    </div>
</footer>
