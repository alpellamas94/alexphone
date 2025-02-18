$(function () {

    // Inicializamos el slider del hero
    if($('.mdl-hero').length > 1){
        const swiperHero = new Swiper('.mdl-hero .swiper-container', {
            slidesPerView: "auto",
            slidesPerGroup: 1,
            spaceBetween: 0,
            loop: true,
            speed: 1500,
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
            allowTouchMove: false,
        });
    }

    if($('.mdl-listado .m-grid .m-item').length > 1){
        let mixer = mixitup("#grid-elements", {
            selectors: {
                target: ".mix"
            },
            animation: {
                duration: 300
            }
        });
    
        let $categoryFilter = $("#category-filter");
        let $colorFilter = $("#color-filter");
    
        function updateFilters() {
            let category = $categoryFilter.val() || "";
            let color = $colorFilter.val() || "";
    
            let filters = [];
    
            if (category) filters.push(category);
            if (color) filters.push(color);
    
            let filterString = filters.length ? filters.join("") : "all";
    
            mixer.filter(filterString);
        }
    
        // Event Listeners para actualizar filtros
        $categoryFilter.on("change", updateFilters);
        $colorFilter.on("change", updateFilters);
    }
});
