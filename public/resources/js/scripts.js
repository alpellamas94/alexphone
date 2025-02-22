$(function () {
    // Inicializamos el slider del hero
    if($('.mdl-hero .swiper-slide').length > 1){
        const swiperHero = new Swiper('.mdl-hero .swiper-container', {
            slidesPerView: "auto",
            slidesPerGroup: 1,
            spaceBetween: 0,
            loop: true,
            speed: 1200,
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
            allowTouchMove: false,
        });
    }

    if ($('.mdl-listado .m-grid .m-item').length > 1) {
        let mixer = mixitup("#grid-elements", {
            selectors: {
                target: ".mix"
            },
            animation: {
                duration: 300
            }
        });
    
        let $sortFilter = $("#sort-filter");
        let $nameFilter = $("#name-filter");
        let $gradeFilter = $("#grade-filter");
        let $colorFilter = $("#color-filter");
        let $storageFilter = $("#storage-filter");
    
        function updateFilters() {
            let name = $nameFilter.val() || "";
            let grade = $gradeFilter.val() || "";
            let color = $colorFilter.val() || "";
            let storage = $storageFilter.val() || "";
            let sort = $sortFilter.val() || "";
    
            let filters = [];
            if (name) filters.push(name);
            if (grade) filters.push(grade);
            if (color) filters.push(color);
            if (storage) filters.push(storage);
    
            let filterString = filters.length ? filters.join("") : "all";
            mixer.filter(filterString);
    
            // Elimina el primer "." de cada filtro si existe
            name = name.replace(/^\./, "");
            grade = grade.replace(/^\./, "");
            color = color.replace(/^\./, "");
            storage = storage.replace(/^\./, "");
    
            // Actualiza la URL con los parámetros de filtros y ordenación
            let url = new URL(window.location);
            name ? url.searchParams.set("name", name) : url.searchParams.delete("name");
            grade ? url.searchParams.set("grade", grade) : url.searchParams.delete("grade");
            color ? url.searchParams.set("color", color) : url.searchParams.delete("color");
            storage ? url.searchParams.set("storage", storage) : url.searchParams.delete("storage");
            sort ? url.searchParams.set("sort", sort) : url.searchParams.delete("sort");
    
            window.history.replaceState({}, "", url);
        }
    
        function updateSorting() {
            let sortValue = $sortFilter.val();
            mixer.sort(sortValue || "default");
            updateFilters(); // Llamamos para actualizar la URL
        }
    
        function setInitialFilters() {
            let urlParams = new URLSearchParams(window.location.search);
            let name = urlParams.get("name");
            let grade = urlParams.get("grade");
            let color = urlParams.get("color");
            let storage = urlParams.get("storage");
            let sort = urlParams.get("sort");
    
            if (name) $nameFilter.val(`.${name}`).trigger("change");
            if (grade) $gradeFilter.val(`.${grade}`).trigger("change");
            if (color) $colorFilter.val(`.${color}`).trigger("change");
            if (storage) $storageFilter.val(`.${storage}`).trigger("change");
            if (sort) {
                $sortFilter.val(sort);
                mixer.sort(sort);
            }
    
            updateFilters();
        }
    
        function toggleResetVisibility() {
            let hasFilters = $nameFilter.val() || $gradeFilter.val() || $colorFilter.val() || $storageFilter.val() || $sortFilter.val();
            $("#reset-filter").toggleClass("active", !!hasFilters);
        }
    
        function handleFilterChange() {
            updateFilters();
            updateSorting();
            toggleResetVisibility();
        }
    
        $nameFilter.on("change", handleFilterChange);
        $gradeFilter.on("change", handleFilterChange);
        $colorFilter.on("change", handleFilterChange);
        $storageFilter.on("change", handleFilterChange);
        $sortFilter.on("change", handleFilterChange);
    
        $("#reset-filter").on("click", function () {
            $nameFilter.val("").trigger("change");
            $gradeFilter.val("").trigger("change");
            $colorFilter.val("").trigger("change");
            $storageFilter.val("").trigger("change");
            $sortFilter.val("").trigger("change");
            updateFilters();
            updateSorting();
            toggleResetVisibility();
        });
    
        setInitialFilters();
        toggleResetVisibility();
    }    

    if($('.mdl-product').length > 0){
        Fancybox.bind("[data-fancybox]", {});

        $("#m-add").click(function() {
            $("#message-cart").html();
            var sku = $(this).data("sku");
            var url = $(this).data("url");
            var token = $(this).data("token");

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: token,
                    sku: sku
                },
                success: function(response) {
                    $("#message-cart").html('El producto ha sido añadido al carrito exitosamente.')
                        .removeClass("error")
                        .addClass("success active");
                    
                    setTimeout(() => {
                        $("#message-cart").removeClass("active");
                    }, 2000);

                    reloadNavbarCart();
                },
                error: function() {
                    $("#message-cart").html("No se pudo añadir el producto al carrito.")
                        .removeClass("success")
                        .addClass("error active");
                    
                    setTimeout(() => {
                        $("#message-cart").removeClass("active");
                    }, 2000);
                },
            });
        });
    }

    if($('.mdl-cartlist .m-element').length > 0){
        $('.mdl-cartlist .m-less').click(function (e) {
            
            // Detiene la ejecución aquí si el botón está deshabilitado
            if ($(this).hasClass('disabled')) {
                e.preventDefault();
                return;
            }
        
            let input = $(this).siblings('input[type="number"]');
            let valorActual = parseInt($(input).val());
        
            valorActual--;
            
            if (valorActual >= 1) {
                $(input).val(valorActual);
            }
        
            toggleButtonState(false, input, valorActual);
        });
        
        $('.mdl-cartlist .m-more').click(function (e) {

            // Detiene la ejecución aquí si el botón está deshabilitado
            if ($(this).hasClass('disabled')) {
                e.preventDefault();
                return;
            }
        
            let input = $(this).siblings('input[type="number"]');
            let valorActual = parseInt($(input).val());
        
            valorActual++;
        
            if (valorActual <= 10) {
                $(input).val(valorActual);
            }
        
            toggleButtonState(false, input, valorActual);
        });

        $('.mdl-cartlist .m-remove').click(function (e) {
            
            // Detiene la ejecución aquí si el botón está deshabilitado
            if ($(this).hasClass('disabled')) {
                e.preventDefault();
                return;
            }

            let element = $(this).closest('.m-element');
            let sku = element.data('sku');
            let cartList = $(this).closest('.mdl-cartlist');
            let token = cartList.data('token');
            let urldelete = cartList.data('delete');

            removeItem(sku, urldelete, token, element);
        });

        // Inicializar el estado de los botones al cargar la página
        $('.mdl-cartlist input[type="number"]').each(function() {
            let value = parseInt($(this).val());
            toggleButtonState(true, $(this), value);
        });

        function toggleButtonState(init, input, value) {
            let lessButton = input.siblings('.m-less');
            let moreButton = input.siblings('.m-more');
        
            if (value <= 1) {
                lessButton.addClass('disabled');
            } else {
                lessButton.removeClass('disabled');
            }
            
            if (value >= 10) {
                moreButton.addClass('disabled');
            } else {
                moreButton.removeClass('disabled');
            }

            // Llamada a updateQuantity() con los parámetros necesarios
            if (!init && value >= 1 && value <= 10) {
                let sku = input.closest('.m-element').data('sku');
                let urlupdate = input.closest('.mdl-cartlist').data('update');
                let token = input.closest('.mdl-cartlist').data('token');
                updateQuantity(sku, urlupdate, token, value); 
            }
        }

        function reloadPrice(){
            if($("#m-total").length > 0){
                setTimeout(() => {
                    $("#m-total").load(window.location.href + " #m-total > *");
                }, 300);
            }
        }
        
        function checkVoidCart() {
            const cartList = $('.mdl-cartlist');
            const cartElements = cartList.find('.m-element');
            const gridElements = cartList.find('.m-grid');
            const totalElement = cartList.find('#m-total');
            const emptyElement = cartList.find('.m-empty');
        
            if (cartElements.length === 0) {
                gridElements.hide();
                totalElement.hide();
                emptyElement.show();
            }
        }
        
        function updateQuantity(sku, url, token, quantity){
            toggleDisabledButtons(true);

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: token,
                    sku: sku,
                    quantity: quantity,
                },
                success: function(response) {
                    reloadNavbarCart();
                    reloadPrice();
                },
                error: function() {
                    console.log(response);
                },
                complete: function() {
                    toggleDisabledButtons();
                }
            });
        }
        
        function removeItem(sku, url, token, element) {
            toggleDisabledButtons(true);
            
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: token,
                    sku: sku,
                },
                success: function(response) {
                    element.remove();
        
                    reloadNavbarCart();
                    reloadPrice();
                    checkVoidCart();
                },
                error: function() {
                    console.error("Error al eliminar el producto del carrito.");
                },
                complete: function() {
                    toggleDisabledButtons();
                }
            });
        }
    }
});

function reloadNavbarCart(){
    if($("#m-cart").length > 0){
        setTimeout(() => {
            $("#m-cart").load(window.location.href + " #m-cart > *");
        }, 500);
    }
}

function toggleDisabledButtons(disabled) {
    if (disabled) {
        $('.check-disabled').addClass('disabled').on('click.preventDefault', function(e) {
            e.preventDefault();
        });
    } else {
        setTimeout(() => {
            $('.check-disabled').removeClass('disabled').off('click.preventDefault');
        }, 1000);
    }
}

function payCart(element){
    var url = $(element).data("url");

    $.ajax({
        url: url,
        type: "GET",

        success: function(response) {
            console.log(response);
        },
        error: function(error) {
            console.log(error);
        },
    });
}
