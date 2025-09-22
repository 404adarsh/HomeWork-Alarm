let slideIndex = 0;

function showSlide(index) {
  const slides = document.getElementsByClassName('slide');
  if (index >= slides.length) {
    slideIndex = 0;
  } else if (index < 0) {
    slideIndex = slides.length - 1;
  }
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = 'none';
  }
  slides[slideIndex].style.display = 'block';
}

function nextSlide() {
  showSlide(++slideIndex);
}

function prevSlide() {
  showSlide(--slideIndex);
}

// Show the first slide initially
showSlide(slideIndex);

// Automatic sliding every 3 seconds
setInterval(nextSlide, 3000);


