@extends('layouts.app')

@section('title', isset($product) ? 'PixelVault — Modifier le produit' : 'PixelVault — Créer un produit')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #cur{width:10px;height:10px;background:#7c3aed;border-radius:50%;position:fixed;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:.15s width,.15s height;mix-blend-mode:screen;}
    #ring{width:32px;height:32px;border:1px solid rgba(124,58,237,.4);border-radius:50%;position:fixed;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);}
    .g2{background:linear-gradient(135deg,#f59e0b,#34d399);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
    .grid-bg{background-image:linear-gradient(rgba(124,58,237,.035) 1px,transparent 1px),linear-gradient(90deg,rgba(124,58,237,.035) 1px,transparent 1px);background-size:60px 60px;}

    @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
    @keyframes panelIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
    @keyframes tagPop{from{transform:scale(0)}60%{transform:scale(1.1)}to{transform:scale(1);opacity:1}}
    @keyframes scalePop{0%{transform:scale(0) rotate(-5deg);opacity:0}60%{transform:scale(1.1)}100%{transform:scale(1);opacity:1}}
    @keyframes checkDraw{0%{stroke-dashoffset:60;opacity:0}40%{opacity:1}100%{stroke-dashoffset:0}}
    @keyframes confetti{0%{transform:translateY(0) rotate(0);opacity:1}100%{transform:translateY(-110px) rotate(720deg);opacity:0}}
    
    /* ── Sub Navigation (Steps) ── */
    .steps-container {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 32px;
        background: rgba(255, 255, 255, 0.03);
        padding: 8px 16px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        width: fit-content;
    }
    .si{display:flex;align-items:center;gap:10px;padding:8px 16px;border-radius:12px;cursor:pointer;transition:all .2s;}
    .si:hover{background:rgba(124,58,237,.07);}
    .si.active{background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.2);}
    .si.done{background:rgba(16,185,129,.05);}
    .sn{width:22px;height:22px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:10px;border:1.5px solid #1e1e2e;color:#64748b;transition:all .3s;flex-shrink:0;}
    .si.active .sn{background:#7c3aed;border-color:#7c3aed;color:#fff;}
    .si.done .sn{background:rgba(16,185,129,.15);border-color:rgba(16,185,129,.4);color:#34d399;}
    .sl{font-size:12px;font-weight:600;color:#64748b;transition:color .2s;}
    .si.active .sl,.si.done .sl{color:#e2e8f0;}

    /* ── Progress bar ── */
    .pbar{height:3px;border-radius:2px;background:#1e1e2e;overflow:hidden; margin-bottom: 32px; max-width: 400px;}
    .pfill{height:100%;border-radius:2px;background:linear-gradient(90deg,#7c3aed,#06b6d4);transition:width 1s cubic-bezier(.22,1,.36,1);}

    .panel{max-width:820px;}

    /* ── Card surface ── */
    .surf{background:rgba(17,17,24,.7);backdrop-filter: blur(10px); border:1px solid #1e1e2e;border-radius:20px;position:relative;overflow:hidden;}
    .surf::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 50% 0%,rgba(124,58,237,.05),transparent 55%);pointer-events:none;}

    /* ── Field label ── */
    .lbl{display:block;font-size:11px;font-weight:600;color:#94a3b8;letter-spacing:.07em;text-transform:uppercase;margin-bottom:7px;}
    .hint{font-size:11px;color:#64748b;margin-top:4px;}

    /* ── Input ── */
    .iw{position:relative;background:rgba(255,255,255,.03);border:1.5px solid #1e1e2e;border-radius:13px;transition:border-color .2s,box-shadow .2s;}
    .iw:focus-within{border-color:rgba(124,58,237,.6);box-shadow:0 0 0 3px rgba(124,58,237,.08);}
    .iw.v{border-color:rgba(16,185,129,.35);}
    .ii{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#2e2e48;pointer-events:none;transition:color .2s;}
    .iw:focus-within .ii{color:#a78bfa;}
    input.fi,textarea.fi,select.fi{background:transparent;border:none;outline:none;color:#e2e8f0;font-family:'DM Sans',sans-serif;font-size:14px;width:100%;}
    input.fi,select.fi{padding:13px 14px 13px 44px;}
    input.fi::placeholder,textarea.fi::placeholder{color:#2a2a3e;}
    select.fi{cursor:pointer;}
    select.fi option{background:#111118;}
    textarea.fi{padding:13px 14px 13px 44px;resize:none;}

    /* Rich editor toolbar */
    .toolbar{background:rgba(255,255,255,.03);border-bottom:1px solid #1e1e2e;padding:8px 10px;display:flex;gap:4px;flex-wrap:wrap;}
    .tb{width:27px;height:27px;border-radius:6px;border:none;background:transparent;color:#64748b;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;font-family:'DM Sans',sans-serif;transition:all .2s;}
    .tb:hover{background:rgba(124,58,237,.15);color:#a78bfa;}
    .tb-sep{width:1px;height:20px;background:#1e1e2e;margin:0 3px;}

    /* ── Upload zone ── */
    .uzone{border:2px dashed rgba(124,58,237,.25);border-radius:16px;cursor:pointer;transition:all .3s;position:relative;overflow:hidden;}
    .uzone:hover,.uzone.drag{border-color:rgba(124,58,237,.65);background:rgba(124,58,237,.05);}
    .uzone.loaded{border-style:solid;border-color:rgba(16,185,129,.4);background:rgba(16,185,129,.03);}
    .uzone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}

    /* ── Category cards ── */
    .cat{border:1.5px solid #1e1e2e;border-radius:13px;padding:14px 10px;cursor:pointer;transition:all .2s;text-align:center;position:relative;}
    .cat:hover{border-color:rgba(124,58,237,.35);background:rgba(124,58,237,.05);}
    .cat.sel{border-color:#7c3aed;background:rgba(124,58,237,.1);box-shadow:0 0 0 3px rgba(124,58,237,.1);}
    .cat .ck{position:absolute;top:7px;right:7px;opacity:0;transition:opacity .2s;}
    .cat.sel .ck{opacity:1;}

    /* ── Tag input ── */
    .tagbox{background:rgba(255,255,255,.03);border:1.5px solid #1e1e2e;border-radius:13px;padding:8px 10px;display:flex;flex-wrap:wrap;gap:6px;align-items:center;min-height:48px;cursor:text;transition:border-color .2s,box-shadow .2s;}
    .tagbox:focus-within{border-color:rgba(124,58,237,.6);box-shadow:0 0 0 3px rgba(124,58,237,.08);}
    .tag{display:inline-flex;align-items:center;gap:5px;background:rgba(124,58,237,.14);border:1px solid rgba(124,58,237,.3);border-radius:6px;padding:3px 9px;color:#a78bfa;font-size:12px;font-weight:500;animation:tagPop .2s ease both;}
    .tag-x{color:#7c3aed;cursor:pointer;font-size:13px;line-height:1;transition:color .15s;}
    .tag-x:hover{color:#f87171;}
    input.taginp{background:transparent;border:none;outline:none;color:#e2e8f0;font-family:'DM Sans',sans-serif;font-size:13px;min-width:100px;flex:1;padding:3px 4px;}

    /* ── License option ── */
    .lic{border:1.5px solid #1e1e2e;border-radius:14px;padding:14px 16px;cursor:pointer;transition:all .2s;}
    .lic:hover{border-color:rgba(124,58,237,.3);}
    .lic.sel{border-color:#7c3aed;background:rgba(124,58,237,.08);}
    .lrad{width:18px;height:18px;border-radius:50%;border:1.5px solid #3f3f5a;display:flex;align-items:center;justify-content:center;transition:all .2s;flex-shrink:0;}
    .lic.sel .lrad{border-color:#7c3aed;background:#7c3aed;}

    /* ── Pricing toggle ── */
    .ptog{display:inline-flex;background:#111118;border:1px solid #1e1e2e;border-radius:10px;padding:3px;gap:2px;}
    .ptb{padding:7px 16px;border-radius:7px;font-size:12px;font-weight:500;cursor:pointer;transition:all .25s;color:#64748b;border:none;background:transparent;font-family:'DM Sans',sans-serif;}
    .ptb.on{background:#7c3aed;color:#fff;box-shadow:0 0 12px rgba(124,58,237,.4);}

    /* ── Price field ── */
    .pfield{display:flex;}
    .ppfx{background:rgba(255,255,255,.04);border:1.5px solid #1e1e2e;border-right:none;border-radius:13px 0 0 13px;padding:13px 14px;color:#64748b;font-size:14px;}
    .pinp{background:rgba(255,255,255,.03);border:1.5px solid #1e1e2e;border-left:none;border-radius:0 13px 13px 0;flex:1;padding:13px 14px;color:#e2e8f0;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;outline:none;transition:border-color .2s,box-shadow .2s;}

    /* ── Preview card ── */
    .prev-card{background:#111118;border:1px solid #1e1e2e;border-radius:18px;overflow:hidden;transition:transform .3s,box-shadow .3s;}
    .prev-card:hover{transform:translateY(-4px);box-shadow:0 16px 44px rgba(124,58,237,.14);}

    /* ── Checklist item ── */
    .ck-item{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:12px;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05);}

    /* ── Quality score bar ── */
    .qbar{height:4px;border-radius:2px;background:#1e1e2e;overflow:hidden;}
    .qfill{height:100%;border-radius:2px;background:linear-gradient(90deg,#7c3aed,#06b6d4);transition:width 1s cubic-bezier(.22,1,.36,1);}

    /* ── Publish option ── */
    .pubopt{border:1.5px solid #1e1e2e;border-radius:14px;padding:16px;cursor:pointer;transition:all .2s;}
    .pubopt:hover{border-color:rgba(124,58,237,.35);background:rgba(124,58,237,.04);}
    .pubopt.sel{border-color:#7c3aed;background:rgba(124,58,237,.09);}

    /* ── Buttons ── */
    .btn{background:linear-gradient(135deg,#7c3aed,#5b21b6);border:none;cursor:pointer;position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s;font-family:'Syne',sans-serif;font-weight:700;color:#fff;}
    .btn::before{content:'';position:absolute;inset:0;background:linear-gradient(100deg,transparent 40%,rgba(255,255,255,.17) 50%,transparent 60%);background-size:200% 100%;animation:shimmer 2.5s infinite;}
    .btn:hover{transform:translateY(-2px);box-shadow:0 0 26px rgba(124,58,237,.5);}
    .btn:disabled{opacity:.35;pointer-events:none;}
    .btn-out{background:transparent;border:1px solid rgba(124,58,237,.3);cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;font-weight:500;color:#94a3b8;}
    .btn-out:hover{border-color:rgba(124,58,237,.6);background:rgba(124,58,237,.07);color:#e2e8f0;}

    /* ── Success ── */
    .suc-ring{width:80px;height:80px;border-radius:50%;background:rgba(16,185,129,.1);border:2px solid rgba(16,185,129,.35);display:flex;align-items:center;justify-content:center;animation:scalePop .6s cubic-bezier(.34,1.56,.64,1) both;}
    .chk-svg{animation:checkDraw .6s .25s ease both;stroke-dasharray:60;stroke-dashoffset:60;}
    .conf-dot{position:absolute;animation:confetti 1.2s ease forwards;}

    .spinner{width:17px;height:17px;border-radius:50%;border:2px solid rgba(255,255,255,.2);border-top-color:#fff;animation:spin .6s linear infinite;}
</style>
@endsection

@section('content')
    <div class="animate-fade">
        <!-- Sub Nav (Steps) -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
            <div class="steps-container">
                <div class="si active" id="si1" onclick="goTo(1)">
                    <div class="sn" id="sn1">1</div>
                    <div class="sl">Infos</div>
                </div>
                <div class="text-[#1e1e2e]">/</div>
                <div class="si" id="si2" onclick="goTo(2)">
                    <div class="sn" id="sn2">2</div>
                    <div class="sl">Médias</div>
                </div>
                <div class="text-[#1e1e2e]">/</div>
                <div class="si" id="si3" onclick="goTo(3)">
                    <div class="sn" id="sn3">3</div>
                    <div class="sl">Prix</div>
                </div>
                <div class="text-[#1e1e2e]">/</div>
                <div class="si" id="si4" onclick="goTo(4)">
                    <div class="sn" id="sn4">4</div>
                    <div class="sl">Publier</div>
                </div>
            </div>

            <div class="flex items-center gap-4 mb-8 md:mb-0">
                <button onclick="saveDraft()" class="text-xs text-slate-500 hover:text-white transition-colors" id="draftBtn">Sauvegarder brouillon</button>
                <a href="{{ route('allProduct') }}" class="text-xs text-slate-500 hover:text-red-400 transition-colors">Annuler</a>
            </div>
        </div>

        <div class="pbar"><div class="pfill" id="navProg" style="width:25%;"></div></div>

        <!-- ══════ PANEL 1 — Informations ══════ -->
        <div id="p1" class="panel">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-white mb-1">{{ isset($product) ? 'Modifier' : 'Informations' }} <span class="g">{{ isset($product) ? 'le produit' : 'générales' }}</span></h1>
                <p class="text-slate-500 text-sm">Présentez votre produit de façon claire et attractive.</p>
            </div>

            <!-- Title & Tagline -->
            <div class="surf p-8 mb-6">
                <div class="lbl mb-4">Titre du produit <span class="text-red-500">*</span></div>
                <div class="iw mb-4" id="wTitle">
                    <div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg></div>
                    <input class="fi" type="text" id="prodTitle" name="nom" value="{{ $product->nom ?? '' }}" placeholder="ex: SaaS Dashboard Pro — Kit UI Figma complet" maxlength="80" oninput="onTitle(this)"/>
                </div>
                <div class="flex justify-between items-center text-[10px] text-slate-600">
                    <span>Soyez précis et spécifique.</span>
                    <span id="titleCnt">0/80</span>
                </div>
            </div>

            <!-- Description -->
            <div class="surf mb-6">
                <div class="toolbar">
                    <button class="tb"><b>B</b></button>
                    <button class="tb"><i>I</i></button>
                    <div class="tb-sep"></div>
                    <button class="tb">≡</button>
                    <button class="tb">🔗</button>
                </div>
                <div class="p-6">
                    <label class="lbl">Description <span class="text-red-500">*</span></label>
                    <textarea class="fi min-h-[160px]" id="desc" name="description" placeholder="Décrivez votre produit..." oninput="cntDesc()">{{ $product->description ?? '' }}</textarea>
                    <div class="flex justify-between mt-2 text-[10px] text-slate-600">
                        <span>Min. 100 caractères recommandés.</span>
                        <span id="descCnt">0 car.</span>
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div class="surf p-8 mb-10">
                <input type="hidden" name="categorie_id" id="categorie_id" value="{{ $product->categorie_id ?? '' }}">
                <label class="lbl mb-6 text-center">Catégorie <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4" id="catGrid">
                    @foreach($categories as $category)
                        <div class="cat" onclick="pickCat(this,'{{ $category->categorie }}','📦', {{ $category->id }})">
                            <div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                            <div class="text-xl mb-1">📦</div>
                            <div class="text-[10px] text-slate-400 uppercase font-bold">{{ $category->categorie }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <button class="btn px-8 py-3 rounded-xl text-sm" onclick="goTo(2)">{{ isset($product) ? 'Suivant' : 'Continuer' }} →</button>
            </div>
        </div>

        <!-- ══════ PANEL 2 — Médias ══════ -->
        <div id="p2" style="display:none;" class="panel">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-white mb-1">Médias & <span class="g">Fichiers</span></h1>
                <p class="text-slate-500 text-sm">Les produits avec de meilleures visuels se vendent mieux.</p>
            </div>

            <div class="surf p-8 mb-6">
                <label class="lbl mb-4">Image de couverture <span class="text-red-500">*</span></label>
                <div class="uzone p-12" id="coverZone">
                    <input type="file" name="image" id="prodImage" accept="image/*" onchange="loadCover(this)"/>
                    <div id="coverEmpty" class="text-center" style="{{ isset($product->url_image) ? 'display:none;' : '' }}">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg width="20" height="20" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-300">Glissez votre image</p>
                        <p class="text-xs text-slate-500 mt-1">PNG, JPG ou WEBP (Max 5Mo)</p>
                    </div>
                    <div id="coverLoaded" style="{{ isset($product->url_image) ? 'display:block;' : 'display:none;' }}" class="text-center">
                        <div class="text-emerald-400 text-2xl mb-2">✓</div>
                        <p class="text-xs font-bold text-emerald-400" id="coverFn">{{ isset($product->url_image) ? 'Image actuelle conservée' : 'Image chargée' }}</p>
                    </div>
                </div>
            </div>

            <div class="surf p-8 mb-10">
                <label class="lbl mb-4">Fichiers du produit <span class="text-red-500">*</span></label>
                <div class="uzone p-8" id="fileZone">
                    <input type="file" multiple onchange="loadFiles(this)"/>
                    <div id="fileEmpty" class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/20 flex items-center justify-center">
                             <svg width="18" height="18" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-300">Sélectionnez vos fichiers</p>
                            <p class="text-[10px] text-slate-500">ZIP, PDF, etc. (Max 500Mo)</p>
                        </div>
                    </div>
                    <div id="fileList" class="space-y-2"></div>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button class="btn-out px-6 py-2.5 rounded-xl text-xs" onclick="goTo(1)">← Retour</button>
                <button class="btn px-8 py-3 rounded-xl text-sm" onclick="goTo(3)">Continuer →</button>
            </div>
        </div>

        <!-- ══════ PANEL 3 — Prix ══════ -->
        <div id="p3" style="display:none;" class="panel">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-white mb-1">Prix & <span class="g">Licence</span></h1>
                <p class="text-slate-500 text-sm">Définissez votre modèle tarifaire.</p>
            </div>

            <div class="surf p-8 mb-6">
                <div class="ptog mb-8">
                    <button class="ptb on" id="pt-paid" onclick="setPriceMode('paid')">Payant</button>
                    <button class="ptb" id="pt-free" onclick="setPriceMode('free')">Gratuit</button>
                </div>

                <div id="paidForm">
                    <label class="lbl">Prix de vente (€)</label>
                    <div class="pfield mb-6">
                        <div class="ppfx">€</div>
                        <input class="pinp" type="number" id="price" name="prix" value="{{ $product->prix ?? '' }}" placeholder="0.00" oninput="calcEarnings()"/>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="metric p-4 border border-white/5 rounded-xl">
                            <p class="text-[10px] text-slate-500 font-bold uppercase mb-1">Prix</p>
                            <p class="text-xl font-bold text-white" id="ePrice">—</p>
                        </div>
                        <div class="metric p-4 border border-white/5 rounded-xl">
                            <p class="text-[10px] text-slate-500 font-bold uppercase mb-1">Frais</p>
                            <p class="text-xl font-bold text-red-400" id="eComm">—</p>
                        </div>
                        <div class="metric p-4 border border-purple-500/20 bg-purple-500/5 rounded-xl">
                            <p class="text-[10px] text-purple-400 font-bold uppercase mb-1">Vos gains</p>
                            <p class="text-xl font-bold text-emerald-400" id="eYou">—</p>
                        </div>
                    </div>
                </div>
                
                <div id="freeForm" style="display:none;" class="text-center py-12">
                    <div class="text-4xl mb-4">🎁</div>
                    <p class="text-lg font-bold text-white">Produit Gratuit</p>
                    <p class="text-sm text-slate-500 mt-2">Construisez votre audience avec du contenu gratuit.</p>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button class="btn-out px-6 py-2.5 rounded-xl text-xs" onclick="goTo(2)">← Retour</button>
                <button class="btn px-8 py-3 rounded-xl text-sm" onclick="goTo(4)">Continuer →</button>
            </div>
        </div>

        <!-- ══════ PANEL 4 — Publication (Preview) ══════ -->
        <div id="p4" style="display:none;" class="panel">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-white mb-1">Publication</h1>
                <p class="text-slate-500 text-sm">Vérifiez les détails avant de mettre en ligne.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                <div class="prev-card" style="max-width:320px;">
                    <div class="h-44 bg-slate-800 flex items-center justify-center relative" id="prevCover">
                        <div class="absolute top-4 left-4"><span id="prevCatBadge" class="px-2 py-0.5 bg-black/40 backdrop-blur-md rounded text-[10px] font-bold text-white border border-white/10 uppercase italic">CATÉGORIE</span></div>
                        <div class="text-5xl" id="prevEmoji">✨</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-white truncate mb-1" id="prevTitle">Nom du produit</h3>
                        <p class="text-xs text-slate-500 mb-4">par {{ Auth::user()->pseudo }}</p>
                        <div class="flex justify-between items-center">
                             <div class="text-xs text-amber-400">★★★★★</div>
                             <div class="text-lg font-extrabold text-white" id="prevPrice">—</div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="ck-item" id="cki-title">
                        <div id="cki-title-ico" class="w-5 h-5 rounded-full bg-slate-800 flex items-center justify-center shrink-0">✕</div>
                        <span class="text-xs text-slate-400" id="cki-title-txt">Titre : manquant</span>
                    </div>
                    <div class="ck-item" id="cki-desc">
                        <div id="cki-desc-ico" class="w-5 h-5 rounded-full bg-slate-800 flex items-center justify-center shrink-0">✕</div>
                        <span class="text-xs text-slate-400" id="cki-desc-txt">Description : manquante</span>
                    </div>
                    <div class="ck-item" id="cki-cat">
                         <div id="cki-cat-ico" class="w-5 h-5 rounded-full bg-slate-800 flex items-center justify-center shrink-0">✕</div>
                         <span class="text-xs text-slate-400" id="cki-cat-txt">Catégorie : non sélectionnée</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button class="btn-out px-6 py-2.5 rounded-xl text-xs" onclick="goTo(3)">← Retour</button>
                <button class="btn px-10 py-4 rounded-xl text-sm flex items-center gap-3 shadow-xl shadow-purple-500/30" id="pubBtn" onclick="publish()">
                    <span>{{ isset($product) ? '💾 Enregistrer les modifications' : '🚀 Publier le produit' }}</span>
                    <div class="spinner" id="pubSpin" style="display:none;"></div>
                </button>
            </div>
        </div>

        <!-- ══════ SUCCESS ══════ -->
        <div id="pOK" style="display:none;" class="text-center py-20 animate-fade">
             <div class="suc-ring mx-auto mb-6">
                <svg width="36" height="36" viewBox="0 0 40 40" fill="none"><path class="chk-svg" d="M10 20 L17 27 L30 13" stroke="#34d399" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
             </div>
              <h2 class="text-4xl font-extrabold text-white mb-2">{{ isset($product) ? 'Produit modifié !' : 'Produit publié !' }}</h2>
             <p class="text-slate-500 mb-10" id="okTitle">{{ isset($product) ? 'Vos modifications ont été enregistrées avec succès.' : 'Votre création numérique est maintenant sur PixelVault.' }}</p>
             <div class="flex justify-center gap-4">
                 <a href="{{ route('allProduct') }}" class="btn px-8 py-3 rounded-xl text-sm">Voir mes produits</a>
                 <button  class="btn-out px-8 py-3 rounded-xl text-sm"><a href="{{ route('createProduct') }}">En ajouter un autre</a></button>
             </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let curStep=1,selCat='',selCatEmoji='',selLic='p',pubOpt='now',hasCover={{ isset($product) ? 'true' : 'false' }},hasFile=false;
    const productId = {{ $product->id ?? 'null' }};

    function goTo(n){
        [1,2,3,4,'OK'].forEach(i=>{const el=document.getElementById('p'+i);if(el)el.style.display='none';});
        const t=document.getElementById('p'+n);
        if(t){t.style.display='block';t.style.animation='panelIn .35s ease both';}
        curStep=n; updSidebar(n); updProgress(n);
        if(n===4)updChecklist();
        window.scrollTo({top:0,behavior:'smooth'});
    }

    function updSidebar(n){
        [1,2,3,4].forEach(i=>{
            const si=document.getElementById('si'+i),sn=document.getElementById('sn'+i);
            if(!si)return;
            if(i<n) si.className='si done';
            else if(i===n) si.className='si active';
            else si.className='si';
        });
    }

    function updProgress(n){
        document.getElementById('navProg').style.width=(n/4*100)+'%';
    }

    function onTitle(inp){
        document.getElementById('titleCnt').textContent=inp.value.length+'/80';
        document.getElementById('prevTitle').textContent=inp.value||'Nom du produit';
    }

    function cntDesc(){
        document.getElementById('descCnt').textContent=document.getElementById('desc').value.length+' car.';
    }

    function pickCat(el,name,emoji, id){
        document.querySelectorAll('.cat').forEach(c=>c.classList.remove('sel'));
        el.classList.add('sel'); 
        selCat=name; 
        selCatEmoji=emoji;
        document.getElementById('categorie_id').value = id;
        document.getElementById('prevCatBadge').textContent=name.toUpperCase();
        selCat = name;
    }

    window.addEventListener('DOMContentLoaded', () => {
        if(productId) {
            const catId = document.getElementById('categorie_id').value;
            const catEl = document.querySelector(`.cat[onclick*="${catId}"]`);
            if(catEl) catEl.click();
            
            // Trigger pre-population for preview
            onTitle(document.getElementById('prodTitle'));
            cntDesc();
            calcEarnings();

            @if(isset($product->url_image))
                const d = document.getElementById('prevCover');
                d.style.backgroundImage = 'url(/storage/{{ $product->url_image }})';
                d.style.backgroundSize = 'cover';
                d.style.backgroundPosition = 'center';
                document.getElementById('prevEmoji').style.display = 'none';
            @endif
        }
    });

    function loadCover(inp){
        if(!inp.files||!inp.files[0])return;
        hasCover=true;
        document.getElementById('coverEmpty').style.display='none';
        document.getElementById('coverLoaded').style.display='block';
        document.getElementById('coverFn').textContent=inp.files[0].name;
        const r=new FileReader();r.onload=e=>{
            const d=document.getElementById('prevCover');
            d.style.backgroundImage='url('+e.target.result+')';d.style.backgroundSize='cover';d.style.backgroundPosition='center';
            document.getElementById('prevEmoji').style.display='none';
        };r.readAsDataURL(inp.files[0]);
    }

    function loadFiles(inp){
        if(!inp.files||!inp.files.length)return;
        hasFile=true;
        document.getElementById('fileEmpty').style.display='none';
        const list=document.getElementById('fileList');
        [...inp.files].forEach(f=>{
            const row=document.createElement('div');
            row.className = 'flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5';
            row.innerHTML=`<div class="flex items-center gap-3"><span class="text-lg">📁</span><span class="text-xs text-white">${f.name}</span></div><span class="text-emerald-400 text-xs">✓</span>`;
            list.appendChild(row);
        });
    }

    function setPriceMode(m){
        ['paid','free'].forEach(p=>{
            document.getElementById('pt-'+p).classList.toggle('on',p===m);
            const f=document.getElementById(p+'Form');if(f)f.style.display=p===m?'block':'none';
        });
        calcEarnings();
    }

    function calcEarnings(){
        const p=parseFloat(document.getElementById('price')?.value)||0;
        document.getElementById('ePrice').textContent=p?p.toFixed(2)+'€':'—';
        document.getElementById('eComm').textContent=p?(p*.30).toFixed(2)+'€':'—';
        document.getElementById('eYou').textContent=p?(p*.70).toFixed(2)+'€':'—';
        document.getElementById('prevPrice').textContent=p?p.toFixed(0)+'€':'Gratuit';
    }

    function updChecklist(){
        const title=document.getElementById('prodTitle')?.value.trim();
        const desc=document.getElementById('desc')?.value.trim();
        const chks=[
            {id:'title',ok:title&&title.length>5,txt:'Titre : '+(title||'manquant')},
            {id:'desc',ok:desc&&desc.length>80,txt:'Description : '+(desc?desc.length+' car.':'manquante')},
            {id:'cat',ok:!!selCat,txt:'Catégorie : '+(selCat||'non sélectionnée')},
        ];
        chks.forEach(c=>{
            const ico=document.getElementById('cki-'+c.id+'-ico');
            const txt=document.getElementById('cki-'+c.id+'-txt');
            if(c.ok){ ico.className='w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0'; ico.innerHTML='✓'; }
            if(txt)txt.textContent=c.txt;
        });
    }

    async function publish(){
        const btn=document.getElementById('pubBtn'),spin=document.getElementById('pubSpin');
        const title = document.getElementById('prodTitle').value;
        const desc = document.getElementById('desc').value;
        const catId = document.getElementById('categorie_id').value;
        const price = document.getElementById('price').value;
        const image = document.getElementById('prodImage').files[0];

        if(!title || !desc || !catId || !price || (!image && !productId)){
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }

        btn.disabled=true;spin.style.display='block';

        const formData = new FormData();
        formData.append('nom', title);
        formData.append('description', desc);
        formData.append('categorie_id', catId);
        formData.append('prix', price);
        if(image) formData.append('image', image);
        formData.append('stock', 999); 
        
        if(productId) {
            formData.append('_method', 'PUT');
        }

        try {
            const url = productId ? `/products/${productId}` : "{{ route('storeProduct') }}";
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            if(response.ok) {
                [1,2,3,4].forEach(i=>{const el=document.getElementById('p'+i);if(el)el.style.display='none';});
                document.getElementById('pOK').style.display='block';
            } else {
                const data = await response.json();
                alert('Erreur: ' + (data.message || 'Une erreur est survenue lors de la publication.'));
                btn.disabled=false;spin.style.display='none';
            }
        } catch (error) {
            console.error(error);
            alert('Une erreur réseau est survenue.');
            btn.disabled=false;spin.style.display='none';
        }
    }

    function saveDraft(){ alert('Brouillon sauvegardé !'); }
</script>
@endsection
