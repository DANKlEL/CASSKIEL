const track = document.querySelector('.carousel-track');
const slides = Array.from(track.children);

let currentIndex = 0;

const initializeCarousel = () => {
  const firstClone = slides[0].cloneNode(true);
  const lastClone = slides[slides.length - 1].cloneNode(true);

  track.appendChild(firstClone);
  track.insertBefore(lastClone, slides[0]);

  const slideWidth = slides[0].getBoundingClientRect().width;
  track.style.transform = `translateX(-${slideWidth}px)`;
  currentIndex = 0;
};

const moveToSlide = (index) => {
  const slideWidth = slides[0].getBoundingClientRect().width;
  track.style.transition = 'transform 0.5s ease-in-out';
  track.style.transform = `translateX(-${(index + 1) * slideWidth}px)`;
};

const handleNext = () => {
  const slideWidth = slides[0].getBoundingClientRect().width;
  currentIndex++;
  moveToSlide(currentIndex);

  if (currentIndex === slides.length - 1) {
    setTimeout(() => {
      track.style.transition = 'none';
      track.style.transform = `translateX(-${slideWidth}px)`;
      currentIndex = 0;
    }, 500);
  }
};

const handlePrev = () => {
  const slideWidth = slides[0].getBoundingClientRect().width;
  currentIndex--;
  moveToSlide(currentIndex);

  if (currentIndex < 0) {
    setTimeout(() => {
      track.style.transition = 'none';
      track.style.transform = `translateX(-${(slides.length - 1) * slideWidth}px)`;
      currentIndex = slides.length - 2;
    }, 500);
  }
};

const autoScroll = () => {
  setInterval(() => {
    handleNext();
  }, 3000);
};

initializeCarousel();
autoScroll();