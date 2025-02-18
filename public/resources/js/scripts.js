$(function () {
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
});
