@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => 'https://mi.fovipol.gob.pe'])
            {{ config('mail.from.name') }}
        @endcomponent
    @endslot

    @slot('content')
        @component($view, $parameters)

        @endcomponent
    @endslot

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer', ['contact_name' => 'Contáctenos', 'contact_address' => config('email.from.address')])
            &copy; {{ date('Y') }} {{ config('mail.from.name') }} todos los derechos reservados.
        @endcomponent
    @endslot

@endcomponent
