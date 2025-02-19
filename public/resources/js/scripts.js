$(function () {

    // Inicializamos el slider del hero
    if($('.mdl-hero .swiper-slide').length > 1){
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
    
        let $nameFilter = $("#name-filter");
        let $gradeFilter = $("#grade-filter");
        let $colorFilter = $("#color-filter");
        let $storageFilter = $("#storage-filter");
    
        function updateFilters() {
            let name = $nameFilter.val() || "";
            let grade = $gradeFilter.val() || "";
            let color = $colorFilter.val() || "";
            let storage = $storageFilter.val() || "";
        
            let filters = [];
        
            if (name) filters.push(name);
            if (grade) filters.push(grade);
            if (color) filters.push(color);
            if (storage) filters.push(storage);
        
            let filterString = filters.length ? filters.join("") : "all";
        
            mixer.filter(filterString);

            // Elimina el primer caracter del string "."
            if (name) name = name.substring(1);
            if (grade) grade = grade.substring(1);
            if (color) color = color.substring(1);
            if (storage) storage = storage.substring(1);

            // Actualizamos la URL con los parámetros de los filtros
            let url = new URL(window.location);
            if (name) {
                url.searchParams.set('name', name);
            } else {
                url.searchParams.delete('name');
            }
            if (grade) {
                url.searchParams.set('grade', grade);
            } else {
                url.searchParams.delete('grade');
            }
            if (color) {
                url.searchParams.set('color', color);
            } else {
                url.searchParams.delete('color');
            }
            if (storage) {
                url.searchParams.set('storage', storage);
            } else {
                url.searchParams.delete('storage');
            }
            window.history.replaceState({}, '', url);
        }

        // Setea los filtros en base a los parámetros de la URL
        function setInitialFilters() {
            let urlParams = new URLSearchParams(window.location.search);
            let name = urlParams.get('name');
            let grade = urlParams.get('grade');
            let color = urlParams.get('color');
            let storage = urlParams.get('storage');

            if (name) {
                $nameFilter.val(`.${name}`).trigger('change');
            }
            if (grade) {
                $gradeFilter.val(`.${grade}`).trigger('change');
            }
            if (color) {
                $colorFilter.val(`.${color}`).trigger('change');
            }
            if (storage) {
                $storageFilter.val(`.${storage}`).trigger('change');
            }

            updateFilters();
        }

        // Controla si se mostrará el botón para resetear los filtros
        function toggleResetVisibility() {
            let name = $nameFilter.val();
            let grade = $gradeFilter.val();
            let color = $colorFilter.val();
            let storage = $storageFilter.val();
        
            if (name || grade || color || storage) {
                $("#reset-filter").addClass('active');
            } else {
                $("#reset-filter").removeClass('active');
            }
        }
    
        // Actualizar filtros y visibilidad del reset
        function handleFilterChange() {
            updateFilters();
            toggleResetVisibility();
        }

        $nameFilter.on("change", handleFilterChange);
        $gradeFilter.on("change", handleFilterChange);
        $colorFilter.on("change", handleFilterChange);
        $storageFilter.on("change", handleFilterChange);

        // Resetear filtros al hacer clic en el botón de reset
        $("#reset-filter").on("click", function() {
            $nameFilter.val("").trigger("change");
            $gradeFilter.val("").trigger("change");
            $colorFilter.val("").trigger("change");
            $storageFilter.val("").trigger("change");
            updateFilters();
            toggleResetVisibility();
        });
        
        // Inicializamos filtros al cargar la página
        setInitialFilters();
        toggleResetVisibility();
    }
});
