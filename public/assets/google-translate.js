(() => {
  const supported = new Set(['en', 'pa', 'hi', 'es']);
  const select = document.querySelector('[data-language-select]');
  const queryLanguage = new URLSearchParams(window.location.search).get('lang');
  let language = supported.has(queryLanguage) ? queryLanguage : (supported.has(document.documentElement.lang) ? document.documentElement.lang : 'en');
  if (select) select.value = language;

  const skip = 'script,style,noscript,svg,canvas,select,option,textarea,[translate="no"],.notranslate,[data-translate-exclude],.language-switch,.auth-language,.admin-language,.brand-logo-window,.brand-logo';
  const cachePrefix = 'hhc-dyn-tr-v4:';
  let running = false;

  const protectedBrandTerms = new Set([
    'happy home care',
    'elevated care. right at home.',
    'elevated care. right at home',
    'mail2rakeshpandit@gmail.com',
    '+91 81440 01842',
    '918144001842'
  ]);

  function isBrandProtected(str) {
    if (!str) return true;
    const lower = str.trim().toLowerCase();
    return protectedBrandTerms.has(lower);
  }

  function updateBrandLogos() {
    document.querySelectorAll('[data-brand-logo], .brand-logo').forEach(img => {
      if (img.tagName && img.tagName.toLowerCase() === 'img') {
        img.src = '/images/hhc-approved-logo.svg';
        img.alt = 'Happy Home Care - Elevated Care. Right At Home.';
      }
    });
  }

  function isExcluded(element) {
    return Boolean(element && element.closest(skip));
  }

  function hash(value) {
    let h = 2166136261;
    for (let i = 0; i < value.length; i++) h = Math.imul(h ^ value.charCodeAt(i), 16777619);
    return (h >>> 0).toString(36);
  }

  function needsTranslation(text, target) {
    if (!text) return false;
    const trimmed = text.trim();
    if (trimmed.length < 2) return false;
    if (isBrandProtected(trimmed)) return false;
    
    // Check if it contains English letters
    if (!/[a-zA-Z]{2,}/.test(trimmed)) return false;

    // If target is Hindi and already contains Devanagari script, skip
    if (target === 'hi' && /[\u0900-\u097F]/.test(trimmed)) return false;

    // If target is Punjabi and already contains Gurmukhi script, skip
    if (target === 'pa' && /[\u0A00-\u0A7F]/.test(trimmed)) return false;

    // If purely digits, punctuation, or phone
    if (/^[0-9+\s\-.,()#/*]+$/.test(trimmed)) return false;

    return true;
  }

  async function fetchTranslation(text, target) {
    const key = cachePrefix + target + ':' + hash(text);
    try {
      const cached = localStorage.getItem(key);
      if (cached && typeof cached === 'string') return cached;
    } catch (_) {}

    // Primary: Google clients5 API directly from client browser
    try {
      const url = 'https://clients5.google.com/translate_a/t?client=dict-chrome-ex&sl=en&tl=' + encodeURIComponent(target) + '&q=' + encodeURIComponent(text);
      const resp = await fetch(url);
      if (resp.ok) {
        const data = await resp.json();
        if (Array.isArray(data) && typeof data[0] === 'string' && data[0].trim()) {
          const trans = data[0].trim();
          try { localStorage.setItem(key, trans); } catch (_) {}
          return trans;
        }
      }
    } catch (_) {}

    // Fallback: server /translate.php
    try {
      const resp = await fetch('/translate.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ target, texts: [text] })
      });
      if (resp.ok) {
        const data = await resp.json();
        if (Array.isArray(data.translations) && typeof data.translations[0] === 'string' && data.translations[0].trim()) {
          const trans = data.translations[0].trim();
          try { localStorage.setItem(key, trans); } catch (_) {}
          return trans;
        }
      }
    } catch (_) {}

    return text;
  }

  async function translateDynamicContent(target) {
    if (running || target === 'en') return;
    running = true;

    try {
      updateBrandLogos();

      const items = [];
      const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
      while (walker.nextNode()) {
        const node = walker.currentNode;
        if (isExcluded(node.parentElement)) continue;
        const val = node.nodeValue;
        if (!node.__hhcOrig) node.__hhcOrig = val;
        if (needsTranslation(val, target)) {
          items.push({
            node,
            text: val,
            set: (res) => { node.nodeValue = res; }
          });
        }
      }

      // Input attributes
      document.body.querySelectorAll('input[placeholder],*[title],*[aria-label]').forEach(el => {
        if (isExcluded(el)) return;
        ['placeholder', 'title', 'aria-label'].forEach(attr => {
          if (!el.hasAttribute(attr)) return;
          const val = el.getAttribute(attr);
          const origKey = '__hhcOrig_' + attr;
          if (el[origKey] === undefined) el[origKey] = val;
          if (needsTranslation(val, target)) {
            items.push({
              node: el,
              text: val,
              set: (res) => { el.setAttribute(attr, res); }
            });
          }
        });
      });

      if (items.length === 0) return;

      // Translate in parallel batches of 6
      const uniqueTexts = [...new Set(items.map(item => item.text))];
      const translationMap = new Map();

      // Check localStorage first
      const missing = [];
      uniqueTexts.forEach(text => {
        const key = cachePrefix + target + ':' + hash(text);
        try {
          const cached = localStorage.getItem(key);
          if (cached && typeof cached === 'string') {
            translationMap.set(text, cached);
            return;
          }
        } catch (_) {}
        missing.push(text);
      });

      // Fetch missing in parallel
      const concurrency = 6;
      for (let i = 0; i < missing.length; i += concurrency) {
        const chunk = missing.slice(i, i + concurrency);
        await Promise.all(chunk.map(async (text) => {
          const trans = await fetchTranslation(text, target);
          translationMap.set(text, trans);
        }));
      }

      // Apply to all items
      items.forEach(item => {
        const translated = translationMap.get(item.text);
        if (translated && translated !== item.text) {
          item.set(translated);
        }
      });
    } catch (err) {
      console.warn('Dynamic translate error:', err);
    } finally {
      running = false;
    }
  }

  // Handle language switch
  select?.addEventListener('change', () => {
    const next = new URL(window.location.href);
    next.searchParams.set('lang', select.value);
    window.location.assign(next.toString());
  });

  // Keep brand logo consistent on load
  updateBrandLogos();

  // Run dynamic translation if not English
  if (language !== 'en') {
    translateDynamicContent(language);
  }

  // Observe dynamically added or expanded elements (e.g. FAQs opening, modals)
  let timer;
  const observer = new MutationObserver(mutations => {
    if (language === 'en') return;
    const hasAdditions = mutations.some(m => m.addedNodes && m.addedNodes.length > 0);
    if (hasAdditions) {
      clearTimeout(timer);
      timer = setTimeout(() => {
        translateDynamicContent(language);
      }, 150);
    }
  });
  observer.observe(document.body, { childList: true, subtree: true });
})();
