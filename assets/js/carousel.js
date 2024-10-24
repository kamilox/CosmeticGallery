jQuery(document).ready(function($){

    const carousel = document.querySelector('.carousel');
    const carouselInner = carousel.querySelector('.carousel-inner');
    const prevBtn   
    = carousel.querySelector('.prev');
    const nextBtn = carousel.querySelector('.next');

    let currentIndex = 0;
    const itemsPerPage = 4; // Número de imágenes por grupo

    prevBtn.addEventListener('click', () => {
        currentIndex = Math.max(currentIndex - 1, 0);
        updateCarousel();
    });

    nextBtn.addEventListener('click', () => {
        currentIndex = Math.min(currentIndex   
    + 1, carouselInner.children.length - 1);
        updateCarousel();
    });

    function updateCarousel() {
        var screenWidth = $(window).width();
        if(screenWidth > 768){
            carouselInner.style.transform = `translateX(-${currentIndex * 34}%)`;
        }
        if(screenWidth < 769){
            carouselInner.style.transform = `translateX(-${currentIndex * 50}%)`;
        }
    }
    
    //display images from gallery to top
    jQuery('.carousel-item').on('click', function(){
        var sons = $(this).children().find('img');
    
        var urls = [];
        sons.each(function() {
            urls.push($(this).attr("src"));
        });

        $(".gallery-images-top").find('img').each(function(index) {
            $(this).attr("src", urls[index]);
        });
        
    });
});