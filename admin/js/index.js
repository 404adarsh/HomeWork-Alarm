const showAdminContainerButton = document.getElementById('showAdminContainer');
const adminContainer = document.getElementById('adminContainer');

showAdminContainerButton.addEventListener('click', function() {
    if (adminContainer.style.display === 'none' || adminContainer.style.display === '') {
        adminContainer.style.display = 'block';
    } else {
        adminContainer.style.display = 'none';
    }
});

// Canvas Animation
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');

// Set canvas size to window size
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

const colors = ['#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#fd7e14', '#ffc107'];

class Particle {
    constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.radius = Math.random() * 3 + 1;
        this.speedX = Math.random() * 3 - 1.5;
        this.speedY = Math.random() * 3 - 1.5;
        this.color = colors[Math.floor(Math.random() * colors.length)];
    }

    draw() {
        ctx.fillStyle = this.color;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fill();
    }

    update() {
        this.x += this.speedX;
        this.y += this.speedY;
        if (this.x + this.radius > canvas.width || this.x - this.radius < 0) {
            this.speedX = -this.speedX;
        }
        if (this.y + this.radius > canvas.height || this.y - this.radius < 0) {
            this.speedY = -this.speedY;
        }
        this.draw();
    }
}

const particles = [];

function init() {
    for (let i = 0; i < 100; i++) {
        particles.push(new Particle());
    }
}

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(particle => {
        particle.update();
    });
    requestAnimationFrame(animate); // Recursive call to continue animation
}

init();
animate();


// JavaScript for slider
const slides = document.querySelector('.slides');
const slide = document.querySelectorAll('.slide');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
let index = 0;

function nextSlide() {
    index++;
    if (index === slide.length) {
        index = 0;
    }
    updateSlidePosition();
}

function prevSlide() {
    index--;
    if (index < 0) {
        index = slide.length - 1;
    }
    updateSlidePosition();
}

function updateSlidePosition() {
    slides.style.transform = `translateX(${-index * slide[0].clientWidth}px)`;
}

nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);