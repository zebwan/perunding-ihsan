// ===== Mobile nav toggle =====
const navToggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('.nav');

if (navToggle && nav) {
  navToggle.addEventListener('click', () => {
    nav.classList.toggle('nav-open');
  });

  nav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      nav.classList.remove('nav-open');
    });
  });
}

// ===== Stats count-up animation on scroll =====
const statSection = document.querySelector('#stats');
const counters = document.querySelectorAll('.stat-number[data-target]');

function animateCounter(el, target, duration = 1500) {
  const suffix = el.dataset.suffix || ''; // e.g. "+"
  const startTime = performance.now();

  function update(now) {
    const elapsed = now - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const value = Math.floor(progress * target);

    el.textContent = value + suffix;

    if (progress < 1) {
      requestAnimationFrame(update);
    } else {
      el.textContent = target + suffix; // make sure final is exact
    }
  }

  requestAnimationFrame(update);
}

if (statSection && counters.length) {
  let hasRun = false;

  const observer = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !hasRun) {
          hasRun = true;
          counters.forEach(counter => {
            const target = parseInt(counter.dataset.target, 10);
            if (!isNaN(target)) {
              animateCounter(counter, target);
            }
          });
        }
      });
    },
    { threshold: 0.4 } // when ~40% of the section is visible
  );

  observer.observe(statSection);
}
 // Smooth scroll back to top
  document.querySelector('.back-to-top').addEventListener('click', function (e) {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });