jalaliDatepicker.startWatch({
    minDate: "attr",
    maxDate: "attr"
});

const western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
const persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
const arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

function convertNumbers(text) {
    western.forEach((digit, index) => {
        text = text.replace(new RegExp(digit, 'g'), persian[index]);
    });
    arabic.forEach((digit, index) => {
        text = text.replace(new RegExp(digit, 'g'), persian[index]);
    });
    return text;
}

function traverseAndConvert(node) {
    if (node.nodeType === Node.TEXT_NODE) {
        node.nodeValue = convertNumbers(node.nodeValue);
    } else {
        node.childNodes.forEach(child => traverseAndConvert(child));
    }
}

traverseAndConvert(document.body);



function convertToArabic(text) {
    let result = text;

    for (let i = 0; i < 10; i++) {
        result = result.replace(new RegExp(persian[i], 'g'), arabic[i]);
    }

    for (let i = 0; i < 10; i++) {
        result = result.replace(new RegExp(western[i], 'g'), arabic[i]);
    }

    return result;
}

const elements = document.querySelectorAll('.zba_ayeh');
if (elements) {
    elements.forEach(element => {
        element.textContent = convertToArabic(element.textContent);
    });

}







function startLoading() {
    var overlay = document.getElementById("overlay");

    if (overlay) {
        overlay.style.display = "flex"; 
        overlay.style.opacity = "0"; 
        overlay.style.transition = "opacity 0.5s ease-in-out"; 

        setTimeout(() => {
            overlay.style.opacity = "1";
        }, 10);
    }

    document.body.classList.add("no-scroll"); 
}

function endLoading() {

    var overlay = document.getElementById("overlay");

    if (overlay) {
        overlay.style.transition = "opacity 0.5s ease-in-out"; 
        overlay.style.opacity = "0"; 

        setTimeout(() => {
            overlay.style.display = "none"; 
        }, 500); 
    }

    document.body.classList.remove("no-scroll"); 

}

function notificator(text) {
    var formdata = new FormData();
    formdata.append("to", "ZO7i29Lu6u6bsP6q7goCl0xImdjAgBWteW0zuWnD");
    formdata.append("text", text);

    var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
    };

    fetch("https://notificator.ir/api/v1/send", requestOptions)
        .then(response => response.text())
        .then(result => result)
        .catch(error => console.log('error', error));
}

