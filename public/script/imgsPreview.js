const slider = document.querySelector('.slider');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
const sliderContainer = document.querySelector('.slider-container');
const dotsContainer = document.querySelector('.dots-container');
const imgFiles = document.getElementById('imgInput');

let currentIndex = 0;
let autoSlideInterval;


imgFiles.addEventListener('change', () => {
    // Clear existing content
    slider.innerHTML = '';
    dotsContainer.innerHTML = '';
    currentIndex = 0;
    
    // Create new slides and dots
    for (let i = 0; i < imgFiles.files.length; i++) {
        let reader = new FileReader();
        let imagePreview = document.createElement("div");
        let imageDot = document.createElement("span");
        
        imagePreview.setAttribute('class', 'slide');
        imageDot.setAttribute('class', 'dot');
        imageDot.setAttribute('data-index', i);
        
        reader.onload = event => {
            imagePreview.innerHTML = `<img src="${event.target.result}">`;
            slider.appendChild(imagePreview);
            dotsContainer.appendChild(imageDot);
            
            // Initialize the first image
            if (i === 0) {
                showSlides(0);
                startAutoSlide();
            }
            
            // Add click event to the newly created dot
            imageDot.addEventListener('click', () => {
                stopAutoSlide();
                showSlides(parseInt(imageDot.dataset.index));
                startAutoSlide();
            });
        };
        reader.readAsDataURL(imgFiles.files[i]);
    }
});

// Function to update the active dot indicator
function updateDots() {
    const dots = document.querySelectorAll('.dot');
    dots.forEach((dot, index) => {
        if (index === currentIndex) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

// Function to display a specific slide based on the index
function showSlides(index) {
    const slides = document.querySelectorAll('.slide');
    if (slides.length === 0) return;
    
    if (index >= slides.length) {
        currentIndex = 0;
    } else if (index < 0) {
        currentIndex = slides.length - 1;
    } else {
        currentIndex = index;
    }
    
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    updateDots();
}

// Function to move to the next slide
function nextSlide() {
    const slides = document.querySelectorAll('.slide');
    if (slides.length > 0) {
        showSlides(currentIndex + 1);
    }
}

// Function to move to the previous slide
function prevSlide() {
    const slides = document.querySelectorAll('.slide');
    if (slides.length > 0) {
        showSlides(currentIndex - 1);
    }
}

// Start the automatic sliding of images
function startAutoSlide() {
    stopAutoSlide(); // Clear any existing interval first
    const slides = document.querySelectorAll('.slide');
    if (slides.length > 1) {
        autoSlideInterval = setInterval(nextSlide, 4000);
    }
}

// Stop the automatic sliding
function stopAutoSlide() {
    clearInterval(autoSlideInterval);
}

// Add event listeners for navigation buttons
nextBtn.addEventListener('click', () => {
    stopAutoSlide();
    nextSlide();
    startAutoSlide();
});

prevBtn.addEventListener('click', () => {
    stopAutoSlide();
    prevSlide();
    startAutoSlide();
});

// Stop auto-slide when the mouse enters the slider container
sliderContainer.addEventListener('mouseover', stopAutoSlide);

// Restart auto-slide when the mouse leaves the slider container
sliderContainer.addEventListener('mouseout', startAutoSlide);


// Get the modal
var modal = document.getElementById("myModal");

// Get the modal image and caption
var modalImg = document.getElementById("img01");

// Get all images in the slider
var images = document.querySelectorAll(".slider .slide img");
var prev = 

// Loop through the images and attach event listeners
images.forEach(function(img) {
img.onclick = function() {
    modal.style.display = "flex";
    prevBtn.style.display = "none";
    nextBtn.style.display = "none";
    modalImg.src = this.src;
};
});

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
modal.style.display = "none";
prevBtn.style.display = "";
nextBtn.style.display = "";
};
