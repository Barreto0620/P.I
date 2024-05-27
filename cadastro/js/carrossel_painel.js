const arrowBtns = document.querySelectorAll('.arrow-btn');
const cards = document.querySelectorAll('.card');
let currentCard = 2; // Alterado para iniciar no primeiro cartão (índice 0)
let dir = 1;
moveCards();

const applyPointerEffect = (btn, ease, shadow) => {
  btn.onpointerenter = () => gsap.to(btn, { ease, 'box-shadow': shadow });
  btn.onpointerleave = () => gsap.to(btn, { ease, 'box-shadow': '0 6px 8px #00000030' });
};

arrowBtns.forEach((btn, i) => {
  applyPointerEffect(btn, 'expo', '0 3px 4px #00000050');
  btn.onclick = () => {
    dir = (i == 0) ? 1 : -1;
    currentCard += (i === 0) ? -1 : 1;
    currentCard = (currentCard < 0) ? cards.length - 1 : (currentCard >= cards.length) ? 0 : currentCard;
    moveCards(0.75);
  };
});

cards.forEach((card, i) => {
  applyPointerEffect(card, 'power3', () => (i === currentCard) ? '0 6px 11px #00000030' : '0 0px 0px #00000030');
  card.onclick = () => {
    dir = (i < currentCard) ? 1 : -1;
    currentCard = i;
    moveCards(0.75);
  };
});

function moveCards(dur = 0) {
  gsap.timeline({ defaults: { duration: dur, ease: 'power3', stagger: { each: -0.03 * dir } } })
    .to('.card', {
      x: -270 * currentCard,
      y: (i) => (i === currentCard) ? 0 : 15,
      height: (i) => (i === currentCard) ? 270 : 240,
      ease: 'elastic.out(0.4)'
    }, 0)
    .to('.card', {
      cursor: (i) => (i === currentCard) ? 'default' : 'pointer',
      'box-shadow': (i) => (i === currentCard) ? '0 6px 11px #00000030' : '0 0px 0px #00000030',
      background: (i) => (i === currentCard) ? '#1a2e3d' : '#1a2e3d',
      ease: 'expo'
    }, 0)
    .to('.arrow-btn-prev, .arrow-btn-next', {
      autoAlpha: (i) => (i === 0 && currentCard === 0) || (i === 1 && currentCard === cards.length - 1) ? 0 : 1
    }, 0)
    .to('.card h4', {
      y: (i) => (i === currentCard) ? 0 : 8,
      opacity: (i) => (i === currentCard) ? 1 : 0,
    }, 0);
}