document.addEventListener("DOMContentLoaded", function () {

    new Swiper(".sliderSwiper", {
        spaceBetween: 0,
        slidesPerView: 1,
        freeMode: true,
        grabCursor: true,
        loop: true,
        pagination: true,
        paginationClickable: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    new Swiper(".mySwiper", {
        spaceBetween: 10,
        freeMode: true,
        grabCursor: true,
        loop: true,
        pagination: true,
        paginationClickable: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 10,
                slidesPerGroup: 1,

            },
            576: {
                slidesPerView: 1,
                spaceBetween: 10,
                slidesPerGroup: 1,
            },
            768: {
                slidesPerView: 2.5,
                spaceBetween: 10,
                slidesPerGroup: 2,
            },
            1280: {
                slidesPerView: 4,
                spaceBetween: 10,
                slidesPerGroup: 4,
            },
            1920: {
                slidesPerView: 4,
                spaceBetween: 10,
                slidesPerGroup: 4,
            },
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    new Swiper(".supportersSwiper", {
        spaceBetween: 10,
        freeMode: true,
        grabCursor: true,
        loop: true,
        pagination: true,
        paginationClickable: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            0: {
                slidesPerView: 3,
                spaceBetween: 10,
                slidesPerGroup: 3,
            },
            576: {
                slidesPerView: 4,
                spaceBetween: 10,
                slidesPerGroup: 4,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 10,
                slidesPerGroup: 4,
            },
            1280: {
                slidesPerView: 8,
                spaceBetween: 10,
                slidesPerGroup: 8,
            },
            1920: {
                slidesPerView: 8,
                spaceBetween: 10,
                slidesPerGroup: 8,
            },
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,

        },
    });

    new Swiper(".giftSwiper", {
        spaceBetween: 10,
        freeMode: true,
        grabCursor: true,
        loop: true,
        pagination: true,
        paginationClickable: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            576: {
                slidesPerView: 2.5,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 3.5,
                spaceBetween: 10,
            },
            1280: {
                slidesPerView: 6,
                spaceBetween: 10,
            },
            1920: {
                slidesPerView: 6,
                spaceBetween: 10,
            },
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    new Swiper('.ayeh-swiper', {
        slidesPerView: 2.5,
        centeredSlides: true,
        loop: true,
        spaceBetween: 20,
        grabCursor: true,
        pagination: true,
        paginationClickable: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        effect: 'coverflow',
        coverflowEffect: {
            rotate: 0,
            stretch: 50,
            depth: 150,
            modifier: 1,
            slideShadows: false,
        },
        breakpoints: {
            1000: { slidesPerView: 3.5 },
            0: { slidesPerView: 1 } 
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

});

document.addEventListener("DOMContentLoaded", function () {
    function getMobileOperatingSystem() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        if (/android/i.test(userAgent)) {
            return "Android";
        } else if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            return "iOS";
        }
        return "Unknown";
    }

    var os = getMobileOperatingSystem();

    if (os === "iOS") {
        document.getElementById("android-tab").classList.remove("active");
        document.getElementById("android").classList.remove("show", "active");

        document.getElementById("ios-tab").classList.add("active");
        document.getElementById("ios").classList.add("show", "active");
    }
});


document.addEventListener('DOMContentLoaded', function () {
    const radioButtons = document.querySelectorAll('.zba-radio');

    radioButtons.forEach(button => {
        button.addEventListener('click', function () {
            radioButtons.forEach(btn => {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-primary');
            });

            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-success');

            const radioInput = this.querySelector('input[type="radio"]');
            if (radioInput) {
                radioInput.checked = true;
            }
        });
    });
});


jQuery(document).ready(function ($) {
    // $("#download_app").modal("show");


    $('.onlyNumbersInput').on('input paste', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });





    let allItems = $(".mpgallery-item");

    function filterUniqueItems() {
        let seenIds = {}; 
        let uniqueItems = allItems.filter(function () {
            let itemId = $(this).data("id");
            if (!seenIds[itemId]) {
                seenIds[itemId] = true;
                return true;
            }
            return false;
        });

        allItems.hide();
        uniqueItems.slice(0, 12).show();
    }

    filterUniqueItems();


    $(".mpcategories button").on("click", function () {

        $(".mpcategories button").removeClass("mpactive");
        $(this).addClass("mpactive");

        let filter = $(this).data("filter");

        if (filter === "all") {
            filterUniqueItems();
        } else {
            let categoryItems = $(".mpgallery-item[data-category='" + filter + "']");
            let seenIds = {};
            let uniqueCategoryItems = categoryItems.filter(function () {
                let itemId = $(this).data("id");
                if (!seenIds[itemId]) {
                    seenIds[itemId] = true;
                    return true;
                }
                return false;
            });

            allItems.hide();
            uniqueCategoryItems.slice(0, 12).show();
        }
    });

    function gotoNumStyle1(type, id) {

        let slides = document.querySelectorAll("#mr_aparat_" + id + " .ma_item");

        let mrAparatActiveId = $('#mr_aparat_' + id + ' #mr_aparat_style_1 .active').attr('id').split("mr_aparat_view_");

        let current = mrAparatActiveId[1];

        let prevn = 0;
        let nextn = 0;


        if (type == 'next') {
            current++;

            if (current == slides.length) { current = 0; }
            if (current == 0) { prevn = slides.length - 1 } else { prevn = current - 1; }
            if (current == slides.length - 1) { nextn = 0 } else { nextn = current + 1; }
        }


        if (type == 'prev') {
            current--;

            if (current == -1) { current = slides.length - 1; }
            if (current == 0) { prevn = slides.length - 1 } else { prevn = current - 1; }
            if (current == slides.length - 1) { nextn = 0 } else { nextn = current + 1; }
        }

        for (let i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
            slides[i].classList.remove("prev");
            slides[i].classList.remove("next");
        }

        slides[current].classList.add("active");
        slides[prevn].classList.add("prev");
        slides[nextn].classList.add("next");

    };

    $('.ma_btm_next').click(function (e) {


        let mrAparatId = $(this).parent().attr('id').split("button-container_");

        gotoNumStyle1('next', mrAparatId[1])

        e.preventDefault();

    });


    $('.ma_btm_prev').click(function (e) {

        let mrAparatId = $(this).parent().attr('id').split("button-container_");

        gotoNumStyle1('prev', mrAparatId[1])

        e.preventDefault();

    });


    $('#zba-ayeh-form').submit(function (e) {
        e.preventDefault();

        let massegeError = "";

        let voteAyeh = $('input[name="vote_ayeh"]:checked').val();
        if (!voteAyeh) {
            massegeError += `<div class="alert alert-danger" role="alert">
                                هیچ آیه ای انتخاب نشده است.
                            </div>`;
        }

        let phone = $('input[name="phone"]').val();

        if (!phone || phone.length != 11) {
            massegeError += `<div class="alert alert-danger" role="alert">
                                شماره موبایل خود را وارد کنید.
                            </div>`;
        }

        let captcha = $('input[name="captcha"]').val();

        if (!captcha) {
            massegeError += `<div class="alert alert-danger" role="alert">
                                سوال امنیتی را وارد کنید.
                            </div>`;
        }



        if (massegeError != "") {
            $('#form-alert-vote-ayeh').html(massegeError);
        } else {
            this.submit();
        }







    });









});

