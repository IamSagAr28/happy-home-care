const menuButton = document.querySelector('.menu-toggle');
const navigation = document.querySelector('.primary-nav');
menuButton?.addEventListener('click', () => {
  const open = menuButton.getAttribute('aria-expanded') !== 'true';
  menuButton.setAttribute('aria-expanded', String(open));
  navigation.classList.toggle('open', open);
});
navigation?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
  navigation.classList.remove('open');
  menuButton?.setAttribute('aria-expanded', 'false');
}));

document.querySelectorAll('[data-language-select]').forEach(select => {
  select.addEventListener('change', () => {
    const next = new URL(window.location.href);
    next.searchParams.set('lang', select.value);
    window.location.assign(next.toString());
  });
});

const quizSteps = [
  { title: 'What kind of support would feel helpful?', answers: ['A little help with daily routines', 'Company and activities', 'Specialized memory support', 'Help after a hospital stay'] },
  { title: 'When would care be most helpful?', answers: ['A few hours each week', 'Most days of the week', 'Overnight or around the clock', 'We are still figuring that out'] },
  { title: 'Where would you like care to happen?', answers: ['At home', 'At home and out in the community', 'Not sure yet'] }
];
let quizStep = 0;
let quizChoice = '';
const quizContent = document.querySelector('#quiz-content');
const quizNext = document.querySelector('#quiz-next');
function renderQuiz() {
  const current = quizSteps[quizStep];
  document.querySelector('.step-label').textContent = `Step ${quizStep + 2} of 4`;
  document.querySelector('.progress-track span').style.width = `${(quizStep + 2) * 25}%`;
  quizContent.innerHTML = `<h3>${current.title}</h3><p>Choose the one that feels closest.</p><div class="quiz-options">${current.answers.map((answer, index) => `<button class="quiz-option" data-choice="${index}">${answer}<span>→</span></button>`).join('')}</div>`;
  quizNext.disabled = true;
  quizContent.querySelectorAll('.quiz-option').forEach(option => option.addEventListener('click', () => {
    quizContent.querySelectorAll('.quiz-option').forEach(item => item.classList.remove('selected'));
    option.classList.add('selected');
    quizChoice = option.textContent.trim();
    quizNext.disabled = false;
  }));
}
quizContent?.querySelectorAll('.quiz-option').forEach(option => option.addEventListener('click', () => {
  quizContent.querySelectorAll('.quiz-option').forEach(item => item.classList.remove('selected'));
  option.classList.add('selected');
  quizChoice = option.textContent.trim();
  quizNext.disabled = false;
}));
quizNext?.addEventListener('click', () => {
  if (!quizChoice) return;
  if (quizStep < quizSteps.length) {
    quizStep += 1;
    quizChoice = '';
    if (quizStep < quizSteps.length) renderQuiz();
    else {
      document.querySelector('.step-label').textContent = 'Your next step';
      document.querySelector('.progress-track span').style.width = '100%';
      quizContent.innerHTML = '<h3>A caring conversation can help.</h3><p>Based on your answers, a care specialist can help you explore a plan that feels right for your family.</p><a class="button quiz-next" href="#contact">Talk with our team <span>→</span></a>';
      quizNext.hidden = true;
    }
  }
});

const stateFilter = document.querySelector('#location-filter');
const citySearch = document.querySelector('#location-search');
function filterLocations() {
  const state = stateFilter.value;
  const query = citySearch.value.trim().toLowerCase();
  document.querySelectorAll('.secondary-location').forEach(card => {
    const matchesState = state === 'all' || card.dataset.state === state;
    const matchesQuery = !query || card.textContent.toLowerCase().includes(query);
    card.style.display = matchesState && matchesQuery ? 'flex' : 'none';
  });
  const first = document.querySelector('#location-results');
  const firstMatchesState = state === 'all' || state === 'Texas';
  const firstMatchesQuery = !query || first.textContent.toLowerCase().includes(query);
  first.style.display = firstMatchesState && firstMatchesQuery ? 'flex' : 'none';
  if (state !== 'all' && state !== 'Texas' && !document.querySelector('.secondary-location[style*="flex"]')) {
    document.querySelector('#location-results').insertAdjacentHTML('afterend', '<p class="empty-locations">More local teams are coming soon. <a href="#contact">Ask us about care in your area →</a></p>');
  } else document.querySelector('.empty-locations')?.remove();
}
stateFilter?.addEventListener('change', filterLocations);
citySearch?.addEventListener('input', filterLocations);

document.querySelector('#zip-form')?.addEventListener('submit', event => {
  event.preventDefault();
  document.querySelector('#locations').scrollIntoView({ behavior: 'smooth' });
  citySearch.value = document.querySelector('#zip').value;
  filterLocations();
});
