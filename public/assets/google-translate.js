(() => {
  const supported = new Set(['en', 'pa', 'hi', 'es']);
  const select = document.querySelector('[data-language-select]');
  const queryLanguage = new URLSearchParams(window.location.search).get('lang');
  let language = supported.has(queryLanguage) ? queryLanguage : (supported.has(document.documentElement.lang) ? document.documentElement.lang : 'en');
  if (select) select.value = language;

  const skip = 'script,style,noscript,svg,canvas,select,option,textarea,[translate="no"],.notranslate,[data-translate-exclude],.language-switch,.auth-language,.admin-language';
  const cachePrefix = 'hhc-google-translate-v3:';
  let applying = false;
  let notice;
  let originalTitle = document.title;

  const brandAlt = {
    en: 'Happy Home Care - Elevated Care. Right At Home.',
    pa: 'Happy Home Care - Elevated Care. Right At Home.',
    hi: 'Happy Home Care - Elevated Care. Right At Home.',
    es: 'Happy Home Care - Elevated Care. Right At Home.'
  };

  function updateBrandLogos(target) {
    // Keep the official brand logo fixed without translating
    document.querySelectorAll('[data-brand-logo], .brand-logo').forEach(img => {
      if (img.tagName && img.tagName.toLowerCase() === 'img') {
        img.src = '/images/hhc-approved-logo.svg';
        img.alt = 'Happy Home Care - Elevated Care. Right At Home.';
      }
    });
  }

  function setNotice(message) {
    if (!notice) {
      notice = document.createElement('div');
      notice.className = 'translation-status';
      notice.setAttribute('role', 'status');
      document.body.appendChild(notice);
    }
    notice.textContent = message;
    notice.hidden = !message;
  }

  function isExcluded(element) {
    return Boolean(element && element.closest(skip));
  }

  function hash(value) {
    let h = 2166136261;
    for (let i = 0; i < value.length; i++) h = Math.imul(h ^ value.charCodeAt(i), 16777619);
    return (h >>> 0).toString(36);
  }

  function collect() {
    const records = [];
    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
    while (walker.nextNode()) {
      const node = walker.currentNode;
      if (isExcluded(node.parentElement) || !node.nodeValue.trim()) continue;
      if (!node.__hhcOriginal) node.__hhcOriginal = node.nodeValue;
      records.push({ node, original: node.__hhcOriginal, set: value => { node.nodeValue = value; } });
    }
    document.body.querySelectorAll('input[placeholder],img[alt],*[title],*[aria-label]').forEach(element => {
      if (isExcluded(element)) return;
      for (const attribute of ['placeholder', 'alt', 'title', 'aria-label']) {
        if (!element.hasAttribute(attribute)) continue;
        const originalKey = `__hhcOriginal_${attribute}`;
        if (element[originalKey] === undefined) element[originalKey] = element.getAttribute(attribute);
        const original = element[originalKey];
        if (!original || !original.trim()) continue;
        records.push({ node: element, original, set: value => element.setAttribute(attribute, value) });
      }
    });
    return records;
  }

  async function translateBatch(records, target) {
    const strings = records.map(record => record.original);
    const key = cachePrefix + target + ':' + hash(strings.join('\u001f'));
    try {
      const saved = localStorage.getItem(key);
      if (saved) {
        const values = JSON.parse(saved);
        if (Array.isArray(values) && values.length === records.length) {
          records.forEach((record, index) => record.set(values[index]));
          return;
        }
      }
    } catch (_) { /* Private browsing may disable storage. */ }

    const response = await fetch('/translate.php', {
      method: 'POST',
      credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ target, texts: strings })
    });
    const result = await response.json().catch(() => ({}));
    if (!response.ok || !Array.isArray(result.translations)) {
      throw new Error(result.error || 'Translation service is unavailable.');
    }
    records.forEach((record, index) => record.set(result.translations[index] ?? record.original));
    try {
      localStorage.setItem(key, JSON.stringify(result.translations));
    } catch (_) { /* Translation still works without a cache. */ }
  }

  async function translatePage(target) {
    updateBrandLogos(target);
    if (target === 'en') {
      applying = true;
      collect().forEach(record => record.set(record.original));
      document.documentElement.lang = 'en';
      document.title = originalTitle;
      setNotice('');
      applying = false;
      return;
    }
    if (applying) return;
    applying = true;
    try {
      const records = collect();
      const batches = [];
      let batch = [], size = 0;
      records.forEach(record => {
        const length = Array.from(record.original).length;
        if (batch.length >= 128 || (batch.length && size + length > 26000)) {
          batches.push(batch);
          batch = [];
          size = 0;
        }
        batch.push(record);
        size += length;
      });
      if (batch.length) batches.push(batch);
      for (const group of batches) await translateBatch(group, target);
      if (originalTitle.trim()) {
        const [translatedTitle] = await translateStrings([originalTitle], target);
        if (translatedTitle) document.title = translatedTitle;
      }
      document.documentElement.lang = target;
      setNotice('');
    } catch (error) {
      console.warn('Translation warning:', error);
      setNotice('');
    } finally {
      applying = false;
    }
  }

  async function translateStrings(texts, target) {
    const response = await fetch('/translate.php', {
      method: 'POST',
      credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ target, texts })
    });
    const result = await response.json().catch(() => ({}));
    if (!response.ok || !Array.isArray(result.translations)) {
      return texts;
    }
    return result.translations;
  }

  select?.addEventListener('change', () => {
    const next = new URL(window.location.href);
    next.searchParams.set('lang', select.value);
    window.location.assign(next.toString());
  });

  // Ensure brand logo matches initial language
  updateBrandLogos(language);

  // Only run client-side translation if the page was NOT already server-rendered in the target language
  const serverLang = document.documentElement.lang || 'en';
  if (language !== 'en' && serverLang !== language) {
    translatePage(language);
  }

  const observer = new MutationObserver(changes => {
    if (applying || language === 'en') return;
    if (changes.some(change => [...change.addedNodes].some(node => node.nodeType === Node.ELEMENT_NODE || (node.nodeType === Node.TEXT_NODE && node.nodeValue.trim())))) {
      window.clearTimeout(observer.timer);
      observer.timer = window.setTimeout(() => {
        if (document.documentElement.lang !== language) {
          translatePage(language);
        }
      }, 120);
    }
  });
  observer.observe(document.body, { childList: true, subtree: true });
})();
