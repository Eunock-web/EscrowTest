<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PixelVault — Connexion</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    html,body{height:100%;}
    body{background:#09090f;color:#e2e8f0;font-family:'DM Sans',sans-serif;cursor:none;overflow:hidden;}
    h1,h2,h3{font-family:'Syne',sans-serif;}
    #cur{width:10px;height:10px;background:#7c3aed;border-radius:50%;position:fixed;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:.15s width,.15s height;mix-blend-mode:screen;}
    #ring{width:32px;height:32px;border:1px solid rgba(124,58,237,.4);border-radius:50%;position:fixed;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);}
    .g{background:linear-gradient(135deg,#a78bfa,#22d3ee);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
    body::after{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");pointer-events:none;z-index:999;opacity:.5;}

    .orb{position:absolute;border-radius:50%;filter:blur(70px);pointer-events:none;}
    .float-card{position:absolute;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:16px;backdrop-filter:blur(10px);padding:14px 16px;}

    @keyframes floatA{0%,100%{transform:translateY(0) rotate(-2deg)}50%{transform:translateY(-16px) rotate(0)}}
    @keyframes floatB{0%,100%{transform:translateY(0) rotate(2deg)}50%{transform:translateY(-12px) rotate(-1deg)}}
    @keyframes floatC{0%,100%{transform:translateY(-6px) rotate(1deg)}50%{transform:translateY(8px) rotate(-2deg)}}
    @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
    @keyframes slideIn{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}
    @keyframes pulse{0%,100%{opacity:.5}50%{opacity:1}}
    @keyframes spin{to{transform:rotate(360deg)}}
    @keyframes rotSlow{from{transform:translate(-50%,-50%) rotate(0)}to{transform:translate(-50%,-50%) rotate(360deg)}}

    .left{background:#050509;position:relative;overflow:hidden;}
    .right{background:#09090f;overflow-y:auto;display:flex;align-items:center;justify-content:center;}

    .inp-w{position:relative;background:rgba(255,255,255,.03);border:1.5px solid #1a1a2e;border-radius:14px;transition:border-color .2s,box-shadow .2s;}
    .inp-w:focus-within{border-color:rgba(124,58,237,.6);box-shadow:0 0 0 4px rgba(124,58,237,.08);}
    .inp-w.ok{border-color:rgba(16,185,129,.4);}
    .inp-ico{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#2e2e48;transition:color .2s;pointer-events:none;}
    .inp-w:focus-within .inp-ico{color:#a78bfa;}
    input.inp{background:transparent;border:none;outline:none;color:#e2e8f0;font-family:'DM Sans',sans-serif;font-size:14px;width:100%;padding:15px 15px 15px 46px;}
    input.inp::placeholder{color:#2a2a3e;}
    .eye{position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#3f3f5a;cursor:pointer;transition:color .2s;background:none;border:none;}
    .eye:hover{color:#a78bfa;}

    .btn-main{background:linear-gradient(135deg,#7c3aed,#5b21b6);border:none;cursor:pointer;position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s;font-family:'Syne',sans-serif;font-weight:700;}
    .btn-main::before{content:'';position:absolute;inset:0;background:linear-gradient(100deg,transparent 40%,rgba(255,255,255,.18) 50%,transparent 60%);background-size:200% 100%;animation:shimmer 2.5s infinite;}
    .btn-main:hover{transform:translateY(-2px);box-shadow:0 0 28px rgba(124,58,237,.55);}
    .btn-main:disabled{opacity:.35;pointer-events:none;}

    .btn-soc{display:flex;align-items:center;justify-content:center;gap:10px;background:rgba(255,255,255,.04);border:1.5px solid #1a1a2e;border-radius:13px;padding:13px;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;color:#e2e8f0;transition:all .2s;}
    .btn-soc:hover{border-color:rgba(124,58,237,.4);background:rgba(124,58,237,.06);transform:translateY(-1px);}

    .or{display:flex;align-items:center;gap:12px;color:#2a2a3e;font-size:11px;}
    .or::before,.or::after{content:'';flex:1;height:1px;background:#1a1a2e;}

    .chk{width:17px;height:17px;border-radius:5px;border:1.5px solid #2a2a3e;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;flex-shrink:0;}
    .chk.on{background:#7c3aed;border-color:#7c3aed;}

    .spinner{width:18px;height:18px;border-radius:50%;border:2px solid rgba(255,255,255,.2);border-top-color:#fff;animation:spin .6s linear infinite;}
    ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-thumb{background:rgba(124,58,237,.3);border-radius:2px}
  </style>
</head>
<body>
<div id="cur"></div>
<div id="ring"></div>

<div style="display:grid;grid-template-columns:1fr 1fr;height:100vh;">

  <!-- LEFT -->
  <div class="left">
    <svg style="position:absolute;inset:0;width:100%;height:100%;opacity:.12;" preserveAspectRatio="xMidYMid slice">
      <defs><pattern id="gp" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M60 0L0 0 0 60" fill="none" stroke="#7c3aed" stroke-width=".6"/></pattern></defs>
      <rect width="100%" height="100%" fill="url(#gp)"/>
    </svg>
    <div class="orb" style="width:380px;height:380px;background:rgba(124,58,237,.22);top:-80px;left:-80px;"></div>
    <div class="orb" style="width:260px;height:260px;background:rgba(6,182,212,.13);bottom:80px;right:-40px;"></div>
    <div class="orb" style="width:180px;height:180px;background:rgba(245,158,11,.08);top:48%;left:38%;"></div>
    <svg style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) rotate(0);opacity:.06;animation:rotSlow 40s linear infinite;" width="520" height="520" viewBox="0 0 520 520">
      <circle cx="260" cy="260" r="240" fill="none" stroke="#7c3aed" stroke-width="1" stroke-dasharray="10 16"/>
      <circle cx="260" cy="260" r="170" fill="none" stroke="#06b6d4" stroke-width=".6" stroke-dasharray="4 10"/>
      <circle cx="260" cy="260" r="100" fill="none" stroke="#f59e0b" stroke-width=".4" stroke-dasharray="2 6"/>
    </svg>

    <div style="position:relative;z-index:2;height:100%;display:flex;flex-direction:column;justify-content:space-between;padding:40px;">
      <a href="index.html" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
        <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#06b6d4);display:flex;align-items:center;justify-content:center;">
          <svg width="18" height="18" fill="#fff" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
        </div>
        <span style="font-family:'Syne',sans-serif;font-weight:800;font-size:18px;color:#fff;">Pixel<span class="g">Vault</span></span>
      </a>

      <div>
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(124,58,237,.12);border:1px solid rgba(124,58,237,.3);border-radius:100px;padding:6px 14px;margin-bottom:22px;">
          <span style="width:6px;height:6px;border-radius:50%;background:#a78bfa;display:block;animation:pulse 2s ease-in-out infinite;"></span>
          <span style="font-size:12px;color:#a78bfa;font-weight:500;">+12 000 créatifs actifs</span>
        </div>
        <h1 style="font-family:'Syne',sans-serif;font-size:clamp(2rem,3.5vw,3rem);font-weight:800;color:#fff;line-height:.95;margin-bottom:18px;">La marketplace<br/>des <span class="g">créatifs</span><br/>ambitieux.</h1>
        <p style="color:#64748b;font-size:14px;line-height:1.7;max-width:320px;">2 400 ressources premium. Des centaines de créateurs talentueux. Tout pour créer, vendre et grandir.</p>
      </div>

      <!-- Floating cards -->
      <div class="float-card" style="top:36%;right:24px;animation:floatA 5s ease-in-out infinite;">
        <div style="font-size:10px;color:#7c3aed;font-weight:600;margin-bottom:6px;letter-spacing:.05em;">DERNIÈRE VENTE</div>
        <div style="display:flex;align-items:center;gap:10px;">
          <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,rgba(124,58,237,.3),rgba(6,182,212,.2));display:flex;align-items:center;justify-content:center;font-size:14px;">🎨</div>
          <div>
            <div style="font-size:12px;color:#e2e8f0;font-weight:600;">SaaS Dashboard Pro</div>
            <div style="font-size:11px;color:#34d399;">+49€ · il y a 2 min</div>
          </div>
        </div>
      </div>
      <div class="float-card" style="top:57%;left:20px;animation:floatB 6s ease-in-out infinite;">
        <div style="font-size:10px;color:#64748b;margin-bottom:4px;">Revenus ce mois</div>
        <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:#fff;">3 847<span class="g">€</span></div>
        <div style="font-size:11px;color:#34d399;">↑ +24% vs mois dernier</div>
      </div>
      <div class="float-card" style="bottom:130px;right:16px;animation:floatC 7s ease-in-out infinite;padding:10px 14px;">
        <div style="color:#f59e0b;font-size:12px;margin-bottom:3px;">★★★★★</div>
        <div style="font-size:11px;color:#94a3b8;max-width:130px;">"La meilleure plateforme créative."</div>
      </div>

      <div style="display:flex;gap:24px;padding-top:20px;border-top:1px solid rgba(255,255,255,.06);">
        <div><div style="font-family:'Syne',sans-serif;font-weight:800;font-size:20px;color:#fff;">2.4k<span class="g">+</span></div><div style="font-size:11px;color:#64748b;">Ressources</div></div>
        <div style="width:1px;background:rgba(255,255,255,.07);"></div>
        <div><div style="font-family:'Syne',sans-serif;font-weight:800;font-size:20px;color:#fff;">847<span class="g">+</span></div><div style="font-size:11px;color:#64748b;">Créateurs</div></div>
        <div style="width:1px;background:rgba(255,255,255,.07);"></div>
        <div><div style="font-family:'Syne',sans-serif;font-weight:800;font-size:20px;color:#fff;">70<span class="g">%</span></div><div style="font-size:11px;color:#64748b;">Commission</div></div>
      </div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <div style="width:100%;max-width:420px;padding:50px 48px;animation:slideIn .5s ease both;">
      <div style="margin-bottom:32px;">
        <h2 style="font-size:28px;font-weight:800;color:#fff;margin-bottom:6px;">Bon retour 👋</h2>
        <p style="color:#64748b;font-size:14px;">Connectez-vous à votre espace créatif</p>
      </div>

      @if (session('success'))
        <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:12px;padding:12px;margin-bottom:18px;color:#34d399;font-size:13px;display:flex;align-items:center;gap:10px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:12px;padding:12px;margin-bottom:18px;color:#f87171;font-size:13px;display:flex;align-items:center;gap:10px;">
            <svg width="16" height="16" fill="none" stroke="#f87171" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>
            <span style="color:#f87171;font-size:13px;">{{ session('error') }}</span>
        </div>
      @endif


      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:6px;">
        <button class="btn-soc" onclick="socialLogin(this)">
          <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285f4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34a853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#fbbc05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#ea4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
          Google
        </button>
        <button class="btn-soc" onclick="socialLogin(this)">
          <svg width="18" height="18" fill="#e2e8f0" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
          GitHub
        </button>
      </div>

      <div class="or" style="margin:20px 0;">ou avec votre email</div>

      <form action="{{ url('auth/login') }}" method="POST">
        @csrf
        <div style="display:flex;flex-direction:column;gap:12px;">
          <div>
            <div class="inp-w @error('email') border-red-500 @enderror" id="wE">
              <div class="inp-ico"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
              <input class="inp" type="email" id="email" name="email" placeholder="vous@email.com" oninput="chk()" autocomplete="email" value="{{ old('email') }}"/>
            </div>
            @error('email') <span style="color:#f87171;font-size:10px;margin-top:2px;display:block;">{{ $message }}</span> @enderror
          </div>
          <div>
            <div class="inp-w @error('password') border-red-500 @enderror" id="wP">
              <div class="inp-ico"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
              <input class="inp" type="password" id="pass" name="password" placeholder="Mot de passe" style="padding-right:48px;" oninput="chk()" autocomplete="current-password"/>
              <button class="eye" onclick="togglePass('pass')" type="button"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
            </div>
            @error('password') <span style="color:#f87171;font-size:10px;margin-top:2px;display:block;">{{ $message }}</span> @enderror
          </div>

        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin:16px 0 24px;">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;" onclick="toggleRem()">
            <div class="chk" id="remChk"></div>
            <input type="checkbox" name="remember" id="remember" style="display:none">
            <span style="font-size:13px;color:#64748b;">Se souvenir de moi</span>
          </label>
          <a href="#" style="font-size:13px;color:#7c3aed;text-decoration:none;">Mot de passe oublié ?</a>
        </div>

        <button type="submit" class="btn-main" id="subBtn" disabled
          style="width:100%;padding:15px;border-radius:14px;color:#fff;font-size:15px;display:flex;align-items:center;justify-content:center;gap:10px;">
          <span id="bTxt">Se connecter</span>
          <div class="spinner" id="bSpin" style="display:none;"></div>
        </button>
      </form>

      <p style="text-align:center;margin-top:22px;color:#64748b;font-size:13px;">
        Pas de compte ? <a href="register" style="color:#a78bfa;font-weight:600;text-decoration:none;">Créer un compte →</a>
      </p>

      <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:28px;color:#2e2e48;font-size:11px;">
        <svg width="11" height="11" fill="none" stroke="#34d399" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        SSL 256-bit
        <span style="margin:0 6px;color:#1a1a2e;">|</span>
        <a href="index.html" style="color:#2e2e48;text-decoration:none;">← Accueil</a>
      </div>
    </div>
  </div>
</div>

<script>
const cur=document.getElementById('cur'),ring=document.getElementById('ring');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;cur.style.left=mx+'px';cur.style.top=my+'px';});
(function loop(){rx+=(mx-rx)*.1;ry+=(my-ry)*.1;ring.style.left=rx+'px';ring.style.top=ry+'px';requestAnimationFrame(loop);})();
document.querySelectorAll('a,button,input,label').forEach(el=>{
  el.addEventListener('mouseenter',()=>{cur.style.width='20px';cur.style.height='20px';ring.style.width='48px';ring.style.height='48px';});
  el.addEventListener('mouseleave',()=>{cur.style.width='10px';cur.style.height='10px';ring.style.width='32px';ring.style.height='32px';});
});
function toggleRem(){
  rem=!rem;
  const b=document.getElementById('remChk');
  const inp=document.getElementById('remember');
  b.classList.toggle('on',rem);
  inp.checked = rem;
  b.innerHTML=rem?'<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>':'';
}
function chk(){const e=document.getElementById('email').value,p=document.getElementById('pass').value,ok=/.+@.+\..+/.test(e)&&p.length>0;const b=document.getElementById('subBtn');b.disabled=!ok;b.style.opacity=ok?'1':'.35';}
function togglePass(id){const i=document.getElementById(id);i.type=i.type==='password'?'text':'password';}
document.querySelector('form').addEventListener('submit', function() {
  const b=document.getElementById('subBtn'),sp=document.getElementById('bSpin'),tx=document.getElementById('bTxt');
  b.disabled=true;
  sp.style.display='block';
  tx.style.opacity='0';
});
function socialLogin(btn){btn.style.opacity='.5';btn.style.pointerEvents='none';setTimeout(()=>location.href='index.html',1600);}
document.getElementById('subBtn').style.opacity='.35';
</script>
</body>
</html>
