$ = jQuery.noConflict();

window.scrollTo({ top: 0, behavior: 'smooth' })
$(document).ready(function () {
    // Header Fixed on Scroll
  window.addEventListener('scroll', function() {
  const header = document.querySelector('header');
  const scrollThreshold = window.innerHeight * 0.3;

  if (window.scrollY > scrollThreshold) {
    header.classList.add('.fixed-header');
  } else {
    header.classList.remove('sticky');
  }
});
    // Scroll Event (Go to Top on Click)
    //To scroll top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            $(".scrollToTop").fadeIn().addClass("d-block");
        } else {
            $(".scrollToTop").fadeOut().removeClass("d-block");
        }
    });
    //Click event to scroll to top
    $(".scrollToTop").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

  



    // banner on click to show the form

    const formLink = document.querySelector('.formlink');
    const formAppear = document.querySelector('.form-click');
    const crossIcon = document.querySelector('.cross-icon')
    formLink.addEventListener('click', function() {
    formAppear.style.display = 'block';
    document.body.classList.add('no-scroll');
    })
    crossIcon.addEventListener('click', function() {
    formAppear.style.display = 'none';
    document.body.classList.remove('no-scroll');
    })
  });







    







