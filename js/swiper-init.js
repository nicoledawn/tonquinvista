const swiper = new Swiper('.swiper', {

  direction: 'horizontal',
  loop: true,
  effect: "fade",
  fadeEffect: { crossFade: false },
  speed: 1000,
  slidesPerView: 1,
  autoplay: { delay: 7000 },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

});