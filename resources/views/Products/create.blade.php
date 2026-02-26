<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PixelVault — Créer un produit</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{min-height:100vh;background:#09090f;color:#e2e8f0;font-family:'DM Sans',sans-serif;cursor:none;overflow-x:hidden;}
    h1,h2,h3,h4{font-family:'Syne',sans-serif;}
    #cur{width:10px;height:10px;background:#7c3aed;border-radius:50%;position:fixed;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:.15s width,.15s height;mix-blend-mode:screen;}
    #ring{width:32px;height:32px;border:1px solid rgba(124,58,237,.4);border-radius:50%;position:fixed;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);}
    .g{background:linear-gradient(135deg,#a78bfa,#22d3ee);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
    .g2{background:linear-gradient(135deg,#f59e0b,#34d399);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
    body::after{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");pointer-events:none;z-index:998;opacity:.5;}
    .grid-bg{background-image:linear-gradient(rgba(124,58,237,.035) 1px,transparent 1px),linear-gradient(90deg,rgba(124,58,237,.035) 1px,transparent 1px);background-size:60px 60px;}
    .orb{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none;}

    @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
    @keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
    @keyframes panelIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
    @keyframes spin{to{transform:rotate(360deg)}}
    @keyframes pulse{0%,100%{opacity:.5}50%{opacity:1}}
    @keyframes tagPop{from{transform:scale(0)}60%{transform:scale(1.1)}to{transform:scale(1);opacity:1}}
    @keyframes scalePop{0%{transform:scale(0) rotate(-5deg);opacity:0}60%{transform:scale(1.1)}100%{transform:scale(1);opacity:1}}
    @keyframes checkDraw{0%{stroke-dashoffset:60;opacity:0}40%{opacity:1}100%{stroke-dashoffset:0}}
    @keyframes confetti{0%{transform:translateY(0) rotate(0);opacity:1}100%{transform:translateY(-110px) rotate(720deg);opacity:0}}
    @keyframes uploadBlink{0%,100%{border-color:rgba(124,58,237,.25)}50%{border-color:rgba(124,58,237,.65);box-shadow:0 0 16px rgba(124,58,237,.12)}}
    @keyframes progFill{from{width:0%}to{width:var(--pct)}}
    @keyframes floatMini{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}

    /* ── Nav ── */
    nav{position:fixed;top:0;left:0;right:0;z-index:100;backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);background:rgba(9,9,15,.85);border-bottom:1px solid rgba(255,255,255,.05);}

    /* ── Sidebar ── */
    aside{position:fixed;top:60px;left:0;bottom:0;width:240px;background:rgba(9,9,15,.95);border-right:1px solid rgba(255,255,255,.05);overflow-y:auto;padding:24px 16px;z-index:40;}
    .si{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;cursor:pointer;transition:all .2s;margin-bottom:2px;}
    .si:hover{background:rgba(124,58,237,.07);}
    .si.active{background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.2);}
    .si.done{background:rgba(16,185,129,.05);}
    .sn{width:26px;height:26px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:11px;border:1.5px solid #1e1e2e;color:#64748b;transition:all .3s;flex-shrink:0;}
    .si.active .sn{background:#7c3aed;border-color:#7c3aed;color:#fff;}
    .si.done .sn{background:rgba(16,185,129,.15);border-color:rgba(16,185,129,.4);color:#34d399;}
    .sl{font-size:13px;font-weight:500;color:#64748b;transition:color .2s;}
    .si.active .sl,.si.done .sl{color:#e2e8f0;}
    .sc{width:1.5px;height:18px;background:#1e1e2e;margin:2px 0 2px 24px;transition:background .4s;}
    .sc.done{background:rgba(124,58,237,.35);}

    /* ── Progress bar ── */
    .pbar{height:3px;border-radius:2px;background:#1e1e2e;overflow:hidden;}
    .pfill{height:100%;border-radius:2px;background:linear-gradient(90deg,#7c3aed,#06b6d4);transition:width 1s cubic-bezier(.22,1,.36,1);}

    /* ── Main content area ── */
    .content{margin-left:240px;padding-top:60px;min-height:100vh;}
    .panel{padding:40px 48px 60px;max-width:820px;}

    /* ── Section heading ── */
    .sec-head{display:flex;align-items:center;gap:10px;margin-bottom:6px;}
    .sec-icon{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}

    /* ── Card surface ── */
    .surf{background:rgba(17,17,24,.9);border:1px solid #1e1e2e;border-radius:20px;position:relative;overflow:hidden;}
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
    input.taginp::placeholder{color:#2a2a3e;}

    /* ── License option ── */
    .lic{border:1.5px solid #1e1e2e;border-radius:14px;padding:14px 16px;cursor:pointer;transition:all .2s;}
    .lic:hover{border-color:rgba(124,58,237,.3);}
    .lic.sel{border-color:#7c3aed;background:rgba(124,58,237,.08);}
    .lrad{width:18px;height:18px;border-radius:50%;border:1.5px solid #3f3f5a;display:flex;align-items:center;justify-content:center;transition:all .2s;flex-shrink:0;}
    .lic.sel .lrad{border-color:#7c3aed;background:#7c3aed;}
    .lic.sel .lrad::after{content:'';width:6px;height:6px;border-radius:50%;background:#fff;}

    /* ── Pricing toggle ── */
    .ptog{display:inline-flex;background:#111118;border:1px solid #1e1e2e;border-radius:10px;padding:3px;gap:2px;}
    .ptb{padding:7px 16px;border-radius:7px;font-size:12px;font-weight:500;cursor:pointer;transition:all .25s;color:#64748b;border:none;background:transparent;font-family:'DM Sans',sans-serif;}
    .ptb.on{background:#7c3aed;color:#fff;box-shadow:0 0 12px rgba(124,58,237,.4);}

    /* ── Price field ── */
    .pfield{display:flex;}
    .ppfx{background:rgba(255,255,255,.04);border:1.5px solid #1e1e2e;border-right:none;border-radius:13px 0 0 13px;padding:13px 14px;color:#64748b;font-size:14px;}
    .pinp{background:rgba(255,255,255,.03);border:1.5px solid #1e1e2e;border-left:none;border-radius:0 13px 13px 0;flex:1;padding:13px 14px;color:#e2e8f0;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;outline:none;transition:border-color .2s,box-shadow .2s;}
    .pinp:focus{border-color:rgba(124,58,237,.55);box-shadow:0 0 0 3px rgba(124,58,237,.08);}
    .pinp::placeholder{color:#2a2a3e;font-weight:400;}

    /* ── Metric ── */
    .metric{background:rgba(255,255,255,.03);border:1px solid #1e1e2e;border-radius:12px;padding:12px 14px;text-align:center;}

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
    ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-thumb{background:rgba(124,58,237,.3);border-radius:2px}
  </style>
</head>
<body class="grid-bg">
<div id="cur"></div>
<div id="ring"></div>

<!-- Background orbs -->
<div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
  <div class="orb" style="width:450px;height:280px;background:rgba(124,58,237,.08);top:-80px;right:-120px;"></div>
  <div class="orb" style="width:320px;height:320px;background:rgba(6,182,212,.06);bottom:-80px;left:-60px;"></div>
</div>

<!-- ════════ NAV ════════ -->
<nav>
  <div style="height:60px;display:flex;align-items:center;justify-content:space-between;padding:0 24px 0 260px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <a href="index.html" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
        <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#7c3aed,#06b6d4);display:flex;align-items:center;justify-content:center;">
          <svg width="14" height="14" fill="#fff" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
        </div>
        <span style="font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:#fff;">Pixel<span class="g">Vault</span></span>
      </a>
      <span style="color:#2e2e48;font-size:16px;">/</span>
      <span style="font-size:13px;color:#94a3b8;">Nouveau produit</span>
    </div>

    <!-- Nav progress -->
    <div style="flex:1;max-width:300px;margin:0 32px;display:flex;align-items:center;gap:10px;">
      <div class="pbar" style="flex:1;"><div class="pfill" id="navProg" style="width:25%;"></div></div>
      <span style="font-size:11px;color:#64748b;white-space:nowrap;" id="navLbl">Étape 1 / 4</span>
    </div>

    <div style="display:flex;align-items:center;gap:16px;">
      <button onclick="saveDraft()" style="background:none;border:none;cursor:pointer;font-size:13px;color:#64748b;font-family:'DM Sans',sans-serif;transition:color .2s;" onmouseover="this.style.color='#e2e8f0'" onmouseout="this.style.color='#64748b'" id="draftBtn">Sauvegarder brouillon</button>
      <a href="createurs.html" style="font-size:13px;color:#3f3f5a;text-decoration:none;display:flex;align-items:center;gap:5px;" onmouseover="this.style.color='#94a3b8'" onmouseout="this.style.color='#3f3f5a'">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        Annuler
      </a>
    </div>
  </div>
</nav>

<!-- ════════ SIDEBAR ════════ -->
<aside>
  <div style="font-size:10px;font-weight:600;color:#3f3f5a;letter-spacing:.1em;text-transform:uppercase;margin-bottom:16px;padding-left:12px;">Étapes</div>

  <div class="si active" id="si1" onclick="goTo(1)">
    <div class="sn" id="sn1">1</div>
    <div><div class="sl">Informations</div><div style="font-size:11px;color:#3f3f5a;margin-top:1px;">Titre, description</div></div>
  </div>
  <div class="sc" id="sc1"></div>
  <div class="si" id="si2" onclick="goTo(2)">
    <div class="sn" id="sn2">2</div>
    <div><div class="sl">Médias & Fichiers</div><div style="font-size:11px;color:#3f3f5a;margin-top:1px;">Images, fichiers</div></div>
  </div>
  <div class="sc" id="sc2"></div>
  <div class="si" id="si3" onclick="goTo(3)">
    <div class="sn" id="sn3">3</div>
    <div><div class="sl">Prix & Licence</div><div style="font-size:11px;color:#3f3f5a;margin-top:1px;">Tarification, droits</div></div>
  </div>
  <div class="sc" id="sc3"></div>
  <div class="si" id="si4" onclick="goTo(4)">
    <div class="sn" id="sn4">4</div>
    <div><div class="sl">Publication</div><div style="font-size:11px;color:#3f3f5a;margin-top:1px;">Aperçu & publier</div></div>
  </div>

  <!-- Tip box -->
  <div style="margin-top:auto;padding-top:24px;position:absolute;bottom:24px;left:16px;right:16px;">
    <div style="background:rgba(124,58,237,.08);border:1px solid rgba(124,58,237,.2);border-radius:12px;padding:14px;">
      <div style="font-size:10px;font-weight:600;color:#a78bfa;letter-spacing:.05em;margin-bottom:6px;">💡 CONSEIL</div>
      <p style="font-size:12px;color:#94a3b8;line-height:1.6;" id="tipTxt">Un bon titre augmente les ventes de 3×. Soyez précis et spécifique.</p>
    </div>
  </div>
</aside>

<!-- ════════ CONTENT ════════ -->
<div class="content">

  <!-- ══════ PANEL 1 — Informations ══════ -->
  <div id="p1" class="panel">
    <div style="margin-bottom:32px;">
      <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:6px;">Informations <span class="g">générales</span></h1>
      <p style="color:#64748b;font-size:14px;">Présentez votre produit de façon claire et attractive.</p>
    </div>

    <!-- Title & Tagline -->
    <div class="surf" style="padding:28px;margin-bottom:20px;">
      <div class="sec-head">
        <div class="sec-icon" style="background:rgba(124,58,237,.15);border:1px solid rgba(124,58,237,.25);">
          <svg width="16" height="16" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
        </div>
        <div>
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;">Titre & Accroche</div>
          <div style="font-size:11px;color:#64748b;">Ce sont les premières choses vues par les acheteurs</div>
        </div>
      </div>
      <div style="margin-top:20px;display:flex;flex-direction:column;gap:14px;">
        <div>
          <label class="lbl">Titre du produit <span style="color:#f87171;">*</span></label>
          <div class="iw" id="wTitle">
            <div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg></div>
            <input class="fi" type="text" id="prodTitle" placeholder="ex: SaaS Dashboard Pro — Kit UI Figma complet" maxlength="80" oninput="onTitle(this)"/>
          </div>
          <div style="display:flex;justify-content:space-between;margin-top:4px;">
            <div class="hint">Soyez précis : incluez le type de fichier et le cas d'usage.</div>
            <div style="font-size:11px;color:#64748b;" id="titleCnt">0/80</div>
          </div>
        </div>
        <div>
          <label class="lbl">Accroche <span style="color:#64748b;text-transform:none;font-weight:400;letter-spacing:0;">(optionnel)</span></label>
          <div class="iw">
            <div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
            <input class="fi" type="text" id="prodTagline" placeholder="ex: 200+ composants prêts à l'emploi pour projets SaaS" maxlength="120" oninput="document.getElementById('taglCnt').textContent=this.value.length+'/120'"/>
          </div>
          <div style="text-align:right;margin-top:4px;"><span style="font-size:11px;color:#64748b;" id="taglCnt">0/120</span></div>
        </div>
      </div>
    </div>

    <!-- Description -->
    <div class="surf" style="margin-bottom:20px;overflow:hidden;">
      <div style="padding:22px 28px 12px;">
        <div class="sec-head">
          <div class="sec-icon" style="background:rgba(6,182,212,.1);border:1px solid rgba(6,182,212,.2);">
            <svg width="16" height="16" fill="none" stroke="#22d3ee" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          </div>
          <div>
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;">Description <span style="color:#f87171;">*</span></div>
            <div style="font-size:11px;color:#64748b;">Décrivez en détail ce que contient votre produit</div>
          </div>
        </div>
      </div>
      <!-- Toolbar -->
      <div class="toolbar">
        <button class="tb" title="Gras" onclick="document.getElementById('desc').focus()"><b>B</b></button>
        <button class="tb" title="Italique" onclick="document.getElementById('desc').focus()"><i>I</i></button>
        <button class="tb" title="Souligné"><u style="font-size:11px;">U</u></button>
        <div class="tb-sep"></div>
        <button class="tb" title="Liste" onclick="insDesc('\n✓ ')">≡</button>
        <button class="tb" title="Lien">🔗</button>
        <button class="tb" title="Emoji">😊</button>
        <div class="tb-sep"></div>
        <button class="tb" title="Effacer" onclick="document.getElementById('desc').value='';cntDesc()" style="color:#3f3f5a;">✕</button>
      </div>
      <div style="padding:0 28px 22px;">
        <textarea class="fi" id="desc" placeholder="Décrivez votre produit en détail :&#10;&#10;✓ Ce qu'il contient&#10;✓ À qui il s'adresse&#10;✓ Comment l'utiliser&#10;✓ Ce qui est inclus" style="padding:14px;margin-top:8px;min-height:160px;" oninput="cntDesc()"></textarea>
        <div style="display:flex;justify-content:space-between;margin-top:4px;">
          <div class="hint">Min. 100 caractères recommandés pour le référencement.</div>
          <div style="font-size:11px;color:#64748b;" id="descCnt">0 car.</div>
        </div>
      </div>
    </div>

    <!-- Category -->
    <div class="surf" style="padding:28px;margin-bottom:20px;">
      <div class="sec-head" style="margin-bottom:16px;">
        <div class="sec-icon" style="background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.2);">
          <svg width="16" height="16" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
        </div>
        <div>
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;">Catégorie <span style="color:#f87171;">*</span></div>
          <div style="font-size:11px;color:#64748b;">Choisissez la catégorie qui correspond le mieux</div>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px;" id="catGrid">
        <div class="cat" onclick="pickCat(this,'UI Kit','🎨')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">🎨</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">UI Kit</div></div>
        <div class="cat" onclick="pickCat(this,'Template','📄')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">📄</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">Template</div></div>
        <div class="cat" onclick="pickCat(this,'Plugin','⚡')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">⚡</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">Plugin</div></div>
        <div class="cat" onclick="pickCat(this,'Cours','📚')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">📚</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">Cours</div></div>
        <div class="cat" onclick="pickCat(this,'Illustration','🖼')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">🖼</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">Illustration</div></div>
        <div class="cat" onclick="pickCat(this,'Audio','🎵')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">🎵</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">Audio</div></div>
        <div class="cat" onclick="pickCat(this,'Vidéo','🎬')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">🎬</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">Vidéo</div></div>
        <div class="cat" onclick="pickCat(this,'Bundle','📦')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">📦</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">Bundle</div></div>
        <div class="cat" onclick="pickCat(this,'3D','🔮')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">🔮</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">3D</div></div>
        <div class="cat" onclick="pickCat(this,'Autre','✨')"><div class="ck"><svg width="12" height="12" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div><div style="font-size:20px;margin-bottom:4px;">✨</div><div style="font-size:11px;color:#94a3b8;font-weight:500;">Autre</div></div>
      </div>
    </div>

    <!-- Formats & Tags -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
      <div class="surf" style="padding:22px;">
        <label class="lbl">Formats inclus</label>
        <div class="iw">
          <div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg></div>
          <select class="fi" multiple id="fmts" style="min-height:110px;padding:8px;">
            <option value="figma">Figma</option>
            <option value="sketch">Sketch</option>
            <option value="xd">Adobe XD</option>
            <option value="react">React</option>
            <option value="vue">Vue.js</option>
            <option value="html">HTML/CSS</option>
            <option value="svg">SVG</option>
            <option value="png">PNG</option>
            <option value="ai">Illustrator</option>
            <option value="psd">Photoshop</option>
            <option value="mp4">Vidéo MP4</option>
            <option value="pdf">PDF</option>
          </select>
        </div>
        <div class="hint">Ctrl+clic pour sélectionner plusieurs</div>
      </div>
      <div class="surf" style="padding:22px;">
        <label class="lbl">Niveau requis</label>
        <div class="iw" style="margin-bottom:14px;">
          <div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
          <select class="fi" id="level"><option value="">Tous niveaux</option><option>Débutant</option><option>Intermédiaire</option><option>Avancé</option></select>
        </div>
        <label class="lbl">Langue</label>
        <div class="iw">
          <div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg></div>
          <select class="fi" id="lang"><option value="fr">Français</option><option value="en">Anglais</option><option value="multi">Multilingue</option></select>
        </div>
      </div>
    </div>

    <!-- Tags -->
    <div class="surf" style="padding:22px;margin-bottom:32px;">
      <label class="lbl">Tags / Mots-clés <span style="color:#64748b;text-transform:none;letter-spacing:0;font-weight:400;">(max 10)</span></label>
      <div class="tagbox" id="tagbox" onclick="document.getElementById('taginput').focus()">
        <input class="taginp" id="taginput" type="text" placeholder="Tapez un tag + Entrée..." onkeydown="tagKey(event)"/>
      </div>
      <div class="hint">Les tags améliorent la découvrabilité de votre produit dans les recherches.</div>
    </div>

    <div style="display:flex;justify-content:flex-end;">
      <button class="btn" onclick="goTo(2)" style="padding:13px 28px;border-radius:13px;font-size:14px;">Médias & Fichiers →</button>
    </div>
  </div>

  <!-- ══════ PANEL 2 — Médias & Fichiers ══════ -->
  <div id="p2" style="display:none;" class="panel">
    <div style="margin-bottom:32px;">
      <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:6px;">Médias & <span class="g">Fichiers</span></h1>
      <p style="color:#64748b;font-size:14px;">Les produits avec de bonnes images se vendent 5× plus.</p>
    </div>

    <!-- Cover image -->
    <div class="surf" style="padding:28px;margin-bottom:20px;">
      <div class="sec-head" style="margin-bottom:16px;">
        <div class="sec-icon" style="background:rgba(124,58,237,.15);border:1px solid rgba(124,58,237,.25);">
          <svg width="16" height="16" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;">Image de couverture <span style="color:#f87171;">*</span></div>
          <div style="font-size:11px;color:#64748b;">Recommandé : 1200×800px · PNG, JPG, WEBP · Max 5 Mo</div>
        </div>
      </div>
      <div class="uzone" id="coverZone" style="padding:40px;">
        <input type="file" accept="image/*" onchange="loadCover(this)"/>
        <div id="coverEmpty" style="text-align:center;">
          <div style="width:52px;height:52px;border-radius:16px;background:rgba(124,58,237,.15);border:1px solid rgba(124,58,237,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
            <svg width="24" height="24" fill="none" stroke="#a78bfa" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          </div>
          <div style="font-weight:600;color:#e2e8f0;margin-bottom:4px;">Glissez votre image ici</div>
          <div style="font-size:13px;color:#64748b;">ou cliquez pour parcourir</div>
        </div>
        <div id="coverLoaded" style="display:none;text-align:center;">
          <div style="font-size:18px;margin-bottom:6px;">✅</div>
          <div style="font-size:13px;font-weight:600;color:#34d399;">Image chargée</div>
          <div style="font-size:11px;color:#64748b;margin-top:2px;" id="coverFn">—</div>
        </div>
      </div>
    </div>

    <!-- Gallery -->
    <div class="surf" style="padding:28px;margin-bottom:20px;">
      <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;margin-bottom:4px;">Galerie d'images <span style="font-family:'DM Sans';font-weight:400;font-size:12px;color:#64748b;">(optionnel · max 8)</span></div>
      <div style="font-size:11px;color:#64748b;margin-bottom:14px;">Montrez les différentes vues et fonctionnalités de votre produit</div>
      <div class="uzone" id="galleryZone" style="padding:24px;">
        <input type="file" accept="image/*" multiple onchange="loadGallery(this)"/>
        <div style="display:flex;align-items:center;justify-content:center;gap:12px;">
          <svg width="28" height="28" fill="none" stroke="#3f3f5a" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
          <div><div style="font-size:13px;color:#94a3b8;">Ajoutez jusqu'à 8 captures d'écran</div><div style="font-size:11px;color:#64748b;">PNG, JPG · Max 5 Mo chacune</div></div>
        </div>
      </div>
      <div id="galleryPrev" style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px;"></div>
    </div>

    <!-- Product files -->
    <div class="surf" style="padding:28px;margin-bottom:20px;">
      <div class="sec-head" style="margin-bottom:14px;">
        <div class="sec-icon" style="background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.2);">
          <svg width="16" height="16" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
        </div>
        <div>
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;">Fichier(s) produit <span style="color:#f87171;">*</span></div>
          <div style="font-size:11px;color:#64748b;">.fig, .zip, .sketch, .pdf, .mp4 et plus · Max 500 Mo</div>
        </div>
      </div>
      <div class="uzone" id="fileZone" style="padding:28px;">
        <input type="file" multiple onchange="loadFiles(this)"/>
        <div id="fileEmpty" style="display:flex;align-items:center;justify-content:center;gap:14px;">
          <div style="width:44px;height:44px;border-radius:12px;background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="22" height="22" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
          </div>
          <div><div style="font-weight:600;color:#e2e8f0;font-size:14px;">Glissez vos fichiers ici</div><div style="font-size:12px;color:#64748b;margin-top:2px;">Tous formats acceptés</div></div>
        </div>
        <div id="fileList" style="display:flex;flex-direction:column;gap:8px;"></div>
      </div>
    </div>

    <!-- Preview link -->
    <div class="surf" style="padding:22px;margin-bottom:32px;">
      <label class="lbl">Aperçu interactif <span style="font-weight:400;letter-spacing:0;text-transform:none;color:#64748b;">(optionnel — +40% de conversions)</span></label>
      <div class="iw">
        <div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg></div>
        <input class="fi" type="url" id="previewUrl" placeholder="https://figma.com/community/file/... ou Framer, CodeSandbox, YouTube..."/>
      </div>
    </div>

    <div style="display:flex;align-items:center;justify-content:space-between;">
      <button class="btn-out" onclick="goTo(1)" style="padding:12px 22px;border-radius:13px;font-size:13px;">← Retour</button>
      <button class="btn" onclick="goTo(3)" style="padding:13px 28px;border-radius:13px;font-size:14px;">Prix & Licence →</button>
    </div>
  </div>

  <!-- ══════ PANEL 3 — Prix & Licence ══════ -->
  <div id="p3" style="display:none;" class="panel">
    <div style="margin-bottom:32px;">
      <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:6px;">Prix & <span class="g">Licence</span></h1>
      <p style="color:#64748b;font-size:14px;">Définissez votre modèle tarifaire et les droits d'utilisation.</p>
    </div>

    <!-- Pricing type -->
    <div class="surf" style="padding:28px;margin-bottom:20px;">
      <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;margin-bottom:14px;">Modèle de prix</div>
      <div class="ptog" style="margin-bottom:22px;">
        <button class="ptb on" id="pt-paid" onclick="setPriceMode('paid')">Payant</button>
        <button class="ptb" id="pt-free" onclick="setPriceMode('free')">Gratuit</button>
        <button class="ptb" id="pt-pwyw" onclick="setPriceMode('pwyw')">Pay what you want</button>
      </div>

      <!-- Paid -->
      <div id="paidForm">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
          <div>
            <label class="lbl">Prix de vente <span style="color:#f87171;">*</span></label>
            <div class="pfield">
              <div class="ppfx">€</div>
              <input class="pinp" type="number" id="price" placeholder="0.00" min="0" step="0.01" oninput="calcEarnings()"/>
            </div>
            <div class="hint">Min : 0,99€ · Recommandé : 9–99€</div>
          </div>
          <div>
            <label class="lbl">Ancien prix <span style="font-weight:400;letter-spacing:0;text-transform:none;color:#64748b;">(optionnel)</span></label>
            <div class="pfield">
              <div class="ppfx">€</div>
              <input class="pinp" type="number" id="oldPrice" placeholder="prix barré" min="0" step="0.01" oninput="calcEarnings()"/>
            </div>
          </div>
        </div>
        <!-- Earnings breakdown -->
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:16px;">
          <div class="metric">
            <div style="font-size:10px;color:#64748b;margin-bottom:4px;">Prix affiché</div>
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:18px;color:#e2e8f0;" id="ePrice">—</div>
          </div>
          <div class="metric">
            <div style="font-size:10px;color:#64748b;margin-bottom:4px;">Commission (30%)</div>
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:18px;color:#f87171;" id="eComm">—</div>
          </div>
          <div class="metric" style="border-color:rgba(16,185,129,.3);background:rgba(16,185,129,.04);">
            <div style="font-size:10px;color:#64748b;margin-bottom:4px;">Vos gains (70%)</div>
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:18px;color:#34d399;" id="eYou">—</div>
          </div>
        </div>
      </div>
      <!-- Free -->
      <div id="freeForm" style="display:none;text-align:center;padding:28px 0;">
        <div style="font-size:32px;margin-bottom:10px;">🎁</div>
        <div style="font-weight:600;color:#e2e8f0;margin-bottom:4px;">Produit gratuit</div>
        <div style="font-size:13px;color:#64748b;max-width:360px;margin:0 auto;">Excellent pour construire votre audience. Votre produit sera accessible gratuitement par tous.</div>
      </div>
      <!-- PWYW -->
      <div id="pwywForm" style="display:none;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
          <div><label class="lbl">Prix minimum</label><div class="pfield"><div class="ppfx">€</div><input class="pinp" type="number" placeholder="1.00"/></div></div>
          <div><label class="lbl">Prix suggéré</label><div class="pfield"><div class="ppfx">€</div><input class="pinp" type="number" placeholder="15.00"/></div></div>
        </div>
        <div style="background:rgba(245,158,11,.07);border:1px solid rgba(245,158,11,.2);border-radius:12px;padding:12px 14px;margin-top:14px;font-size:13px;color:#fbbf24;">
          💡 Les acheteurs paient ce qu'ils veulent au-delà du minimum. Très efficace pour les projets communautaires.
        </div>
      </div>
    </div>

    <!-- License -->
    <div class="surf" style="padding:28px;margin-bottom:20px;">
      <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;margin-bottom:14px;">Type de licence</div>
      <div style="display:flex;flex-direction:column;gap:10px;">
        <div class="lic sel" id="lic-p" onclick="pickLic('p')">
          <div style="display:flex;align-items:flex-start;gap:12px;">
            <div class="lrad"></div>
            <div><div style="font-weight:600;color:#e2e8f0;font-size:14px;">Licence personnelle</div><div style="font-size:12px;color:#64748b;margin-top:2px;">Usage personnel et projets non-commerciaux uniquement. L'acheteur ne peut pas revendre ni utiliser commercialement.</div></div>
          </div>
        </div>
        <div class="lic" id="lic-c" onclick="pickLic('c')">
          <div style="display:flex;align-items:flex-start;gap:12px;">
            <div class="lrad"></div>
            <div>
              <div style="display:flex;align-items:center;gap:8px;"><div style="font-weight:600;color:#e2e8f0;font-size:14px;">Licence commerciale</div><span style="font-size:10px;background:rgba(124,58,237,.15);border:1px solid rgba(124,58,237,.3);border-radius:6px;padding:2px 8px;color:#a78bfa;">Recommandée</span></div>
              <div style="font-size:12px;color:#64748b;margin-top:2px;">Projets clients, applications SaaS, produits commerciaux. Usage illimité dans des projets générant des revenus.</div>
            </div>
          </div>
        </div>
        <div class="lic" id="lic-e" onclick="pickLic('e')">
          <div style="display:flex;align-items:flex-start;gap:12px;">
            <div class="lrad"></div>
            <div><div style="font-weight:600;color:#e2e8f0;font-size:14px;">Licence étendue + revente</div><div style="font-size:12px;color:#64748b;margin-top:2px;">Tous droits commerciaux + possibilité de revente dans des compilations et bundles.</div></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Options -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:32px;">
      <div class="surf" style="padding:22px;">
        <label class="lbl">Version</label>
        <div class="iw"><div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg></div><input class="fi" type="text" placeholder="ex: v1.0, 2024"/></div>
      </div>
      <div class="surf" style="padding:22px;">
        <label class="lbl">Support inclus</label>
        <div class="iw"><div class="ii"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div><select class="fi" id="support"><option value="none">Aucun</option><option value="email" selected>Email</option><option value="48h">48h garantis</option><option value="priority">Support prioritaire</option></select></div>
      </div>
    </div>

    <div style="display:flex;align-items:center;justify-content:space-between;">
      <button class="btn-out" onclick="goTo(2)" style="padding:12px 22px;border-radius:13px;font-size:13px;">← Retour</button>
      <button class="btn" onclick="goTo(4)" style="padding:13px 28px;border-radius:13px;font-size:14px;">Aperçu & Publication →</button>
    </div>
  </div>

  <!-- ══════ PANEL 4 — Publication ══════ -->
  <div id="p4" style="display:none;" class="panel">
    <div style="margin-bottom:32px;">
      <h1 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:6px;">Aperçu & <span class="g">Publication</span></h1>
      <p style="color:#64748b;font-size:14px;">Vérifiez votre produit avant de le mettre en ligne.</p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">
      <!-- Preview card -->
      <div>
        <div style="font-size:10px;font-weight:600;color:#94a3b8;letter-spacing:.1em;text-transform:uppercase;margin-bottom:12px;">Aperçu carte produit</div>
        <div class="prev-card" style="max-width:280px;">
          <div style="height:160px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;" id="prevCover" style="background:linear-gradient(135deg,rgba(124,58,237,.3),rgba(6,182,212,.15));">
            <div style="position:absolute;top:10px;left:10px;">
              <span id="prevCatBadge" style="font-size:10px;padding:3px 8px;border-radius:100px;font-weight:600;background:rgba(124,58,237,.2);border:1px solid rgba(124,58,237,.4);color:#a78bfa;">CATÉGORIE</span>
            </div>
            <div style="font-size:40px;" id="prevEmoji">✨</div>
          </div>
          <div style="padding:14px;">
            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:13px;color:#e2e8f0;margin-bottom:4px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" id="prevTitle">Titre de votre produit</div>
            <div style="font-size:11px;color:#64748b;margin-bottom:8px;">par <span style="color:#7c3aed;">Vous</span></div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <div style="font-size:11px;color:#f59e0b;">★★★★★ <span style="color:#64748b;">nouveau</span></div>
              <div style="font-family:'Syne',sans-serif;font-weight:700;color:#e2e8f0;font-size:14px;" id="prevPrice">—</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Checklist -->
      <div>
        <div style="font-size:10px;font-weight:600;color:#94a3b8;letter-spacing:.1em;text-transform:uppercase;margin-bottom:12px;">Vérification</div>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <div class="ck-item" id="cki-title">
            <div id="cki-title-ico" style="width:20px;height:20px;border-radius:50%;background:rgba(100,116,139,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="10" height="10" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span style="font-size:13px;color:#94a3b8;" id="cki-title-txt">Titre du produit</span>
          </div>
          <div class="ck-item" id="cki-desc">
            <div id="cki-desc-ico" style="width:20px;height:20px;border-radius:50%;background:rgba(100,116,139,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="10" height="10" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span style="font-size:13px;color:#94a3b8;" id="cki-desc-txt">Description</span>
          </div>
          <div class="ck-item">
            <div id="cki-cat-ico" style="width:20px;height:20px;border-radius:50%;background:rgba(100,116,139,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="10" height="10" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span style="font-size:13px;color:#94a3b8;" id="cki-cat-txt">Catégorie</span>
          </div>
          <div class="ck-item">
            <div id="cki-img-ico" style="width:20px;height:20px;border-radius:50%;background:rgba(100,116,139,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="10" height="10" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span style="font-size:13px;color:#94a3b8;" id="cki-img-txt">Image de couverture</span>
          </div>
          <div class="ck-item">
            <div id="cki-file-ico" style="width:20px;height:20px;border-radius:50%;background:rgba(100,116,139,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="10" height="10" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></div>
            <span style="font-size:13px;color:#94a3b8;" id="cki-file-txt">Fichier produit</span>
          </div>
        </div>

        <!-- Quality score -->
        <div style="background:rgba(124,58,237,.07);border:1px solid rgba(124,58,237,.18);border-radius:14px;padding:14px;margin-top:14px;">
          <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
            <span style="font-size:13px;color:#a78bfa;font-weight:600;">Score de qualité</span>
            <span style="font-family:'Syne',sans-serif;font-weight:800;color:#fff;" id="qScore">0%</span>
          </div>
          <div class="qbar"><div class="qfill" id="qFill" style="width:0%;"></div></div>
          <div style="font-size:11px;color:#64748b;margin-top:6px;" id="qMsg">Complétez les étapes pour améliorer le score.</div>
        </div>
      </div>
    </div>

    <!-- Publication options -->
    <div class="surf" style="padding:24px;margin-bottom:24px;">
      <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#e2e8f0;margin-bottom:14px;">Options de publication</div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
        <div class="pubopt sel" id="pub-now" onclick="pickPub('now')">
          <div style="font-size:22px;margin-bottom:8px;">🚀</div>
          <div style="font-weight:600;color:#e2e8f0;font-size:13px;">Publier maintenant</div>
          <div style="font-size:11px;color:#64748b;margin-top:2px;">Visible immédiatement</div>
        </div>
        <div class="pubopt" id="pub-draft" onclick="pickPub('draft')">
          <div style="font-size:22px;margin-bottom:8px;">📋</div>
          <div style="font-weight:600;color:#e2e8f0;font-size:13px;">Brouillon</div>
          <div style="font-size:11px;color:#64748b;margin-top:2px;">Continuer plus tard</div>
        </div>
        <div class="pubopt" id="pub-review" onclick="pickPub('review')">
          <div style="font-size:22px;margin-bottom:8px;">🔍</div>
          <div style="font-weight:600;color:#e2e8f0;font-size:13px;">Soumettre à la revue</div>
          <div style="font-size:11px;color:#64748b;margin-top:2px;">Mise en avant éditoriale</div>
        </div>
      </div>
    </div>

    <div style="display:flex;align-items:center;justify-content:space-between;">
      <button class="btn-out" onclick="goTo(3)" style="padding:12px 22px;border-radius:13px;font-size:13px;">← Retour</button>
      <button class="btn" id="pubBtn" onclick="publish()" style="padding:14px 36px;border-radius:13px;font-size:15px;display:flex;align-items:center;gap:10px;">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        <span id="pubTxt">Publier le produit</span>
        <div class="spinner" id="pubSpin" style="display:none;"></div>
      </button>
    </div>
  </div>

  <!-- ══════ SUCCESS ══════ -->
  <div id="pOK" style="display:none;padding:80px 48px;text-align:center;max-width:600px;position:relative;">
    <div id="confBox" style="position:absolute;inset:0;pointer-events:none;overflow:hidden;"></div>
    <div class="suc-ring" style="margin:0 auto 24px;">
      <svg width="36" height="36" viewBox="0 0 40 40" fill="none">
        <path class="chk-svg" d="M10 20 L17 27 L30 13" stroke="#34d399" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h2 style="font-size:2.6rem;font-weight:800;color:#fff;margin-bottom:8px;">Produit <span class="g">publié !</span></h2>
    <p style="color:#94a3b8;margin-bottom:4px;" id="okTitle">Votre produit est maintenant en ligne.</p>
    <p style="color:#64748b;font-size:13px;margin-bottom:28px;">Partagez-le pour maximiser vos ventes.</p>

    <!-- Share URL -->
    <div style="display:inline-flex;align-items:center;gap:12px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:10px 16px;margin-bottom:32px;">
      <span style="font-family:'DM Mono',monospace;font-size:13px;color:#94a3b8;" id="shareUrl">pixelvault.io/p/mon-produit</span>
      <button onclick="copyUrl()" style="background:none;border:none;cursor:pointer;font-size:12px;color:#7c3aed;font-weight:600;font-family:'DM Sans',sans-serif;" id="copyBtn">Copier</button>
    </div>

    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      <button onclick="location.reload()" class="btn" style="padding:13px 24px;border-radius:13px;font-size:14px;">+ Nouveau produit</button>
      <a href="createurs.html" class="btn-out" style="padding:13px 24px;border-radius:13px;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;">Mon tableau de bord</a>
    </div>
  </div>

</div><!-- /content -->

<script>
/* ── Cursor ── */
const cur=document.getElementById('cur'),ring=document.getElementById('ring');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;cur.style.left=mx+'px';cur.style.top=my+'px';});
(function loop(){rx+=(mx-rx)*.1;ry+=(my-ry)*.1;ring.style.left=rx+'px';ring.style.top=ry+'px';requestAnimationFrame(loop);})();
function rc(){document.querySelectorAll('a,button,input,textarea,select,.cat,.lic,.pubopt,.si,.uzone').forEach(el=>{el.addEventListener('mouseenter',()=>{cur.style.width='18px';cur.style.height='18px';ring.style.width='46px';ring.style.height='46px';});el.addEventListener('mouseleave',()=>{cur.style.width='10px';cur.style.height='10px';ring.style.width='32px';ring.style.height='32px';});});}
rc();

/* ── State ── */
let curStep=1,selCat='',selCatEmoji='',selLic='p',pubOpt='now',hasCover=false,hasFile=false,tags=[];
const tips=['Un bon titre augmente les ventes de 3×. Soyez précis et spécifique.','Ajoutez au moins 3 captures d\'écran. Les acheteurs veulent voir avant d\'acheter.','La fourchette 19€–69€ est la plus performante sur PixelVault.','Vérifiez tous les points pour maximiser votre visibilité.'];

/* ── Navigation ── */
function goTo(n){
  [1,2,3,4,'OK'].forEach(i=>{const el=document.getElementById('p'+i);if(el){el.style.display='none';}});
  const t=document.getElementById('p'+n);
  if(t){t.style.display='block';t.style.animation='none';t.offsetHeight;t.style.animation='panelIn .35s ease both';}
  curStep=n; updSidebar(n); updProgress(n);
  if(n===4)updChecklist();
  document.getElementById('tipTxt').textContent=tips[n-1]||tips[0];
  window.scrollTo({top:0,behavior:'smooth'}); rc();
}

function updSidebar(n){
  [1,2,3,4].forEach(i=>{
    const si=document.getElementById('si'+i),sn=document.getElementById('sn'+i);
    if(!si)return;
    if(i<n){si.className='si done';sn.innerHTML='<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>';sn.style.background='rgba(16,185,129,.15)';sn.style.borderColor='rgba(16,185,129,.4)';sn.style.color='#34d399';}
    else if(i===n){si.className='si active';sn.style.background='#7c3aed';sn.style.borderColor='#7c3aed';sn.style.color='#fff';sn.textContent=i;}
    else{si.className='si';sn.style.background='';sn.style.borderColor='#1e1e2e';sn.style.color='#64748b';sn.textContent=i;}
  });
  [1,2,3].forEach(i=>{const sc=document.getElementById('sc'+i);if(sc)sc.className='sc'+(n>i?' done':'');});
}

function updProgress(n){
  document.getElementById('navProg').style.width=(n/4*100)+'%';
  document.getElementById('navLbl').textContent='Étape '+n+' / 4';
}

/* ── Step 1 helpers ── */
function onTitle(inp){
  document.getElementById('titleCnt').textContent=inp.value.length+'/80';
  document.getElementById('prevTitle').textContent=inp.value||'Titre de votre produit';
  document.getElementById('wTitle').className='iw'+(inp.value.length>5?' v':'');
}
function cntDesc(){
  const v=document.getElementById('desc').value;
  document.getElementById('descCnt').textContent=v.length+' car.';
}
function insDesc(t){const ta=document.getElementById('desc');ta.value+=t;ta.focus();cntDesc();}
function pickCat(el,name,emoji){
  document.querySelectorAll('.cat').forEach(c=>c.classList.remove('sel'));
  el.classList.add('sel'); selCat=name; selCatEmoji=emoji;
  document.getElementById('prevCatBadge').textContent=name.toUpperCase();
  document.getElementById('prevEmoji').textContent=emoji;
}

/* Tags */
let tagArr=[];
function tagKey(e){
  if((e.key==='Enter'||e.key===',')&&e.target.value.trim()){
    e.preventDefault();addTag(e.target.value.trim().replace(',',''));e.target.value='';
  }
  if(e.key==='Backspace'&&!e.target.value&&tagArr.length){tagArr.pop();renderTags();}
}
function addTag(t){if(tagArr.length>=10||tagArr.includes(t.toLowerCase()))return;tagArr.push(t.toLowerCase());renderTags();}
function renderTags(){
  const box=document.getElementById('tagbox'),inp=document.getElementById('taginput');
  box.querySelectorAll('.tag').forEach(t=>t.remove());
  tagArr.forEach((t,i)=>{const el=document.createElement('span');el.className='tag';el.innerHTML=t+'<span class="tag-x" onclick="rmTag('+i+')">×</span>';box.insertBefore(el,inp);});
}
function rmTag(i){tagArr.splice(i,1);renderTags();}

/* ── Step 2 helpers ── */
function loadCover(inp){
  if(!inp.files||!inp.files[0])return;
  hasCover=true;
  document.getElementById('coverEmpty').style.display='none';
  document.getElementById('coverLoaded').style.display='block';
  document.getElementById('coverFn').textContent=inp.files[0].name;
  document.getElementById('coverZone').classList.add('loaded');
  // Show image in preview
  const r=new FileReader();r.onload=e=>{
    const d=document.getElementById('prevCover');
    d.style.backgroundImage='url('+e.target.result+')';d.style.backgroundSize='cover';d.style.backgroundPosition='center';
    document.getElementById('prevEmoji').style.display='none';
    document.getElementById('prevCatBadge').parentElement.style.zIndex='2';
  };r.readAsDataURL(inp.files[0]);
}
function loadGallery(inp){
  const prev=document.getElementById('galleryPrev');
  [...inp.files].slice(0,8).forEach(f=>{
    const d=document.createElement('div');
    d.style.cssText='width:64px;height:64px;border-radius:10px;background:linear-gradient(135deg,rgba(124,58,237,.25),rgba(6,182,212,.15));border:2px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;font-size:10px;color:#64748b;overflow:hidden;flex-shrink:0;';
    d.textContent=f.name.slice(0,5);
    prev.appendChild(d);
  });
}
function loadFiles(inp){
  if(!inp.files||!inp.files.length)return;
  hasFile=true;
  document.getElementById('fileEmpty').style.display='none';
  document.getElementById('fileZone').classList.add('loaded');
  const list=document.getElementById('fileList');
  [...inp.files].forEach(f=>{
    const sz=f.size>1048576?(f.size/1048576).toFixed(1)+'MB':(f.size/1024).toFixed(0)+'KB';
    const row=document.createElement('div');
    row.style.cssText='display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);';
    row.innerHTML=`<div style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><svg width="15" height="15" fill="none" stroke="#fbbf24" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div style="flex:1;min-width:0;"><div style="font-size:13px;color:#e2e8f0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${f.name}</div><div style="font-size:11px;color:#64748b;">${sz}</div></div><span style="color:#34d399;font-size:13px;">✓</span>`;
    list.appendChild(row);
  });
}

/* ── Step 3 helpers ── */
function setPriceMode(m){
  ['paid','free','pwyw'].forEach(p=>{
    document.getElementById('pt-'+p).classList.toggle('on',p===m);
    const f=document.getElementById(p+'Form');if(f)f.style.display=p===m?'block':'none';
  });
  calcEarnings();
}
function calcEarnings(){
  const p=parseFloat(document.getElementById('price')?.value)||0;
  document.getElementById('ePrice').textContent=p?p.toFixed(2)+'€':'—';
  document.getElementById('eComm').textContent=p?'−'+(p*.3).toFixed(2)+'€':'—';
  document.getElementById('eYou').textContent=p?(p*.7).toFixed(2)+'€':'—';
  document.getElementById('prevPrice').textContent=p?p.toFixed(0)+'€':'Gratuit';
}
function pickLic(l){
  selLic=l;
  ['p','c','e'].forEach(k=>{
    const el=document.getElementById('lic-'+k),r=el.querySelector('.lrad');
    el.classList.toggle('sel',k===l);
    r.style.borderColor=k===l?'#7c3aed':'#3f3f5a';
    r.style.background=k===l?'#7c3aed':'transparent';
    r.innerHTML=k===l?'<div style="width:6px;height:6px;border-radius:50%;background:#fff;"></div>':'';
  });
}

/* ── Step 4 helpers ── */
function updChecklist(){
  const title=document.getElementById('prodTitle')?.value.trim();
  const desc=document.getElementById('desc')?.value.trim();
  const chks=[
    {id:'title',ok:title&&title.length>5,txt:'Titre : '+(title||'manquant')},
    {id:'desc',ok:desc&&desc.length>80,txt:'Description : '+(desc?desc.length+' car.':'manquante')},
    {id:'cat',ok:!!selCat,txt:'Catégorie : '+(selCat||'non sélectionnée')},
    {id:'img',ok:hasCover,txt:'Image de couverture'},
    {id:'file',ok:hasFile,txt:'Fichier produit'},
  ];
  let score=0;
  chks.forEach(c=>{
    const ico=document.getElementById('cki-'+c.id+'-ico');
    const txt=document.getElementById('cki-'+c.id+'-txt');
    if(c.ok){
      score++;
      if(ico){ico.style.background='rgba(16,185,129,.15)';ico.innerHTML='<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>';}
    } else {
      if(ico){ico.style.background='rgba(100,116,139,.15)';ico.innerHTML='<svg width="10" height="10" fill="none" stroke="#64748b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';}
    }
    if(txt)txt.textContent=c.txt;
  });
  const pct=Math.round(score/chks.length*100);
  document.getElementById('qScore').textContent=pct+'%';
  document.getElementById('qFill').style.width=pct+'%';
  document.getElementById('qMsg').textContent=pct>=80?'🎉 Excellent ! Prêt à publier.':pct>=60?'Bon score — quelques améliorations possibles.':'Complétez les informations manquantes.';
}
function pickPub(o){
  pubOpt=o;
  ['now','draft','review'].forEach(p=>{const el=document.getElementById('pub-'+p);el.classList.toggle('sel',p===o);});
  const labels={now:'Publier le produit',draft:'Sauvegarder brouillon',review:'Soumettre à la revue'};
  document.getElementById('pubTxt').textContent=labels[o];
}

/* ── Publish ── */
function publish(){
  const btn=document.getElementById('pubBtn'),spin=document.getElementById('pubSpin'),txt=document.getElementById('pubTxt');
  btn.disabled=true;spin.style.display='block';txt.style.opacity='0';
  setTimeout(()=>{
    const title=document.getElementById('prodTitle')?.value||'mon-produit';
    document.getElementById('okTitle').textContent='"'+title+'" est maintenant en ligne !';
    const slug=title.toLowerCase().replace(/[^a-z0-9]+/g,'-').slice(0,40);
    document.getElementById('shareUrl').textContent='pixelvault.io/p/'+slug;
    [1,2,3,4].forEach(i=>{const el=document.getElementById('p'+i);if(el)el.style.display='none';});
    const ok=document.getElementById('pOK');ok.style.display='block';ok.style.animation='fadeUp .5s ease both';
    updSidebar(5);confLaunch();rc();
  },2400);
}
function confLaunch(){
  const c=document.getElementById('confBox');
  const cols=['#a78bfa','#22d3ee','#f59e0b','#34d399','#f87171'];
  for(let i=0;i<24;i++){
    const d=document.createElement('div');d.className='conf-dot';
    d.style.cssText=`width:${6+Math.random()*7}px;height:${6+Math.random()*7}px;border-radius:${Math.random()>.5?'50%':'3px'};background:${cols[~~(Math.random()*cols.length)]};left:${Math.random()*100}%;top:${20+Math.random()*60}%;animation-delay:${Math.random()*.4}s;animation-duration:${.9+Math.random()*.5}s;`;
    c.appendChild(d);setTimeout(()=>d.remove(),2500);
  }
}

/* ── Draft save ── */
function saveDraft(){
  const btn=document.getElementById('draftBtn');
  const o=btn.textContent;btn.textContent='✓ Sauvegardé !';btn.style.color='#34d399';
  setTimeout(()=>{btn.textContent=o;btn.style.color='';},2000);
}
function copyUrl(){
  const url=document.getElementById('shareUrl').textContent;
  navigator.clipboard?.writeText('https://'+url);
  document.getElementById('copyBtn').textContent='Copié !';
  setTimeout(()=>document.getElementById('copyBtn').textContent='Copier',2000);
}
</script>
</body>
</html>
