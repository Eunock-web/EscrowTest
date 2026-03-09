@extends('layouts.app')

@section('title', 'Paiement – ' . $product->nom . ' — PixelVault')

@section('styles')
{{-- FedaPay checkout.js — chargé dans le head pour être disponible avant le JS inline --}}
<script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
<style>
    /* ─── Checkmark animation ─── */
    @keyframes pop-in {
        0%   { transform: scale(0.5); opacity: 0; }
        80%  { transform: scale(1.1); }
        100% { transform: scale(1);   opacity: 1; }
    }
    @keyframes pulse-ring {
        0%   { transform: scale(1);   opacity: 0.6; }
        100% { transform: scale(1.6); opacity: 0; }
    }
    @keyframes shimmer {
        0%   { background-position: -400px 0; }
        100% { background-position:  400px 0; }
    }

    .checkout-card {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 24px;
    }

    .divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.06);
        margin: 20px 0;
    }

    /* Pay button */
    #btn-pay {
        background: linear-gradient(135deg, #7c3aed 0%, #06b6d4 100%);
        border: none;
        border-radius: 14px;
        color: #fff;
        cursor: pointer;
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .04em;
        padding: 16px 0;
        width: 100%;
        transition: opacity .2s, transform .2s;
        position: relative;
        overflow: hidden;
    }
    #btn-pay:hover:not(:disabled) { opacity: .9; transform: translateY(-1px); }
    #btn-pay:disabled { opacity: .55; cursor: not-allowed; transform: none; }
    #btn-pay .shimmer-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.18), transparent);
        background-size: 400px 100%;
        animation: shimmer 1.6s infinite;
        display: none;
    }
    #btn-pay.loading .shimmer-overlay { display: block; }

    /* Security badges */
    .badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .03em;
    }
    .badge-green { background: rgba(16,185,129,.07); color: #10b981; border: 1px solid rgba(16,185,129,.15); }
    .badge-blue  { background: rgba(6,182,212,.07);  color: #06b6d4;  border: 1px solid rgba(6,182,212,.15); }
    .badge-violet{ background: rgba(124,58,237,.07); color: #a78bfa;  border: 1px solid rgba(124,58,237,.15); }

    /* Success / error state panel */
    #status-panel { display: none; }
    #status-panel.show { display: block; }

    .checkmark-wrap {
        width: 72px; height: 72px; border-radius: 50%;
        background: rgba(16,185,129,.1);
        display: flex; align-items: center; justify-content: center;
        position: relative;
        margin: 0 auto 20px;
        animation: pop-in .4s ease-out forwards;
    }
    .checkmark-wrap::before {
        content: '';
        position: absolute; inset: -8px;
        border-radius: 50%;
        border: 2px solid rgba(16,185,129,.3);
        animation: pulse-ring 1.2s ease-out infinite;
    }

    .errormark-wrap {
        width: 72px; height: 72px; border-radius: 50%;
        background: rgba(239,68,68,.1);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        animation: pop-in .4s ease-out forwards;
    }

    /* Product image container */
    .product-img {
        width: 100%; aspect-ratio: 16/9;
        border-radius: 16px; overflow: hidden;
        background: #0d0d14;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(255,255,255,.05);
    }
    .product-img img { width: 100%; height: 100%; object-fit: cover; }
</style>
@endsection

@section('content')
{{-- ─── Back link ─── --}}
<div class="mb-8">
    <a href="{{ url()->previous() }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour
    </a>
</div>

<div class="max-w-4xl mx-auto animate-fade">
    <h1 class="font-display text-3xl font-800 text-white mb-8 text-center">
        Finaliser votre <span class="g">achat</span>
    </h1>

    <div class="grid lg:grid-cols-5 gap-8 items-start">

        {{-- ─── LEFT: Product summary ─── --}}
        <div class="lg:col-span-3">
            <div class="checkout-card p-6">
                <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-4">Résumé de la commande</p>

                {{-- Product image --}}
                <div class="product-img mb-5">
                    @if($product->url_image)
                        <img src="{{ Str::startsWith($product->url_image, ['http://', 'https://']) ? $product->url_image : asset('storage/' . $product->url_image) }}" alt="{{ $product->nom }}">
                    @else
                        <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>

                {{-- Product name & category --}}
                <div class="text-xs font-semibold text-violet-400 uppercase tracking-widest mb-1">
                    {{ $product->categorie->nom ?? 'Produit numérique' }}
                </div>
                <h2 class="text-xl font-bold text-white font-display mb-4">{{ $product->nom }}</h2>

                @if($product->description)
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">{{ Str::limit($product->description, 160) }}</p>
                @endif

                <hr class="divider">

                {{-- Price breakdown --}}
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-slate-400">
                        <span>Prix du produit</span>
                        <span>{{ number_format($product->prix, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span>Frais de service</span>
                        <span class="text-emerald-400">Inclus</span>
                    </div>
                    <hr class="divider">
                    <div class="flex justify-between text-white font-bold text-base">
                        <span>Total</span>
                        <span class="text-2xl">{{ number_format($product->prix, 0, ',', ' ') }} <span class="text-slate-400 text-sm font-normal">XOF</span></span>
                    </div>
                </div>

                <hr class="divider">

                {{-- Delivery info --}}
                <div class="flex items-center gap-3 text-sm">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-slate-400">Livraison <strong class="text-emerald-400">instantanée</strong> après paiement confirmé</span>
                </div>
            </div>
        </div>

        {{-- ─── RIGHT: Payment action ─── --}}
        <div class="lg:col-span-2">
            <div class="checkout-card p-6">

                {{-- Payment panel (default) --}}
                <div id="pay-panel">
                    <p class="text-xs text-slate-500 uppercase tracking-widest font-bold mb-5">Paiement sécurisé</p>

                    {{-- Security badges --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="badge badge-green">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Crypté SSL
                        </span>
                        <span class="badge badge-blue">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V5zm1 1v8h12V6H4z" clip-rule="evenodd"/>
                            </svg>
                            Mobile Money
                        </span>
                        <span class="badge badge-violet">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            FedaPay Escrow
                        </span>
                    </div>

                    {{-- Amount display --}}
                    <div class="text-center my-6">
                        <p class="text-slate-400 text-sm mb-1">Montant à payer</p>
                        <p class="text-4xl font-bold text-white font-display">
                            {{ number_format($product->prix, 0, ',', ' ') }}
                            <span class="text-slate-400 text-lg font-normal">XOF</span>
                        </p>
                    </div>

                    {{-- Error alert (hidden by default) --}}
                    <div id="error-alert" class="hidden mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm text-center"></div>

                    {{-- Pay button --}}
                    <button id="pay-btn" type="button">
                        <span class="shimmer-overlay"></span>
                        <span id="btn-label" class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Payer maintenant
                        </span>
                    </button>

                    {{-- Secure note --}}
                    <p id="secure-note" class="text-center text-slate-500 text-xs mt-4 leading-relaxed">
                        Le formulaire de paiement s'affichera de manière sécurisée ci-dessous sans redirection.<br>
                        Votre paiement est protégé par <strong class="text-slate-400">FedaPay Escrow</strong>.
                    </p>
                </div>

                {{-- Conteneur FedaPay Embarqué --}}
                <div id="embed" class="w-full mt-4" style="display: none; min-height: 650px; background: #ffffff; border-radius: 16px; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);"></div>

                {{-- Success panel (hidden) --}}
                <div id="status-panel">
                    <div id="success-content" class="hidden text-center py-4">
                        <div class="checkmark-wrap">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-xl font-display mb-2">Paiement reçu !</h3>
                        <p class="text-slate-400 text-sm mb-6">Redirection vers vos achats…</p>
                        <div class="w-8 h-8 border-2 border-t-violet-500 border-violet-500/20 rounded-full animate-spin mx-auto"></div>
                    </div>

                    <div id="error-content" class="hidden text-center py-4">
                        <div class="errormark-wrap">
                            <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-xl font-display mb-2">Paiement annulé</h3>
                        <p class="text-slate-400 text-sm mb-6">Le paiement n'a pas abouti ou a été annulé.</p>
                        <button onclick="resetCheckout()" class="w-full py-3 rounded-xl border border-slate-700 text-slate-300 hover:text-white hover:border-slate-500 transition-colors text-sm font-semibold">
                            Réessayer
                        </button>
                    </div>
                </div>

            </div>{{-- checkout-card --}}
        </div>

    </div>{{-- grid --}}
</div>
@endsection

@section('scripts')

<script>
    // ─── Config injected server-side (clé PUBLIQUE uniquement) ─────────
    const FEDAPAY_PUBLIC_KEY = @json($publicKey);
    const CALLBACK_URL       = @json($callbackUrl);
    const CSRF_TOKEN         = @json(csrf_token());
    const PRODUCT_ID         = @json($product->id);

    // ─── DOM refs ───────────────────────────────────────────────────────
    const btnPay      = document.getElementById('pay-btn');
    const btnLabel    = document.getElementById('btn-label');
    const errorAlert  = document.getElementById('error-alert');
    const payPanel    = document.getElementById('pay-panel');
    const statusPanel = document.getElementById('status-panel');

    // ─── State helpers ────────────────────────────────────────────────
    function setLoading(on) {
        btnPay.disabled = on;
        btnPay.classList.toggle('loading', on);
        btnLabel.innerHTML = on
            ? '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg> Chargement…'
            : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Payer maintenant';
    }

    function showError(msg) {
        errorAlert.textContent = msg;
        errorAlert.classList.remove('hidden');
    }

    function hideError() {
        errorAlert.classList.add('hidden');
        errorAlert.textContent = '';
    }

    function showStatus(type) {
        payPanel.style.display = 'none';
        statusPanel.classList.add('show');
        document.getElementById(type + '-content').classList.remove('hidden');
    }

    function resetCheckout() {
        payPanel.style.display = 'block';
        statusPanel.classList.remove('show');
        document.getElementById('success-content').classList.add('hidden');
        document.getElementById('error-content').classList.add('hidden');

        btnPay.style.display = 'block';
        document.getElementById('secure-note').style.display = 'block';
        document.getElementById('embed').style.display = 'none';
        document.getElementById('embed').innerHTML = ''; // Reset the iframe container

        setLoading(false);
        hideError();
    }

    // ─── Main flow: click → AJAX → FedaPay popup ──────────────────────
    btnPay.addEventListener('click', async () => {
        hideError();
        setLoading(true);

        try {
            // 1. Demander un token à notre serveur (clé secrète reste côté PHP)
            const res = await fetch('/pay/initiate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                body: JSON.stringify({ product_id: PRODUCT_ID }),
            });

            const data = await res.json();

            if (!res.ok || !data.success) {
                throw new Error(data.message || 'Erreur serveur');
            }

            // Hide the pay button to show the embedded payment form
            btnPay.style.display = 'none';
            document.getElementById('secure-note').style.display = 'none';
            document.getElementById('embed').style.display = 'block';

            // 2. Ouvrir le widget FedaPay avec le token reçu
            FedaPay.init({
                public_key:   FEDAPAY_PUBLIC_KEY,
                transaction: {
                    token: data.token,
                    amount: {{ $product->prix }},
                    description: 'Achat de : ' + @json($product->nom),
                    currency: {
                        iso: 'XOF'
                    }
                },
                customer: {
                    email: "{{ auth()->user()->email }}",
                    firstname: "{{ auth()->user()->firstname }}",
                    lastname: "{{ auth()->user()->lastname }}"
                },
                container: '#embed',
                // ─── Callbacks ───────────────────────────────────────
                onComplete: function(transaction) {
                    if (transaction.reason === FedaPay.DIALOG_DISMISSED) {
                        // Fermé sans payer
                        setLoading(false);
                        showStatus('error');
                        return;
                    }

                    if (transaction.reason === FedaPay.CHECKOUT_COMPLETED) {
                        // Paiement soumis → afficher succès puis rediriger vers callback
                        document.getElementById('embed').style.display = 'none';
                        showStatus('success');
                        // On redirige vers le callback Laravel
                        setTimeout(() => {
                            window.location.href = CALLBACK_URL
                                + '?id='     + transaction.transaction.id
                                + '&status=' + transaction.transaction.status;
                        }, 1800);
                    }
                },
            }); // Ne pas appeler .open() avec le mode embarqué

            setLoading(false);

        } catch (err) {
            console.error('[Checkout] Erreur :', err);
            showError(err.message || "Une erreur est survenue. Veuillez réessayer.");
            setLoading(false);
        }
    });
</script>
@endsection
